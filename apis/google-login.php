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
    $id_token = $_POST["id_token"];

    // If request parameter is empty, return an error within the response
    if (empty($id_token)){
        $response->error = true;
        $response->error_message = "Invalid request parameters.";
    } else {
        
        // Verify id token using Google API Client.
        $client = new Google_Client(["client_id" => GOOGLE_CLIENT_ID]);
        $payload = $client->verifyIdToken($id_token);
        
        // If id token is valid, extract id
        if ($payload) {
            
            // Google social media id and platform
            $social_media_id = $payload["sub"];
            $social_media_platform = GOOGLE_PLATFORM_NAME;
            
            // Attempt to find a user in the users table using social media id and social media platform
            $user = $user_data->get_user_by_social_media_id_and_social_media_platform($social_media_id,$social_media_platform);
            
            // If user found, set user session. Otherwise, return an error within the response
            if ($user != null){
                $session_data->set_user_session($user);
            } else {
                $response->error = true;
                $response->message = "That account has not been registered within our system.";
            }

        } else {
            // If id token is invalid, return an error within the response
            $response->error = true;
            $response->message = "Invalid Id Token";
        }
    }

    // Encode the json object
    $json = json_encode($response);

    // Output the json
    echo $json;

?>