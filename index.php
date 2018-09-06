<?php

    session_start();
    require_once("includes/errors.php");

    // Redirects
    if (isset($_SESSION["user_id"])){
        if (isset($_SESSION["is_social_media_user"])){
            if (!isset($_SESSION["provided_username"])){
                header("location:provide-username");
            }
        } else if (!isset($_SESSION["activated_account"])){
            header("location:activate-account");
        }
    }

    require_once("includes/constants.php");
    require_once("classes/Database.php");
    require_once("classes/User.php");
    require_once("classes/UserData.php");
    require_once("classes/SessionData.php");
    require_once("classes/CookieData.php");
    require_once("classes/Hasher.php");
    require_once("classes/Cryptor.php");

    // Construct custom class objects
    $user_data = new UserData();
    $session_data = new SessionData();
    $cookie_data = new CookieData();
    $hasher = new Hasher();
    $cryptor = new Cryptor();

    // If user is not logged in but remember me cookie is set, then log them in via the remember me workflow
    if (!isset($_SESSION["user_id"]) && isset($_COOKIE[REMEMBER_ME_COOKIE_NAME])){
        $encrypted_remember_me_token = $_COOKIE[REMEMBER_ME_COOKIE_NAME];
        $remember_me_token = $cryptor->decrypt($encrypted_remember_me_token);
        $user_id = explode(REMEMBER_ME_TOKEN_DELIMETER,$remember_me_token)[0];
        $user = $user_data->get_user_by_id($user_id);
        if ($user != null && $hasher->verify_hash($encrypted_remember_me_token,$user->get_remember_me_token())){
            $cookie_data->set_cookie_for_30_days(REMEMBER_ME_COOKIE_NAME,$encrypted_remember_me_token);
            $session_data->set_user_session($user);
            // Redirects
            if (isset($_SESSION["user_id"])){
                if (isset($_SESSION["is_social_media_user"])){
                    if (!isset($_SESSION["provided_username"])){
                        header("location:provide-username");
                    }
                } else if (!isset($_SESSION["activated_account"])){
                    header("location:activate-account");
                }
            }
        }
    }
    
    require_once("includes/header.php");
    require_once("includes/navigation.php");

?>
<div class="container mt-20">
    <?php
        if (isset($_SESSION["user_id"])){
            $user = $user_data->get_user_by_id($_SESSION["user_id"]);
            if ($user != null){
                echo "Hello, " . $user->get_username() . "<br>";
            }
        } else {
            echo "Home page...";
        }
    ?>
</div>
<?php
    require_once("includes/footer.php");
?>
