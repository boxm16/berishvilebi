<?php

require_once 'DAO/PersonDao.php';
require_once 'Model/Person.php';
require_once 'Controller/PersonController.php';
if (isset($_POST["setNewPosition"])) {
    $id = $_POST["id"];
    $x = $_POST["x"];
    $y = $_POST["y"];
    $personDao = new PersonDao();
    $personDao->setPosition($id, $x, $y);
    $personDao->setPositionAsParent($id, $x, $y);
    header("Location: admin.php?personInFocusId=$id");
}
if (isset($_POST["insertChild"])) {


    $id = $_POST["id"];
    $x = $_POST["x"];
    $y = $_POST["y"];
    $child = new Person();
    $child->setParentId($id);
    $child->setGeneration($_POST["generation"]);
    $child->setFirstName($_POST["firstName"]);
    $child->setNickname($_POST["nickname"]);
    $child->setSecondName($_POST["secondName"]);
    $child->setLifeStatus($_POST["lifeStatus"]);
    $child->setBirthDate($_POST["birthDate"]);
    $child->setDeathDate($_POST["deathDate"]);
    $child->setParentPositionX($x);
    $child->setParentPositionY($y);
    $child->setPositionX($x + 10);
    $child->setPositionY($y + 10);
    $child->setGeneration($_POST["generation"]);
    $personDao = new PersonDao();
    $personDao->insertPerson($child);

    header("Location: personSettings.php?id=$id&x=$x&y=$y");
}
if (isset($_GET["deleteId"])) {
    $deleteId = $_GET["deleteId"];
    if ($deleteId == 1) {
        echo "You cant delete Main Person. This should not happen.";
        exit;
    }
    $personController = new PersonController();

    $personsDescendantsList = $personController->getPersonsDescendantsList($deleteId);
    $personDao = new PersonDao();
    $personDao->deletePersons($personsDescendantsList);
    header("Location: admin.php");
    exit;
}
if (isset($_POST["saveAllPositions"])) {
    $personDao = new PersonDao();
    $personDao->saveAllPositions($_POST["saveAllPositions"]);
    header("Location: admin.php");
}
var_dump($_POST);
var_dump($_GET);
