<?php

session_start();
require_once 'Model/MapVersion.php';
require_once 'Controller/MapVersionController.php';
require_once 'DAO/PersonDao.php';
require_once 'Model/Person.php';
require_once 'Controller/PersonController.php';

if (isset($_POST["map"])) {
    if (isset($_SESSION["mapVersionId"])) {
        
    } else {
        $mapVersionId = $_POST["mapVersionId"];
        $_SESSION["mapVersionId"] = $mapVersionId;
    }
    var_dump($_POST);
    exit;
    header("Location: map.php");
}

//----------------BELOW ARE ADMIN FUNCTIONS ----------------

if (isset($_POST["authorization"])) {
    $username = $_POST["username"];
    $paswword = $_POST["password"];
    if ($username == 'maxo_beri' && $paswword == 'beri!maxo') {
        $_SESSION["authorized"] = "true";
        header("Location: adminMenu.php");
        exit;
    } else {
        $_SESSION["authorized"] = "false";
        header("Location: adminGate.php?authorizationResult=fail");
        exit;
    }
}
if (isset($_GET["adminStatus"])) {
    if ($_GET["adminStatus"] == "signOut") {
        unset($_SESSION['authorized']);
        session_destroy();
        header("Location: adminGate.php?");
        exit;
    }
}

if ($_SESSION["authorized"] == "true") {
    //you can go on
} else {
    header("Location: adminGate.php?authorizationResult=notAuthorized");
}

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
    $mapVersionId = $_POST["mapVersionId"];
    $personDao = new PersonDao();
    $c = explode(":", $_POST["moveAllPositions"]);

    if ($c[0] == "x") {
        $personDao->moveHorizontalyAllPositions($c[1] * 1, $mapVersionId);
    }
    if ($c[0] == "y") {
        $personDao->moveVerticallyAllPositions($c[1] * 1, $mapVersionId);
    }
    header("Location: versionMenu.php?mapVersionId=$mapVersionId");
}

if (isset($_GET["changeMapWidth"])) {
    $mapVersionId = $_GET["mapVersionId"];
    $mapWidth = $_GET["changeMapWidth"];
    $mapVersionController = new MapVersionController();
    $mapVersionController->changeMapWidth($mapVersionId, $mapWidth);
    header("Location: versionMenu.php?mapVersionId=$mapVersionId");
}
if (isset($_GET["changeMapHeight"])) {
    $mapVersionId = $_GET["mapVersionId"];
    $mapHeight = $_GET["changeMapHeight"];
    $mapVersionController = new MapVersionController();
    $mapVersionController->changeMapHeight($mapVersionId, $mapHeight);
    header("Location: versionMenu.php?mapVersionId=$mapVersionId");
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
    header("Location: versionMenu.php?mapVersionId=1");
}

if (isset($_POST["updateId"])) {
    $personId = $_POST["personId"];

    $person = new Person();

    $person->setId($_POST["personId"]);
    $person->setFirstName($_POST["firstName"]);
    $person->setNickname($_POST["nickname"]);
    $person->setSecondName($_POST["secondName"]);
    $person->setLifeStatus($_POST["lifeStatus"]);
    $person->setBirthDate($_POST["birthDate"]);
    $person->setDeathDate($_POST["deathDate"]);

    $personDao = new PersonDao();
    $personDao->updatePerson($person);
    header("Location: personPage.php?personId=$personId&mapVersionId=1");
}

if (isset($_GET["searchChildrenFor"])) {
    $personId = $_GET["searchChildrenFor"];
    $mapVersionId = $_GET["mapVersionId"];
    $personDao = new PersonDao();
    $personDao->addPersonsChildrenToMapVersion($personId, $mapVersionId);
    header("Location: personPageForVersion.php?personId=$personId&mapVersionId=$mapVersionId");
}


var_dump($_POST);
var_dump($_GET);
