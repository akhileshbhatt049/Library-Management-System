<?php


require "../config/database.php";
require "../includes/session.php";


header("Content-Type: application/json");




$data = json_decode(

    file_get_contents("php://input"),

    true

);




$email = trim($data["email"]);

$phone = trim($data["phone"]);





$stmt=$conn->prepare(

"SELECT user_id FROM users 
WHERE email=? AND phone=?"

);




$stmt->bind_param(

"ss",

$email,

$phone

);



$stmt->execute();



$result=$stmt->get_result();





if($result->num_rows == 1){



    $user=$result->fetch_assoc();




    // Store user temporarily

    $_SESSION["reset_user"] =
    $user["user_id"];





    echo json_encode([

        "success"=>true,

        "message"=>"Account verified"

    ]);



}

else{


    echo json_encode([

        "success"=>false,

        "message"=>"Email or phone does not match"

    ]);


}



?>