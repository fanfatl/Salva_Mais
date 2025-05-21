<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: Entrar.php?funcao=ilhado");
    exit();
}

$user_id = $_SESSION['id'];

include 'connection_db.php';

// user
$sql = "SELECT * FROM usuarios WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// chamado
$sql = "SELECT * FROM chamados WHERE usuario_id = :id";
$stmt_request = $conn->prepare($sql);
$stmt_request->bindParam(':id', $user_id, PDO::PARAM_INT);
$stmt_request->execute();
$chamado = $stmt_request->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SalvaMais - Minha Conta</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    
    <!-- Menu Lateral -->
    <div class="menu-container" id="menuContainer">
        <div class="menu-header">
        <h3>Menu</h3>
        <button onclick="toggleMenu()">✕</button>
    </div>
    <div class="menu-items">
        <div class="menu-item menu-home" onclick="navigate('userpage.php')">
            <span class="icon"></span>
            <span>Início</span>
        </div>
        <div class="menu-item menu-new" onclick="navigate('newticket.php')">
            <span class="icon"></span>
            <span>Novo Chamado</span>
        </div>
        <div class="menu-item menu-requests" onclick="navigate('userpage.php#requests')">
            <span class="icon"></span>
            <span>Meus Chamados</span>
        </div>
        <div class="menu-item menu-map" onclick="navigate('resgate_map.php')">
            <span class="icon"></span>
            <span>Mapa de Resgate</span>
        </div>
        <div class="menu-item menu-profile" onclick="navigate('profile.php')">
            <span class="icon"></span>
            <span>Meu Perfil</span>
        </div>
        <div class="menu-item menu-settings" onclick="navigate('settings.php')">
            <span class="icon"></span>
            <span>Configurações</span>
        </div>
        <div class="menu-item menu-help" onclick="navigate('help.php')">
            <span class="icon"></span>
            <span>Ajuda</span>
        </div>
        <div class="menu-item menu-logout" onclick="logout()">
            <span class="icon"></span>
            <span>Sair</span>
        </div>
    </div>
</div>
<!-- Menu Toggle Button -->
<button class="menu-toggle" onclick="toggleMenu()">☰</button>

<script>
    function toggleMenu() {
        const menu = document.getElementById('menuContainer');
       // const content = document.querySelector('.main-content');
        
        menu.classList.toggle('active');
        //content.classList.toggle('shifted');
    }

    function navigate(page) {
        window.location.href = page;
    }

    function logout() {
        // Implementar lógica de logout
        window.location.href = 'logout.php';
    }
</script>
<div class="main-content">
    <div class="container">
        <header>
            <h1>Olá, <?= htmlspecialchars($user['nome']) ?></h1>
        </header>

        <div class="card">
            <h2>Seus Chamados</h2>
            
            <?php if (count($chamado) > 0): ?>
                <ul class="request-list">
                    <?php foreach ($chamado as $request): ?>
                        <li class="request-item">
                            <h3>Chamado #<?= htmlspecialchars($request['id']) ?></h3>
                            <p><strong>Endereço:</strong> <?= htmlspecialchars($request['rua']) ?>, <?= htmlspecialchars($request['numero']) ?> - <?= htmlspecialchars($request['bairro']) ?>, <?= htmlspecialchars($request['cidade']) ?></p>
                            <p><strong>Pessoas para resgate:</strong> <?= htmlspecialchars($request['quantidade_pessoas']) ?></p>
                            <p><strong>Animais:</strong> <?= $request['possui_animais'] ? 'Sim (' . htmlspecialchars($request['quantidade_animais']) . ')' : 'Não' ?></p>
                            <p><strong>Situação:</strong> <?= htmlspecialchars($request['situacao']) ? htmlspecialchars($request['situacao']) : 'Não informada' ?></p>
                            <p><strong>Data:</strong> <?= htmlspecialchars($request['data_criacao']) ?></p>
                            <p><strong>Status:</strong> <span class="status-<?= strtolower(htmlspecialchars($request['status'])) ?>"><?= htmlspecialchars($request['status']) ?></span></p>
                            
                            <form action="crud_request/deleter.php" method="POST">
                                <input type="hidden" name="id_chamado" value="<?= htmlspecialchars($request['id']) ?>">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Realmente deseja excluir esse chamado?')">Excluir Chamado</button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <div class="no-requests">
                    <p>Nenhum chamado encontrado.</p>
                    <a href="newticket.php" class="btn btn-success">Criar Novo Chamado</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div></div>
</body>
</html>