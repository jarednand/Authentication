<?php

    class SessionData {

        // Sets the session after the user has been registered or logged into the application
        public function set_user_session($user){
            if ($user != null){
                $_SESSION["user_id"] = $user->get_id();
                if ($user->get_activated_account()){
                    $_SESSION["activated_account"] = true;
                }
                if ($user->get_social_media_id() != null){
                    $_SESSION["is_social_media_user"] = true;
                    if ($user->get_username() != null){
                        $_SESSION["provided_username"] = true;
                    }
                }
            }
        }

        // Sets user session after social media user has provided their username
        public function set_user_session_after_provided_username(){
            if (isset($_SESSION["user_id"]) && isset($_SESSION["is_social_media_user"])){
                $_SESSION["provided_username"] = true;
            }
        }

        // Destroys entire session and all session data
        public function destroy_session(){
            session_unset();
            session_destroy();
        }

    }

?>