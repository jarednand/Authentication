<?php

    class CookieData {

        // Sets a cookie for 30 days given a cookie name and cookie value. Note: 86400 = 1 day and "/" means that the cookie is available on the entire site
        public function set_cookie_for_30_days($cookie_name,$cookie_value){
            setcookie($cookie_name,$cookie_value,time() + (86400 * 30),"/");
        }

        // If a cookie is set, unsets the cookie, empties the cookie value, and sets the expiration one hour before
        public function expire_cookie($cookie_name){
            if (isset($_COOKIE[$cookie_name])){
                unset($_COOKIE[$cookie_name]);
                setcookie($cookie_name, '', time() - 3600,"/");
            }
        }

    }

?>