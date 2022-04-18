<?php

require_once 'DataBaseConnection.php';

class PersonDao {

    private $connection;

    function __construct() {
        $dbConnection = new DataBaseConnection();
        $this->connection = $dbConnection->getConnection();
    }

    public function insertPerson($person, $mapVersionId) {


        $parentId = $person->getParentId();
        $generation = $person->getGeneration();
        $positionX = $person->getPositionX();
        $positionY = $person->getPositionY();
        $firstName = $person->getFirstName();
        $secondName = $person->getSecondName();
        $nickname = $person->getNickname();
        $lifeStatus = $person->getLifeStatus();
        $birthDate = $person->getBirthDate();
        $deathDate = $person->getDeathDate();



        $sql = "INSERT INTO person (parent_id, generation, first_name, second_name, nickname, life_status, birth_date, death_date ) "
                . "        VALUES (:parentId, :generation, :firstName, :secondName, :nickname, :lifeStatus, :birthDate, :deathDate)";


        $statement = $this->connection->prepare($sql);

        $statement->bindValue(':parentId', $parentId);
        $statement->bindValue(':generation', $generation);
        $statement->bindValue(':firstName', $firstName);
        $statement->bindValue(':secondName', $secondName);
        $statement->bindValue(':nickname', $nickname);
        $statement->bindValue(':lifeStatus', $lifeStatus);
        $statement->bindValue(':birthDate', $birthDate);
        $statement->bindValue(':deathDate', $deathDate);

        $insertionResult = $statement->execute();


        //-------------------------

        $personId = $this->connection->lastInsertId();;
        $positionX = $person->getPositionX();
        $positionY = $person->getPositionY();

        $sql = "INSERT INTO version_position (version_id, person_id, position_X, position_Y) "
                . "                   VALUES (:mapVersionId, :personId, :positionX, :positionY)";

        $mapVersionStatement = $this->connection->prepare($sql);
        $mapVersionStatement->bindValue(':mapVersionId', $mapVersionId);
        $mapVersionStatement->bindValue(':personId', $personId);
        $mapVersionStatement->bindValue(':positionX', $positionX);
        $mapVersionStatement->bindValue(':positionY', $positionY);
        $mapVersionInsertionResult = $mapVersionStatement->execute();
        return $insertionResult & $mapVersionInsertionResult;
    }

}
