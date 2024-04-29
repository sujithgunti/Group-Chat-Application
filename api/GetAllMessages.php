<?php

require("./utils/functions.php");

if ($_SERVER["REQUEST_METHOD"] != "GET") {
    sendResponse(false, "Invalid request method");
}

$pdo = connect();

$query = "SELECT u.id,u.name,m.message,TO_CHAR(m.message_time, 'HH:MI') message_time FROM users u INNER JOIN messages m on u.id=m.user_id ORDER BY m.id";
$stmt = $pdo->prepare($query);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    sendResponse(true, "Success", ["messages" => $messages]);
}


sendResponse(false, "No messages");
