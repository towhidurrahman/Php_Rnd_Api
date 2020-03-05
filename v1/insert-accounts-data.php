<?php


ini_set("display_errors",1);


    // Headers
    header('Access-Control-Allow-origin:*');
    header('Content-Type: application/json; charst=UTF-8');
    header('Access-Control-Allow-Methods: POST');

    include_once '../config/Database.php';
    include_once '../classes/accounts.php';

    //Instatiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $post = new accounts($db);

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $data = json_decode(file_get_contents("php://input"));

        if(!empty($data->description) ){

           
            $post->description = $data->description;
            $post->debit = $data->debit;
            $post->credit = $data->credit;
            $post->transactionthrough = $data->transactionthrough;
            $post->reference = $data->reference;
            $post->transactiondate = $data->transactiondate;
            $post->enteredby = $data->enteredby;
            

            //Create User
            if($post->create_entry()){
                echo json_encode(
                    array('message' => 'Data insertion Successful')

                );
            }
            else{
                echo json_encode(
                    array('message' => 'Data insertion Failed'));

                
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