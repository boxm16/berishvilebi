<?php
//require_once 'Controller/AdminController.php';
require_once 'Controller/PersonController.php';
//$adminController = new adminController();
$width = 4000;
$height = 4000;
$id = '1';
$name = 'ilio';
$firstName = 'lia';
$secondName = 'berish';
$x = 1000;
$y = 1000;


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
        <title></title>
        <script src="https://code.jquery.com/jquery-2.2.1.min.js"></script>
        <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <style>

        </style>
    </head>
    <body>
        <svg style="background-color:skyblue" width="<?php echo $width ?>"  height="<?php echo $height ?>">
        <?php
        echo "<svg id='$id' class='movingCircle' name='$name' style='cursor: default' x='$x' y='$y' >";
        echo "<g id='$id' ondblclick='goPersonPage(event);'>";
        echo "<circle   cx='42' cy='42' r='40' stroke='green' stroke-width='4' fill='yellow' />";
        echo "<text x='42' y='30' text-anchor='middle' fill='black' font-size='15px' font-family='Arial' dy='.3em'>
        $firstName 
        </text>;
        <text x='42' y='50' text-anchor='middle' fill='black' font-size='13px' font-family='Arial' dy='.3em'>
        $secondName      
        </text>";
        echo "</g>";
        echo "</svg>";
        ?>
        </svg>
        <script>
            window.addEventListener("load", centerPersonInFocus());
            function centerPersonInFocus() {
                document.getElementById('<?php echo $personInFocusId ?>').scrollIntoView({
                    behavior: 'auto',
                    block: 'center',
                    inline: 'center'
                });
            }

            var allCircles = document.querySelectorAll(".movingCircle");
            allCircles.forEach(element => dragMovingCirlce(element));

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

                    let name = elmnt.getAttribute("name");
                    let parentChildren = name.split(':');
                    let parentId = parentChildren[0];
                    let children = parentChildren[1].split(',');

                    children.forEach((childId) => {
                        line_y_1 = movingCirclePosEndY + 42;
                        line_x_1 = movingCirclePosEndX + 42;
                        let meToChildLineId = '#line_' + childId + '_' + elmnt.id;
                        $(meToChildLineId).attr({x1: line_x_1, y1: line_y_1})
                    })

                    line_y_2 = movingCirclePosEndY + 42;
                    line_x_2 = movingCirclePosEndX + 42;
                    let meToParentId = '#line_' + elmnt.id + '_' + parentId;
                    $(meToParentId).attr({x2: line_x_2, y2: line_y_2})

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
