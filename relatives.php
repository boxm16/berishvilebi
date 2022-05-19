<?php
require_once 'Controller/PersonController.php';
$personController = new PersonController();
$allPersons = $personController->getAllPersonsPerGeneration();
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <title>ნათესავური კავშირები</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-auto">
                    <center>
                        <h1>ნათესავური კავშირები</h1>
                        <h3><a href="index.php">საწყის გვერდზე გადასვლა</a> &nbsp  &nbsp   <a href="menu.php">მენიუში დაბრუნება</a></h3>
                        <hr>


                        <div id="selectPersonText"> <h2 >აირჩიე ან მოიძიე ორი პიროვნება</h2></div>
                        <form id="form" action="relationshipDisplay.php" method="POST">
                            <div > <input hidden id="firstPersonInput" name ="firstPersonInput" value=""></div>
                            <div > <input hidden id="secondPersonInput" name="secondPersonInput" value=""></div>
                        </form>
                        <h2 > 
                            <table id="inputTable" class="table table-bordered" style="width:700px; font-size:25px" >
                            </table>
                        </h2>

                        <h3> <input type="text" id="myInput" onkeyup="myFunction()" placeholder="მოიძიე პიროვნება" title="Type in a name">  </h3>

                        <table id="myTable" class="table table-bordered" style="width:700px; font-size:25px" >
                            <tr class="header">
                                <th style="width:80%;">სახელი და გვარი</th>
                                <th style="width:10%;">თაობა</th>
                                <th style="width:10%;">არჩევა</th>
                            </tr>
                            <?php
                            $rowIndex = 1;
                            foreach ($allPersons as $person) {
                                $personId = $person->getId();
                                $firstName = $person->getFirstName();
                                $secondName = $person->getSecondName();
                                $generations = $person->getGeneration();
                                echo "<tr id='row:$rowIndex'><td id='personId:$personId'>$firstName $secondName</td><td>$generations</td><td><button id='$rowIndex' class='btn  btn-warning' onclick='select(event)'>არჩევა</button></td></tr>";
                                $rowIndex++;
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
            var selectedPersons = 0;
            function select(event) {
                if (selectedPersons >= 2) {
                    alert("ორზე მეტი პიროვნების არჩევა დაუშვებელია ");
                } else {
                    let selectedRow = event.target.parentNode.parentNode;
                    let tds = selectedRow.querySelectorAll("td");

                    let newRow = document.getElementById("inputTable").insertRow(selectedPersons);

                    newRow.setAttribute("id", "inputRow:" + event.target.id);
                    var cell_1 = newRow.insertCell(0);
                    var cell_2 = newRow.insertCell(1);
                    var cell_3 = newRow.insertCell(2);
                    cell_1.setAttribute("width", "80%");
                    cell_2.setAttribute("width", "10%");
                    cell_3.setAttribute("width", "10%");

                    cell_1.setAttribute("id", tds[0].getAttribute("id"));
                    cell_1.innerHTML = tds[0].innerHTML;
                    cell_2.innerHTML = tds[1].innerHTML;
                    cell_3.innerHTML = "<button class='btn btn-danger' onclick='cancelChoice(event, " + event.target.id + ")'>გააუქმე</button>";
                    document.getElementById("row:" + event.target.id).remove();
                    selectedPersons++;
                    if (selectedPersons == 2) {
                        let buttonRow = document.getElementById("inputTable").insertRow(2);
                        buttonRow.setAttribute("id", "buttonRow");
                        var buttonCell_1 = buttonRow.insertCell(0);
                        buttonCell_1.setAttribute("colspan", "3");

                        buttonCell_1.innerHTML = "<button class='btn btn-primary btn-block' onclick='submit()'><h2>ნათესავური კავშირის გამორკვევა</h2></button>";
                    }
                }
            }

            function cancelChoice(event, id) {
                let selectedRow = event.target.parentNode.parentNode;
                let tds = selectedRow.querySelectorAll("td");

                let newRow = document.getElementById("myTable").insertRow(id);
                newRow.setAttribute("id", "row:" + id);
                var cell_1 = newRow.insertCell(0);
                var cell_2 = newRow.insertCell(1);
                var cell_3 = newRow.insertCell(2);
                cell_1.setAttribute("width", "80%");
                cell_2.setAttribute("width", "10%");
                cell_3.setAttribute("width", "10%");

                cell_1.setAttribute("id", tds[0].getAttribute("id"));

                cell_1.innerHTML = tds[0].innerHTML;
                cell_2.innerHTML = tds[1].innerHTML;
                cell_3.innerHTML = "<button id='" + id + "' class='btn  btn-warning' onclick='select(event)'>არჩევა</button>";

                document.getElementById("inputRow:" + id).remove();
                if (selectedPersons == 2) {
                    document.getElementById("buttonRow").remove();
                }
                selectedPersons--;
            }

            function submit() {
                let rows = document.getElementById("inputTable").rows;
                let firstRow = rows[0];
                let secondRow = rows[1];
                let firstCellFirstRow = firstRow.querySelectorAll("td");
                let firstCellSecondRow = secondRow.querySelectorAll("td");
                firstPersonInput.value = firstCellFirstRow[0].getAttribute("id");
                secondPersonInput.value = firstCellSecondRow[0].getAttribute("id");
                form.submit();

            }
        </script>

    </body>
</html>
