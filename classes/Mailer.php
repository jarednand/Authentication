<?php

    use \PHPMailer\PHPMailer\PHPMailer;

    class Mailer {

        private $mail;

        public function __construct(){
            $this->mail = new PHPMailer();
            $this->mail->IsSMTP();
            $this->mail->SMTPAuth = true;
            $this->mail->Host = SMTP_HOST;
            $this->mail->Port = SMTP_PORT;
            $this->mail->Username = SMTP_USERNAME;
            $this->mail->Password = SMTP_PASSWORD;
        }

        public function get_password_reset_mail($user,$url){
            $this->mail->addAddress($user->get_email());
            $this->mail->setFrom(COMPANY_SUPPORT_EMAIL,COMPANY_SUPPORT_NAME);
            $this->mail->Subject = "Reset your " . COMPANY . " password";
            $body = "<div style='font-size:16px; font-family:arial;'>";
            $body .= "  <p style='line-height:24px;'>Hello,</p>";
            $body .= "  <p style='line-height:24px;'>We got a request to change the password for the account with the username: <b>" . $user->get_username() . "</b>.</p>";
            $body .= "  <p style='line-height:24px;'>Click the button below to reset your password.</p>";
            $body .= "  <a href='" . $url . "' target='_blank' style='text-decoration:none;'>";
            $body .= "      <div style='background-color:#1ab9ed; color:#fff; width:160px; text-align:center; padding:10px; font-size:16px; border:1px solid #1ab9ed; border-radius:2px;' onMouseOver='this.style.cursor=\"pointer\"'>";
            $body .= "          Reset your password";
            $body .= "      </div>";
            $body .= "  </a>";
            $body .= "  <p style='line-height:24px;'>If you did not request a password reset, please ignore this email or reply to let us know.</p>";
            $body .= "  <p style='line-height:24px;'>This password reset is only valid for the next " . TOKEN_EXPIRATION_MINUTES . " minutes.</p>";
            $body .= "<p style='line-height:24px;'>Best Regards,</p>";
            $body .= "<p style='line-height:24px;'>The " . COMPANY . " Team</p>";
            $body .= "</div>";
            $this->mail->Body = $body;
            $this->mail->isHTML(true);
            return $this->mail;
        }

        public function get_username_recovery_mail($user,$url){
            $this->mail->addAddress($user->get_email());
            $this->mail->setFrom(COMPANY_SUPPORT_EMAIL,COMPANY_SUPPORT_NAME);
            $this->mail->Subject = COMPANY . " username reminder";
            $body = "<div style='font-size:16px; font-family:arial;'>";
            $body .= "  <p style='line-height:24px;'>Hello,</p>";
            $body .= "  <p style='line-height:24px;'>Your username is: <b>" . $user->get_username() . "</b>.</p>";
            $body .= "  <p style='line-height:24px;'>Click the button below to log into your " . COMPANY . " account.</p>";
            $body .= "  <a href='" . $url . "' target='_blank' style='text-decoration:none;'>";
            $body .= "      <div style='background-color:#1ab9ed; color:#fff; width:160px; text-align:center; padding:10px; font-size:16px; border:1px solid #1ab9ed; border-radius:2px;' onMouseOver='this.style.cursor=\"pointer\"'>";
            $body .= "          Log into " . COMPANY;
            $body .= "      </div>";
            $body .= "  </a>";
            $body .= "  <p style='line-height:24px;'>If you did not make a request to recover your username, please ignore this email or reply to let us know.</p>";
            $body .= "<p style='line-height:24px;'>Best Regards,</p>";
            $body .= "<p style='line-height:24px;'>The " . COMPANY . " Team</p>";
            $body .= "</div>";
            $this->mail->Body = $body;
            $this->mail->isHTML(true);
            return $this->mail;
        }

        public function get_activate_account_email($user,$url){
            $this->mail->addAddress($user->get_email());
            $this->mail->setFrom(COMPANY_SUPPORT_EMAIL,COMPANY_SUPPORT_NAME);
            $this->mail->Subject = "Activate your " . COMPANY . " account";
            $body = "<div style='font-size:16px; font-family:arial;'>";
            $body .= "  <p style='line-height:24px;'>Hello,</p>";
            $body .= "  <p style='line-height:24px;'>Please click the button below to activate your " . COMPANY . " account.</p>";
            $body .= "  <a href='" . $url . "' target='_blank' style='text-decoration:none;'>";
            $body .= "      <div style='background-color:#1ab9ed; color:#fff; width:160px; text-align:center; padding:10px; font-size:16px; border:1px solid #1ab9ed; border-radius:2px;' onMouseOver='this.style.cursor=\"pointer\"'>";
            $body .= "          Activate your account";
            $body .= "      </div>";
            $body .= "  </a>";
            $body .= "  <p style='line-height:24px;'>If you have recieved this email by error, please ignore this email or reply to let us know.</p>";
            $body .= "<p style='line-height:24px;'>Best Regards,</p>";
            $body .= "<p style='line-height:24px;'>The " . COMPANY . " Team</p>";
            $body .= "</div>";
            $this->mail->Body = $body;
            $this->mail->isHTML(true);
            return $this->mail;
        }

    }

?>