<?php   
    class accounts{

        //Define Properties
        public $description;
        public $debit;
        public $credit;
        public $transactionthrough;
        public $reference;
        public $transactiondate;
        public $enteredby;


        private $conn;
        private $table_name;

        public function __construct($db){
            $this->conn = $db;
            $this->table_name = "tbl_accounts";
        }
        

        public function create_entry(){
            // $query = 'insert into ' .$this->table_name .' set _name = :param_name, _password= :param_pass, _email= :param_email , _status = 1';
            $query = 'insert into ' .$this->table_name .' set Description = :param_description,                                                    
                                                                    debit = :param_debit, 
                                                                   credit = :param_credit , 
                                                      transaction_through = :param_transaction_through,
                                                                reference = :param_reference,
                                                          transactiondate = :param_transactiondate,
                                                               entered_by = :param_entered_by
            
            
                                                        ';

                                                     
            

            $stmt = $this->conn->prepare($query);           


            $stmt->bindparam(':param_description', $this->description);
            $stmt->bindparam(':param_debit', $this->debit);
            $stmt->bindparam(':param_credit', $this->credit);
            $stmt->bindparam(':param_transaction_through', $this->transactionthrough);
            $stmt->bindparam(':param_reference', $this->reference);
            $stmt->bindparam(':param_transactiondate', $this->transactiondate);
            $stmt->bindparam(':param_entered_by', $this->enteredby);
          

           
            

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