<?php

require_once 'DataBaseConnection.php';
require_once 'Model/MapVersion.php';

class MapVersionDao {

    private $connection;

    function __construct() {
        $dbConnection = new DataBaseConnection();
        $this->connection = $dbConnection->getConnection();
    }

    public function insertMapVersion($mapVersion) {


        $name = $mapVersion->getName();
        $mapWidth = $mapVersion->getMapWidth();
        $mapHeight = $mapVersion->getMapHeight();



        $sql = "INSERT INTO version (name, map_width, map_height ) "
                . "        VALUES (:name, :map_width, :map_height)";


        $statement = $this->connection->prepare($sql);

        $statement->bindValue(':name', $name);
        $statement->bindValue(':map_width', $mapWidth);
        $statement->bindValue(':map_height', $mapHeight);

        $inserted = $statement->execute();

        return $inserted;
    }

    public function getAllMapVersions() {
        $sql = "SELECT * FROM version";

        try {
            $result = $this->connection->query($sql)->fetchAll();
        } catch (\PDOException $e) {
            echo $e->getMessage() . " Error Code:";
            echo $e->getCode() . "<br>";
        }
// var_dump($result);
        $person = new Person();
        foreach ($result as $personData) {
            $person->setId($personData["id"]);
            $person->setParentId($personData["parent_id"]);
            $person->setGeneration($personData["generation"]);
            $person->setFirstName($personData["first_name"]);
            $person->setSecondName($personData["second_name"]);
            $person->setPositionX($personData["position_X"]);
            $person->setPositionY($personData["position_Y"]);
        }

        return $person;
    }

}
