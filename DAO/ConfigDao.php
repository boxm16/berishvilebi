<?php

require_once 'DataBaseConnection.php';

class ConfigDao {

    private $connection;

    function __construct() {
        $dataBaseConnection = new DataBaseConnection();
        $this->connection = $dataBaseConnection->getConnection();
    }

    public function getSvgWidth() {

        $sql = "SELECT * FROM config WHERE config_type='svg_width'";

        try {
            $result = $this->connection->query($sql)->fetch();
        } catch (\PDOException $e) {
            echo $e->getMessage() . " Error Code:";
            echo $e->getCode() . "<br>";
        }
        return $result["int_value"];
    }

    public function getSvgHeight() {

        $sql = "SELECT * FROM config WHERE config_type='svg_height'";

        try {
            $result = $this->connection->query($sql)->fetch();
        } catch (\PDOException $e) {
            echo $e->getMessage() . " Error Code:";
            echo $e->getCode() . "<br>";
        }
        return $result["int_value"];
    }

}
