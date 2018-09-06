<?php

    session_start();
    require_once("../includes/errors.php");
    require_once("../includes/constants.php");
    require_once("../classes/Database.php");
    require_once("../classes/User.php");
    require_once("../classes/UserData.php");
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

    // Construct a response object and set default error to false
    $response = new stdClass();
    $response->error = false;

    // Construct custom class objects
    $user_data = new UserData();
    $hasher = new Hasher();
    $cryptor = new Cryptor();
    $mailer = new Mailer();

    // If email is provided, find user associated with that email, generate an activate account token by encrypting the user id, hash the token and store in the users table, and send url encoded activate account token in the activate account email. If any error occurs, return an error within the response.
    if (empty($email)){
        $response->error = true;
    } else {
        $user = $user_data->get_user_by_email_or_username($email);
        if ($user == null){
            $response->error = true;
        } else {
            $user_id = $user->get_id();
            $activate_account_token = $cryptor->encrypt($user_id);
            $hashed_activate_account_token = $hasher->generate_hash($activate_account_token);
            if ($user_data->update_activate_account_token_and_expiration_date_by_id($hashed_activate_account_token,$user_id)){
                $url = ACTIVATED_ACCOUNT_URL . "?id=" . urlencode($activate_account_token); 
                $mail = $mailer->get_activate_account_email($user,$url);
                if (!$mail->send()){
                    $response->error = true;
                }
            } else {
                $response->error = true;
            }
        }
    }

    // Set message based on whether or not error occurred
    $error_message = "There was an issue resending the email. Please try again.";
    $success_message = "Email resent! Please check your inbox.";
    $response->message = $response->error ? $error_message : $success_message;

    // Encode the json object
    $json = json_encode($response);

    // Output the json
    echo $json;
    
?>