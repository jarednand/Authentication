<?php

    class NonceData {

        private $database;

        public function __construct(){
            $this->database = new Database;
        }

        /***** INSERT OPERATIONS *****/

        // Inserts a nonce into the nonces table given a value. Returns a boolean designating whether or not insert was successful.
        public function insert_nonce($value){
            $this->database->query("INSERT INTO nonces (value) VALUES(:value)");
            $this->database->bind(":value",$value);
            return $this->database->execute();
        }

        /***** GET OPERATIONS *****/

        // Gets a nonce from the nonces table given a value. Returns null if nonce is not found.
        public function get_nonce_by_value($value){
            $nonce = null;
            $this->database->query("SELECT * FROM nonces WHERE value = :value");
            $this->database->bind(":value",$value);
            $this->database->execute();
            $results = $this->database->resultset();
            if (sizeof($results) == 1){
                $result = $results[0];
                $nonce = new Nonce(
                                $result->id,
                                $result->value,
                                $result->created_at
                            );
            }
            return $nonce;
        }

    }

?>