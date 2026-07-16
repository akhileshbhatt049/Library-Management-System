<?php
session_start();

require_once "../config/database.php";
/** @var mysqli $conn */

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

$email = trim($data["email"] ?? "");
$password = $data["password"] ?? "";

if(empty($email) || empty($password)){
    echo json_encode([
        "success"=>false,
        "message"=>"Email and password required"
    ]);
    exit;
}

$stmt = mysqli_prepare($conn, "SELECT * FROM Accounts WHERE email = ?");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if(mysqli_num_rows($result) == 0){
    echo json_encode([
        "success"=>false,
        "message"=>"Account not found"
    ]);
    exit;
}

$user = mysqli_fetch_assoc($result);

if(password_verify($password, $user["password"])){
    // Set session variables
    $_SESSION["user_id"] = $user["user_id"];
    $_SESSION["email"] = $user["email"];
    $_SESSION["fullname"] = $user["fullname"];
    $_SESSION["is_admin"] = $user["is_admin"]; // ✅ Added this
    
    echo json_encode([
        "success"=>true,
        "message"=>"Login successful",
        "user_id"=>$user["user_id"],
        "is_admin"=>$user["is_admin"] // ✅ Send admin status to frontend
    ]);
} else {
    echo json_encode([
        "success"=>false,
        "message"=>"Incorrect password"
    ]);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>