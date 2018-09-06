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
    $email_or_username = $_POST["email_or_username"];

    // Construct a response object and set default error to false
    $response = new stdClass();
    $response->error = false;

    // Construct custom class objects
    $user_data = new UserData();
    $hasher = new Hasher();
    $cryptor = new Cryptor();
    $mailer = new Mailer();

    // If email or username is provided, fetch the user associated with that email or username, generate a password reset token, hash the password reset token, store the hash in the users table, and send the password reset token in the password reset email. If successful, return the user's email or username within the response. If any error occurs, return the error within the response.
    if (empty($email_or_username)){
        $response->error = true;
        $response->message = "Please provide your email or username.";
    } else {
        $user_data = new UserData();
        $user = $user_data->get_user_by_email_or_username($email_or_username);
        if ($user == null){
            $response->error = true;
            $response->message = "No user found with that email or username.";
        } else {
            $user_id = $user->get_id();
            $password_reset_token = $cryptor->encrypt($user_id);
            $hashed_password_reset_token = $hasher->generate_hash($password_reset_token);
            if ($user_data->update_password_reset_token_and_expiration_date_by_id($hashed_password_reset_token,$user_id)){
                $id = urlencode($password_reset_token);
                $url = PASSWORD_RESET_URL . "?id=" . $id; 
                $mail = $mailer->get_password_reset_mail($user,$url);
                if (!$mail->send()){
                    $response->error = true;
                    $response->message = "Error sending password reset email. Please try again.";
                } else {
                    $response->email_or_username = $email_or_username;
                }
            } else {
                $response->error = true;
                $response->message = "An error has occurred. Please try again.";
            }
        }
    }

    // If resend parameter exists within POST request, set resend message based on whether or not error occurred
    if (isset($_POST["resend"])){
        $error_message = "There was an issue resending the email. Please try again.";
        $success_message = "Email resent! Please check your inbox.";
        $response->message = $response->error ? $error_message : $success_message;
    }

    // Encode the json object
    $json = json_encode($response);

    // Output the json
    echo $json;
    
?>