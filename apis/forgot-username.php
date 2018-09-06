<?php

    session_start();
    require_once("../includes/errors.php");
    require_once("../includes/constants.php");
    require_once("../classes/Database.php");
    require_once("../classes/User.php");
    require_once("../classes/UserData.php");
    
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
    $mailer = new Mailer();

    // If email is provided, find user associated with that email and send that user a username recovery email. If mail sent successfully, return the email address within the response. If any error occurs, return the error within the response.
    if (empty($email)){
        $response->error = true;
        $response->message = "Please provide your email.";
    } else {
        $user = $user_data->get_user_by_email_or_username($email);
        if ($user == null){
            $response->error = true;
            $response->message = "No user found with that email.";
        } else {
            $url = LOGIN_URL . "?username=" . $user->get_username();
            $mail = $mailer->get_username_recovery_mail($user,$url);
            if (!$mail->send()){
                $response->error = true;
                $response->message = "Error sending username recovery email. Please try again.";
            } else {
                $response->email = $email;
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