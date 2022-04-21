<?php
require_once 'Controller/MapVersionController.php';

$mapPositioningChanged = "false";
$allPositions;
if (isset($_GET["mapVersionId"])) {
    $mapVersionId = $_GET["mapVersionId"];
} else {
    $mapVersionId = $_POST["mapVersionId"];
    $mapPositioningChanged = $_POST["mapPositioningChanged"];
    $allPositions = $_POST["allPositions"];
}
echo $mapPositioningChanged;
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



            if ($mapPositioningChanged == "true") {
                echo "<center><h2 style='background-color:red'>რუქაზე პიროვნების/პიროვნებების მდებარეობა შეიცვალა</h2><center>"
                . "<form action='requestDispatcher.php' method='POST'>"
                . "<input name='saveAllPositions'  hidden value='$allPositions'>"
                . "<input name='mapVersionId'  hidden value='$mapVersionId'>"
                . "<input type = 'submit' value = 'შეინახე ცვლილებები' style = 'color:green; font-size:20px;font-weight:bold'>"
                . "</form>"
                . "<hr>";
            }


            echo "<br>";
            echo "Map Dimesnisons:MAP WIDTH-$width. MAP HEIGHT-$height";
            ?>
        </h2>  

        <form action="adminMap.php" method="POST">
            <input name="mapVersionId" hidden value="<?php echo $mapVersionId
            ?>">
            <button type="submit">გადადი რუკაზე</button>
        </form>
    </body>
</html>
