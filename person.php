<?php
$mapVersionId = $_GET["mapVersionId"];
$personId = $_GET["personId"];
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        echo "person page here";
        ?>
        <br>
        <form action="adminMap.php" method="POST">
            <input name="mapVersionId" hidden value="<?php echo $mapVersionId?>">
            <button type="submit">GO TO ADMIN MAP</button>
        </form>
    </body>
</html>
