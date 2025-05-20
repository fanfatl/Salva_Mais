<?php

session_start();
include '../connection_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pegando dados do formulário
    $usuario_id = $_POST['id_usuario'];
    $rua = $_POST['rua'];
    $numero = $_POST['numero'];
    $bairro = $_POST['bairro'];
    $cidade = $_POST['cidade'];
    $quantidade_pessoas = $_POST['quantidade_pessoas'];
    $possui_animais = $_POST['possui_animais'] === 'sim' ? 1 : 0;
    $quantidade_animais = isset($_POST['quantidade_animais']) && $_POST['quantidade_animais'] !== '' ? $_POST['quantidade_animais'] : null;
    $situacao = $_POST['situacao'] ?? null;

    // Montando SQL
    $sql = "INSERT INTO chamados 
        (usuario_id, rua, numero, bairro, cidade, quantidade_pessoas, possui_animais, quantidade_animais, situacao, status, data_criacao)
        VALUES 
        (:usuario_id, :rua, :numero, :bairro, :cidade, :quantidade_pessoas, :possui_animais, :quantidade_animais, :situacao, 'aberto', NOW())";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':usuario_id', $usuario_id);
    $stmt->bindParam(':rua', $rua);
    $stmt->bindParam(':numero', $numero);
    $stmt->bindParam(':bairro', $bairro);
    $stmt->bindParam(':cidade', $cidade);
    $stmt->bindParam(':quantidade_pessoas', $quantidade_pessoas);
    $stmt->bindParam(':possui_animais', $possui_animais, PDO::PARAM_BOOL);
    $stmt->bindParam(':quantidade_animais', $quantidade_animais);
    $stmt->bindParam(':situacao', $situacao);

    if ($stmt->execute()) {
        header("Location: ../userpage.php?id=" . urlencode($usuario_id));
        exit();
    } else {
        echo "Erro ao salvar o chamado.";
        print_r($stmt->errorInfo());
    }
}
?>