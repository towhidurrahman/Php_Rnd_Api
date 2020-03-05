<?php
    class Database{
        // DB params
       
        private $host = "localhost";
        private $db_name = "dahukstu_appdb";
        private $username = "dahukstu_admin";
        private $password = "tHxx_XLCjKzh";
        public $conn;



        //DB Connect
        public function connect(){
           $this->conn = null;

            try{                
            
                $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name,
                $this->username, $this->password);
                $this->conn->exec("set names utf8");



            } catch(PDOException $e){
                echo 'Connection Error: ' . $e->getMessage();

            }

            return $this->conn;
        }

    }
?>