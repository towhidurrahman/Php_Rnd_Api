<?php


ini_set("display_errors",1);


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

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $data = json_decode(file_get_contents("php://input"));

        if(!empty($data->name) && !empty($data->password) && !empty($data->email)){

           
            $post->name = $data->name;
            $post->password = password_hash($data->password, PASSWORD_DEFAULT);
            $post->email = $data->email;


            //Create User
            if($post->create_user()){
                echo json_encode(
                    array('message' => 'User Creation Successful')

                );
            }
            else{
                echo json_encode(
                    array('message' => 'User Creation Failed'));

                
            }




        }else{
            http_response_code(503);
            echo json_encode(array("status"=>0,"message" => "All Data needed"));

        }

    }else {
       http_response_code(503);
       echo json_encode(array("status"=>0,"message" => "access denied"));
    }

    ?>