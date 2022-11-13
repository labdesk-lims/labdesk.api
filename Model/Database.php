<?php
class Database
{
    protected $connection = null;
 
    public function __construct()
    {
        try {
			$conInfo = array("Database"=>DB_DATABASE_NAME, "APP"=>DB_APP, "UID"=>DB_USERNAME, "PWD"=>DB_PASSWORD);
			$this->connection = sqlsrv_connect(DB_HOST, $conInfo);

            if ( !$this->connection ) {
                throw new Exception("Could not connect to database.");   
            }
        } catch (Exception $e) {
            print $e->getMessage();   
        }           
    }
 
    public function executeStatement($query = "" , $params = [])
    {
        try {
			$stmt = sqlsrv_query( $this->connection, $query , $params);
			while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
						  $result[] = $row;
					}
			sqlsrv_free_stmt($stmt);
			
            return $result;
        } catch(Exception $e) {
            throw New Exception( $e->getMessage() );
        }
        return false;
    }
}
?>