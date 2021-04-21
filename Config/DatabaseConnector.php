<?php

/**
 * Description of DatabaseConnector
 * 
 * @author Reza 
 */
class DatabaseConnector {

    private $conn = null;

    public function __construct() {

        $httpServer = filter_input(INPUT_SERVER, 'HTTP_HOST', FILTER_SANITIZE_STRING);

        if ($httpServer == "localhost" ||
                strncmp($httpServer, "172.", 4) == 0 ||
                strncmp($httpServer, "192.", 4) == 0 ||
                strncmp($httpServer, "10.", 3) == 0) {
            $serverName = "localhost";
            $userName = "root";
            $password = "";
            $dbName = "tinylink";
        } else {
            $serverName = ""; your server Name: Example fdb27.biz.nf"; 
            $userName = ""; // Your user name for database
            $password = ""; // Your password for database
            $dbName = "tinylink"; // Or you desired DB name
        }

        // Create connection
        $this->conn = new mysqli($serverName, $userName, $password, $dbName);

        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        // Connected successfully
    }

    public function getConnection() {
        return $this->conn;
    }

    public function runQuery($queryString) {

        $queryResult = null;

        $result = $this->conn->query($queryString);

        $i = 0;

        if (is_object($result)) {
            if ($result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) {
                    $queryResult[$i] = $row;
                    $i++;
                }
            }
            return $queryResult ;
        }

        return $result;
    }

}
