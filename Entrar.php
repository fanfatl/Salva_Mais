<?php
session_start();
$funcao = $_GET['funcao'] ?? $_SESSION['funcao'] ?? 'ilhado';
$_SESSION['funcao'] = $funcao;
/* var_dump($_SESSION['funcao']); */
require __DIR__ . "/vendor/autoload.php";

$client = new Google\Client;
$client->setClientId("1063843599243-gqe8u6vbsgtmr0l0tbiucna4c3d2b9st.apps.googleusercontent.com");
$client->setClientSecret("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");
$client->setRedirectUri("http://localhost:8080/callbackGoogle.php");

$client->addScope("email");
$client->addScope("profile");

$url = $client->createAuthUrl();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="Entrar.css">
</head>
<body>
    <div class=topo-decoracao></div>
    
    <div class="login-container">
        <h1>Login</h1>
        <form action="crud/read.php" method="POST">
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn">Entrar</button>
            <p>Não tem um cadastro? Faça <a href="Cadastro.php?funcao=<?= htmlspecialchars($funcao) ?>">aqui</a></p>
        </form>
        <hr>
        <p><a href="Cadastro.php"></a></p>
        <button onclick="location.href = '<?= $url ?>'" class="gsi-material-button">
            <div class="gsi-material-button-icon">
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" xmlns:xlink="http://www.w3.org/1999/xlink" style="display: block;">
                    <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"></path>
                    <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"></path>
                    <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"></path>
                    <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"></path>
                    <path fill="none" d="M0 0h48v48H0z"></path>
                </svg>
            </div>
            <span class="gsi-material-button-contents">Entrar com Google</span>
        </button>
    </div>
</body>
</html>