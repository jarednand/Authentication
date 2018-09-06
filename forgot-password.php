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
<div class="membership-container">
    <div id="forgot-password-form-container">
        <h2 class="text-center">Forgot your password?</h2>
        <p class="mt-20 mb-20">Enter your email or username, and we will email you instructions on how to reset your password.</p>
        <form action="" method="post" id="forgot-password-form" class="membership-form">
            <label id="forgot-password-error-message"></label>
            <input type="text" class="mb-20" name="email_or_username" id="forgot-password-email-or-username" placeholder="Email or username" maxlength="250">
            <button type="submit" class="mb-20" id="forgot-password-button">Reset your password</button>
        </form>
        <p class="p-small text-center">Remember your password? <a href="login">Login</a></p>
    </div>
    <div class="hidden" id="forgot-password-success-container">
        <h2 class="mb-20 text-center">Email sent!</h2>
        <p class="mb-20">We have emailed you instructions on how to reset your password.</p>
        <p class="mb-20">If you do not see our email, please click on the button below to resend the email.</p>
        <form action="" method="post" id="forgot-password-resend-form" class="membership-form">
            <input type="hidden" name="email_or_username" id="forgot-password-resend-email-or-username" maxlength="250">
            <button type="submit" name="resend" id="forgot-password-resend-button">Resend</button>
            <label class="mt-20 text-center" id="forgot-password-resend-response-message"></label>
        </form>
    </div>
</div>
<?php
    require_once("includes/footer.php");
?>