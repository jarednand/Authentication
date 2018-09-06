<?php

    session_start();
    require_once("includes/errors.php");

    // Redirects
    if (isset($_SESSION["user_id"])){
        if (isset($_SESSION["is_social_media_user"])){
            if (isset($_SESSION["provided_username"])){
                header("location:/notestore");
            }
        } else {
            if (!isset($_SESSION["activated_account"])){
                header("location:/activate-account");
            } else {
                header("location:/notestore");
            }
        }
    } else {
        header("location:/notestore");
    }

    require_once("includes/constants.php");
    require_once("includes/header.php");
    require_once("includes/navigation.php");
    
?>
<div class="membership-container">
    <h2 class="text-center">Provide a username</h2>
    <p class="mt-20 mb-20">To finish creating your account, please provide a username.</p>
    <form action="" method="post" id="provide-username-form" class="membership-form">
        <label id="provide-username-error-message"></label>
        <input type="text" class="mt-10 mb-10" name="username" id="provide-username-username" placeholder="Username" maxlength="250">
        <button type="submit" id="provide-username-button">Submit</button>
    </form>
</div>
<?php
    require_once("includes/footer.php");
?>