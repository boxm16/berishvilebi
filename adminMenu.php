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

    <form action="versionMenu.php" method="GET">
        <select name="mapVersionId">
            <?php
            foreach ($allVersions as $mapVersion) {
                $mapVersionId = $mapVersion->getId();
                $mapVersionName = $mapVersion->getName();
                echo "  <option value=\"$mapVersionId\">$mapVersionName</option>";
            }
            ?>
        </select>
        <button type="submit">გადადი ვერსის სანახავად</button>
    </form>

    <hr>


    <form action="requestDispatcher.php" method="POST">
        <h3>რუკის ახალი ვერსიის შექმნა</h3>
        სახელი <input type="text" name="newVersionName">

        <button type="submit">შექმნა</button>
    </form>
</body>
</html>
