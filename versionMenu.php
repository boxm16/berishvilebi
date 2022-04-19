<?php
require_once 'Controller/MapVersionController.php';
$mapVersionId = $_POST["mapVersionId"];
$mapVersionController = new MapVersionController();
$mapVersion = $mapVersionController->getMapVersion($mapVersionId);
$versionName = $mapVersion->getName();
$width = $mapVersion->getMapWidth();
$height = $mapVersion->getMapHeight();
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <h1>ვერსიის მენუ</h1>
        <a href="adminMenu.php">Go Admin Menu</a>
        <h2>
            <?php
            echo "Version Name:$versionName";
            echo "<br>";
            echo "Map Dimesnisons:MAP WIDTH-$width. MAP HEIGHT-$height";
            ?>
        </h2>  
    </body>
</html>
