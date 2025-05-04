<?php
session_start();
$user_id = $_GET['id'];
include 'connection_db.php';
$sql = "SELECT * FROM usuarios WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $user_id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
/* var_dump(
    $user['nome'],
    $user['email'],
    $user['senha'],
    $user['cpf'],
    $user['funcao']
) */

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SalvaMais</title>
</head>
<h1>Olá, <?=$user['nome']?></h1>
<body>
    
</body>
</html>