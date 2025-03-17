<?php
include '../connection_db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $familyName = $_POST["familyName"];
    $givenName = $_POST["givenName"];
    $name = $_POST["name"];
    $cpf = $_POST["cpf"];

    $sql = "INSERT INTO usuarios (email, family_name, given_name, full_name, cpf) VALUES (:email, :familyName, :givenName, :fullName, :cpf)";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":familyName", $familyName);
    $stmt->bindParam(":givenName", $givenName);
    $stmt->bindParam(":fullName", $name);
    $stmt->bindParam(":cpf", $cpf);

    if ($stmt->execute()) {
        echo "Usuário salvo com sucesso!";
    } else {
        echo "Erro ao salvar o usuário.";
        print_r($stmt->errorInfo()); 
    }
}
?>