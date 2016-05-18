<?php
	$link = mysql_connect('localhost', 'root', '');
	if (!$link) {
		die('Ошибка соединения: ' . mysql_error());
	}
	mysql_select_db('map', $link) or die('Could not select database.');
	$sql = "SELECT IPAddress,WPort,WTime,WStatus,Authorization,ServName,BSSID,ESSID,WSecurity,WKey,WPSPIN,LANIPAddress,LANSubnetMask,WANIPAddress,WANSubnetMask,WANGateway,DomainNameServers,Latitude,Longitude,Comments FROM data WHERE Latitude <> '' AND Longitude <> '' AND BSSID <> '<no wireless>' AND BSSID <> ''";
	$res = mysql_query($sql, $link);
	
	$i = 0;
	while ($row = @mysql_fetch_assoc($res)) {
		/*$result .= $row['IPAddress']."|".$row['WPort']."|".$row['WTime']."|".$row['WStatus']."|".$row['Authorization']."|".$row['ServName']."|".$row['BSSID']."|".
				$row['ESSID']."|".$row['WSecurity']."|".$row['WKey']."|".$row['WPSPIN']."|".$row['LANIPAddress']."|".$row['LANSubnetMask']."|".$row['WANIPAddress']."|".
				$row['WANSubnetMask']."|".$row['WANGateway']."|".$row['DomainNameServers']."|".$row['Latitude']."|".$row['Longitude']."|".$row['Comments']."*";*/
		$result[$i][0] = $row['IPAddress'];
		$result[$i][1] = $row['WPort'];
		$result[$i][2] = $row['WTime'];
		$result[$i][3] = $row['WStatus'];
		$result[$i][4] = $row['Authorization'];
		$result[$i][5] = $row['ServName'];
		$result[$i][6] = $row['BSSID'];
		$result[$i][7] = $row['ESSID'];
		$result[$i][8] = $row['WSecurity'];
		$result[$i][9] = $row['WKey'];
		$result[$i][10] = $row['WPSPIN'];
		$result[$i][11] = $row['LANIPAddress'];
		$result[$i][12] = $row['LANSubnetMask'];
		$result[$i][13] = $row['WANIPAddress'];
		$result[$i][14] = $row['WANSubnetMask'];
		$result[$i][15] = $row['WANGateway'];
		$result[$i][16] = $row['DomainNameServers'];
		$result[$i][17] = $row['Latitude'];
		$result[$i][18] = $row['Longitude'];
		$result[$i][19] = $row['Comments'];
		$i += 1;
	}
	//var_dump($result);
	echo json_encode($result);
?>