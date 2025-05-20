<?php
session_start();
$user_id = $_GET['id'];
include 'connection_db.php';
$sql = "SELECT * FROM usuarios WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $user_id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
//chamados
$sql = "SELECT * FROM chamados WHERE usuario_id = :id;";
$stmt_request = $conn->prepare($sql);
$stmt_request->bindParam(':id', $user_id);
$stmt_request->execute();
$chamado = $stmt_request->fetchAll(PDO::FETCH_ASSOC);
//var_dump($chamado);


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
    <h3>Seu Chamado:</h3>
    <ul>
        <?php if (count($chamado) > 0): ?>
            <?php foreach ($chamado as $request): ?>
                <li>
                    <strong>Chamado ID:</strong> <?= htmlspecialchars($request['id']) ?><br>
                    <strong>Rua:</strong> <?= htmlspecialchars($request['rua']) ?><br>
                    <strong>Número:</strong> <?= htmlspecialchars($request['numero']) ?><br>
                    <strong>Bairro:</strong> <?= htmlspecialchars($request['bairro']) ?><br>
                    <strong>Cidade:</strong> <?= htmlspecialchars($request['cidade']) ?><br>
                    <strong>Quantidade de pessoas para resgate:</strong> <?= htmlspecialchars($request['quantidade_pessoas']) ?><br>
                    <strong>Possui animais de estimação:</strong> <?= htmlspecialchars($request['possui_animais'] ? 'Sim' : 'Não') ?><br>
                    <?php if ($request['possui_animais']): ?>
                        <strong>Quantidade de animais:</strong> <?= htmlspecialchars($request['quantidade_animais']) ?><br>
                    <?php endif; ?>
                    <strong>Data de criação:</strong> <?= htmlspecialchars($request['data_criacao']) ?><br>
                    <strong>Situação:</strong> <?= htmlspecialchars($request['situacao']) ?><br>
                    <strong>Status:</strong> <?= htmlspecialchars($request['status']) ?><br>
        <li>
           <?php endforeach; ?>
        <?php else: ?>
            <li>Nenhum chamado encontrado.</li> 
            <a href="newticket.php?id=<?=htmlspecialchars($user['id'])?>">Novo Chamado</a></li>
        <?php endif; ?>

    </ul>
</body>
</html>