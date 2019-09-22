<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link rel="stylesheet" href="<?= base_url(); ?>assets/css/dashboard-map.css">

<div id="googlemaps">
	<div class="row" id="filtro-google-maps">
		<input class="form-control col-6" name="id-equipamento" class="id-equipamento">
		<select class="form-control col-6" name="usuario" id="usuario"></select>
	</div>
	<div id="map"></div>
</div>
<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=SUA_KEY_AQUI&callback=initMap" async defer></script>

<script>

		var map;
		var markers = [];

		function initMap() {
			var infowindow = new google.maps.InfoWindow(); //infowindows como variável global
			let iconBase = '<?= base_url(); ?>assets/img/pins/'; 
			let map = new google.maps.Map(document.getElementById('map'), {
				center: {lat: -12.5816, lng: -38.3039},
				zoom: 10,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			});

			$.get("<?= base_url(); ?>telemetria/getConsumidoresPosicoes", 
				function(response) {
					for(resp of response) { //for percorrendo o dados retornados do json
						var markerLatlng = new google.maps.LatLng(resp.lat, resp.lng); //setando a posição no mapa
						var title = resp.id_consumidor;
						var iwContent = '123 0 - ' + resp.id_consumidor; //conteúdo - Aqui aceita HTML
						createMarker(markerLatlng, title, iwContent); //chama a função que cria o Marker
					}
					var markerCluster = new MarkerClusterer(map, markers);
				}
			);
			
			function createMarker(latLng,title,iwContent) { //essa função fica dentro da função initMap, ela é responsável por criar o marker e permitir o evento de clique que abra o infowindow
				var marker = new google.maps.Marker({
					position: latLng,
					title: title,
					map: map
				});
				
				markers.push(marker);

				google.maps.event.addListener(marker, 'click', function () { //inserindo o listener de click para abrir o infowindow após clicar no marker
					infowindow.setContent(iwContent);
					infowindow.open(map, marker);
				});
			}
		}
</script>
