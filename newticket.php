<?php
include 'connection_db.php';
session_start();
$user_id = $_GET['id'];
$sql = "SELECT * FROM usuarios WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $user_id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
//var_dump($user['nome']);
//mostrar chamados abertos
$sql = "SELECT * FROM chamados WHERE usuario_id = :id;";
$stmt_request = $conn->prepare($sql);
$stmt_request->bindParam(':id', $user_id);
$stmt_request->execute();
$requests = $stmt_request->fetchAll(PDO::FETCH_ASSOC);
var_dump($requests);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realize um chamado</title>
    <h1>Realize um chamado:</h1>
    <script>
        function toggleAnimais() {
            const possuiAnimais = document.getElementById('possui_animais').value;
            document.getElementById('quantidade_animais_group').style.display = 
                possuiAnimais === 'sim' ? 'block' : 'none';
        }
    </script>
</head>
<body>
    <form action="crud_request/creater.php" method="POST">
        <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($user['id']) ?>">
        <label for="rua">Endereço:</label> <br>
        <input type="text" name="rua" id="rua" placeholder="Rua" required>
        <input type="number" name="numero" id="numero" placeholder="Número" required>
        <input type="text" name="bairro" id="bairro" placeholder="Bairro" required>
        <input type="text" name="cidade" id="cidade" placeholder="Cidade" required>
        <br>
        <label for="quantidade_pessoas">Quantidade de pessoas para resgate: </label>
        <input type="number" name="quantidade_pessoas" id="quantidade_pessoas" min="1" required>
        <br>
        <label for="possui_animais">Possui animais de estimação?</label>
        <select name="possui_animais" id="possui_animais" onchange="toggleAnimais()" required>
            <option value="" disabled selected>Selecione uma opção</option>
            <option value="sim">Sim</option>
            <option value="nao">Não</option>
        </select>
        <br>
        <div id="quantidade_animais_group" style="display:none;">
            <label for="quantidade_animais">Quantidade de animais:</label>
            <input type="number" name="quantidade_animais" id="quantidade_animais" min="1">
            <br>
        </div>
        <label for="situacao">Situação (opcional):</label>
        <textarea name="situacao" id="situacao" placeholder="Descreva a situação, se desejar"></textarea>
        <br>
        <input type="submit" value="Enviar">
    </form>
</body>
</html>