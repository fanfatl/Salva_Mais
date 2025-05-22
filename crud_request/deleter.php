<?php
session_start();
include '../connection_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $id_chamado = $_POST['id_chamado'];

    $sql = "UPDATE chamados SET status = 'excluido' WHERE id = :id_chamado";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_chamado', $id_chamado, PDO::PARAM_INT);
    if ($stmt->execute()) {
        echo "<script>alert('Chamado excluído com sucesso!');</script>";
        header("Location: ../userpage.php");
        exit();
    } else {
        echo "<script>alert('Erro ao excluir chamado.');</script>";
        header("Location: ../userpage.php");
        exit();
    }
}
?>