<?php

    session_start();
    require_once("includes/errors.php");
    require_once("includes/constants.php");
    require_once("classes/SessionData.php");
    require_once("classes/CookieData.php");
    require_once("classes/Database.php");
    require_once("classes/User.php");
    require_once("classes/UserData.php");
    require_once("classes/Hasher.php");
    require_once("classes/Cryptor.php");

    // Construct custom class objects
    $user_data = new UserData();
    $session_data = new SessionData();
    $cookie_data = new CookieData();
    $hasher = new Hasher();
    $cryptor = new Cryptor();
     
    // If id GET parameter is not present, redirect user to error page
    if (!isset($_GET["id"])){
        header("location:error");
    }
    
    // Fetch the activate account token from the GET request
    $activate_account_token = urldecode($_GET["id"]);

    // Extract the user id from the activate account token
    $user_id = $cryptor->decrypt($activate_account_token);

    // Find the user associated with the extracted user id who has a activate account token expiration date greater than or equal to the current date
    $user = $user_data->get_user_by_id_and_activate_account_token_expiration_date($user_id);

    // If no user found or the activate account token does not match the user's hashed activate account token, then the activate account link is deemed invalid or expired
    $invalid_link = $user == null || !$hasher->verify_hash($activate_account_token,$user->get_activate_account_token());

    // If the link is valid, determine whether or not the user has activated their account already
    $already_activated = !$invalid_link && $user->get_activated_account();

    // If the user did not already activate their account, then activate their account
    $activation_successful = !$already_activated && $user_data->update_activated_account_by_id(1,$user_id);

    // Expire the remember me cookie
    $cookie_data->expire_cookie(REMEMBER_ME_COOKIE_NAME);

    // Destroy the session
    $session_data->destroy_session();

    require_once("includes/header.php");
    require_once("includes/navigation.php");

?>
<div class="membership-container">
    <div id="account-activated-form-container">
        <h2 class="mb-20 text-center">
            <?php
                if ($invalid_link){
                    echo "Invalid activation link!";
                } else if ($already_activated){
                    echo "Account already activated!";
                } else if ($activation_successful) {
                    echo "Account activated!";
                } else {
                    echo "Error!";
                }
            ?>
        </h2>
        <p class="mb-20">
            <?php
                if ($invalid_link){
                    echo "The activation link is either expired or no longer valid.";
                } else if ($already_activated){
                    echo "You have already activated your account.";
                } else if ($activation_successful) {
                    echo "You have successfully activated your account.";
                } else {
                    echo "An error has occurred.";
                }
            ?>
        </p>
        <p class="mb-20">Please click on the button below to log into your account.</p>
        <form method="post" action="login" class="membership-form">
            <button class="mb-20" type="submit">Login</button>
        </form>
    </div>
</div>
<?php
    require_once("includes/footer.php");
?>