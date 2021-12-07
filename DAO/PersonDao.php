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
        $firstName = $person->getFirstName();
        $secondName = $person->getSecondName();
        $nickname = $person->getNickname();
        $lifeStatus = $person->getLifeStatus();

        $sql = "INSERT INTO person (parent_id, generation, first_name, second_name, nickname, life_status ) VALUES (:parentId, :generation, :firstName , :secondName, :nickname, :lifeStatus)";


        $statement = $this->connection->prepare($sql);

        $statement->bindValue(':parentId', $parentId);
        $statement->bindValue(':generation', $generation);
        $statement->bindValue(':firstName', $firstName);
        $statement->bindValue(':secondName', $secondName);

        $statement->bindValue(':nickname', $nickname);
        $statement->bindValue(':lifeStatus', $lifeStatus);



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
            $person->setGeneration($personData["generation"]);
            $person->setFirstName($personData["first_name"]);
            $person->setSecondName($personData["second_name"]);
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

}
