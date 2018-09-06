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
    <div id="forgot-username-form-container">
        <h2 class="text-center">Forgot your username?</h2>
        <p class="mt-20 mb-20">You can recover your username by providing the email associated with your <?php echo COMPANY; ?> account.</p>
        <form action="" method="post" id="forgot-username-form" class="membership-form">
            <label id="forgot-username-error-message"></label>
            <input type="text" class="mb-20" name="email" id="forgot-username-email" placeholder="Email" maxlength="250">
            <button type="submit" class="mb-20" id="forgot-username-button">Recover your username</button>
        </form>
        <p class="p-small text-center">Remember your username? <a href="login">Login</a></p>
    </div>
    <div class="hidden" id="forgot-username-success-container">
        <h2 class="mb-20 text-center">Email sent!</h2>
        <p class="mb-20">We have emailed you your username.</p>
        <p class="mb-20">If you do not see our email, please click on the button below to resend the email.</p>
        <form action="" method="post" id="forgot-username-resend-form" class="membership-form">
            <input type="hidden" name="email" id="forgot-username-resend-email" maxlength="250">
            <button type="submit" name="resend" id="forgot-username-resend-button">Resend</button>
            <label class="mt-20 text-center" id="forgot-username-resend-response-message"></label>
        </form>
    </div>
</div>
<?php
    require_once("includes/footer.php");
?>