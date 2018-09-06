<?php

    session_start();
    require_once("../includes/errors.php");
    require_once("../includes/constants.php");
    require_once("../classes/Database.php");
    require_once("../classes/User.php");
    require_once("../classes/UserData.php");
    require_once("../classes/Hasher.php");
    require_once("../classes/Cryptor.php");

    // If the request method is not POST, then redirect user to the error page
    if ($_SERVER["REQUEST_METHOD"] !== "POST"){
        header("location:../error");
    }

    // Retrieve values from the POST request
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $id = $_POST["id"];

    // Construct a response object and set default error to false
    $response = new stdClass();
    $response->password = new stdClass();
    $response->confirm_password = new stdClass();
    $response->id = new stdClass();
    $response->generic = new stdClass();

    // Default error values are set to false, meaning no error has occurred
    $response->password->error = false;
    $response->confirm_password->error = false;
    $response->id->error = false;
    $response->generic->error = false;

    // Construct custom class objects
    $user_data = new UserData();
    $hasher = new Hasher();
    $cryptor = new Cryptor();

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

    // Id validation
    if (!isset($_POST["id"])){
        $response->id->error = true;
        $response->id->error_message = "An error has occurred. Please try again.";
    }

    // If there are no errors, update the user's password and reset the password_reset_token and password_reset_token_expiration_date
    if (!$response->password->error         && 
        !$response->confirm_password->error && 
        !$response->id->error
       ){
        $password_reset_token = $_POST["id"];
        $user_id = $cryptor->decrypt($password_reset_token);
        $user = $user_data->get_user_by_id_and_password_reset_token_expiration_date($user_id);
        if ($user != null && $hasher->verify_hash($password_reset_token,$user->get_password_reset_token())){
            $hashed_password = $hasher->generate_hash($password);
            if (!$user_data->update_password_by_id($hashed_password,$user_id)){
                $response->generic->error = true;
            }
        } else {
            $response->generic->error = true;
        }
    }

    // Set message for generic error if generic error occurred
    if ($response->generic->error){
        $response->generic->error_message = "An error has occurred. Please try again.";
    }

    // Encode the json object
    $json = json_encode($response);

    // Output the json
    echo $json;
    
?>