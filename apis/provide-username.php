<?php

    session_start();
    require_once("../includes/errors.php");
    require_once("../includes/constants.php");
    require_once("../classes/Database.php");
    require_once("../classes/User.php");
    require_once("../classes/UserData.php");
    require_once("../classes/SessionData.php");
    require_once("../vendor/autoload.php");

    // If the request method is not POST, then redirect user to the error page
    if ($_SERVER["REQUEST_METHOD"] !== "POST"){
        header("location:../error");
    }

    // Construct a response object and set default error to false
    $response = new stdClass();
    $response->error = false;

    // Construct custom class objects
    $user_data = new UserData();
    $session_data = new SessionData();

    // Get values from POST request
    $username = $_POST["username"];

    // If request parameter is empty, return an error within the response
    if (empty($username)){
        $response->error = true;
        $response->message = "Please provide a username.";
    } else {
        // Check if user already exists with that username. If does, return error within response.
        $user = $user_data->get_user_by_username($username);
        if ($user != null){
            $response->error = true;
            $response->message = "Username is already in use.";
        } else {
            // Update username for the currently logged in user. If an error occurs, return error within response.
            $user_id = $_SESSION["user_id"];
            if (!$user_data->update_username_by_id($username,$user_id)){
                $response->error = true;
                $response->message = "Error updating username for logged in user.";
            } else {
                // Set session
                $session_data->set_user_session_after_provided_username();
            }
        }
    }

    // Encode the json object
    $json = json_encode($response);

    // Output the json
    echo $json;

?>