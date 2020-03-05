<?php
 ini_set("display_errors", 1);
 require '../vendor/autoload.php';

 use \Firebase\JWT\JWT;

  // Headers
  header('Access-Control-Allow-origin:*');
  header('Content-Type: application/json; charst=UTF-8');
  header('Access-Control-Allow-Methods: POST');

  include_once '../config/Database.php';
  include_once '../classes/Users.php';


  //Instatiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $post = new Users($db);

class authenticate{

    public function generate_token($name, $password){  

        $iss = 'localhost';
                $iat = time();
                $nbf = $iat + 2;
                $exp = $iat + 1800;
                $aud = 'myusers';
                $user_arr_data = array(
                    "name" => $name,
                    "password" => $password
                );
            
                $secret_key = 'erprnd';
            
            
                $payload_info = array(
                    "iss"=> $iss,
                    "iat"=> $iat,
                    "nbf"=> $nbf,
                    "exp"=> $exp,
                    "aud"=> $aud,
                    "data"=> $user_arr_data
                );
            
               $jwt =  JWT::encode($payload_info, $secret_key, 'HS512');

               return $jwt;

    }


    public function validate_token($token){         
    

        if(!empty($token)){            

            try{

                $secret_key = 'erprnd';

                $decoded_data = JWT::decode($token, $secret_key, array('HS512'));

             http_response_code(200);


             $user_name = $decoded_data->data->name;


            // echo json_encode(array(
            //     "status" => 1,
            //     "message" => "we got jwt",
            //     "user_data" => $decoded_data,
            //     "user_name" => $user_name
            // ));

            return 1;



            }catch(Exception $ex){

                http_response_code(500);
                echo json_encode(array(
                    "status" => 0,
                    "message" => $ex->getMessage()
                ));

            }



          
        }
  

    }
}

?>