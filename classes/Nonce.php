<?php

    class Nonce {

        // Private variables
        private $id;
        private $value;
        private $created_at;

        // Constructor
        public function __construct($id,$value,$created_at){
            $this->id = $id;
            $this->value = $value;
            $this->created_at = $created_at;
        }

        // Getter methods
        public function get_id(){ return $this->id; }
        public function get_value(){ return $this->value; }
        public function get_created_at(){ return $this->created_at; }

        // Setter methods
        public function set_id($id){ $this->id = $id; }
        public function set_value($value){ $this->value = $value; }
        public function set_created_at($created_at){ $this->created_at = $created_at; }

        // Returns the User object as a formatted string
        public function to_string(){
            $string = "";
            $string .= "Id: " . $this->id . "<br>";
            $string .= "Value: " . $this->value . "<br>";
            $string .= "Created At: " . $this->created_at . "<br>";
            return $string; 
        }

    }

?>