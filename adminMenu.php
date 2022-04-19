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


    <hr>

    <form action="adminMap.php" method="POST">
        <select name="mapVersion" id="cars">
            <?php
            foreach ($allVersions as $mapVersion) {
                $mapVersionId = $mapVersion->getId();
                $mapVersionName = $mapVersion->getName();
                echo "  <option value=\"$mapVersionId\">$mapVersionName</option>";
            }
            ?>
        </select>
        <button type="submit">GO TO MAP</button>
    </form>

    <hr>
    <h3>რუკის ახალი ვერსიის შექმნა</h3>
    სახელი <input type="text"> <button>შექმნა</button>

</body>
</html>
