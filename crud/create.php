<?php
session_start();
$funcao = $_GET['funcao'] ?? $_SESSION['funcao'] ?? 'ilhado';
$_SESSION['funcao'] = $funcao;

include '../connection_db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $cpf = $_POST['cpf'];
    $funcao = $_POST['funcao']; //ilhado ou voluntario

    $sql = "INSERT INTO usuarios (nome, email, senha, cpf, funcao) VALUES (:nome, :email, :senha, :cpf, :funcao)";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha', password_hash($senha, PASSWORD_DEFAULT)); //censura a senha
    $stmt->bindParam(':cpf', $cpf);
    $stmt->bindParam(':funcao', $funcao); // Envia ao banco o valor da funcao (ilhado ou voluntario)

    if ($stmt->execute()) {
        header("Location: ../Entrar.php?funcao=$funcao");
        exit();
    } else {
        echo "Erro ao salvar o usuário.";
        print_r($stmt->errorInfo()); 
    }
}
?>