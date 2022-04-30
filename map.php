<?php
require_once 'Controller/MapVersionController.php';
require_once 'Controller/PersonController.php';


$mapVersionId = 1;

$mapVersionController = new MapVersionController();
$mapVersion = $mapVersionController->getMapVersion($mapVersionId);
$width = $mapVersion->getMapWidth();
$height = $mapVersion->getMapHeight();



$personController = new PersonController();
$personsList = $personController->getAllPersonsForMap($mapVersionId);
if (isset($_GET["personInFocusId"])) {
    $personInFocusId = $_GET["personInFocusId"];
} else if (isset($_POST["personInFocusId"])) {
    $personInFocusId = $_POST["personInFocusId"];
} else {
    $personInFocusId = 1;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title></title>
        <script src="https://code.jquery.com/jquery-2.2.1.min.js"></script>
        <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <style>
            svg {
                position: absolute;
                left: 0;
                top: 0;

            }
        </style>
    </head>
    <body>

        <svg style="background-color:skyblue" width="<?php echo $width ?>"  height="<?php echo $height ?>" ondblclick="redirectToMainMenu();">
        <?php
        foreach ($personsList as $person) {
            if ($person->getParentId() == 0) {
                //no need for line, line goes only from child to parent  
            } else {
                $parentId = $person->getParentId();
                $personId = $person->getId();
                $x1 = $person->getParentPositionX() + 42;
                $y1 = $person->getParentPositionY() + 42;
                $x2 = $person->getPositionX() + 42;
                $y2 = $person->getPositionY() + 42;
                $lineId = 'line_' . $personId . '_' . $parentId;

                echo "<line id='$lineId' x1='$x1' y1='$y1' x2='$x2' y2='$y2' style='stroke:rgb(255,0,0)'></line>";
            }
        }

        foreach ($personsList as $person) {

            $id = $person->getId();
            $generation = $person->getGeneration();
            $x = $person->getPositionX();
            $y = $person->getPositionY();
            $parentPositionX = $person->getParentPositionX();
            $parentPositionY = $person->getParentPositionY();
            $firstName = $person->getFirstName();
            $secondName = $person->getSecondName();
            $firstNameX = $x;
            $firstdNameY = $y - 10;
            $secondNameX = $x;
            $secondNameY = $firstdNameY + 15;

            $parentId = $person->getParentId();
            $children = $person->getChildren();
            $name = $parentId . ':';
//name actually is code for for a person, it contains parent Id and children ids
            foreach ($children as $child) {
                $childId = $child->getId();
                $name = $name . $childId . ',';
            }

            echo "<svg id='$id' class='movingCircle' name='$name' style='cursor: default' x='$x' y='$y' >";
            echo "<g id='$id'  ondblclick='redirect(event, $id)'>";
             if ($id == 1) {
                echo "<circle   cx='42' cy='42' r='40' stroke='red' stroke-width='4' fill='yellow' />";
            } else if ($personInFocusId == $id) {
                echo "<circle   cx='42' cy='42' r='40' stroke='green' stroke-width='4' fill='lime' />";
            } else {
                echo "<circle   cx='42' cy='42' r='40' stroke='green' stroke-width='4' fill='yellow' />";
            }
            echo "<text x='42' y='30' text-anchor='middle' fill='black' font-size='15px' font-family='Arial' dy='.3em'>
        $firstName 
        </text>;
        <text x='42' y='50' text-anchor='middle' fill='black' font-size='13px' font-family='Arial' dy='.3em'>
        $secondName      
        </text>
        <text x='42' y='70' text-anchor='middle' fill='black' font-size='15px' font-family='Arial' dy='.3em'>
        $generation 
        </text>;";
            echo "</g>";
            echo "</svg>";
        }
        ?>
        </svg>
        <form action="menu.php" method="POST">
            <input  name="mapVersionId" hidden value="<?php echo $mapVersionId; ?>">
        </form>

        <script>
            window.addEventListener("load", centerPersonInFocus());
            function centerPersonInFocus() {
                document.getElementById('<?php echo $personInFocusId ?>').scrollIntoView({
                    behavior: 'auto',
                    block: 'center',
                    inline: 'center'
                });
            }

//------------------------REDIRECTION START ---------------------------------------
            function redirectToMainMenu() {
                var form = document.querySelector("form");

                form.submit();

            }
            function redirect(event, personId) {

                document.location.href = "personDisplay.php?personId=" + personId;
                event.stopPropagation();
            }
//------------------------REDIRECTING END ------------------------------


        </script>
    </body>
</html>



