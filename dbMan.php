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
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <input hidden name="dropTables">
            <button type="submit">Drop Tables</button>

        </form>
        <?php
        if (isset($_POST["dropTables"])) {
            //precedence is important, there are primary-foreign keys rstrictions
            $dbManController->dropTripPeriodTable();
            $dbManController->dropTripVoucherTable();
            $dbManController->dropLastUploadTable();
            $dbManController->dropReportsRoutesDatesTable();
            $dbManController->dropCronJobTable();
            $dbManController->dropRouteTable();
        }
        ?>

        <hr>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <input hidden name="size">
            <button type="submit">Show Size of all DataBases(at this moment)</button>
        </form>
        <?php
        if (isset($_POST["size"])) {
            $dataBases = $dbManController->getDataBases();
            foreach ($dataBases as $db) {
                $dbName = $db[0];
                $dbSize = $db[1];
                echo "Name:$dbName-Size:$dbSize<br>";
            }
        }
        ?>
    </body>
</html>
