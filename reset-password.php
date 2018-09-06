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

    // If no id exists within the GET request parameter, then redirect the user to the forgot password page
    if (!isset($_GET["id"])){
        header("location:forgot-password");
    }

    require_once("classes/Database.php");
    require_once("classes/User.php");
    require_once("classes/UserData.php");
    require_once("classes/Hasher.php");
    require_once("classes/Cryptor.php");

    // Construct custom class objects
    $user_data = new UserData();
    $hasher = new Hasher();
    $cryptor = new Cryptor();

    // Extract the user id from the password reset token
    $password_reset_token = urldecode($_GET["id"]);
    $user_id = $cryptor->decrypt($password_reset_token);

    // Find the user associated with the extracted user id who has a password reset token expiration date greater than or equal to the current date
    $user = $user_data->get_user_by_id_and_password_reset_token_expiration_date($user_id);

    // If no user found or the password reset token does not correspond to the hashed password reset token of the user, then redirect the user to the forgot password page
    if ($user == null || !$hasher->verify_hash($password_reset_token,$user->get_password_reset_token())){
        header("location:forgot-password");
    }

    require_once("includes/header.php");
    require_once("includes/navigation.php");
    
?>
<div class="membership-container">
    <div id="reset-password-form-container">
        <h2 class="mb-20 text-center">Reset your password</h2>
        <form action="" method="post" id="reset-password-form" class="membership-form">
            <label id="password-reset-password-error-message"></label>
            <input type="password" class="mb-20" name="password" id="password-reset-password" placeholder="Password" maxlength="250">
            <div class="mb-20" id="password-requirements">
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
            <label id="password-reset-confirm-password-error-message"></label>
            <input type="password" class="mb-20" name="confirm_password" id="password-reset-confirm-password" placeholder="Confirm password" maxlength="250">
            <input type="hidden" name="id" id="password-reset-id" value="<?php echo $password_reset_token; ?>">
            <button type="submit" class="mb-20" id="password-reset-button">Reset your password</button>
        </form>
    </div>
    <div class="hidden" id="reset-password-success-container">
        <h2 class="mb-20 text-center">Password reset!</h2>
        <p class="mb-20">Your password has been successfully changed!</p>
        <p class="mb-20">Please click on the button below to log into your account.</p>
        <form method="post" action="login" class="membership-form">
            <button class="mb-20" type="submit">Login</button>
        </form>
    </div>
</div>
<?php
    require_once("includes/footer.php");
?>