<?php
require_once 'Controller/PersonController.php';
$personController = new PersonController();
$allPersons = $personController->getAllPersonsPerGeneration();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>საბერიშვილო</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-auto">
                    <a href="adminGate.php">ადმინისტრატორისთვის</a>
                    <hr>
                    <center><h1>საბერიშვილო</h1></center>
                    <hr>
                    <center>
                        <button class="btn btn-secondary btn-block" ><a href="menu.php" ><h2>მენიუში გადასვლა</h2></a></button>
                        <hr>
                        <h3> <input type="text" id="myInput" onkeyup="myFunction()" placeholder="მოიძიე პიროვნება" title="Type in a name">  </h3>
                        <hr>
                        <table id="myTable" class="table table-bordered" style="width:700px; font-size:25px" >
                            <tr class="header">
                                <th style="width:80%;">სახელი და გვარი</th>
                                <th style="width:20%;">თაობა</th>
                            </tr>
                            <?php
                            foreach ($allPersons as $person) {
                                $personId = $person->getId();
                                $firstName = $person->getFirstName();
                                $secondName = $person->getSecondName();
                                $generations = $person->getGeneration();
                                echo "<tr><td ><a href='personDisplay.php?personId=$personId'>$firstName $secondName</a></td><td>$generations</td></tr>";
                            }
                            ?>
                        </table>

                    </center>
                </div>
            </div>
        </div>
        <script>
            function myFunction() {
                var input, filter, table, tr, td, i, txtValue;
                input = document.getElementById("myInput");
                filter = input.value.toUpperCase();
                table = document.getElementById("myTable");
                tr = table.getElementsByTagName("tr");
                for (i = 0; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName("td")[0];
                    if (td) {
                        txtValue = td.textContent || td.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }
        </script>

    </body>
</html>
