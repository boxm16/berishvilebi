<?php

require_once 'Model/MapVersion.php';
require_once 'Controller/MapVersionController.php';
require_once 'DAO/PersonDao.php';
require_once 'Model/Person.php';
require_once 'Controller/PersonController.php';

if (isset($_POST["newVersionName"])) {
    $mapVersionName = $_POST["newVersionName"];
    $mapVersion = new MapVersion();
    $mapVersion->setName($mapVersionName);
    $mapVersion->setMapWidth(7000);
    $mapVersion->setMapHeight(7000);

    $mapVersionDao = new MapVersionDao();
    $newMapVersionId = $mapVersionDao->insertMapVersion($mapVersion);
    $personDao = new PersonDao();
    $personDao->insertPersonPosition($newMapVersionId, 1, 200, 200);
    header("Location: adminMenu.php");
}

if (isset($_POST["insertChild"])) {
    $mapVersionId = $_POST["mapVersinId"];
    $parentId = $_POST["parentId"];

    $newPerson = new Person();
    $newPerson->setParentId($parentId);
    $newPerson->setGeneration($_POST["generation"]);
    $newPerson->setFirstName($_POST["firstName"]);
    $newPerson->setNickname($_POST["nickname"]);
    $newPerson->setSecondName($_POST["secondName"]);
    $newPerson->setLifeStatus($_POST["lifeStatus"]);
    $newPerson->setBirthDate($_POST["birthDate"]);
    $newPerson->setDeathDate($_POST["deathDate"]);

    $personController = new PersonController();
    $personController->insertChild($newPerson, $mapVersionId);
    header("Location: personPage.php?personId=$parentId&mapVersionId=$mapVersionId");
}

if (isset($_POST["saveAllPositions"])) {
    $personDao = new PersonController();
    $saveAllPositions = $_POST["saveAllPositions"];
    $mapVersionId = $_POST["mapVersionId"];
    $personDao->saveAllPositions($saveAllPositions, $mapVersionId);
    header("Location: versionMenu.php?mapVersionId=$mapVersionId");
}
if (isset($_POST["moveAllPositions"])) {
    $personDao = new PersonDao();
    $c = explode(":", $_POST["moveAllPositions"]);

    if ($c[0] == "x") {
        $personDao->moveHorizontalyAllPositions($c[1] * 1);
    }
    if ($c[0] == "y") {
        $personDao->moveVerticallyAllPositions($c[1] * 1);
    }
    header("Location: admin.php");
}
var_dump($_POST);
var_dump($_GET);
