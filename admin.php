<?php
require_once 'Controller/AdminController.php';
require_once 'Controller/PersonController.php';
$adminController = new adminController();
if (isset($_POST["setSpace"])) {
    $svgWidth = $_POST["svgWidth"];
    $svgHeight = $_POST["svgHeight"];
    $adminController->updateSpace($svgWidth, $svgHeight);
}

$svgWidth = $adminController->getSvgWidth();
$svgHeight = $adminController->getSvgHeight();

$personController = new PersonController();
$personsList = $personController->getAllPersons();
if (isset($_GET["personInFocusId"])) {
    $personInFocusId = $_GET["personInFocusId"];
} else {
    $personInFocusId = 1;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <title></title>
    </head>
    <body>
        <div class="container-fluid">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <input hidden name="setSpace">
                სივრცის სიგანე:   <input type="number" name="svgWidth" value="<?php echo $svgWidth; ?>"> &nbsp სივრცის სიმაღლე: <input type="number" name="svgHeight" value="<?php echo $svgHeight; ?>"> 

                <button type="submit">სივრცის ზომების შეცვლა</button>
            </form>
            <hr>
            <?php
            ?>
            <svg width="<?php echo $svgWidth; ?>" height="<?php echo $svgHeight; ?>">
            <rect x="0" y="0"  width="<?php echo $svgWidth; ?>" height="<?php echo $svgHeight; ?>" style="fill: skyblue;"/>
            <?php
            foreach ($personsList as $person) {
                $id = $person->getId();
                $x = $person->getPositionX();
                $y = $person->getPositionY();
                $firstName = $person->getFirstName();
                $secondName = $person->getSecondName();
                $firstNameX = $x;
                $firstdNameY = $y - 10;
                $secondNameX = $x;
                $secondNameY = $firstdNameY + 15;
                echo "<svg  class='movingCircle' style='cursor: default' x='$x' y='$y'>";
                echo "<g id='$id' ondblclick='goPersonPage(event);'>";
                echo "<circle  cx='42' cy='42' r='40' stroke='green' stroke-width='4' fill='yellow' />";
                echo "<text x='42' y='30' text-anchor='middle' fill='black' font-size='15px' font-family='Arial' dy='.3em'>
        $firstName 
        </text>;
        <text x='42' y='50' text-anchor='middle' fill='black' font-size='13px' font-family='Arial' dy='.3em'>
        $secondName      
        </text>";
                echo "</g>";
                echo "</svg>";
            }
            ?>

            </svg>


        </div>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script>

            var allCircles = document.querySelectorAll(".movingCircle");
            allCircles.forEach(element => dragMovingCirlce(element));
            centerPersonInFocus();

            //-----------------------------

            function myFunction() {
                let modalButton = (document.getElementById("modalButton"));
                modalButton.click();
            }



            function dragMovingCirlce(elmnt) {

                var mousePosStartX = 0, mousePosStartY = 0, mousePosEndX = 0, mousePosEndY = 0;
                var movingCirclePosStartX = 0, movingCirclePosStartY = 0, movingCirclePosEndX = 0, movingCirclePosEndY = 0;

                var diffPosX = 0, diffPosY = 0;

                elmnt.onmousedown = dragMouseDown;


                function dragMouseDown(e) {

                    e = e || window.event;
                    e.preventDefault();
                    // get the mouse cursor position at startup:
                    mousePosStartX = e.clientX;
                    mousePosStartY = e.clientY;
                    movingCirclePosStartX = elmnt.getAttribute("x");
                    movingCirclePosStartY = elmnt.getAttribute("y");
                    diffPosX = movingCirclePosStartX - mousePosStartX;
                    diffPosY = movingCirclePosStartY - mousePosStartY;

                    document.onmouseup = closeDragElement;
                    // call a function whenever the cursor moves:
                    document.onmousemove = elementDrag;
                }

                function elementDrag(e) {
                    e = e || window.event;
                    e.preventDefault();
                    // calculate the new cursor position:

                    mousePosEndX = e.clientX;
                    mousePosEndY = e.clientY;

                    movingCirclePosEndX = mousePosEndX + diffPosX;
                    movingCirclePosEndY = mousePosEndY + diffPosY;
                    // set the element's new position:
                    elmnt.setAttribute("x", movingCirclePosEndX);
                    elmnt.setAttribute("y", movingCirclePosEndY);

                }

                function closeDragElement() {
                    /* stop moving when mouse button is released:*/
                    document.onmouseup = null;
                    document.onmousemove = null;
                }
            }


            function centerPersonInFocus() {
                document.getElementById('<?php echo $personInFocusId ?>').scrollIntoView({
                    behavior: 'auto',
                    block: 'center',
                    inline: 'center'
                });
            }

            //----------------------------------------------------
            function goPersonPage(event) {


                let id = event.target.parentNode.getAttribute("id");
                let x = event.target.parentNode.parentNode.getAttribute("x");
                let y = event.target.parentNode.parentNode.getAttribute("y");
                location.href = "personSettings.php?id=" + id + "&x=" + x + "&y=" + y;
            }
        </script>
    </body>
</html>
