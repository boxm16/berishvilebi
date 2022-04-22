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

        <a href="adminMenu.php">მთავარი (ადმინისტრატორის) მენიუ</a>
        <hr>
        <h1>რუქის ვერსიის მენიუ</h1>
        <h2>
            <?php
            echo "ვერსიის დასახელება:   $versionName";



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
            echo "რუქის ზომები:   სიგანე-$width. სიმაღლე-$height";
            ?>
            <hr>
            <h2>ყველა პიროვნების გადაადგილება</h2>
            <input id="moveAllPositionsInput" type="number"> ნაბიჯი
            <br>
            <br>
            <button type="button" class="btn btn-primary" onclick="moveAllPositions('left')">მარცხნივ</button>
            <button type="button" class="btn btn-primary" onclick="moveAllPositions('right')">მარჯვნივ</button>
            <button type="button" class="btn btn-primary" onclick="moveAllPositions('up')">ზემოთ</button>
            <button type="button" class="btn btn-primary" onclick="moveAllPositions('down')">ქვემოთ</button>
            <form id="moveAllPositionsForm" action="requestDispatcher.php" method="POST">
                <input id="moveAllPositionsFormInput" name='moveAllPositions' hidden value="">
                <input id="mapVersionId" name='mapVersionId' hidden value="<?php echo $mapVersionId ?>">

            </form>

            <hr>
            <form action="adminMap.php" method="POST">
                <input name="mapVersionId" hidden value="<?php echo $mapVersionId
            ?>">
                <button type="submit">რუქის ნახვა</button>
            </form>
    </body>
    <script>
        function moveAllPositions(direction) {
            let steps = document.getElementById("moveAllPositionsInput").value;
            if (steps == '') {
                return;
            }
            let sentValue = '';
            if (direction == 'left') {
                steps = steps * (-1);
                sentValue = 'x:' + steps;
            }
            if (direction == 'right') {
                steps = steps * 1;
                sentValue = 'x:' + steps;

            }
            if (direction == 'up') {
                steps = steps * (-1);
                sentValue = 'y:' + steps;

            }
            if (direction == 'down') {
                steps = steps * 1;
                sentValue = 'y:' + steps;
            }
            console.log(sentValue);
            document.getElementById("moveAllPositionsFormInput").value = sentValue;
            document.getElementById("moveAllPositionsForm").submit();
        }
    </script>
</html>
