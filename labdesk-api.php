<?php
error_reporting(E_ERROR | E_PARSE);

/* Applied error codes:
 * E01 - Establishing connection failed
 * E02 - Invalid unique identifier
 * E03 - Token unknown
 * E05 - Nothing to report
 * E06 - CUD failed
 * E07 - Unknown path
 * E08 - Primary is null
 */

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
	$serverName = "???";
	$connectionInfo = array("Database"=>"labdesk", "UID"=>"rest-api", "PWD"=>"???");
	$con = sqlsrv_connect($serverName, $connectionInfo);

	// Check if connection was established, otherwise warn
	if( !$con ) {
		 throw new Exception('E01');
	}

	// Request and parse url from server
	$url = parse_url_detail($_SERVER['REQUEST_URI']);

	// Get url parameters
	$token = $url['query']['token'];
	$api = $url['query']['api'];
	$action = $url['query']['action'];
	$title = $url['query']['title'];
	$sap_matno = $url['query']['sap_matno'];
	$sap_blocked = $url['query']['sap_blocked'];
	$sap_additionals = $url['query']['sap_additionals'];
	$id = $url['query']['id'];

	// Authorize http request
	$stmt = sqlsrv_query( $con, 'SELECT * FROM api WHERE token = ?', array(&$token));
	
	// Check for valid unique identifier
	if( !$stmt ) {
		throw new Exception('E02');
	}
	
	// Check for valid token
	If (strtolower(sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)['token']) != $token) {
		throw new Exception('E03');
	}
	
	// Switch interface
	switch($api) {
		case 'material':
			// Perform action
			switch ($action) {
				case 'c':
					$stmt = sqlsrv_query( $con, 'INSERT INTO material (title, sap_matno, sap_blocked, sap_additionals) VALUES(?, ?, ?, ?)', array(&$title, &$sap_matno, &$sap_blocked, &$sap_additionals));
					if( $stmt === false ) {
						 throw new Exception('E06');
					}
					break;
				case 'r':
					$stmt = sqlsrv_query( $con, 'SELECT * FROM material WHERE sap_matno = ?', array(&$sap_matno));
					if( $stmt === false ) {
						 throw new Exception('E05');
					}
					while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
						  $res[] = $row;
					}
					sqlsrv_free_stmt($stmt);
					echo json_encode( [ $res ] );
					break;
				case 'u':
					If ($id == Null) { throw new Exception('E08'); }
					$stmt = sqlsrv_query( $con, 'UPDATE material SET title = ?, sap_matno = ?, sap_blocked = ?, sap_additionals = ? WHERE id = ?', array(&$title, &$sap_matno, &$sap_blocked, &$sap_additionals, &$id));
					if( $stmt === false ) {
						 throw new Exception('E06');
					}
					break;
				case 'd':
					If ($id == Null) { throw new Exception('E08'); }
					$stmt = sqlsrv_query( $con, 'DELETE FROM material WHERE id = ?', array(&$id));
					if( $stmt === false ) {
						 throw new Exception('E06');
					}
					break;
				sqlsrv_free_stmt($stmt);  
			}
			break;
	}
	
	sqlsrv_close($con); 
} catch (Exception $e) {
	echo $e->getMessage(), "\n";
}
?>