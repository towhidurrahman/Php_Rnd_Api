<?php   
    class Users{

        //Define Properties
        public $id;
        public $name;
        public $password;
        public $email;
        public $status;


        private $conn;
        private $table_name;

        public function __construct($db){
            $this->conn = $db;
            $this->table_name = "tbl_users";
        }
        

        public function create_user(){
            $query = 'insert into ' .$this->table_name .' set _name = :param_name, _password= :param_pass, _email= :param_email , _status = 1';
            

            $stmt = $this->conn->prepare($query);           


            $stmt->bindparam(':param_name', $this->name);
            $stmt->bindparam(':param_pass', $this->password);
            $stmt->bindparam(':param_email', $this->email);
          
            

            if($stmt->execute()){
                return true;
              }
  
              // Print error if something goes wrong
              printf("Error: %s. \n", $stmt->error);
  
              return false;

        
        }

        public function check_login(){
           
            $query = 'SELECT * FROM ' .$this->table_name . ' where _name = :param_name';

            $stmt = $this->conn->prepare($query);

            $stmt->bindparam(':param_name', $this->name);
          

            if($stmt->execute()){
                 
                return $stmt->fetch(PDO::FETCH_ASSOC);


            }

            return array();

        }


        public function read(){
           
            $query = 'SELECT * FROM ' .$this->table_name;

            $stmt = $this->conn->prepare($query);
        
          

          $stmt->execute();

          return $stmt;

        }


    }

?>