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
        <script src="https://code.jquery.com/jquery-2.2.1.min.js"></script>
        <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
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
        </style>
    </head>
    <body style="width:7000px;">
        <div class="container-fluid">
            <a href="config.php">GO TO CONFIG</a> &nbsp &nbsp &nbsp  &nbsp &nbsp &nbsp &nbsp 

            <button type="button" class="btn btn-primary" onclick="saveAllPositions()">განლაგების ცვლილებების შენახვა</button>&nbsp &nbsp &nbsp  &nbsp &nbsp &nbsp &nbsp
            <input id="moveAllPositionsInput" type="number">&nbsp &nbsp
            <button type="button" class="btn btn-primary" onclick="moveAllPositions('left')">Left</button>
            <button type="button" class="btn btn-primary" onclick="moveAllPositions('right')">Right</button>
            <button type="button" class="btn btn-primary" onclick="moveAllPositions('up')">Up</button>
            <button type="button" class="btn btn-primary" onclick="moveAllPositions('down')">Down</button>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <input hidden name="setSpace">
                სივრცის სიგანე:   <input type="number" name="svgWidth" value="<?php echo $svgWidth; ?>"> &nbsp სივრცის სიმაღლე: <input type="number" name="svgHeight" value="<?php echo $svgHeight; ?>"> 

                <button type="submit">სივრცის ზომების შეცვლა</button>
            </form>

            <hr>
            <?php
            ?>
            <svg style="background-color:skyblue" width="100%"  height="<?php echo $svgHeight; ?>">

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
            }
            ?>

            </svg>
            <form id="saveAllPositionsForm" action="requestDispatcher.php" method="POST">
                <input id="saveAllPositionsInput" name='saveAllPositions' hidden value="">
            </form>
            <form id="moveAllPositionsForm" action="requestDispatcher.php" method="POST">
                <input id="moveAllPositionsFormInput" name='moveAllPositions' hidden value="">
            </form>
        </div>

        <script>
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
            //----------------------------
            function saveAllPositions() {
                let allCircles = document.querySelectorAll(".movingCircle");
                let postRequest = "";
                for (let i = 0; i < allCircles.length; i++) {
                    let circle = allCircles[i];
                    let id = circle.id;
                    let x = circle.getAttribute("x");
                    let y = circle.getAttribute("y");
                    if (i == 0) {
                        postRequest = postRequest + id + "," + x + "," + y;
                    } else {
                        postRequest = postRequest + ":" + id + "," + x + "," + y;
                    }
                }
                document.getElementById("saveAllPositionsInput").value = postRequest;
                document.getElementById("saveAllPositionsForm").submit();
            }

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
    </body>
</html>
