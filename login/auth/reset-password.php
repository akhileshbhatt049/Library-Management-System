<?php


require "../config/database.php";
require "../includes/session.php";


header("Content-Type: application/json");





if(!isset($_SESSION["reset_user"])){

    echo json_encode([

        "success"=>false,

        "message"=>"Unauthorized request"

    ]);

    exit;

}





$data=json_decode(

file_get_contents("php://input"),

true

);





$password=$data["password"];





if(strlen($password)<4 ||
   strlen($password)>16){



    echo json_encode([

        "success"=>false,

        "message"=>"Password must be 4-16 characters"

    ]);

    exit;

}





$userID=$_SESSION["reset_user"];





// Hash new password

$newPassword=password_hash(

    $password,

    PASSWORD_DEFAULT

);






$stmt=$conn->prepare(

"UPDATE users 
SET password=? 
WHERE user_id=?"

);





$stmt->bind_param(

"ss",

$newPassword,

$userID

);





if($stmt->execute()){



    unset($_SESSION["reset_user"]);



    echo json_encode([

        "success"=>true,

        "message"=>"Password updated successfully"

    ]);



}

else{


    echo json_encode([

        "success"=>false,

        "message"=>"Password update failed"

    ]);

}



?>