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
            <input hidden name="setSpace">
            Width:   <input type="number" name="width" value="1000"> &nbsp Height: <input type="number" name="height" value="1000"> 
            <br>
            <button type="submit">Set Space</button>
        </form>
        <?php
        if (isset($_POST["setSpace"])) {
            if (isset($_POST["width"]) && isset($_POST["height"])) {
                $width = $_POST["width"];
                $height = $_POST["height"];
                $dbManController->setSpace($width, $height);
            } else {
                echo "Something wrong happaned";
            }
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
        <hr><hr>
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
    </body>
</html>
