<?php
require_once 'Controller/PersonController.php';
$personController = new PersonController();
//$fullGenTree = $personController->getFullGenTree();
$generationsLayers = $personController->getGenerationsLayers();
$svgHeight = count($generationsLayers) * 100;
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
        <a href="display.php">Go Display</a>
        <br>
          <a href="display_2.php">Go Display 2</a>






        <hr>
        <svg width="800" height="<?php echo $svgHeight ?>">
        <?php
        $cy = 60;

        foreach ($generationsLayers as $generationLayer) {
            $x = $cx = 70;
       
            foreach ($generationLayer as $person) {
                 $y = $cy - 15;
                $firstName = $person->getFirstName();
                $secondName = $person->getSecondName();
                $id = $person->getId();
                echo " <ellipse cx='$cx' cy='$cy' rx='50' ry='30' style='fill:yellow;stroke:purple;stroke-width:2' /> ";
                echo " <text x='$x' y='$y' text-anchor='middle' fill='black' font-size='15px' font-family='Arial' dy='.3em'>
           $firstName 
                   </text>";
                $y += 13;

                echo " <text x='$x' y='$y' text-anchor='middle' fill='black' font-size='15px' font-family='Arial' dy='.3em'>
          $secondName      
                  </text>";
                $y += 13;
                echo " <text x='$x' y='$y' text-anchor='middle' fill='black' font-size='15px' font-family='Arial' dy='.3em'>
         <a href='addChild.php?id=$id'>add child</a>    
                  </text>";

                $cx += 100;
                $x += 100;
            }
            $cy += 100;
            $y += 100;
        }
        ?>
        </svg>  
    </body>
</html>
