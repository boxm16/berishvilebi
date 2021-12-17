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
                $x = $person->getPositionX();
                $y = $person->getPositionY();
                echo "<circle  cx='$x' cy='$y' r='40' stroke='green' stroke-width='4' fill='yellow'  ondblclick='myFunction()' />";
            }
            ?>

            </svg>

            <!-- MODAL WINDOW FOR ADDING SON -->
            <!-- Button trigger modal -->
            <button id="modalButton" hidden type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                Launch demo modal
            </button>

            <!-- Modal -->
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            ...
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script>

            var allCircles = document.querySelectorAll("circle");
            allCircles.forEach(element => dragCirlce(element));

            function myFunction() {
                let modalButton = (document.getElementById("modalButton"));
                modalButton.click();
            }

            function dragCirlce(elmnt) {

                var mousePosStartX = 0, mousePosStartY = 0, mousePosEndX = 0, mousePosEndY = 0;
                var circlePosStartX = 0, circlePosStartY = 0, circlePosEndX = 0, circlePosEndY = 0;

                var diffPosX = 0, diffPosY = 0;

                elmnt.onmousedown = dragMouseDown;


                function dragMouseDown(e) {

                    e = e || window.event;
                    e.preventDefault();
                    // get the mouse cursor position at startup:
                    mousePosStartX = e.clientX;
                    mousePosStartY = e.clientY;
                    circlePosStartX = elmnt.getAttribute("cx");
                    circlePosStartY = elmnt.getAttribute("cy");
                    diffPosX = circlePosStartX - mousePosStartX;
                    diffPosY = circlePosStartY - mousePosStartY;

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

                    circlePosEndX = mousePosEndX + diffPosX;
                    circlePosEndY = mousePosEndY + diffPosY;
                    // set the element's new position:
                    elmnt.setAttribute("cx", circlePosEndX);
                    elmnt.setAttribute("cy", circlePosEndY);

                }

                function closeDragElement() {
                    /* stop moving when mouse button is released:*/
                    document.onmouseup = null;
                    document.onmousemove = null;
                }
            }
        </script>
    </body>
</html>
