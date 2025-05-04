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
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['funcao'] = $user['funcao'];
        if($_SESSION['funcao'] == 'voluntario'){
            header("Location: ../uvolpage.php?id=" . $_SESSION['user_id']);
        } else {
            header("Location: ../userpage.php?id=" . $_SESSION['user_id']);
        }
        
    } else {
        echo "
        <script>
        alert('E-mail ou senha incorretos.');
        window.location.href = '../Entrar.php';
        </script>";
exit();
    }
}
?>