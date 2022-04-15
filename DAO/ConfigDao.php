<?php

require_once 'DataBaseConnection.php';

class ConfigDao {

    private $connection;

    function __construct() {
        $dbConnection = new DataBaseConnection();
        $this->connection = $dbConnection->getConnection();
    }

    function createTables() {

        echo "labu";
    }

}
