<?php
session_start();
include 'connection_db.php';

if (!isset($_SESSION['id'])) {
    header("Location: Entrar.php");
    exit();
}

$user_id = $_SESSION['id'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realize um chamado</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function toggleAnimais() {
            const possuiAnimais = document.getElementById('possui_animais').value;
            document.getElementById('quantidade_animais_group').style.display = 
                possuiAnimais === 'sim' ? 'block' : 'none';
        }
    </script>
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
        //const content = document.querySelector('.main-content');
        
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
            <h1>Realize um chamado</h1>
        </header>
        
        <div class="card">
            <form action="crud_request/creater.php" method="POST">
                <input type="hidden" name="usuario_id" value="<?= htmlspecialchars($user_id) ?>">
                
                <div class="form-group">
                    <label for="rua">Endereço:</label>
                    <div class="address-group">
                        <input type="text" name="rua" id="rua" placeholder="Rua" required>
                        <input type="number" name="numero" id="numero" placeholder="Número" required>
                        <input type="text" name="bairro" id="bairro" placeholder="Bairro" required>
                        <input type="text" name="cidade" id="cidade" placeholder="Cidade" required>
                    </div>
                    <button type="button" class="btn" onclick="getEndereco()">Usar minha localização atual</button>
                    <p id="endereco">Endereço: </p>
                </div>
                
                <div class="form-group">
                    <label for="quantidade_pessoas">Quantidade de pessoas para resgate:</label>
                    <input type="number" name="quantidade_pessoas" id="quantidade_pessoas" min="1" required>
                </div>
                
                <div class="form-group">
                    <label for="possui_animais">Possui animais de estimação?</label>
                    <select name="possui_animais" id="possui_animais" onchange="toggleAnimais()" required>
                        <option value="" disabled selected>Selecione uma opção</option>
                        <option value="sim">Sim</option>
                        <option value="nao">Não</option>
                    </select>
                </div>
                
                <div id="quantidade_animais_group" class="form-group hidden">
                    <label for="quantidade_animais">Quantidade de animais:</label>
                    <input type="number" name="quantidade_animais" id="quantidade_animais" min="1">
                </div>
                
                <div class="form-group">
                    <label for="situacao">Situação (opcional):</label>
                    <textarea name="situacao" id="situacao" rows="4" placeholder="Descreva a situação, se desejar"></textarea>
                </div>
                
                <input type="submit" class="btn btn-success" value="Enviar Chamado">
            </form>
        </div>
    </div>
    
    <script>
        
        async function getEndereco() {
            if (!navigator.geolocation) {
                alert("Geolocalização não suportada.");
                return;
            }

            navigator.geolocation.getCurrentPosition(
                async function(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;

                    try {
                        const response = await fetch(
                            `https://maps.googleapis.com/maps/api/geocode/json?latlng=${lat},${lng}&key=AIzaSyCYVmO-Av6Mnp7YIDCQQOIcC8-rhLhs1WY`
                        );

                        const dados = await response.json();
                        console.log(dados);

                        if (dados.status === "OK") {
                            const resultado = dados.results[0];
                            const componentes = resultado.address_components;

                            let rua = "", numero = "", bairro = "", cidade = "";

                            componentes.forEach(c => {
                                if (c.types.includes("route")) rua = c.long_name;
                                if (c.types.includes("street_number")) numero = c.long_name;
                                if (c.types.includes("sublocality") || c.types.includes("sublocality_level_1")) bairro = c.long_name;
                                if (c.types.includes("administrative_area_level_2")) cidade = c.long_name;
                            });

                            
                            document.getElementById("rua").value = rua;
                            document.getElementById("numero").value = numero;
                            document.getElementById("bairro").value = bairro;
                            document.getElementById("cidade").value = cidade;

                            document.getElementById("endereco").textContent = "Endereço: " + resultado.formatted_address;
                        } else {
                            document.getElementById("endereco").textContent = "Erro ao obter endereço.";
                        }
                    } catch (erro) {
                        console.error("Erro ao conectar com a API:", erro);
                        document.getElementById("endereco").textContent = "Erro ao conectar à API.";
                    }
                },
                function(error) {
                    alert("Erro ao obter localização: " + error.message);
                },
                {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                }
            );
        }
    </script>
    </div>
</body>
</html>