<?php
session_start();
include '../Entrar.php';
include '../connection_db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['senha'])) {
        $_SESSION['id'] = $user['id'];
        $_SESSION['funcao'] = $user['funcao'];
        if($_SESSION['funcao'] == 'voluntario'){
            header("Location: ../uvolpage.php");
        } else {
            header("Location: ../userpage.php");
        }
        
    } else {
        echo "
        <script>
        alert('E-mail ou senha incorretos.');
        window.location.href = '../Entrar.php?funcao=" . $_SESSION['funcao'] . "';
        </script>";
exit();
    }
}
?>