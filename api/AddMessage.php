<?php

require("./utils/functions.php");

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    sendResponse(false, "Invalid request method");
}

if (!isset($_POST["user_id"])) {
    sendResponse(false, "user_id is required");
}

if (empty($_POST["message"])) {
    sendResponse(false, "message is required");
} else {
    $message = test_input($_POST["message"]);
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    return $data;
}
$user_id = $_POST["user_id"];

$pdo = connect();

$query = "INSERT INTO messages (user_id, message) VALUES (:user_id, :message)";

$stmt = $pdo->prepare($query);
$stmt->bindParam("user_id", $user_id, PDO::PARAM_STR);
$stmt->bindParam("message", $message, PDO::PARAM_STR);

$stmt->execute();
if ($stmt->rowCount() > 0) {
    sendResponse(true, " Successfully inserted");
}

sendResponse(false, "Failed");
