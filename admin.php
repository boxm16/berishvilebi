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
        <script src="http://code.jquery.com/jquery-2.2.1.min.js"></script>
        <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <style>
            body
            {
                padding:0px;
                margin:0px;
                width: 3300px;
                height: 5000px
            }

            svg{

                width:100%;
                height:100%;
                top:0px;
                z-index:-1;
            }

            .table{
                position:absolute;
                cursor:pointer;	
                border-top: solid 1px;
            }

            .table.node2 {
                left: 353px;
                top: 383px;
            }

            .td{			
                padding-top: 0px;
                padding-bottom: 0px;
                padding-left: 7px;
                padding-right: 7px;
                border-style: solid;
                border-top-width: 0px;
                border-bottom-width: 1px;
                border-left-width: 1px;
                border-right-width: 1px;
            }
        </style>
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
            <line id='line' style='stroke:rgb(255,0,0)'></line>           
            <?php
            $ind = 1;

            foreach ($personsList as $person) {
                if ($ind == 1) {
                    $cirlceId = 'cirlce1';
                } if ($ind == 2) {
                    $cirlceId = 'cirlce2';
                }
                $id = $person->getId();
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
                $node = 'movingCircle' . $ind;
                echo "<svg  class='movingCircle $node' style='cursor: default' x='$x' y='$y'>";
                echo "<g id='$id' ondblclick='goPersonPage(event);'>";
                echo "<circle id='$cirlceId' cx='42' cy='42' r='40' stroke='green' stroke-width='4' fill='yellow' />";
                echo "<text x='42' y='30' text-anchor='middle' fill='black' font-size='15px' font-family='Arial' dy='.3em'>
        $firstName 
        </text>;
        <text x='42' y='50' text-anchor='middle' fill='black' font-size='13px' font-family='Arial' dy='.3em'>
        $secondName      
        </text>";
                echo "</g>";
                echo "</svg>";
                $ind++;
            }
            ?>

            </svg>
        </div>
        <script>
            $(".movingCircle1").draggable(
                    {
                        drag: function () {
                            //OUT
                            var cirlce1 = $("#cirlce1");
                            var cirlce1_position = cirlce1.offset();
                            line_y_1 = cirlce1_position.top - 21;
                            line_x_1 = cirlce1_position.left + 22;
                            $('#line').attr({x1: line_x_1, y1: line_y_1})
                        }
                    });

            $(".movingCircle2").draggable(
                    {
                        drag: function () {
                            //IN
                            var cirlce2 = $("#cirlce2");
                            var cirlce2_position = cirlce2.offset();
                            line_y_2 = cirlce2_position.top - 21;
                            line_x_2 = cirlce2_position.left + 22;
                            $('#line').attr({x2: line_x_2, y2: line_y_2})
                        }
                    });


            //OUT
            var cirlce1 = $("#cirlce1");
            var cirlce1_position = cirlce1.offset();
            line_y_1 = cirlce1_position.top - 21;
            line_x_1 = cirlce1_position.left + 22;

            //IN
            var cirlce2 = $("#cirlce2");
            var cirlce2_position = cirlce2.offset();
            line_y_2 = cirlce2_position.top - 21;
            line_x_2 = cirlce2_position.left + 22;

            //LINE
            $('#line').attr({
                'x1': line_x_1,
                'y1': line_y_1,
                'x2': line_x_2,
                'y2': line_y_2
            });
            //---------------------

            var allCircles = document.querySelectorAll(".movingCircle");
            allCircles.forEach(element => dragMovingCirlce(element));
            centerPersonInFocus();

            //-----------------------------
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
