<?php

ini_set("display_errors",1);
    // include vendor

    require '../vendor/autoload.php';
    use \Firebase\JWT\JWT;

    // Headers
    header('Access-Control-Allow-origin:*');
    header('Content-Type: application/json; charst=UTF-8');
    header('Access-Control-Allow-Methods: POST');

    include_once '../config/Database.php';
    include_once '../classes/Users.php';
    include_once '../classes/authenticate.php';


    //Instatiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $post = new Users($db);

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $data = json_decode(file_get_contents("php://input"));

        if(!empty($data->name) && !empty($data->password)){

            $post->name = $data->name;
            $post->password = $data->password;
           

            $user_data = $post->check_login();

                    

            if(!empty($user_data)){

                $data_name  = $user_data['_name'];
                $data_password  = $user_data['_password'];
                


                if(password_verify($data->password, $data_password)){                  
                            
               
            
            $token_obj = new authenticate();
            $token = $token_obj->generate_token($user_data['_name'], $user_data['_password']);


                ////

                echo json_encode(array(
                    "status" => 1,
                    "token" => $token,
                    "message" =>"User Logged in successfully"
                ));        


                }else{
                    http_response_code(404);
                    echo json_encode(array(
                        "status" => 0,
                        "message" =>"Invalid credentials"
                    ));

                }
            


            } else{
                http_response_code(404);
                echo json_encode(array(
                    "status" => 0,
                    "message" =>"Invalid credentials"
                ));
            }


        }else{
            http_response_code(503);
            echo json_encode(array("status"=>0,"message" => "All Data needed"));

        }

    }
   

    ?>