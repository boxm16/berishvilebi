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

        $personId = $this->connection->lastInsertId();

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

    public function insertPersonPosition($mapVersionId, $personId, $positionX, $positionY) {


        $sql = "INSERT INTO version_position (version_id, person_id, position_X, position_Y) "
                . "                   VALUES (:mapVersionId, :personId, :positionX, :positionY)";

        $mapVersionStatement = $this->connection->prepare($sql);
        $mapVersionStatement->bindValue(':mapVersionId', $mapVersionId);
        $mapVersionStatement->bindValue(':personId', $personId);
        $mapVersionStatement->bindValue(':positionX', $positionX);
        $mapVersionStatement->bindValue(':positionY', $positionY);
        $mapVersionInsertionResult = $mapVersionStatement->execute();
        return $mapVersionInsertionResult;
    }

    //-----------------------
    public function getAllPersonsForMap($mapVersionId) {
        $persons = array();
        $sql = "SELECT * FROM person INNER JOIN version_position ON person.id=version_position.person_id WHERE version_id=$mapVersionId";

        try {
            $result = $this->connection->query($sql)->fetchAll();
        } catch (\PDOException $e) {
            echo $e->getMessage() . " Error Code:";
            echo $e->getCode() . "<br>";
        }
// var_dump($result);
        $person = new Person();

        foreach ($result as $personData) {
            $person = new Person();
            $personId = $personData["id"];
            $person->setId($personId);
            $person->setGeneration($personData["generation"]);
            $person->setPositionX($personData["position_X"]);
            $person->setPositionY($personData["position_Y"]);
            $person->setParentId($personData["parent_id"]);
            $person->setFirstName($personData["first_name"]);
            $person->setNickname($personData["nickname"]);
            $person->setSecondName($personData["second_name"]);
            $person->setLifeStatus($personData["life_status"]);

            $parentId = $personData["parent_id"];

            $id = $personData["id"];
            if ($parentId == null) {
                
            } else {
                $parent = $persons[$parentId];
                $parent->addChild($person);
                $persons[$parentId] = $parent;
                $parentPositionX = $parent->getPositionX();
                $parentPositionY = $parent->getPositionY();
                $person->setParentPositionX($parentPositionX);
                $person->setParentPositionY($parentPositionY);
            }
            $persons[$personId] = $person;
        }

        return $persons;
    }

    public function getPerson($personId, $mapVersionId) {

        $sql = "SELECT * FROM person INNER JOIN version_position ON person.id=version_position.person_id WHERE (id=$personId OR parent_id=$personId) AND (version_id=$mapVersionId);";

        try {
            $result = $this->connection->query($sql)->fetchAll();
        } catch (\PDOException $e) {
            echo $e->getMessage() . " Error Code:";
            echo $e->getCode() . "<br>";
        }
// var_dump($result);
        $person = new Person();
        foreach ($result as $personData) {
            if ($personData["id"] == $personId) {
                $person->setId($personData["id"]);
                $person->setParentId($personData["parent_id"]);
                $person->setGeneration($personData["generation"]);
                $person->setFirstName($personData["first_name"]);
                $person->setSecondName($personData["second_name"]);
                $person->setPositionX($personData["position_X"]);
                $person->setPositionY($personData["position_Y"]);
            } else {
                $child = new Person();
                $child->setId($personData["id"]);
                $child->setParentId($personData["parent_id"]);
                $child->setGeneration($personData["generation"]);
                $child->setFirstName($personData["first_name"]);
                $child->setSecondName($personData["second_name"]);
                $child->setPositionX($personData["position_X"]);
                $child->setPositionY($personData["position_Y"]);
                $person->addChild($child);
            }
        }
        return $person;
    }

    public function saveAllPositions($allPersonsPositions, $mapVersionId) {


        $allPersonsPositionsArrayt = explode(":", $allPersonsPositions);


        // prepare the SQL query once
        $stmt = $this->connection->prepare("UPDATE version_position SET position_x = ?, position_y = ? WHERE person_id= ? and version_id=?;");

        $this->connection->beginTransaction();
// loop over the data array
        foreach ($allPersonsPositionsArrayt as $personPositionCode) {

            $personPositionCodeArray = explode(",", $personPositionCode);
            $stmt->execute([$personPositionCodeArray[1], $personPositionCodeArray[2], $personPositionCodeArray[0], $mapVersionId]);
        }
        $this->connection->commit();
    }

    public function moveHorizontalyAllPositions($step, $mapVersionId) {
        $sql = "UPDATE version_position SET position_X=position_X+:step WHERE version_id=$mapVersionId;";

        $statement = $this->connection->prepare($sql);
        $statement->bindValue(':step', $step);
        $updated = $statement->execute();
        if ($updated) {
            echo 'რუქაზე პიორვნების მდებარეობა შენახულია!<br>';
        }
    }

    public function moveVerticallyAllPositions($step, $mapVersionId) {
        $sql = "UPDATE version_position SET position_Y=position_Y+:step WHERE version_id=$mapVersionId;";

        $statement = $this->connection->prepare($sql);
        $statement->bindValue(':step', $step);
        $updated = $statement->execute();
        if ($updated) {
            echo 'რუქაზე პიორვნების მდებარეობა შენახულია!<br>';
        }
    }

    public function deletePerson($personId) {
        $sql = "DELETE FROM person WHERE id=:id;";

        $statement = $this->connection->prepare($sql);
        $statement->bindValue(':id', $personId);
        $updated = $statement->execute();
        if ($updated) {
            echo 'რუქაზე პიორვნების მდებარეობა შენახულია!<br>';
        }
    }

}
