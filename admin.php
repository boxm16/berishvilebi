<?php
require_once 'Controller/AdminController.php';
$adminController = new adminController();
if (isset($_POST["setSpace"])) {
    $svgWidth = $_POST["svgWidth"];
    $svgHeight = $_POST["svgHeight"];
    $adminController->updateSpace($svgWidth, $svgHeight);
}
$svgWidth = $adminController->getSvgWidth();
$svgHeight = $adminController->getSvgHeight();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <input hidden name="setSpace">
            სივრცის სიგანე:   <input type="number" name="svgWidth" value="<?php echo $svgWidth; ?>"> &nbsp სივრცის სიმაღლე: <input type="number" name="svgHeight" value="<?php echo $svgHeight; ?>"> 

            <button type="submit">სივრცის ზომების შეცვლა</button>
        </form>
        <hr>
        <?php
        ?>
        <svg width="<?php echo $svgWidth; ?>" height="<?php echo $svgHeight; ?>">


        <rect x="10" y="10"  width="<?php echo $svgWidth; ?>" height="<?php echo $svgHeight; ?>" style="fill: skyblue;"/>

        </svg>
    </body>
</html>
