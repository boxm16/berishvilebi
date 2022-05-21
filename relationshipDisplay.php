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
if ($relationship == null) {
    echo "ERROR";
    exit;
}
if ($relationship->getLinealRelatianshipVector() != null) {
    $svgHeight = count($relationship->getLinealRelatianshipVector()) * 200;
} else {

    $svgHeight = count($relationship->getCollateralRelationshipVector_A()) > count($relationship->getCollateralRelationshipVector_B()) ?
            (count($relationship->getCollateralRelationshipVector_A()) + 1) * 200 : (count($relationship->getCollateralRelationshipVector_B()) + 1) * 200;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
    <center>
        <a href="relatives.php"><h4>უკან დაბრუნება</h4></a>
        <svg style="background-color:skyblue" width="600"  height="<?php echo $svgHeight ?>" ondblclick="redirectToRelativesMenu();">
        <?php
        if ($relationship != null) {

            if ($relationship->getType() != "collateral") {
                $linealRelatianshipVector = $relationship->getLinealRelatianshipVector();
                $x = 250;
                $y = 50;
                $x1 = $x + 42;
                $x2 = $x + 42;
                $y1 = $y + 42;
                $y2 = $y + 42 + 200;
                $index = 0;

                foreach ($linealRelatianshipVector as $person) {

                    $id = $person->getId();
                    $generation = $person->getGeneration();

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
                    if ($index == count($linealRelatianshipVector) - 1) {
                        
                    } else {
                        echo "<line id='1' x1='$x1' y1='$y1' x2='$x2' y2='$y2' style='stroke:rgb(255,0,0)'></line>";
                    }
                    $index++;

                    echo "<svg id='$id' class='movingCircle' name='$name' style='cursor: default' x='$x' y='$y' >";
                    echo "<g id='$id'  ondblclick='redirect(event, $id)'>";
                    echo "<circle   cx='42' cy='42' r='40' stroke='green' stroke-width='4' fill='yellow' />";

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
                    $y += 200;
                    $y1 += 200;
                    $y2 += 200;
                }
            } else {


                //first drawing the heade
                $collatarealRelationshipHead = $relationship->getCollatarealRelationshipHead();

                $x = 250;
                $y = 50;


                $id = $collatarealRelationshipHead->getId();
                $generation = $collatarealRelationshipHead->getGeneration();

                $firstName = $collatarealRelationshipHead->getFirstName();
                $secondName = $collatarealRelationshipHead->getSecondName();

                $firstNameX = $x;
                $firstdNameY = $y - 10;
                $secondNameX = $x;
                $secondNameY = $firstdNameY + 15;

                $parentId = $collatarealRelationshipHead->getParentId();
                $children = $collatarealRelationshipHead->getChildren();
                $name = $parentId . ':';
//name actually is code for for a person, it contains parent Id and children ids
                foreach ($children as $child) {
                    $childId = $child->getId();
                    $name = $name . $childId . ',';
                }

                $x1 = $x + 42;
                $x2 = $x + 42 - 100;
                $y1 = $y + 42;
                $y2 = $y + 42 + 200;
                echo "<line id='1' x1='$x1' y1='$y1' x2='$x2' y2='$y2' style='stroke:rgb(255,0,0)'></line>";

                $x1 = $x + 42;
                $x2 = $x + 42 + 100;
                $y1 = $y + 42;
                $y2 = $y + 42 + 200;
                echo "<line id='1' x1='$x1' y1='$y1' x2='$x2' y2='$y2' style='stroke:rgb(255,0,0)'></line>";


                echo "<svg id='$id' class='movingCircle' name='$name' style='cursor: default' x='$x' y='$y' >";
                echo "<g id='$id'  ondblclick='redirect(event, $id)'>";
                echo "<circle   cx='42' cy='42' r='40' stroke='green' stroke-width='4' fill='yellow' />";

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








                $x = 150;
                $y = 250;
                $x1 = $x + 42;
                $x2 = $x + 42;
                $y1 = $y + 42;
                $y2 = $y + 42 + 200;
                $index = 0;

                $collateralRelationshipVector_A = $relationship->getCollateralRelationshipVector_A();
                $collateralRelationshipVector_A = array_reverse($collateralRelationshipVector_A);

                $collateralRelationshipVector_B = $relationship->getCollateralRelationshipVector_B();
                $collateralRelationshipVector_B = array_reverse($collateralRelationshipVector_B);




                foreach ($collateralRelationshipVector_A as $person) {

                    $id = $person->getId();
                    $generation = $person->getGeneration();

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
                    if ($index == count($collateralRelationshipVector_A) - 1) {
                        
                    } else {
                        echo "<line id='1' x1='$x1' y1='$y1' x2='$x2' y2='$y2' style='stroke:rgb(255,0,0)'></line>";
                    }
                    $index++;

                    echo "<svg id='$id' class='movingCircle' name='$name' style='cursor: default' x='$x' y='$y' >";
                    echo "<g id='$id'  ondblclick='redirect(event, $id)'>";
                    echo "<circle   cx='42' cy='42' r='40' stroke='green' stroke-width='4' fill='yellow' />";

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
                    $y += 200;
                    $y1 += 200;
                    $y2 += 200;
                }


                $x = 350;
                $y = 250;
                $x1 = $x + 42;
                $x2 = $x + 42;
                $y1 = $y + 42;
                $y2 = $y + 42 + 200;
                $index = 0;

                foreach ($collateralRelationshipVector_B as $person) {

                    $id = $person->getId();
                    $generation = $person->getGeneration();

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
                    if ($index == count($collateralRelationshipVector_B) - 1) {
                        
                    } else {
                        echo "<line id='1' x1='$x1' y1='$y1' x2='$x2' y2='$y2' style='stroke:rgb(255,0,0)'></line>";
                    }
                    $index++;

                    echo "<svg id='$id' class='movingCircle' name='$name' style='cursor: default' x='$x' y='$y' >";
                    echo "<g id='$id'  ondblclick='redirect(event, $id)'>";
                    echo "<circle   cx='42' cy='42' r='40' stroke='green' stroke-width='4' fill='yellow' />";

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
                    $y += 200;
                    $y1 += 200;
                    $y2 += 200;
                }
            }
        }
        ?>
        </svg>
    </center>
    <script>
        function redirectToRelativesMenu() {
            document.location.href = "relatives.php";
            event.stopPropagation();
        }

    </script>
</body>
</html>
