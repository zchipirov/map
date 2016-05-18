<html>
<head>
	<title>Обновление базы</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="dist/css/bootstrap.min.css">
	<script src="dist/js/jquery.min.js"></script>
	<script src="dist/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container">
		<div class="well">
		  <h2 style="text-align: center;">Обновление базы</h2>
			<form role="form" action="load.php" method="GET" name="search" style="width: 60%;">
				<input type="hidden" name="action" id="action"/>
				<button type="submit" class="btn btn-success">обновить</button>
			</form>
			<?php
				function utf8($struct) {
					foreach ($struct as $key => $value) {
						if (is_array($value)) {
							$struct[$key] = utf8($value);
						}
						elseif (is_string($value)) {
							$struct[$key] = utf8_encode($value);
						}
					}
					return $struct;
				}
				
				if (isset($_GET) && count($_GET)> 0) {
					ini_set("max_execution_time", "3600");
					$link = mysql_connect('localhost', 'root', '');
					if (!$link) {
						die('Ошибка соединения: ' . mysql_error());
					}
					mysql_select_db('map', $link) or die('Could not select database.');
					$sql = "SELECT BSSID, IPAddress FROM data WHERE (Latitude = '' OR Longitude = '') AND BSSID <> '<no wireless>' AND BSSID <> '' AND IPAddress <> ''";
					
					$res = mysql_query($sql, $link);
					while ($row = @mysql_fetch_assoc($res)) {
						$params = array(
								'common' => array('version' => '1.0', 'api_key' => 'AJIOPVQBAAAAdWXMVQQAuYvjzUxhqzcJ56ARfLcMj3MfMFUAAAAAAAAAAABqD6_AjX1vX4fFB5EAlzH5tXiuCg=='),
								'wifi_networks' => array(
									array('mac' => "'".$row['BSSID']."'")
								),
								'ip' => 
									array('address_v4' => "'".$row['IPAddress']."'")
							);
						
						$json = json_encode($params);
						
						$resp = json_decode(file_get_contents('http://api.lbs.yandex.net/geolocation' . '?json=' . $json, true));
						// $resp->position->{'latitude'};
						mysql_query("UPDATE data SET Latitude='".$resp->position->{'latitude'}."', Longitude='".$resp->position->{'longitude'}."' WHERE BSSID='".$row['BSSID']."'");
					}
					mysql_close($link);
				}
			?>
		</div>
	</div>
</body>
</html>