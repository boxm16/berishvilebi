<?php
require_once 'Controller/PersonController.php';

$firstPerson = $_POST["firstPersonInput"];
$secondPerson = $_POST["secondPersonInput"];

$firstPersonSplitted = explode(":", $firstPerson);
$secondPersonSplitted = explode(":", $secondPerson);
$firstPersonId = $firstPersonSplitted[1];
$secondPersonId = $secondPersonSplitted[1];
$personController = new PersonController();
$relationship = $personController->getRelationsip($firstPersonId, $secondPersonId);
if ($relationship != null) {
    echo "RELATIONSHIP TYPE: " . $relationship->getType();
    echo "<br>";
    if ($relationship->getType() != "collateral") {
        $linealRelatianshipVector = $relationship->getLinealRelatianshipVector();
        foreach ($linealRelatianshipVector as $person) {
            echo $person->getFirstName() . "<br>";
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        // put your code here
        ?>
    </body>
</html>
