<?php

    class User {

        // Private variables
        private $id;
        private $email;
        private $username;
        private $password;
        private $remember_me_token;
        private $password_reset_token;
        private $password_reset_token_expiration_date;
        private $activated_account;
        private $activate_account_token;
        private $activate_account_token_expiration_date;
        private $social_media_id;
        private $social_media_platform;
        private $created_at;

        // Constructor
        public function __construct($id,$email,$username,$password,$remember_me_token,$password_reset_token,$password_reset_token_expiration_date,$activated_account,$activate_account_token,$activate_account_token_expiration_date,$social_media_id,$social_media_platform,$created_at){
            $this->id = $id;
            $this->email = $email;
            $this->username = $username;
            $this->password = $password;
            $this->remember_me_token = $remember_me_token;
            $this->password_reset_token = $password_reset_token;
            $this->password_reset_token_expiration_date = $password_reset_token_expiration_date;
            $this->activated_account = $activated_account;
            $this->activate_account_token = $activate_account_token;
            $this->social_media_id = $social_media_id;
            $this->social_media_platform = $social_media_platform;
            $this->activate_account_token_expiration_date = $activate_account_token_expiration_date;
            $this->created_at = $created_at;
        }

        // Getter methods
        public function get_id(){ return $this->id; }
        public function get_email(){ return $this->email; }
        public function get_username(){ return $this->username; }
        public function get_password(){ return $this->password; }
        public function get_remember_me_token(){ return $this->remember_me_token; }
        public function get_password_reset_token(){ return $this->password_reset_token; }
        public function get_password_reset_token_expiration_date(){ return $this->password_reset_token_expiration_date; }
        public function get_activated_account(){ return $this->activated_account; }
        public function get_activate_account_token(){ return $this->activate_account_token; }
        public function get_activate_account_token_expiration_date(){ return $this->activate_account_token_expiration_date; }
        public function get_social_media_id(){ return $this->social_media_id; }
        public function get_social_media_platform(){ return $this->social_media_platform; }
        public function get_created_at(){ return $this->created_at; }

        // Setter methods
        public function set_id($id){ $this->id = $id; }
        public function set_email($email){ $this->email = $email; }
        public function set_username($username){ $this->username = $username; }
        public function set_password($pasword){ $this->password = $password; }
        public function set_remember_me_token($remember_me_token){ $this->remember_me_token = $remember_me_token; }
        public function set_password_reset_token($password_reset_token){ $this->password_reset_token = $password_reset_token; }
        public function set_password_reset_token_expiration_date($password_reset_token_expiration_date){ $this->password_reset_token_expiration_date = $password_reset_token_expiration_date; }
        public function set_activated_account($activated_account){ $this->activated_account = $activated_account; }
        public function set_activate_account_token($activate_account_token){ $this->activate_account_token = $activate_account_token; }
        public function set_activate_account_token_expiration_date($activate_account_token_expiration_date){ $this->activate_account_token_expiration_date = $activate_account_token_expiration_date; }
        public function set_social_media_id($social_media_id){ $this->social_media_id = $social_media_id; }
        public function set_social_media_platform($social_media_platform){ $this->social_media_platform = $social_media_platform; }
        public function set_created_at($created_at){ $this->created_at = $created_at; }

        // Returns the User object as a formatted string
        public function to_string(){
            $string = "";
            $string .= "Id: " . $this->id . "<br>";
            $string .= "Email: " . $this->email . "<br>";
            $string .= "Username: " . $this->username . "<br>";
            $string .= "Password: " . $this->password . "<br>";
            $string .= "Remember Me Token: " . $this->remember_me_token . "<br>";
            $string .= "Password Reset Token: " . $this->password_reset_token . "<br>";
            $string .= "Password Reset Token Expiration Date: " . $this->password_reset_token_expiration_date . "<br>";
            $string .= "Activated account: " . $this->activated_account . "<br>";
            $string .= "Activate account token: " . $this->activate_account_token . "<br>";
            $string .= "Activate account token expiration date: " . $this->activate_account_token_expiration_date . "<br>";
            $string .= "Social Media Id: " . $this->social_media_id . "<br>";
            $string .= "Social Media Platform: " . $this->social_media_platform . "<br>";
            $string .= "Created At: " . $this->created_at . "<br>";
            return $string; 
        }

    }

?>