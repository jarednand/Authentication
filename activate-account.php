<?php

    session_start();
    require_once("includes/errors.php");
    require_once("includes/constants.php");

    // Redirects
    if (isset($_SESSION["user_id"])){
        if (isset($_SESSION["activated_account"])){
            header("location:/notestore");
        } else {
            if (isset($_SESSION["is_social_media_user"])){
                if (!isset($_SESSION["provided_username"])){
                    header("location:provide-username");
                } else {
                    header("location:/notestore");
                }
            }    
        }
    } else {
        header("location:/notestore");
    }

    require_once("classes/Database.php");
    require_once("classes/User.php");
    require_once("classes/UserData.php");

    // Get the user by the user id. If no user found, redirect user to the home page. 
    $user_data = new UserData();
    $user = $user_data->get_user_by_id($_SESSION["user_id"]);
    if ($user == null){
        header("location:notestore");
    }

    require_once("includes/header.php");
    require_once("includes/navigation.php");

?>
<div class="membership-container">
    <div id="activate-account-form-container">
        <h2 class="mb-20 text-center">Activate your account</h2>
        <p class="mb-20">Before you can log into your account, please check your email inbox and click on the account activation link that we have sent you.</p>
        <p class="mb-20">If you do not see our email, please click on the button below to resend the email</p>
        <form action="" method="post" id="activate-account-resend-form" class="membership-form">
            <input type="hidden" name="email" id="activate-account-resend-email" maxlength="250" value="<?php echo $user->get_email(); ?>">
            <button type="submit" id="activate-account-resend-button">Resend</button>
            <label class="mt-20 text-center" id="activate-account-resend-response-message"></label>
        </form>
    </div>
</div>
<?php
    require_once("includes/footer.php");
?>