<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link rel="stylesheet" href="<?= base_url(); ?>assets/css/mapa.css">

<div id="googlemaps">
	<div id="map"></div>
</div>
<script src="<?= base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=SUAKEY&callback=initMap" async defer></script>
<script>
		var map;

		function initMap() {
			var infowindow = new google.maps.InfoWindow(); //infowindows como variável global
			let iconBase = '<?= base_url(); ?>assets/img/pins/'; 

			pos = {lat: -22.85592924, lng: -43.3190918};
			let map = new google.maps.Map(document.getElementById('map'), {
				center: {lat: -22.7631956, lng: -43.1631281},
				zoom: 11
			});

			$.get("<?= base_url(); ?>index.php/meucontroller/jsonComAsInformacoes", 
				function(response) {
					for(resp of response) { //for percorrendo o dados retornados do json
						var markerLatlng = new google.maps.LatLng(resp.latitude, resp.longitude); //setando a posição no mapa
						var title = resp.id;
						var iwContent = '123 0 - ' + resp.id; //conteúdo - Aqui aceita HTML
						createMarker(markerLatlng, title, iwContent); //chama a função que cria o Marker
					}
				}
			);
			
			function createMarker(latlon,title,iwContent) { //essa função fica dentro da função initMap, ela é responsável por criar o marker e permitir o evento de clique que abra o infowindow
				var marker = new google.maps.Marker({
					position: latlon,
					title: title,
					map: map
				});

				google.maps.event.addListener(marker, 'click', function () { //inserindo o listener de click para abrir o infowindow após clicar no marker
					infowindow.setContent(iwContent);
					infowindow.open(map, marker);
				});
			}

		}
</script>
