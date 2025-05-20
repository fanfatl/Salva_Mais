<!DOCTYPE html>
<html>
  <head>
    <title>Geolocalização com Google Maps</title>
    <style>
      #map {
        height: 100%;
      }
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      .custom-map-control-button {
        background-color: #fff;
        border: 0;
        outline: none;
        width: 220px;
        height: 40px;
        margin: 10px auto;
        font-size: 16px;
        cursor: pointer;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        text-align: center;
      }
    </style>
  </head>
  <body>
    <div id="map"></div>

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
        map.controls[google.maps.ControlPosition.TOP_CENTER].push(locationButton);

        locationButton.addEventListener("click", () => {
          if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
              (position) => {
                const pos = {
                  lat: position.coords.latitude,
                  lng: position.coords.longitude,
                };

                // Marcador no local atual
                new google.maps.Marker({
                  position: pos,
                  map: map,
                  title: "Você está aqui",
                });

                // InfoWindow
                infoWindow.setPosition(pos);
                infoWindow.setContent("Localização precisa encontrada.");
                infoWindow.open(map);

                // Centraliza o mapa
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
      async
      defer
    </script>
  </body>
</html>
