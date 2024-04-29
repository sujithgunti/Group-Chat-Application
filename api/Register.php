<?php

require("./utils/functions.php");

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    sendResponse(false, "Invalid request method");
}

if (!isset($_POST["name"])) {
    sendResponse(false, "Name is required");
}
if (!isset($_POST["email"])) {
    sendResponse(false, "Email is required");
}
if (!isset($_POST["password"])) {
    sendResponse(false, "Password is required");
}
if (!isset($_POST["confirmPassword"])) {
    sendResponse(false, "Confirm Password is required");
}
if (!isset($_POST["DOB"])) {
    sendResponse(false, "Date of birth is required");
}

$name = $_POST["name"];
$email = $_POST["email"];
$password = md5($_POST["password"]);
$confirmPassword = $_POST["confirmPassword"];
$Date_Of_Birth = $_POST["DOB"];

if (!preg_match("/^[a-zA-Z0-9_]{3,}$/", $name)) {
    sendResponse(false, "Name must contain characters and number atleast 5");
}
if (!preg_match("/^[a-zA-Z0-9]+@[a-zA-Z]+\.[a-zA-Z]{2,}$/", $_POST["email"])) {
    sendResponse(false, "Email must in following format xxx@xx.xxx");
}
if ($_POST["password"] != $confirmPassword) {
    sendResponse(false, "The confirm account number should match the account number");
}
if (!preg_match("/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{5,16}/", $_POST["password"])) {
    sendResponse(false, "Password must contain atleast 5 letter and one capital letter,one digit and special character");
}


$pdo = connect();

$query = "SELECT * FROM users WHERE email = :email";
$stmt = $pdo->prepare($query);
$stmt->bindParam("email", $email, PDO::PARAM_STR);

$stmt->execute();
if ($stmt->rowCount() > 0) {
    sendResponse(false, "Email already exists");
}


$query = "INSERT INTO users (name, email, password,Date_Of_Birth) VALUES (:name, :email, :password,:Date_Of_Birth)";

$stmt = $pdo->prepare($query);
$stmt->bindParam("name", $name, PDO::PARAM_STR);
$stmt->bindParam("email", $email, PDO::PARAM_STR);
$stmt->bindParam("password",$password, PDO::PARAM_STR);
$stmt->bindParam("Date_Of_Birth", $Date_Of_Birth, PDO::PARAM_STR);

$stmt->execute();
if ($stmt->rowCount() > 0) {
    sendResponse(true, "Registered Successfully");
}

sendResponse(false, "User registration failed");
