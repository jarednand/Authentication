<?php

    class Hasher {

        // Generates a hash given a value
        public function generate_hash($value){
            return password_hash($value,PASSWORD_DEFAULT);
        }

        // Returns true if a given value is equal to the unhashed value of a hash
        public function verify_hash($value,$hash){
            return password_verify($value,$hash);
        }

    }

?>