<?php

    session_start();
    require_once("../includes/errors.php");
    require_once("../includes/constants.php");
    require_once("../classes/Database.php");
    require_once("../classes/User.php");
    require_once("../classes/UserData.php");
    require_once("../classes/SessionData.php");
    require_once("../classes/Hasher.php");
    require_once("../classes/Cryptor.php");

    use \PHPMailer\PHPMailer\PHPMailer;
    require_once("../libraries/PHPMailer/PHPMailer.php");
    require_once("../libraries/PHPMailer/SMTP.php");
    require_once("../libraries/PHPMailer/Exception.php");

    require_once("../classes/Mailer.php");

    // If the request method is not POST, then redirect user to the error page
    if ($_SERVER["REQUEST_METHOD"] !== "POST"){
        header("location:../error");
    }

    // Retrieve values from the POST request
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Construct a response object
    $response = new stdClass();
    $response->email = new stdClass();
    $response->username = new stdClass();
    $response->password = new stdClass();
    $response->confirm_password = new stdClass();
    $response->generic = new stdClass();

    // Default error values are set to false, meaning no error has occurred
    $response->email->error = false;
    $response->username->error = false;
    $response->password->error = false;
    $response->confirm_password->error = false;
    $response->generic->error = false;

    // Construct custom class objects
    $user_data = new UserData();
    $session_data = new SessionData();
    $hasher = new Hasher();
    $cryptor = new Cryptor();
    $mailer = new Mailer();

    // Email validation
    if (empty($email)){
        $response->email->error = true;
        $response->email->error_message = "Please provide an email address.";
    } else if (!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $response->email->error = true;
        $response->email->error_message = "Invalid email address."; 
    } else if ($user_data->get_user_by_email_or_username($email) != null){
        $response->email->error = true;
        $response->email->error_message = "Email address is already in use.";
    }

    // Username validation
    if (empty($username)){
        $response->username->error = true;
        $response->username->error_message = "Please provide a username.";
    } else if (!ctype_alnum($username)){
        $response->username->error = true;
        $response->username->error_message = "Username can only have numbers and letters.";
    } else if ($user_data->get_user_by_email_or_username($username) != null){
        $response->username->error = true;
        $response->username->error_message = "Username is already in use.";
    }

    // Password validation
    if (empty($password)){
        $response->password->error = true;
        $response->password->error_message = "Please provide a password.";
    } else if (!(
                preg_match('/[A-Z]/',$password)          && 
                preg_match('/[a-z]/',$password)          && 
                preg_match('/\d/',$password)             && 
                preg_match('/[^a-zA-Z\d]/',$password)    && 
                strlen($password) >= 8
                )){
        $response->password->error = true;
        $response->password->error_message = "Password does not meet requirements.";
    }

    // Confirm password validation
    if ($password != $confirm_password){
        $response->confirm_password->error = true;
        $response->confirm_password->error_message = "Passwords do not match.";
    }

    // If there are no errors, register the user within the system. If an error occurs, return an error within the response.
    if (!$response->email->error            && 
        !$response->username->error         && 
        !$response->password->error         && 
        !$response->confirm_password->error
       ){
        $hashed_password = $hasher->generate_hash($password);
        if ($user_data->insert_user($email,$username,$hashed_password)){
            $user = $user_data->get_user_by_email_or_username($email);
            if ($user != null){
                $session_data->set_user_session($user);
                $user_id = $user->get_id();
                $activate_account_token = $cryptor->encrypt($user_id);
                $hashed_activate_account_token = $hasher->generate_hash($activate_account_token);
                if ($user_data->update_activate_account_token_and_expiration_date_by_id($hashed_activate_account_token,$user_id)){
                    $url = ACTIVATED_ACCOUNT_URL . "?id=" . urlencode($activate_account_token); 
                    $mail = $mailer->get_activate_account_email($user,$url);
                    if (!$mail->send()){
                        $response->generic->error = true;
                    }
                } else {
                    $response->generic->error = true;
                }
            } else {
                $response->generic->error = true;
            }
        } else {
            $response->generic->error = true;
        }
    }

    // Set generic error message if generic error occurred
    if ($response->generic->error){
        $response->generic->error_message = "An error occurred. Please try again.";
    }

    // Encode the json object
    $json = json_encode($response);

    // Output the json
    echo $json;
    
?>