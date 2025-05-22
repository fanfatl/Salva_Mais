<?php
//pegar chamados com status aberto (dps tem que criar o status fechado, encerrado e em andamento)
include 'connection_db.php';
$sql = "SELECT * FROM chamados WHERE status = 'aberto'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$chamado = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Geolocalização com Google Maps</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <style>
        #map {
            height: 70vh;
        }
        .custom-map-control-button{
          transform: translateY(-100%);
        }
        
    </style>
</head>
<body>
  
  <!-- Menu Lateral -->
  <div class="menu-container" id="menuContainer">
    <div class="menu-header">
        <h3>Menu</h3>
        <button onclick="toggleMenu()">✕</button>
      </div>
      <div class="menu-items">
          <div class="menu-item menu-map" onclick="navigate('uvolpage.php')">
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
       
        
        menu.classList.toggle('active');

    }

    function navigate(page) {
        window.location.href = page;
    }

    function logout() {
        window.location.href = 'logout.php';
    }
</script>
<div class="main-content">
    <div class="container">
        <header>
            <h1>Visualização de Mapa</h1>
        </header>
        
        <div class="card">
            <div id="map"></div>
        </div>
    </div>
    <div class="request-item">
    <h2>Chamados em aberto:</h2>
     <?php if (count($chamado) > 0): ?>
                <ul class="request-list">
                    <?php foreach ($chamado as $request): ?>
                        <li class="request-item">
                            <h3>Chamado #<?= htmlspecialchars($request['id']) ?></h3>
                            <p><strong>Nome: </strong></p>
                            <p><strong>Endereço:</strong> <?= htmlspecialchars($request['rua']) ?>, <?= htmlspecialchars($request['numero']) ?> - <?= htmlspecialchars($request['bairro']) ?>, <?= htmlspecialchars($request['cidade']) ?></p>
                            <p><strong>Pessoas para resgate:</strong> <?= htmlspecialchars($request['quantidade_pessoas']) ?></p>
                            <p><strong>Animais:</strong> <?= $request['possui_animais'] ? 'Sim (' . htmlspecialchars($request['quantidade_animais']) . ')' : 'Não' ?></p>
                            <p><strong>Situação:</strong> <?= htmlspecialchars($request['situacao']) ? htmlspecialchars($request['situacao']) : 'Não informada' ?></p>
                            <p><strong>Data:</strong> <?= htmlspecialchars($request['data_criacao']) ?></p>
                            <p><strong>Status:</strong> <span class="status-<?= strtolower(htmlspecialchars($request['status'])) ?>"><?= htmlspecialchars($request['status']) ?></span></p>
                            
                            <form action="aceitar_chamado.php" method="POST">
                                <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($user_id) ?>">
                                <input type="hidden" name="id_chamado" value="<?= htmlspecialchars($request['id']) ?>">
                                <button type="submit">Aceitar Chamado</button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <div class="no-requests">
                    <p>Nenhum chamado encontrado.</p>
                </div>
            <?php endif; ?>
    </div>

    <script>
        let map, infoWindow;

        function initMap() {
            map = new google.maps.Map(document.getElementById("map"), {
                center: { lat: -34.397, lng: 150.644 },
                zoom: 6,
            });

            infoWindow = new google.maps.InfoWindow();

            const locationButton = document.createElement("button");
            locationButton.textContent = "Ir para minha localização";
            locationButton.classList.add("custom-map-control-button");
            map.controls[google.maps.ControlPosition.BOTTOM_CENTER].push(locationButton);

            locationButton.addEventListener("click", () => {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            const pos = {
                                lat: position.coords.latitude,
                                lng: position.coords.longitude,
                            };

                            
                            new google.maps.Marker({
                                position: pos,
                                map: map,
                                title: "Você está aqui",
                            });

                            
                            infoWindow.setPosition(pos);
                            infoWindow.setContent("Localização precisa encontrada.");
                            infoWindow.open(map);

                            
                            map.setZoom(15);
                            map.setCenter(pos);
                        },
                        () => {
                            handleLocationError(true, infoWindow, map.getCenter());
                        },
                        {
                            enableHighAccuracy: true,
                            timeout: 10000,
                            maximumAge: 0
                        }
                    );
                } else {
                    handleLocationError(false, infoWindow, map.getCenter());
                }
            });
        }

        function handleLocationError(browserHasGeolocation, infoWindow, pos) {
            infoWindow.setPosition(pos);
            infoWindow.setContent(
                browserHasGeolocation
                    ? "Erro: O serviço de geolocalização falhou."
                    : "Erro: Seu navegador não suporta geolocalização."
            );
            infoWindow.open(map);
        }

        window.initMap = initMap;
    </script>

    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCYVmO-Av6Mnp7YIDCQQOIcC8-rhLhs1WY&callback=initMap" async defer>
    </script>
    </div>
</body>
</html>