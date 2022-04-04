<?php

require_once 'DataBaseConnection.php';

class PersonDao {

    private $connection;

    function __construct() {
        $dataBaseConnection = new DataBaseConnection();
        $this->connection = $dataBaseConnection->getConnection();
    }

    public function insertPerson($person) {


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



        $sql = "INSERT INTO person (parent_id, generation, position_X, position_Y, first_name, second_name, nickname, life_status, birth_date, death_date ) "
                . "        VALUES (:parentId, :generation, :positionX, :positionY, :firstName, :secondName, :nickname, :lifeStatus, :birthDate, :deathDate)";


        $statement = $this->connection->prepare($sql);

        $statement->bindValue(':parentId', $parentId);
        $statement->bindValue(':generation', $generation);
        $statement->bindValue(':positionX', $positionX);
        $statement->bindValue(':positionY', $positionY);
        $statement->bindValue(':firstName', $firstName);
        $statement->bindValue(':secondName', $secondName);
        $statement->bindValue(':nickname', $nickname);
        $statement->bindValue(':lifeStatus', $lifeStatus);
        $statement->bindValue(':birthDate', $birthDate);
        $statement->bindValue(':deathDate', $deathDate);

        $inserted = $statement->execute();


        if ($inserted) {
            echo 'Person Inserted!<br>';
        }
    }

    public function getAllPersons() {
        $persons = array();
        $sql = "SELECT * FROM person";

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
            $person->setId($personData["id"]);
            $person->setGeneration($personData["generation"]);
            $person->setParentId($personData["parent_id"]);
            $person->setFirstName($personData["first_name"]);
            $person->setNickname($personData["nickname"]);
            $person->setSecondName($personData["second_name"]);
            $person->setLifeStatus($personData["life_status"]);
            array_push($persons, $person);
        }

        return $persons;
    }

    public function getPersonsMap() {
        $persons = array();
        $sql = "SELECT * FROM person";

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

    public function getPerson($id) {
        $sql = "SELECT * FROM person WHERE id=$id";

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

    public function getPersonsChildren($id) {

        $sql = "SELECT * FROM person WHERE parent_id=$id";

        try {
            $result = $this->connection->query($sql)->fetchAll();
        } catch (\PDOException $e) {
            echo $e->getMessage() . " Error Code:";
            echo $e->getCode() . "<br>";
        }
// var_dump($result);
        $children = array();
        foreach ($result as $personData) {
            $person = new Person();
            $person->setId($personData["id"]);
            $person->setGeneration($personData["generation"]);
            $person->setFirstName($personData["first_name"]);
            $person->setSecondName($personData["second_name"]);
            array_push($children, $person);
        }

        return $children;
    }

    public function setPosition($id, $x, $y) {
        $sql = "UPDATE person SET position_X=:positionX, position_Y=:positionY WHERE  id=:id;";


        $statement = $this->connection->prepare($sql);
        $statement->bindValue(':positionX', $x);
        $statement->bindValue(':positionY', $y);
        $statement->bindValue(':id', $id);
        $updated = $statement->execute();


        if ($updated) {
            echo 'რუქაზე პიორვნების მდებარეობა შენახულია!<br>';
        }
    }

    public function deletePersons($personsDescendantsList) {
        if (count($personsDescendantsList) > 0) {
            $sql = "DELETE FROM person WHERE id IN ";
            $sqlInPart = "(";
            $index = 0;
            foreach ($personsDescendantsList as $person) {
                $perdonId = $person->getId();
                $sqlInPart .= $perdonId;
                if ($index == count($personsDescendantsList) - 1) {
                    $sqlInPart .= ")";
                } else {
                    $sqlInPart .= ",";
                }

                $index++;
            }
            $sql .= $sqlInPart;


            try {
                $deleted = $this->connection->query($sql);
                if ($deleted) {
                    echo "Persons Deleted.";
                }
            } catch (\PDOException $e) {
                echo $e->getMessage() . " Error Code:";
                echo $e->getCode() . "<br>";
            }
        } else {
            echo "nobody to delete";
        }
    }

    public function saveAllPositions($allPersonsPositions) {


        $allPersonsPositionsArrayt = explode(":", $allPersonsPositions);


        // prepare the SQL query once
        $stmt = $this->connection->prepare("UPDATE person SET position_x = ?, position_y = ? WHERE id= ? ;");

        $this->connection->beginTransaction();
// loop over the data array
        foreach ($allPersonsPositionsArrayt as $personPositionCode) {

            $personPositionCodeArray = explode(",", $personPositionCode);
            $stmt->execute([$personPositionCodeArray[1], $personPositionCodeArray[2], $personPositionCodeArray[0]]);
        }
        $this->connection->commit();
    }

}
