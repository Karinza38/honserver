<?php

function get_upgrades($cookie) {
	include 'keys.php';
	include 'upgrades.php';

	$mysqli = new mysqli($mysql_host, $mysql_user, $mysql_password, $mysql_database, $mysql_port);

	$statement = $mysqli->prepare("SELECT account_id, points, mmpoints, upgrades FROM accounts WHERE cookie = ?");
	$statement->bind_param('s', $cookie);

	$statement->execute();
	$result = $statement->get_result();
	$row = $result->fetch_row();
	if ($row == null) {
		$response["error"][0] = "Unknown cookie";
		return $response;
	}

	$account_id = $row[0];
	$field_stats['account_id'] = $account_id;
	$response['field_stats'][0] = $field_stats;
	$response['my_upgrades_info'] = array();

	$response['points'] = $row[1];
	$response['mmpoints'] = $row[2];
	$response['my_upgrades'] = unserialize($row[3]);

	return $response;
}

?>
