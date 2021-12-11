<?php
include_once 'Controller/PersonController.php';
$personController = new PersonController();
$generations = $personController->getGenerations();
$svgWidth = $personController->getSvgWidth();
$svgHeight = $personController->getSvgHeight();
$personsMap = $personController->getPersonsMap();
?>
<!DOCTYPE html>
<html>
    <head>

    </head>
    <body>




        <button onclick="myFunction()">Scroll</button>


        <svg width="<?php echo $svgWidth ?>" height="<?php echo $svgHeight ?>">

        <?php
        //first lines
        foreach ($personsMap as $person) {
            $x = $person->getMyX();
            $y = $person->getMyY();

            $parentId = $person->getParentId();
            if ($parentId == 0) {
                $parentX = $person->getMyX();
                $parentY = $person->getMyY();
            } else {
                $parent = $personsMap[$parentId];
                $parentX = $parent->getMyX();
                $parentY = $parent->getMyY();
            }

            echo "<line x1='$parentX' y1='$parentY' x2='$x' y2='$y' style='stroke:rgb(255,0,0);stroke-width:2' />";
        }
        //now persons
        foreach ($personsMap as $person) {
            $x = $person->getMyX();
            $y = $person->getMyY();



            $firstdNameY = $y - 10;
            $secondNameY = $firstdNameY + 15;
            $addChildeLinkY = $secondNameY + 15;
            $firstName = $person->getFirstName();
            $secondName = $person->getSecondName();
            $id = $person->getId();
            echo "<ellipse id='myID' cx='$x' cy='$y' rx='60' ry='30'  style='fill:yellow;stroke:purple;stroke-width:2' />";
            echo "<text x='$x' y='$firstdNameY' text-anchor='middle' fill='black' font-size='15px' font-family='Arial' dy='.3em'>
        $firstName 
        </text>;
        <text x='$x' y='$secondNameY' text-anchor='middle' fill='black' font-size='15px' font-family='Arial' dy='.3em'>
        $secondName      
        </text>";
            echo " <text x='$x' y='$addChildeLinkY' text-anchor='middle' fill='black' font-size='15px' font-family='Arial' dy='.3em'>
         <a href='addChild.php?id=$id'>Add</a>    
                  </text>";
        }
        ?>

        </svg>

        <script>
            myFunction();
            function myFunction() {
                document.getElementById('myID').scrollIntoView({
                    behavior: 'auto',
                    block: 'center',
                    inline: 'center'
                });
            }
        </script>

    </body>
</html>