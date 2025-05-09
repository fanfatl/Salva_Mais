<?php
$funcao = $_GET['funcao'] ?? 'ilhado';
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
                <input type="text" id="nome" name="nome" required>
            </div>
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required>
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