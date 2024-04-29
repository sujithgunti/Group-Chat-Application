<?php
function connect()
{
    $host = 'localhost';
    $port = '5432';
    $db_name = 'chat';
    $db_username = 'postgres';
    $db_password = 'admin';

    $conStr = sprintf(
        "pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s",
        $host,
        $port,
        $db_name,
        $db_username,
        $db_password
    );

    $pdo = new \PDO($conStr);
    $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

    return $pdo;
}

function sendResponse($status = false, $message = "", $data = null)
{
    echo json_encode(["status" => $status, "message" => $message, "data" => $data]);
    exit();
}

function generateToken($pdo, $length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }

    $query = "SELECT * FROM users WHERE token  = :token";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam("token", $randomString, \PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $randomString = generateToken($pdo, $length);
    }
    return $randomString;
}
