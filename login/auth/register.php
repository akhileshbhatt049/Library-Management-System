<?php

require "../config/database.php";


header("Content-Type: application/json");



$data = json_decode(
    file_get_contents("php://input"),
    true
);



$name = trim($data["fullname"]);

$email = trim($data["email"]);

$phone = trim($data["phone"]);

$password = $data["password"];




if(
    empty($name) ||
    empty($email) ||
    empty($phone) ||
    empty($password)
){

    echo json_encode([
        "success"=>false,
        "message"=>"All fields required"
    ]);

    exit;

}





if(strlen($password)<4 || strlen($password)>16){


    echo json_encode([

        "success"=>false,

        "message"=>"Password must be 4-16 characters"

    ]);

    exit;

}





// Check existing user


$stmt=$conn->prepare(

"SELECT id FROM users WHERE email=? OR phone=?"

);


$stmt->bind_param(
    "ss",
    $email,
    $phone
);


$stmt->execute();


$result=$stmt->get_result();



if($result->num_rows>0){


    echo json_encode([

        "success"=>false,

        "message"=>"Email or phone already exists"

    ]);

    exit;

}





// Generate User ID


$result=$conn->query(

"SELECT id FROM users ORDER BY id DESC LIMIT 1"

);



if($result->num_rows>0){


    $row=$result->fetch_assoc();

    $number=$row["id"]+1;


}

else{


    $number=1;

}



$userID=str_pad(
    $number,
    4,
    "0",
    STR_PAD_LEFT
);




// Hash password

$hash=password_hash(
    $password,
    PASSWORD_DEFAULT
);





$stmt=$conn->prepare(

"INSERT INTO users
(user_id,fullname,email,phone,password)
VALUES(?,?,?,?,?)"

);



$stmt->bind_param(

"sssss",

$userID,

$name,

$email,

$phone,

$hash

);




if($stmt->execute()){


    echo json_encode([

        "success"=>true,

        "message"=>"Account created",

        "user_id"=>$userID

    ]);


}

else{


    echo json_encode([

        "success"=>false,

        "message"=>"Registration failed"

    ]);

}



?>