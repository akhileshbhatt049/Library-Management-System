<?php
session_start();
require_once "../config/database.php";
/** @var mysqli $conn */  // Add this
// ... rest


header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

$name = trim($data["fullname"] ?? "");
$email = trim($data["email"] ?? "");
$phone = trim($data["phone"] ?? "");
$password = $data["password"] ?? "";

if (empty($name) || empty($email) || empty($phone) || empty($password)) {
    echo json_encode([
        "success" => false,
        "message" => "All fields required"
    ]);
    exit;
}

if (strlen($password) < 4 || strlen($password) > 16) {
    echo json_encode([
        "success" => false,
        "message" => "Password must be 4-16 characters"
    ]);
    exit;
}

// Check existing user
$stmt = mysqli_prepare($conn, "SELECT id FROM Accounts WHERE email = ? OR phone = ?");
mysqli_stmt_bind_param($stmt, "ss", $email, $phone);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    echo json_encode([
        "success" => false,
        "message" => "Email or phone already exists"
    ]);
    exit;
}

// Generate User ID
$result = mysqli_query($conn, "SELECT id FROM Accounts ORDER BY id DESC LIMIT 1");
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $number = $row["id"] + 1;
} else {
    $number = 1;
}
$userID = "STU" . str_pad($number, 4, "0", STR_PAD_LEFT);

// Hash password
$hash = password_hash($password, PASSWORD_DEFAULT);

// Insert user
$stmt = mysqli_prepare($conn, "INSERT INTO Accounts (user_id, fullname, email, phone, password, is_admin) VALUES (?, ?, ?, ?, ?, 0)");
mysqli_stmt_bind_param($stmt, "sssss", $userID, $name, $email, $phone, $hash);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode([
        "success" => true,
        "message" => "Account created successfully",
        "user_id" => $userID
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Registration failed: " . mysqli_error($conn)
    ]);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
