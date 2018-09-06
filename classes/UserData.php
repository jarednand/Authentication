<?php

    class UserData {

        private $database;

        public function __construct(){
            $this->database = new Database;
        }

        /***** INSERT OPERATIONS *****/

        // Inserts a user into the users table given a email, username, and password. Returns a boolean designating whether or not insert was successful.
        public function insert_user($email,$username,$password){
            $this->database->query("INSERT INTO users (email,username,password) VALUES(:email,:username,:password)");
            $this->database->bind(":email",$email);
            $this->database->bind(":username",$username);
            $this->database->bind(":password",$password);
            return $this->database->execute();
        }

        // Inserts a social media user into the users table given a social media id and social media platform. Returns a boolean designating whether or not insert was successful.
        public function insert_social_media_user($social_media_id,$social_media_platform){
            $this->database->query("INSERT INTO users (social_media_id,social_media_platform) VALUES(:social_media_id,:social_media_platform)");
            $this->database->bind(":social_media_id",$social_media_id);
            $this->database->bind(":social_media_platform",$social_media_platform);
            return $this->database->execute();
        }

        /***** GET OPERATIONS *****/

        // Gets a user from the users table given a user id. Returns null if user is not found.
        public function get_user_by_id($user_id){
            $user = null;
            $this->database->query("SELECT * FROM users WHERE id = :user_id");
            $this->database->bind(":user_id",$user_id);
            $this->database->execute();
            $results = $this->database->resultset();
            if (sizeof($results) == 1){
                $result = $results[0];
                $user = new User(
                                $result->id,
                                $result->email,
                                $result->username,
                                $result->password,
                                $result->remember_me_token,
                                $result->password_reset_token,
                                $result->password_reset_token_expiration_date,
                                $result->activated_account,
                                $result->activate_account_token,
                                $result->activate_account_token_expiration_date,
                                $result->social_media_id,
                                $result->social_media_platform,
                                $result->created_at
                            );
            }
            return $user;
        }

        // Gets a user from the users table given a username. Returns null if user is not found.
        public function get_user_by_username($username){
            $user = null;
            $this->database->query("SELECT * FROM users WHERE username = :username");
            $this->database->bind(":username",$username);
            $this->database->execute();
            $results = $this->database->resultset();
            if (sizeof($results) == 1){
                $result = $results[0];
                $user = new User(
                                $result->id,
                                $result->email,
                                $result->username,
                                $result->password,
                                $result->remember_me_token,
                                $result->password_reset_token,
                                $result->password_reset_token_expiration_date,
                                $result->activated_account,
                                $result->activate_account_token,
                                $result->activate_account_token_expiration_date,
                                $result->social_media_id,
                                $result->social_media_platform,
                                $result->created_at
                            );
            }
            return $user;
        }

        // Gets a user from the users table given an email or username. Returns null if user is not found.
        public function get_user_by_email_or_username($email_or_username){
            $user = null;
            $this->database->query("SELECT * FROM users WHERE username = :email_or_username OR email = :email_or_username");
            $this->database->bind(":email_or_username",$email_or_username);
            $this->database->execute();
            $results = $this->database->resultset();
            if (sizeof($results) == 1){
                $result = $results[0];
                $user = new User(
                                $result->id,
                                $result->email,
                                $result->username,
                                $result->password,
                                $result->remember_me_token,
                                $result->password_reset_token,
                                $result->password_reset_token_expiration_date,
                                $result->activated_account,
                                $result->activate_account_token,
                                $result->activate_account_token_expiration_date,
                                $result->social_media_id,
                                $result->social_media_platform,
                                $result->created_at
                            );
            }
            return $user;
        }

        // Gets a user from the users table given a user id where the password reset token expiration date is greater than or equal to the current date. Returns null if user is not found.
        public function get_user_by_id_and_password_reset_token_expiration_date($user_id){
            $user = null;
            $this->database->query("SELECT * FROM users WHERE id = :user_id AND password_reset_token_expiration_date >= NOW()");
            $this->database->bind(":user_id",$user_id);
            $this->database->execute();
            $results = $this->database->resultset();
            if (sizeof($results) == 1){
                $result = $results[0];
                $user = new User(
                                $result->id,
                                $result->email,
                                $result->username,
                                $result->password,
                                $result->remember_me_token,
                                $result->password_reset_token,
                                $result->password_reset_token_expiration_date,
                                $result->activated_account,
                                $result->activate_account_token,
                                $result->activate_account_token_expiration_date,
                                $result->social_media_id,
                                $result->social_media_platform,
                                $result->created_at
                            );
            }
            return $user;
        }

        // Gets a user from the users table given a user id where the activation account token expiration date is greater than or equal to the current date. Returns null if user is not found.
        public function get_user_by_id_and_activate_account_token_expiration_date($user_id){
            $user = null;
            $this->database->query("SELECT * FROM users WHERE id = :user_id AND activate_account_token_expiration_date >= NOW()");
            $this->database->bind(":user_id",$user_id);
            $this->database->execute();
            $results = $this->database->resultset();
            if (sizeof($results) == 1){
                $result = $results[0];
                $user = new User(
                                $result->id,
                                $result->email,
                                $result->username,
                                $result->password,
                                $result->remember_me_token,
                                $result->password_reset_token,
                                $result->password_reset_token_expiration_date,
                                $result->activated_account,
                                $result->activate_account_token,
                                $result->activate_account_token_expiration_date,
                                $result->social_media_id,
                                $result->social_media_platform,
                                $result->created_at
                            );
            }
            return $user;
        }

        // Gets a user from the users table given a social media id and social media platform. Returns null if user is not found.
        public function get_user_by_social_media_id_and_social_media_platform($social_media_id,$social_media_platform){
            $user = null;
            $this->database->query("SELECT * FROM users WHERE social_media_id = :social_media_id AND social_media_platform = :social_media_platform");
            $this->database->bind(":social_media_id",$social_media_id);
            $this->database->bind(":social_media_platform",$social_media_platform);
            $this->database->execute();
            $results = $this->database->resultset();
            if (sizeof($results) == 1){
                $result = $results[0];
                $user = new User(
                                $result->id,
                                $result->email,
                                $result->username,
                                $result->password,
                                $result->remember_me_token,
                                $result->password_reset_token,
                                $result->password_reset_token_expiration_date,
                                $result->activated_account,
                                $result->activate_account_token,
                                $result->activate_account_token_expiration_date,
                                $result->social_media_id,
                                $result->social_media_platform,
                                $result->created_at
                            );
            }
            return $user;
        }

        /***** UPDATE OPERATIONS *****/

        // Updates the value of the password field for a user given the user id. Returns boolean designating whether or not update was successful.
        public function update_password_by_id($password,$user_id){
            $this->database->query("UPDATE users SET password = :password WHERE id = :user_id");
            $this->database->bind(":password",$password);
            $this->database->bind(":user_id",$user_id);
            return $this->database->execute();
        }

        // Updates the value of the username for a user given the user id. Returns boolean designating whether or not update was successful.
        public function update_username_by_id($username,$user_id){
            $this->database->query("UPDATE users SET username = :username WHERE id = :user_id");
            $this->database->bind(":username",$username);
            $this->database->bind(":user_id",$user_id);
            return $this->database->execute();
        }

        // Updates the value of the remember_me_token field for a user given the user id. Returns a boolean designating whether or not the update was successful. 
        public function update_remember_me_token_by_id($remember_me_token,$user_id){
            $this->database->query("UPDATE users SET remember_me_token = :remember_me_token WHERE id = :user_id");
            $this->database->bind(":remember_me_token",$remember_me_token);
            $this->database->bind(":user_id",$user_id);
            return $this->database->execute();
        }

        // Updates the value of the password_reset_token field and password_reset_token_expiration_date field for a given user id. Returns boolean designating whether or not update was successful.
        public function update_password_reset_token_and_expiration_date_by_id($password_reset_token,$user_id){
            $this->database->query("UPDATE users SET password_reset_token = :password_reset_token, password_reset_token_expiration_date = DATE_ADD(NOW(), INTERVAL :interval MINUTE) WHERE id = :user_id");
            $this->database->bind(":password_reset_token",$password_reset_token);
            $this->database->bind(":interval",TOKEN_EXPIRATION_MINUTES);
            $this->database->bind(":user_id",$user_id);
            return $this->database->execute();
        }

        // Updates the value of activated_account field for a user given the user id. Returns boolean designating whether or not update was successful.
        public function update_activated_account_by_id($activated_account,$user_id){
            $this->database->query("UPDATE users SET activated_account = :activated_account WHERE id = :user_id");
            $this->database->bind(":activated_account",$activated_account);
            $this->database->bind(":user_id",$user_id);
            return $this->database->execute();
        }

        // Updates the value of the activate_account_token field and activate_account_token_expiration_date field for a given user id. Returns boolean designating whether or not update was successful.
        public function update_activate_account_token_and_expiration_date_by_id($activate_account_token,$user_id){
            $this->database->query("UPDATE users SET activate_account_token = :activate_account_token, activate_account_token_expiration_date = DATE_ADD(NOW(), INTERVAL :interval MINUTE) WHERE id = :user_id");
            $this->database->bind(":activate_account_token",$activate_account_token);
            $this->database->bind(":interval",TOKEN_EXPIRATION_MINUTES);
            $this->database->bind(":user_id",$user_id);
            return $this->database->execute();
        }

    }

?>