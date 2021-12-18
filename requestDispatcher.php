<?php

require_once 'DAO/PersonDao.php';
require_once 'Model/Person.php';
if (isset($_POST["setNewPosition"])) {
    $id = $_POST["id"];
    $x = $_POST["x"];
    $y = $_POST["y"];
    $personDao = new PersonDao();
    $personDao->setPosition($id, $x, $y);
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
    $child->setPositionX($x + 10);
    $child->setPositionY($y + 10);
    $personDao = new PersonDao();
    $personDao->insertPerson($child);

    header("Location: personSettings.php?id=$id&x=$x&y=$y");
}
var_dump($_POST);

