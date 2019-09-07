# Google_Maps_JS_Multiple_Markers_InfoWindows
Exemplo funcional de view no CodeIgniter de mapa com vários markers (pins) que vieram por JSON.
Embora a view seja do CodeIgniter, a lógica é no JS, logo, serve para qualquer código HTML.

API v.3

A idéia é:
#### Tudo está dentro da função que inicializa o mapa
Tudo vai estar dentro da função de inicialização do mapa. Declare o código abaixo como variável global. Ou seja, logo após que abrir a função de inicialização do mapa.
```
   var infowindow = new google.maps.InfoWindow();
```
Dentro do loop que percorre os dados com as informações dos markers deve ter o seguinte código:
```
    var markerLatlng = new google.maps.LatLng(Lat, Lng);
    var title = {{record.title|json_encode|safe}}
    var iwContent = {{record.description|json_encode|safe}}
    createMarker(markerLatlng ,title,iwContent);
```
Declare a função abaixo dentro da função de inicialização do mapa:
```
    function createMarker(latlon,title,iwContent) {
      var marker = new google.maps.Marker({
          position: latlon,
          title: title,
          map: map
      });

      google.maps.event.addListener(marker, 'click', function () {
        infowindow.setContent(iwContent);
        infowindow.open(map, marker);
      });
    }
```

Vi inicialmente em stackoverflow[https://stackoverflow.com/questions/12355249/how-to-create-infowindows-for-multiple-markers-in-a-for-loop] e implementei. Aqui fica o código para facilitar a vida de quem interessar.
