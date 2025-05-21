<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: Entrar.php?funcao=ilhado");
    exit();
}

$user_id = $_SESSION['id'];

include 'connection_db.php';

// user
$sql = "SELECT * FROM usuarios WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// chamado
$sql = "SELECT * FROM chamados WHERE usuario_id = :id";
$stmt_request = $conn->prepare($sql);
$stmt_request->bindParam(':id', $user_id, PDO::PARAM_INT);
$stmt_request->execute();
$chamado = $stmt_request->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SalvaMais</title>
</head>
<body>
    <h1>Olá, <?= htmlspecialchars($user['nome']) ?></h1>

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
                    <strong>Possui animais de estimação:</strong> <?= $request['possui_animais'] ? 'Sim' : 'Não' ?><br>
                    <?php if ($request['possui_animais']): ?>
                        <strong>Quantidade de animais:</strong> <?= htmlspecialchars($request['quantidade_animais']) ?><br>
                    <?php endif; ?>
                    <strong>Data de criação:</strong> <?= htmlspecialchars($request['data_criacao']) ?><br>
                    <strong>Situação:</strong> <?= htmlspecialchars($request['situacao']) ?><br>
                    <strong>Status:</strong> <?= htmlspecialchars($request['status']) ?><br>
                    <form action="crud_request/deleter.php" method="POST">
                        <input type="hidden" name="id_chamado" value=" <?= htmlspecialchars($request['id']) ?>">
                        <button type="submit" onclick="return confirm('Realmente deseja excluir esse chamado?')">Excluir Chamado</button>
                    </form>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>Nenhum chamado encontrado.</li> 
            <li><a href="newticket.php">Novo Chamado</a></li>
        <?php endif; ?>
    </ul>
</body>
</html>
