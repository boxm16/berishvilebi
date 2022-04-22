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
        <meta charset="utf-8">
        <title>რუქის ვერსიის მენიუ</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class=""container-fluid">
            <div class="row">
                <div class="col-md-auto">

                    <center> <h3> <a href="adminMenu.php">მთავარი (ადმინისტრატორის) მენიუ</a></h3></center>
                    <hr>
                    <center> 
                        <h1>რუქის ვერსიის მენიუ</h1>
                        <h3>
                            <?php
                            echo "ვერსიის დასახელება:   $versionName";
                            ?>
                        </h3>

                        <hr>
                        <form action="adminMap.php" method="POST">
                            <input name="mapVersionId" hidden value="<?php echo $mapVersionId
                            ?>">
                            <button class="btn btn-primary btn-block"  style="font-size:40px" type="submit">რუქის ნახვა</button>
                        </form>

                        <hr>

                        <?php
                        if ($mapPositioningChanged == "true") {
                            echo "<center><h2 style='background-color:red'>რუქაზე პიროვნების/პიროვნებების მდებარეობა შეიცვალა</h2><center>"
                            . "<form action='requestDispatcher.php' method='POST'>"
                            . "<input name='saveAllPositions'  hidden value='$allPositions'>"
                            . "<input name='mapVersionId'  hidden value='$mapVersionId'>"
                            . "<input type = 'submit' value = 'შეინახე ცვლილებები' style = 'color:green; font-size:20px;font-weight:bold'>"
                            . "</form>";
                        }
                        ?>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th colspan="3" >
                            <center>  <h2>  რუქის ზომები</h2></center>
                            </th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><center><h3>სიგანე</h3></center></td>
                            <td><center><h3><input id='mapWidth' type='number'  value='<?php echo $width ?>'></h3></center></td>
                            <td><h3><button class="btn btn-danger" style="font-size: 25px" onclick="changeWidth()">შეცვლა</button></h3></td>
                            </tr>
                            <tr>
                                <td><center><h3>სიმღლე</h3></center></td>
                            <td><center><h3><input id="mapHeight" type='number' value='<?php echo $height ?>'></h3></center></td>
                            <td><h2><button class="btn btn-danger" style="font-size: 25px" onclick="changeHeight()"> შეცვლა </button></h2></td >
                            </tr>
                            </tbody>
                        </table>
                        <hr>
                        <h2>ყველა     პიროვნების გადაადგილება</h2>
                        <h3> <input id="moveAllPositionsInput" type="number">ნაბიჯი</h3>
                        <br>        
                        <br>
                        <button type="button" class="btn btn-primary" style="font-size: 25px" onclick="moveAllPositions('left')">მარცხნივ</button>
                        <button type="button" class="btn btn-primary" style="font-size: 25px" onclick="moveAllPositions('right')">მარჯვნივ</button>
                        <button type="button" class="btn btn-primary" style="font-size: 25px" onclick="moveAllPositions('up')">ზემოთ</button>
                        <button type="button" class="btn btn-primary" style="font-size: 25px" onclick="moveAllPositions('down')">ქვემოთ</button>
                        <form id="moveAllPositionsForm" action="requestDispatcher.php" method="POST">
                            <input id="moveAllPositionsFormInput" name='moveAllPositions' hidden value="">
                            <input id="mapVersionId" name='mapVersionId' hidden value="<?php echo $mapVersionId ?>">

                        </form>

                        <hr> 
                    </center>
                </div>  
            </div>
        </div>       


        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

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

                            function changeWidth() {
                                let newWidth = document.getElementById("mapWidth").value;
                                document.location.href = "requestDispatcher.php?changeMapWidth=" + newWidth + "&mapVersionId=<?php echo $mapVersionId ?>";
                            }
                            function changeHeight() {
                                let newHeight = document.getElementById("mapHeight").value;
                                document.location.href = "requestDispatcher.php?changeMapHeight=" + newHeight + "&mapVersionId=<?php echo $mapVersionId ?>";
                            }
        </script>
    </body>
</html>
