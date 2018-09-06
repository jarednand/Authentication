<?php

    session_start();
    require_once("includes/errors.php");

    // Redirects
    if (isset($_SESSION["user_id"])){
        if (isset($_SESSION["is_social_media_user"]) && !isset($_SESSION["provided_username"])){
            header("location:provide-username");
        } else if (!isset($_SESSION["is_social_media_user"]) && !isset($_SESSION["activated_account"])){
            header("location:activate-account");
        } else {
            header("location:/notestore");
        }
    }

    require_once("includes/constants.php");
    require_once("includes/header.php");
    require_once("includes/navigation.php");

?>
<div id="fb-root"></div>
<div class="membership-container">
    <h2 class="mb-20 text-center">Create a free account</h2>
    <form action="" method="post" id="register-form" class="membership-form">
        <label id="register-generic-error-message"></label>
        <label id="register-email-error-message"></label>
        <input type="text" class="mb-10" name="email" id="register-email" placeholder="Email" maxlength="250">
        <label id="register-username-error-message"></label>
        <input type="text" class="mb-10" name="username" id="register-username" placeholder="Username" maxlength="250">
        <label id="register-password-error-message"></label>
        <input type="password" class="mb-10" name="password" id="register-password" placeholder="Password" maxlength="250">
        <div class="mb-10" id="password-requirements">
            <div class="float-left">
                <ul>
                    <li id="password-requirement-uppercase-letter">1 uppercase letter</li>
                    <li id="password-requirement-lowercase-letter">1 lowercase letter</li>
                    <li id="password-requirement-number">1 number</li>
                </ul>
            </div>
            <div class="float-right">
                <ul>
                    <li id="password-requirement-special-character">1 special character</li>
                    <li id="password-requirement-eight-characters">8 characters minimum</li></li>
                </ul>
            </div>
            <div class="float-clear"></div>
        </div>
        <label id="register-confirm-password-error-message"></label>
        <input type="password" class="mb-10" name="confirm_password" id="register-confirm-password" placeholder="Confirm password" maxlength="250">
        <button type="submit" id="register-button">Create a free account</button>
    </form>
    <?php require_once("includes/social-media-login-buttons.php"); ?>
    <input type="hidden" id="social-media-login-operation" value="register">
    <p class="p-small text-center">Already have an account? <a href="login">Log in</a></p>
</div>
<?php
    require_once("includes/social-media-login-footer.php");
?>