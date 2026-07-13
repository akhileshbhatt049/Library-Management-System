<?php
session_start();
require_once "../config/database.php";
/** @var mysqli $conn */  // Add this
// ... rest

// Get input data
$data = json_decode(file_get_contents("php://input"), true);

$email = trim($data["email"] ?? "");
$password = $data["password"] ?? "";

// Validate input
if(empty($email) || empty($password)){
    echo json_encode([
        "success"=>false,
        "message"=>"Email and password required"
    ]);
    exit;
}

// Prepare and execute query
$stmt = mysqli_prepare($conn, "SELECT * FROM Accounts WHERE email = ?");
if(!$stmt) {
    echo json_encode([
        "success"=>false,
        "message"=>"Database prepare error: " . mysqli_error($conn)
    ]);
    exit;
}

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
    $_SESSION["user_id"] = $user["user_id"];
    $_SESSION["email"] = $user["email"];
    $_SESSION["fullname"] = $user["fullname"];
    
    echo json_encode([
        "success"=>true,
        "message"=>"Login successful",
        "user_id"=>$user["user_id"]
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