<?php
require_once 'Controller/PersonController.php';

if (isset($_GET["mapVersionId"]) && isset($_GET["personId"])) {
    //do nothing
} else {
    echo "<h1>რაღაც გაუთვალიწინებელი მოხდა <a href='admin.php'>დაბრუნდი მთავარ გვერდზე</a></h1>";
    exit;
}

$mapVersionId = $_GET["mapVersionId"];
$personId = $_GET["personId"];

$personController = new PersonController;
$person = $personController->getPerson($personId, $mapVersionId);

$parentId = $person->getParentId();
$firstName = $person->getFirstName();
$nickname = $person->getNickname();
$secondName = $person->getSecondName();
$generation = $person->getGeneration();
$lifeStatus = $person->getLifeStatus();
if ($lifeStatus == "dead") {
    $alive = "";
    $dead = "selected";
} else {
    $alive = "selected";
    $dead = "";
}
$birthDate = $person->getBirthDate();
echo "BIRTHDATE" . $birthDate . "<br>";
$deathDate = $person->getDeathDate();
echo "DEATHDATE" . $deathDate;
$children = $person->getChildren();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>პიროვნების მონაცემები</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </head>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col">

                <center>
                    <form action="adminMap.php" method="POST">
                        <input  name="mapVersionId" hidden value="<?php echo $mapVersionId ?>">
                        <button class="btn btn-info" type="submit">რუქაზე დაბრუნება</button>
                    </form>
                </center>
                <hr>
                <h3><center> 
                        <table class="table">
                            <tr>
                                <td>
                                    <label>id </label>
                                </td>
                                <td>
                                    <?php echo $personId ?>
                                </td> 
                            </tr>
                            <tr>
                                <td>
                                    <label>მშობლის id</label>
                                </td>
                                <td>
                                    <?php echo $parentId ?>
                                </td> 
                            </tr>
                            <tr>
                                <td>
                                    <label>თაობა </label>
                                </td>
                                <td>
                                    <?php echo $generation ?>
                                </td> 
                            </tr>

                            <tr>
                                <td>
                                    <label>სახელი </label>
                                </td>
                                <td>
                                    <input type="text" value="<?php echo $firstName ?>">
                                </td> 

                            </tr>
                            <tr>
                                <td>
                                    <label>მეტსახელი </label>
                                </td>
                                <td>
                                    <input type="text" value="<?php echo $nickname ?>">
                                </td>

                            </tr>
                            </tr>
                            <tr>
                                <td>
                                    <label>გვარი </label>
                                </td>
                                <td>
                                    <input type="text" value="<?php echo $secondName ?>">
                                </td>

                            </tr>
                            <tr>
                                <td>
                                    <label>სტატუსი </label>
                                </td>
                                <td>
                                    <select name="lifeStatus" >
                                        <option value="alive" <?php echo $alive ?> >ცოცხალი</option>
                                        <option value="dead" <?php echo $dead ?> >გარდაცვლილი</option>
                                    </select>

                                </td>

                            </tr>
                            <tr>
                                <td>  დაბადების თარიღი</td>
                                <td> 
                                    <input type='date' name='birthDate'>
                                </td>

                            </tr>
                            <tr>
                                <td>   გარდაცვალების თარიღი</td>
                                <td> 
                                    <input type='date' name='deathDate'>
                                </td>

                            </tr>
                            <tr>
                                <td>
                            <center>  
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" <?php if ($personId == 1) echo "disabled" ?>>
                                    პიროვნების წაშლა
                                </button> 
                            </center>
                            </td>
                            <td >
                            <center>  
                                <button type="button" class="btn btn-success"  <?php if ($personId == 1) echo "disabled" ?>>
                                    ცვლილებების შენახვა
                                </button> 
                            </center>
                            </td>
                            </tr>
                        </table> 
                    </center>
                </h3>
                <hr>
                <center><h1>შვილები</h1></center>
                <br>
                <table class="table table-bordered table-striped table-hover table-sm" style="font-size:30px" >

                    <?php
                    foreach ($children as $child) {
                        $childsFirstName = $child->getFirstName();
                        $childsNickname = $child->getNickname();
                        $childsSecondName = $child->getSecondName();
                        echo "<tr><td> $childsFirstName $childsNickname  $childsSecondName</td></tr>";
                    }
                    ?>
                </table>
                <hr>

                <center> <h1>შვილის დამატება</h1></center>
                <form action="requestDispatcher.php" method="POST">

                    <input name="insertChild" hidden>
                    <input name="parentId" value="<?php echo $personId ?>" hidden>
                    <input name="mapVersinId" value="<?php echo $mapVersionId ?>" hidden>

                    <input name="generation" value="<?php echo $generation + 1 ?>" hidden>
                    <table  class="table table-bordered  table-sm" style="font-size:30px" >
                        <tr>
                            <td>სახელი</td>
                            <td><input name="firstName" type="text"></td>
                        </tr>
                        <tr>
                            <td> მეორე სახელი(ზედმეტსახელი)</td>
                            <td><input name="nickname" type="text"></td>
                        </tr>
                        <tr>
                            <td> გვარი</td>
                            <td> <input name="secondName" type="text" value="<?php echo $secondName ?>"></td>
                        </tr>
                        <tr>
                            <td> სტატუსი</td>
                            <td> <select name="lifeStatus" >
                                    <option value="alive">ცოცხალი</option>
                                    <option value="dead">გარდაცვლილი</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>  დაბადების თარიღი</td>
                            <td> 
                                <input type='date' name='birthDate'>
                            </td>
                        </tr>
                        <tr>
                            <td>   გარდაცვალების თარიღი</td>
                            <td> 
                                <input type='date' name='deathDate'>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><button type="submit">დამატება</button></td>
                        </tr>
                    </table>










                </form>

                <hr>



                <!-- MODAL WINDOW --->


                <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title" style ="background-color: red" id="exampleModalLongTitle"><center>ყურადღება</center></h1>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <h2><p style="color:red">პიროვნების წაშლით იშლება მისი ყველა არსებული შთამომავალი.</p> დარწმუნებული ხარ რომ გსურს პიროვნების წაშლა?</h2>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">უკან დაბრუნება</button>
                                <button type="button" class="btn btn-primary" onclick="window.location.href = 'requestDispatcher.php?deleteId=<?php echo $id ?>';">წაშლის დადასტურება</button>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>
