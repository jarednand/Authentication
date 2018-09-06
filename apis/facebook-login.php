<?php

    session_start();
    require_once("../includes/errors.php");
    require_once("../includes/constants.php");
    require_once("../classes/Database.php");
    require_once("../classes/User.php");
    require_once("../classes/UserData.php");
    require_once("../classes/SessionData.php");
    require_once("../classes/Nonce.php");
    require_once("../classes/NonceData.php");

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
    $nonce_data = new NonceData();

    // Get access token from POST
    $social_media_id = $_POST["social_media_id"];
    $access_token = $_POST["access_token"];

    // If request parameter is empty, return an error within the response
    if (empty($social_media_id) || empty($access_token)){
        $response->error = true;
        $response->message = "Invalid request parameters.";
    } else {

        // Send a request over to Facebook using access token to retrieve the nonce that was passed over on the client side via reauthentication
        $graph_url = "https://graph.facebook.com/oauth/access_token_info?" . "client_id=" . FACEBOOK_APP_ID . "&access_token=" . $access_token;
        $access_token_info = json_decode(file_get_contents($graph_url));
        $auth_nonce = $access_token_info->auth_nonce;

        // Do a lookup in the nonces table to see if the nonce is currently being used. If it is, return an error. If not, store the nonce in the nonces table.
        $nonce = $nonce_data->get_nonce_by_value($auth_nonce);
        if ($nonce != null){
            $response->error = true;
            $response->message = "Nonce already in use.";
        } else {
            // If nonce is inserted successfully, attempt to log user in.
            if ($nonce_data->insert_nonce($auth_nonce)){
                
                $social_media_platform = FACEBOOK_PLATFORM_NAME;
                
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
                $response->error = true;
                $response->message = "Error storing nonce.";
            }
            
        }

    }

    // Encode the json object
    $json = json_encode($response);

    // Output the json
    echo $json;

?>