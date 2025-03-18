<?php 
function delete($id) {
include 'connection_db.php';
    $sql = "DELETE FROM usuarios WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt -> bindParam(":id", $id);
    if ($stmt->execute()) {
        echo "Usuário deletado com sucesso!";
    } else {
        echo "Erro ao deletar o usuário.";
        print_r($stmt->errorInfo()); 
    }
}    
        
?>