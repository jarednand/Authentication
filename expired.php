<?php
    session_start();
    require_once("includes/errors.php");
    require_once("includes/constants.php");
    require_once("includes/header.php");
    require_once("includes/navigation.php");
?>
<div class="container mt-20 mb-20">
    <h2 class="mb-20">Expired link!</h2>
    <p>
        <?php
            $message = "You are trying to access a page through an expired link. ";
            $message .= "For further assistance, you can contact <b>" . COMPANY_SUPPORT_NAME . "</b> ";
            $message .= "by calling <b>" . COMPANY_SUPPORT_PHONE_NUMBER . "</b> ";
            $message .= "or by sending an email to <b>" . COMPANY_SUPPORT_EMAIL . "</b>.";
            echo $message;
        ?>
    </p>
</div>
<?php
    require_once("includes/footer.php");
?>
