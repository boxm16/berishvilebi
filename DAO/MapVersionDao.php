<?php

require_once 'DataBaseConnection.php';
require_once 'Model/MapVersion.php';

class MapVersionDao {

    private $connection;

    function __construct() {
        $dbConnection = new DataBaseConnection();
        $this->connection = $dbConnection->getConnection();
    }

    public function insertMainMapVersion($mapVersion) {


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

        $statement->execute();

        return $newMapVersionId = $this->connection->lastInsertId();
    }

    public function getAllMapVersions() {
        $mapVersions = array();
        $sql = "SELECT * FROM version";

        try {
            $result = $this->connection->query($sql)->fetchAll();
        } catch (\PDOException $e) {
            echo $e->getMessage() . " Error Code:";
            echo $e->getCode() . "<br>";
        }
// var_dump($result);

        foreach ($result as $mapVersionData) {

            $mapVersion = new MapVersion();

            $mapVersion->setId($mapVersionData["id"]);
            $mapVersion->setName($mapVersionData["name"]);
            $mapVersion->setMapWidth($mapVersionData["map_width"]);
            $mapVersion->setMapHeight($mapVersionData["map_height"]);

            array_push($mapVersions, $mapVersion);
        }

        return $mapVersions;
    }

    public function getMapVersion($mapVersionId) {

        $sql = "SELECT * FROM version WHERE id=$mapVersionId";
        try {
            $result = $this->connection->query($sql)->fetch();
        } catch (\PDOException $e) {
            echo $e->getMessage() . " Error Code:";
            echo $e->getCode() . "<br>";
        }
        $mapVersion = new MapVersion();
        $mapVersion->setId($result["id"]);
        $mapVersion->setName($result["name"]);
        $mapVersion->setMapWidth($result["map_width"]);
        $mapVersion->setMapHeight($result["map_height"]);

        return $mapVersion;
    }

}
