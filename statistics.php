<?php
require_once 'Controller/PersonController.php';
$personController = new PersonController();
$generationsStatistic = $personController->getGenerationsStatistic();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>სტატისტიკა</title>
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
                        <table style="width: 400px; font-size: 20px" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>  <th>თაობა</th> <th>წარმომადგენელი</th></tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($generationsStatistic as $generation => $count) {
                                echo "<tr><td> $generation </td><td> $count</td>";
                            }
                            ?>
                        </tbody>
                    </table>
                    </center>
                </div>
            </div>
        </div>
    </body>
</html>
