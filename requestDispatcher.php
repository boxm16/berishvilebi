<?php

require_once 'Model/MapVersion.php';
require_once 'Controller/MapVersionController.php';
require_once 'DAO/PersonDao.php';

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
var_dump($_POST);
var_dump($_GET);
