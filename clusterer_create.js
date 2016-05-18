ymaps.ready(function () {
var collection = new ymaps.GeoObjectCollection();
$.get('data.php', 
	function (data) {
		var map = new ymaps.Map('map', { center: [43.02470898392014,44.69021148700207], zoom: 12 });
		myGeoObjects = [];
		var result = JSON.parse(data);
		
		for (var el, i = 0; i < result.length; i++) {
			myGeoObjects[i] = new ymaps.GeoObject({
				geometry: { type: "Point", coordinates: [result[i][17], result[i][18]] },
				properties: {
					clusterCaption: result[i][0],
					balloonContentBody: 'IP Address: '+result[i][0]+'<br>Port: '+result[i][1]
					+'<br>Time: '+result[i][2]
					+'<br>Status: '+result[i][3]
					+'<br>Authorization: '+result[i][4]
					+'<br>ServName: '+result[i][5]
					+'<br>BSSID: '+result[i][6]
					+'<br>ESSID: '+result[i][7]
					+'<br>Security: '+result[i][8]
					+'<br>Key: '+result[i][9]
					+'<br>WPSPIN: '+result[i][10]
					+'<br>LAN IP Address: '+result[i][11]
					+'<br>LAN Subnet Mask: '+result[i][12]
					+'<br>WAN Gateway: '+result[i][13]
					+'<br>Domain Name Servers: '+result[i][14]
				}
			});
		}
		var clusterer = new ymaps.Clusterer({ clusterDisableClickZoom: true });
		clusterer.add(myGeoObjects);
		map.geoObjects.add(clusterer);
	});
});