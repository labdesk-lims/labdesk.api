<?php
error_reporting(E_ERROR | E_PARSE);

// Parse url including parameters
function parse_url_detail($url){
    $parts = parse_url($url);
    if(isset($parts['query'])) {
        parse_str(urldecode($parts['query']), $parts['query']);
    }
    return $parts;
}

try {
	// Connect to database
	$serverName = "169.254.128.250\MSSQL";
	$connectionInfo = array("Database"=>"labdesk", "UID"=>"rest-api", "PWD"=>"260779");
	$con = sqlsrv_connect($serverName, $connectionInfo);

	// Check if connection was established, otherwise throw error
	if( !$con ) {
		 throw new Exception('Establishing a database connection failed.');
	}

	// Request and parse url from server
	$url = parse_url_detail($_SERVER['REQUEST_URI']);

	// Get parameters from URL
	$token = $url['query']['token']; // Token used for authentication
	$api = $url['query']['api']; // Api to be used (e.g. material)
	
	// Validate request send
	If ($token == Null Or $api == null) {
		throw new Exception('Invalid request.');
	}
	
	// Authorize http request
	$stmt = sqlsrv_query( $con, 'SELECT * FROM api WHERE token = ?', array(&$token));
	
	// Check for valid unique identifier, otherwise throw error
	if( !$stmt ) {
		throw new Exception('Invalid token.');
	}
	
	// Check for valid token
	If (strtolower(sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)['token']) != $token) {
		throw new Exception('Token not known.');
	}
	
	switch($api) {
		case 'material':
			// Switch depending action chosen
			$action = $url['query']['action'];
			
			If ($action == Null) {
				throw new Exception('Action missing.');
			}
			
			// Get material specific parameters for SQL request
			$title = $url['query']['title'];
			$sap_matno = $url['query']['sap_matno'];
			$sap_blocked = $url['query']['sap_blocked'];
			$sap_additionals = $url['query']['sap_additionals'];
			$id = $url['query']['id'];
			
			switch ($action) {
				case 'c':
					if ($title == Null Or $sap_matno == Null Or $sap_blocked == Null Or $sap_additionals == Null) {
						throw new Exception('Missing parameters.');
					}
					$stmt = sqlsrv_query( $con, 'INSERT INTO material (title, sap_matno, sap_blocked, sap_additionals) VALUES(?, ?, ?, ?)', array(&$title, &$sap_matno, &$sap_blocked, &$sap_additionals));
					if( $stmt === false ) {
						 throw new Exception('Failed to insert dataset.');
					}
					break;
				case 'r':
					if ($sap_matno == Null) {
						throw new Exception('Missing parameters.');
					}
					$stmt = sqlsrv_query( $con, 'SELECT * FROM material WHERE sap_matno = ?', array(&$sap_matno));
					if( $stmt === false ) {
						 throw new Exception('Failed to read dataset.');
					}
					while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
						  $res[] = $row;
					}
					sqlsrv_free_stmt($stmt);
					echo json_encode( [ $res ] );
					break;
				case 'u':
					if ($id == Null Or $title == Null Or $sap_matno == Null Or $sap_blocked == Null Or $sap_additionals == Null) {
						throw new Exception('Missing parameters.');
					}
					$stmt = sqlsrv_query( $con, 'UPDATE material SET title = ?, sap_matno = ?, sap_blocked = ?, sap_additionals = ? WHERE id = ?', array(&$title, &$sap_matno, &$sap_blocked, &$sap_additionals, &$id));
					if( $stmt === false ) {
						 throw new Exception('Failed to update dataset.');
					}
					break;
				case 'd':
					if ($id == Null) {
						throw new Exception('Missing parameters.');
					}
					$stmt = sqlsrv_query( $con, 'DELETE FROM material WHERE id = ?', array(&$id));
					if( $stmt === false ) {
						 throw new Exception('Failed to delete dataset.');
					}
					break;
				default:
					throw new Exception('Action unknown.');
				sqlsrv_free_stmt($stmt);  
			}
			break;
		default:
			throw new Exception('API unknown.');
	}
	
	sqlsrv_close($con); 
} catch (Exception $e) {
	echo '<b>Error:</b> '.$e->getMessage()."</br>";
}
?>