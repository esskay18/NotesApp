<?php
 
/**
 * A class file to connect to database
 */
class DB_CONNECT {
	var $con = NULL;
    // constructor
    function __construct() {
        // connecting to database
        $this->connect();
    }
 
    // destructor
    function __destruct() {
        // closing db connection
        $this->close();
    }
 
    /**
     * Function to connect with database
     */
    function connect() {
        // import database connection variables
        require_once __DIR__ . '/db_config.php';
 
        // Connecting to mysql database
        $this->con = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD) or die(mysqli_error($this->con));
 
        // Selecing database
        $db = mysqli_select_db($this->con, DB_DATABASE) or die(mysqli_error($this->con));
 
        // returing connection cursor
        return $this->con;
    }
 
    /**
     * Function to close db connection
     */
    function close() {
        // closing db connection
        mysqli_close($this->con);
    }
 
}
$db = new DB_CONNECT();
//$db->connect();
?>