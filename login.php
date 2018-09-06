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
    
    $username = isset($_GET["username"]) ? $_GET["username"] : "";
?>
<div id="fb-root"></div>
<div class="membership-container">
    <h2 class="mb-20 text-center">Log in</h2>
    <form action="" method="post" id="login-form" class="membership-form">
        <label id="login-error-message">
            <?php
                if (isset($_GET["account_activated"]) && $_GET["account_activated"]){
                    echo "You have already activated your account. Please log in.";
                }
            ?>
        </label>
        <input type="text" class="mt-10 mb-10" name="email_or_username" id="login-email-or-username" placeholder="Email or username" maxlength="250" value="<?php echo $username; ?>">
        <input type="password" class="mb-10" name="password" id="login-password" placeholder="Password" maxlength="250">
        <div class="mb-10" id="login-remember-me-container">
            <label class="checkbox-container">Remember me
                <input type="checkbox" checked="checked" name="remember_me" id="remember-me" value="Remember me">
                <span class="checkmark"></span>
            </label>
        </div>
        <button type="submit" id="login-button">Log in</button>
    </form>
    <?php require_once("includes/social-media-login-buttons.php"); ?>
    <input type="hidden" id="social-media-login-operation" value="login">
    <p class="p-small text-center">Don't have an account? <a href="register">Sign up</a></p>
    <div class="mt-10" id="login-forgot-container">
        <a href="forgot-username">Forgot username?</a> 
        <span id="login-bullet">&bull;</span>
        <a href="forgot-password">Forgot password?</a>
    </div>
</div>
<?php
    require_once("includes/social-media-login-footer.php");
?>