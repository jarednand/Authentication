<?php

    session_start();
    require_once("../includes/errors.php");
    require_once("../includes/constants.php");
    require_once("../classes/Database.php");
    require_once("../classes/User.php");
    require_once("../classes/UserData.php");
    require_once("../classes/SessionData.php");
    require_once("../classes/CookieData.php");
    require_once("../classes/Hasher.php");
    require_once("../classes/Cryptor.php");

    // If the request method is not POST, then redirect user to the error page
    if ($_SERVER["REQUEST_METHOD"] !== "POST"){
        header("location:../error");
    }

    // Retrieve values from the POST request
    $email_or_username = $_POST["email_or_username"];
    $password = $_POST["password"];
    $remember_me_checkbox = isset($_POST["remember_me"]) ? $_POST["remember_me"] : null;

    // Construct a response object and set default error to false
    $response = new stdClass();
    $response->error = false;

    // Construct custom class objects
    $user_data = new UserData();
    $session_data = new SessionData();
    $cookie_data = new CookieData();
    $hasher = new Hasher();
    $cryptor = new Cryptor();

    // Validate that all fields are non empty. If fields are non empty, attempt to log user in via login form workflow. If an error occurs, return an error within the response. 
    if (empty($email_or_username) || empty($password)){
        $response->error = true;
        $response->error_message = "Please fill out all fields.";
    } else {
        $user = $user_data->get_user_by_email_or_username($email_or_username);
        if ($user == null || !$hasher->verify_hash($password,$user->get_password())){
            $response->error = true;
            $response->error_message = "Invalid combination. Please try again.";
        } else {
            $user_id = $user->get_id();
            if (!empty($remember_me_checkbox)){
                $remember_me_token = $user_id . REMEMBER_ME_TOKEN_DELIMETER . $_SERVER["REMOTE_ADDR"] . $_SERVER['HTTP_USER_AGENT'];
                $encrypted_remember_me_token = $cryptor->encrypt($remember_me_token);
                $hashed_encrypted_remember_me_token = $hasher->generate_hash($encrypted_remember_me_token);
                if ($user_data->update_remember_me_token_by_id($hashed_encrypted_remember_me_token,$user_id)){
                    $cookie_data->set_cookie_for_30_days(REMEMBER_ME_COOKIE_NAME,$encrypted_remember_me_token);
                    $session_data->set_user_session($user);
                } else {
                    $response->error = true;
                    $response->error = "An error occurred. Please try again.";
                }
            } else {
                $cookie_data->expire_cookie(REMEMBER_ME_COOKIE_NAME);
                $session_data->set_user_session($user);
            }
        }
    }

    // Encode the json object
    $json = json_encode($response);

    // Output the json
    echo $json;
    
?>