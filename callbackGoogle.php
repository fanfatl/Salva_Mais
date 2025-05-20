<?php 
session_start();
$funcao = $_SESSION['funcao'] ?? 'ilhado';

require __DIR__ . "/vendor/autoload.php";

$client = new Google\Client;
$client->setClientId("1063843599243-gqe8u6vbsgtmr0l0tbiucna4c3d2b9st.apps.googleusercontent.com");
$client->setClientSecret("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");
$client->setRedirectUri("http://localhost:8080/callbackGoogle.php");

if ( ! isset($_GET["code"])){
    exit("Login failed");
}

$token = $client->fetchAccessTokenWithAuthCode($_GET["code"]);
$client->setAccessToken($token["access_token"]);
$oauth = new Google\Service\Oauth2($client);
$userinfo = $oauth->userinfo->get();
/*
var_dump(
    $userinfo->email,
    $userinfo->familyName,
    $userinfo->givenName,
    $userinfo->name
);
*/
?>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="Entrar.css">
</head>
<body>
    <div class="topo-decoracao"></div>

    <div class="login-container">
        <h1>Cadastro</h1>
        <form action="crud/create.php" method="POST">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($userinfo->name)?>" readonly required>
            </div>
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($userinfo->email)?>" readonly required>
            </div>
            <div class="form-group">
                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" name="cpf" required maxlength="14">
            </div>
            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>
            </div>
            <input type="hidden" name="funcao" value="<?php echo htmlspecialchars($funcao); ?>">
            <button type="submit" class="btn">Cadastrar</button>
        </form>
    </div>
</body>
</html>