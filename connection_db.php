<?php
$host = "localhost";
$dbname = "salva_mais";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST["email"];
        $familyName = $_POST["familyName"];
        $givenName = $_POST["givenName"];
        $name = $_POST["name"];

        $sql = "INSERT INTO usuarios (email, family_name, given_name, full_name) VALUES (:email, :familyName, :givenName, :fullName)";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":familyName", $familyName);
        $stmt->bindParam(":givenName", $givenName);
        $stmt->bindParam(":fullName", $name);

        $stmt->execute();

        echo "Usuário salvo com sucesso!";
    }
} catch (PDOException $e) {
    echo "Erro ao salvar usuário: " . $e->getMessage();
}
?>
