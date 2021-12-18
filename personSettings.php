<?php
require_once 'Controller/PersonController.php';
require_once 'Controller/AdminController.php';

if (isset($_GET["id"]) && isset($_GET["x"]) && isset($_GET["y"])) {
    //do nothing
} else {
    echo "<h1>რაღაც გაუთვალიწინებელი მოხდა <a href='admin.php'>დაბრუნდი მთავარ გვერდზე</a></h1>";
    exit;
}
$id = $_GET["id"];
$x = $_GET["x"];
$y = $_GET["y"];
$personController = new PersonController;
$person = $personController->getPerson($id);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <h1>პიროვნების მონაცემები</h1>

        <?php
        if ($person->getPositionX() == $x && $person->getPositionY() == $y) {
            //do nothing for now   
        } else {
            echo "<h2>რუქაზე პიორვნების მდებარეობა შეცვლილია</h2>"
            . "<form action='requestDispatcher.php' method='POST'>"
            . "<input hidden name='setNewPosition' value='1'>"
            . "<input hidden name='id' value='$id'>"
            . "<input hidden name='x' value='$x'>"
            . "<input hidden name='y' value='$y'>"
            . "<input type='submit' value='შეინახე ახალი მდებარეობა'>"
            . "</form>";
        }
        echo "<hr>";
        echo $person->getId() . " " . $person->getFirstName() . " " . $person->getNickname() . " " . $person->getSecondName();
        ?>
        <br>
        <a href='admin.php'>რუქაზე გადასვლა</a>
    </body>
</html>
