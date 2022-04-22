<?php

require_once 'Model/Person.php';
require_once 'Dao/PersonDao.php';
require_once 'Dao/DataBaseConnection.php';
$host = 'remotemysql.com';
$db = 'rcTGWKjpv5';
$user = 'rcTGWKjpv5';
$pass = 'rFjVEk8E6B';
$charset = 'utf8';



$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int) $e->getCode());
}



$persons = array();
$sql = "SELECT * FROM person";

try {
    $result = $pdo->query($sql)->fetchAll();
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
$personDao = new PersonDao();
foreach ($persons as $person) {

    $parentId = $person->getParentId();
    $generation = $person->getGeneration();
    $firstName = $person->getFirstName();
    $secondName = $person->getSecondName();
    $nickname = $person->getNickname();
    $lifeStatus = $person->getLifeStatus();
    $birthDate = $person->getBirthDate();
    $deathDate = $person->getDeathDate();

    $dataBaseConnection = new DataBaseConnection();
    $connection = $dataBaseConnection->getConnection();

    $sql = "INSERT INTO person (parent_id, generation, first_name, second_name, nickname, life_status, birth_date, death_date ) "
            . "        VALUES (:parentId, :generation, :firstName, :secondName, :nickname, :lifeStatus, :birthDate, :deathDate)";


    $statement = $connection->prepare($sql);

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
    $oldPersonId = $person->getId();
    $personId = $connection->lastInsertId();
    echo $oldPersonId . ":" . $personId . "<br>";

    $children = $person->getChildren();
    foreach ($children as $child) {
        $childId = $child->getId();
        $childPerson = $persons[$childId];
        $childPerson->setParentId($personId);
        $persons[$childId] = $childPerson;
    }


    $positionX = $person->getPositionX();
    $positionY = $person->getPositionY();

    $sql = "INSERT INTO version_position (version_id, person_id, position_X, position_Y) "
            . "                   VALUES (:mapVersionId, :personId, :positionX, :positionY)";




    $mapVersionStatement = $connection->prepare($sql);
    $mapVersionStatement->bindValue(':mapVersionId', 1);
    $mapVersionStatement->bindValue(':personId', $personId);
    $mapVersionStatement->bindValue(':positionX', $positionX);
    $mapVersionStatement->bindValue(':positionY', $positionY);
    $mapVersionInsertionResult = $mapVersionStatement->execute();
}

echo "good";




