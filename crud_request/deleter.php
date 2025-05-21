<?php
include '../connection_db.php';
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_chamado = $_POST['id_chamado'];

    $sql = "DELETE FROM chamados WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id_chamado, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header("Location: ../userpage.php" . $_SESSION['id']);
        exit();
    } else {
        echo "Erro ao excluir o chamado.";
        print_r($stmt->errorInfo());
    }
}
?>