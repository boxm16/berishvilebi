<?php
require_once 'Controller/DataBaseManipulationController.php';
$dbManController = new DataBaseManipulationController();
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <hr>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <input hidden name="createTables">
            <button type="submit">Create Tables</button>

        </form>
        <?php
        if (isset($_POST["createTables"])) {
            //precedence is important, there are primary-foreign keys rstrictions
            $dbManController->createRouteTable();
            $dbManController->createTripVoucherTable();
            $dbManController->createTripPeriodTable();
            $dbManController->createLastUploadTable();
            $dbManController->createCronJobTable();
            $dbManController->createReportsRoutesDatesTable();
        }
        ?>

        <hr>
    </body>
</html>
