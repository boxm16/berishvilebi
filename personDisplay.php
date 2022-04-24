<?php
require_once 'Controller/PersonController.php';
if (isset($_GET["personId"])) {
    //do nothing
} else {
    echo "<h1>რაღაც გაუთვალიწინებელი მოხდა <a href='admin.php'>დაბრუნდი მთავარ გვერდზე</a></h1>";
    exit;
}

$mapVersionId = 1;
$personId = $_GET["personId"];

$personController = new PersonController;
$person = $personController->getPerson($personId, $mapVersionId);

$parentId = $person->getParentId();
$firstName = $person->getFirstName();
$nickname = $person->getNickname();
$secondName = $person->getSecondName();
$generation = $person->getGeneration();
$lifeStatus = $person->getLifeStatus();

$birthDate = $person->getBirthDate();
$deathDate = $person->getDeathDate();
$children = $person->getChildren();

$parent = $personController->getPerson($parentId, $mapVersionId);
$parentFirstName = $parent->getFirstName();
$parentSecondName = $parent->getSecondName()
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
                    <a href="index.php">საწყისი გვერდი</a>
                    <hr>
                    <form action="adminMapVersion.php" method="POST">
                        <input  name="mapVersionId" hidden value="<?php echo $mapVersionId ?>">
                        <input  name="personInFocusId" hidden value="<?php echo $personId ?>">
                        <button class="btn btn-info" type="submit">რუქაზე ნახვა</button>
                    </form>
                </center>
                <hr>
                <h3><center> 
                        <table class="table">
                            <tr>
                                <td>
                                    <label>მშობელი </label>
                                </td>
                                <td>
                                    <a href="personDisplay.php?personId=<?php echo $parentId ?>">  <?php echo $parentFirstName . " " . $parentSecondName ?></a>
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
                                    <?php echo $firstName ?>
                                </td> 

                            </tr>
                            <tr>
                                <td>
                                    <label>მეტსახელი </label>
                                </td>
                                <td>
                                    <?php echo $nickname ?>
                                </td>

                            </tr>
                            </tr>
                            <tr>
                                <td>
                                    <label>გვარი </label>
                                </td>
                                <td>
                                    <?php echo $secondName ?>
                                </td>

                            </tr>
                            <tr>
                                <td>
                                    <label>სტატუსი </label>
                                </td>
                                <td>
                                    <?php
                                    if ($lifeStatus == "alice") {
                                        echo "ცოცხალი";
                                    } else {
                                        echo "გარდაცვლილი";
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>  დაბადების თარიღი</td>
                                <td> 
                                    <?php echo $birthDate ?>
                                </td>
                            </tr>
                            <tr>
                                <td>   გარდაცვალების თარიღი</td>
                                <td> 
                                    <?php echo $deathDate ?>
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
                        $childId = $child->getId();
                        $childsFirstName = $child->getFirstName();
                        $childsNickname = $child->getNickname();
                        $childsSecondName = $child->getSecondName();
                        echo "<tr><td><a href='personDisplay.php?personId=$childId'> $childsFirstName $childsNickname  $childsSecondName</a></td></tr>";
                    }
                    ?>
                </table>
                <hr>

            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script>
        function updatePerson() {

            firstNameOutput.value = firstNameInput.value;
            nicknameOutput.value = nicknameInput.value;
            secondNameOutput.value = secondNameInput.value;
            lifeStatusOutput.value = lifeStatusInput.value;
            birthDateOutput.value = birthDateInput.value;
            deathDateOutput.value = deathDateInput.value;

            hiddenForm.submit();
        }

        function searchForChildren() {
            document.location.href = 'requestDispatcher.php?searchChildrenFor=<?php echo $personId ?>&mapVersionId=<?php echo $mapVersionId ?>';
        }
    </script>
</body>
</html>
