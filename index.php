<?php
require_once 'Controller/PersonController.php';
$personController = new PersonController();
$fullGenTree = $personController->getFullGenTree();
var_dump($fullGenTree);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <a href="config.php">Go Config</a>
        <br>
        <a href="admin.php">Go Admin</a>
        <br>
        <?php
        $id = $fullGenTree->getId();
        echo $fullGenTree->getFirstName() . " " . $fullGenTree->getSecondName();
        echo "&nbsp<a href='addChild.php?id=$id'>შვილის დამატება</a>";
        ?>

    </body>
</html>
