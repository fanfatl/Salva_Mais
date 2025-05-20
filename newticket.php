<?php
session_start();
include 'connection_db.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
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
    <h1>Realize um chamado:</h1>
    <script>
        function toggleAnimais() {
            const possuiAnimais = document.getElementById('possui_animais').value;
            document.getElementById('quantidade_animais_group').style.display = 
                possuiAnimais === 'sim' ? 'block' : 'none';
        }
    </script>
</head>
<body>
    <form action="crud_request/creater.php" method="POST">
        <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($user_id) ?>">
        
        <label for="rua">Endereço:</label> <br>
        <input type="text" name="rua" id="rua" placeholder="Rua" required>
        <input type="number" name="numero" id="numero" placeholder="Número" required>
        <input type="text" name="bairro" id="bairro" placeholder="Bairro" required>
        <input type="text" name="cidade" id="cidade" placeholder="Cidade" required>
        <button type="button" onclick="getEndereco()">Onde estou?</button>
        <p id="endereco">Endereco: ...</p>
        <br>
        
        <label for="quantidade_pessoas">Quantidade de pessoas para resgate:</label>
        <input type="number" name="quantidade_pessoas" id="quantidade_pessoas" min="1" required>
        <br>
        
        <label for="possui_animais">Possui animais de estimação?</label>
        <select name="possui_animais" id="possui_animais" onchange="toggleAnimais()" required>
            <option value="" disabled selected>Selecione uma opção</option>
            <option value="sim">Sim</option>
            <option value="nao">Não</option>
        </select>
        <br>
        
        <div id="quantidade_animais_group" style="display:none;">
            <label for="quantidade_animais">Quantidade de animais:</label>
            <input type="number" name="quantidade_animais" id="quantidade_animais" min="1">
            <br>
        </div>
        
        <label for="situacao">Situação (opcional):</label>
        <textarea name="situacao" id="situacao" placeholder="Descreva a situação, se desejar"></textarea>
        <br>
        
        <input type="submit" value="Enviar">
    </form>
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

          const dados = await response.json(); // 👈 aqui era o erro: faltava "await"
          console.log(dados); // debug

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

            // Preenche os campos do formulário
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

</body>
</html>
