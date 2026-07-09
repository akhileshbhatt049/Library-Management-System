<?php

session_start();

require "../config/database.php";

header("Content-Type: application/json");


$data = json_decode(
    file_get_contents("php://input"),
    true
);


$email = trim($data["email"] ?? "");
$password = $data["password"] ?? "";


if(empty($email) || empty($password)){

    echo json_encode([
        "success"=>false,
        "message"=>"Email and password required"
    ]);

    exit;
}



$stmt = $conn->prepare(
    "SELECT * FROM users WHERE email=?"
);


$stmt->bind_param(
    "s",
    $email
);


$stmt->execute();


$result = $stmt->get_result();



if($result->num_rows == 0){

    echo json_encode([
        "success"=>false,
        "message"=>"Account not found"
    ]);

    exit;

}



$user = $result->fetch_assoc();



if(password_verify($password, $user["password"])){


    $_SESSION["user_id"] = $user["user_id"];
    $_SESSION["email"] = $user["email"];


    echo json_encode([

        "success"=>true,

        "message"=>"Login successful",

        "user_id"=>$user["user_id"]

    ]);


}
else{


    echo json_encode([

        "success"=>false,

        "message"=>"Incorrect password"

    ]);

}


?>