<?php
require_once 'Controller/MapVersionController.php';
$mapVersionController = new MapVersionController();
$allVersions = $mapVersionController->getAllMapVersions();
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
    <center>   <h1>Admin Menu </h1></center>
    <br>
    <a href="index.php">Go INDEX</a>
    <br>
    <a href="config.php">GO CONFIG</a>
    <br>
    <a href="adminMap.php">Go MAP</a>

</body>
</html>
