<?php

    session_start();
    require_once("includes/errors.php");
    require_once("includes/constants.php");
    require_once("classes/Database.php");
    require_once("classes/User.php");
    require_once("classes/SessionData.php");
    require_once("classes/CookieData.php");
    
    // Construct custom class objects
    $session_data = new SessionData();
    $cookie_data = new CookieData();

    // Expire the remember me cookie
    $cookie_data->expire_cookie(REMEMBER_ME_COOKIE_NAME);

    // Destroy the session
    $session_data->destroy_session();

    // Redirect the user to the home page
    header("location:/notestore");
    
?>