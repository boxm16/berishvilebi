<?php
require_once 'Controller/PersonController.php';
require_once 'Controller/AdminController.php';

if (isset($_GET["id"]) && isset($_GET["x"]) && isset($_GET["y"])) {
    //do nothing
} else {
    echo "<h1>რაღაც გაუთვალიწინებელი მოხდა <a href='admin.php'>დაბრუნდი მთავარ გვერდზე</a></h1>";
    exit;
}
$id = $_GET["id"];
$x = $_GET["x"];
$y = $_GET["y"];
$personController = new PersonController;
$person = $personController->getPerson($id);
$childen = $personController->getPersonsChildren($id);
$parentId = $person->getParentId();
$firstName = $person->getFirstName();
$nickname = $person->getNickname();
$secondName = $person->getSecondName();
$generation = $person->getGeneration();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>პიროვნების მონაცემები</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <style>
            table, th, td {
                border: 1px solid black;
                border-collapse: collapse;
            }
            td {
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col">
                    <?php
                    if ($person->getPositionX() == $x && $person->getPositionY() == $y) {
                        //do nothing for now   
                    } else {
                        echo "<center><h2 style='background-color:red'>რუქაზე პიორვნების მდებარეობა შეცვლილია</h2><center>"
                        . "<form action='requestDispatcher.php' method='POST'>"
                        . "<input hidden name='setNewPosition'>"
                        . "<input hidden name='id' value='$id'>"
                        . "<input hidden name='x' value='$x'>"
                        . "<input hidden name='y' value='$y'>"
                        . "<input type='submit' value='შეინახე ახალი მდებარეობა' style='color:green; font-size:20px;font-weight:bold'>"
                        . "</form>"
                        . "<hr>";
                    }
                    ?>
                    <a href='admin.php?personInFocusId=<?php echo $id ?>'>რუქაზე გადასვლა</a>
                    <h1><center>   <table>
                                <tr>
                                    <td>id</td><td><?php echo $id ?></td> 
                                </tr>
                                <tr>
                                    <td>მშობლის id</td><td><?php echo $parentId ?></td> 
                                </tr>
                                <tr>
                                    <td>თაობა</td><td><?php echo $generation ?></td> 
                                </tr>

                                <tr>
                                    <td>სახელი</td><td><?php echo $firstName ?></td> 
                                </tr>
                                <tr>
                                    <td>მეტსახელი</td><td><?php echo $nickname ?></td>
                                </tr>
                                <tr>
                                    <td>გვარი</td><td><?php echo $secondName ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModalCenter" <?php if ($id == 1) echo "disabled" ?>>
                                            პიროვნების წაშლა
                                        </button> 
                                    </td>
                                </tr>

                            </table> 
                        </center>
                    </h1>
                    <hr>
                    <center><h1>შვილები</h1></center>
                    <br>
                    <?php
                    foreach ($childen as $child) {
                        echo $child->getFirstName() . " " . $child->getSecondName() . "<br>";
                    }
                    ?>
                    <hr>
                    <h1>შვილის დამატება</h1>
                    <form action="requestDispatcher.php" method="POST">
                        <input name="insertChild" hidden>
                        <input name="id" value="<?php echo $id ?>" hidden>
                        <input name="x" value="<?php echo $x ?>" hidden>
                        <input name="y" value="<?php echo $y ?>" hidden>
                        <input name="generation" value="<?php echo $generation+1 ?>" hidden>
                        სახელი <input name="firstName" type="text">

                        მეორე სახელი(ზედმეტსახელი) <input name="nickname" type="text">

                        გვარი <input name="secondName" type="text" value="<?php echo $secondName ?>">
                        <br><br>
                        სტატუსი <select name="lifeStatus" >
                            <option value="alive">ცოცხალი</option>
                            <option value="dead">გარდაცვლილი</option>
                        </select>
                        დაბადების თარიღი <input type='date' name='birthDate'>
                        გარდაცვალების თარიღი <input type='date' name='deathDate'>
                        &nbsp &nbsp
                        <button type="submit">დამატება</button>
                    </form>
                    <hr>



                    <!-- MODAL WINDOW --->


                    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title" id="exampleModalLongTitle"><center>ყურადღება</center></h1>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <h2><p style="background-color: red">პიროვნების წაშლით იშლება მისი ყველა არსებული შთამომავალი.</p> დარწმუნებული ხარ რომ გსურს პიროვნების წაშლა?</h2>
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
