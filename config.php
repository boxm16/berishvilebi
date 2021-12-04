<?php
require_once 'Controller/DbManController.php';
$dbManController = new DbManController();
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <h1>Configurations</h1>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <input hidden name="createTables">
            <button type="submit">Create Tables</button>
        </form>
        <?php
        if (isset($_POST["createTables"])) {
            //precedence is important, there are primary-foreign keys rstrictions
            $dbManController->createTables();
            
        }
        ?>
        <hr>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <input hidden name="deleteTables">
            <button type="submit">Delete Tables</button>
        </form>
        <?php
        if (isset($_POST["deleteTables"])) {
            //precedence is important, there are primary-foreign keys rstrictions
            $dbManController->deleteTables();
        }
        ?>
        <hr>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <input hidden name="insertMainPerson">
            <button type="submit">Insert Main Person</button>
        </form>
        <?php
        if (isset($_POST["insertMainPerson"])) {
            //precedence is important, there are primary-foreign keys rstrictions
            $dbManController->insertMainPerson();
        }
        ?>
    </body>
</html>
