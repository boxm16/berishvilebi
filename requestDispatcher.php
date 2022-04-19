<?php

require_once 'Model/MapVersion.php';
require_once 'Controller/MapVersionController.php';

if (isset($_POST["newVersionName"])) {
    $mapVersionName = $_POST["newVersionName"];
    $mapVersion = new MapVersion();
    $mapVersion->setName($mapVersionName);
    $mapVersion->setMapWidth(7000);
    $mapVersion->setMapHeight(7000);

    $mapVersionDao = new MapVersionDao();
    $insertionResult = $mapVersionDao->insertMapVersion($mapVersion);
    if ($insertionResult) {
        echo 'Main Map Version Inserted!<br>'; //it does not show anywhere, fix it.
    }
    header("Location: adminMenu.php");
}
var_dump($_POST);
var_dump($_GET);
