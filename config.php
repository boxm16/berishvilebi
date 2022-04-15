<?php
require_once 'Controller/ConfigController.php';
$configController = new ConfigController();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <a href="admin.php">Go Admin</a>
        <hr>
        <h1>Configurations</h1>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <input hidden name="createTables">
            <button type="submit">Create Tables</button>
        </form>
        <?php
        if (isset($_POST["createTables"])) {
            //precedence is important, there are primary-foreign keys rstrictions
            $configController->createTables();
        }
        ?>
        <hr>

    </body>
</html>
