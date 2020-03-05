<?php

ini_set("display_errors",1);
    // include vendor

    require '../vendor/autoload.php';
    use \Firebase\JWT\JWT;

    // Headers
    header('Access-Control-Allow-origin:*');
    header('Content-Type: application/json; charst=UTF-8');
    header('Access-Control-Allow-Methods: GET');

    include_once '../config/Database.php';
    include_once '../classes/accounts.php';
    include_once '../classes/authenticate.php';


    //Instatiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $post = new accounts($db);


    if($_SERVER['REQUEST_METHOD'] == 'GET'){

        $data = json_decode(file_get_contents("php://input"));

       
        // if(!empty($data->token)){
        // $token_obj = new authenticate();
        // $validate_token = $token_obj-> validate_token($data->token);

               
        //if($validate_token ==1){
            // echo json_encode(array("Message'"=> "ok"));

            $result = $post->read();

           // Get row count
    $num = $result->rowcount();

    // Check if any posts
    if($num>0){
        // Post array
        $post_arr = array();
        $posts_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
          
            extract($row);

           $post_item = array( 
               'id' => $id,    
               'description' => $Description,           
               'debit' => $debit,
               'credit' => $credit,
               'transactionthrough' => $transaction_through,
               'reference' => $reference,
               'transactiondate' => $transactiondate
               

           );

        // PUsh to the 'data'
        array_push($posts_arr['data'], $post_item);

        }

        // Turn to Json & output
        echo json_encode($posts_arr);

        }

        
      //  }
       // }
    }


?>