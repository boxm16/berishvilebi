<?php
require_once 'Controller/MapVersionController.php';

$mapVersionController = new MapVersionController();
$allVersions = $mapVersionController->getAllMapVersions();
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <title>მენიუ</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script> </head>
    <body>
        <div class=""container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <center>

                        <a href="index.php">საწყის გვერდზე გადასვლა</a>
                        <hr>
                        <h1>მენიუ</h1>
                        <br>
                        <hr>
                        <form action="requestDispatcher.php" method="POST">
                            <input type ="hidden" name = "map" value="map">
                            <table>
                                <tr>
                                    <td>
                                        <select name="mapVersionId" class="form-select form-select-lg mb-3">
                                            <?php
                                            foreach ($allVersions as $mapVersion) {
                                                $mapVersionId = $mapVersion->getId();
                                                $mapVersionName = $mapVersion->getName();
                                                echo "  <option value=\"$mapVersionId\">$mapVersionName</option>";
                                            }
                                            ?>
                                        </select>
                                        <h1> <button class="btn btn-primary" type="submit">გადადი რუქის სანახავად</button></h1>
                                    </td>
                                </tr>
                            </table>
                        </form>
                        <hr>
                        <a href="statistics.php">სტატისტიკის ნახვა</a>
                        <hr>
                    </center>
                </div>  
            </div>
        </div>       

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    </body>
</html>
