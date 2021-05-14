<?php
$s = microtime(true);
$start_memory = memory_get_usage();

if (isset($_POST["timeout"])) {

    $counter = $_POST["counter"];
    $x = 0;
    while ($counter > $x) {

        $x++;
    }
    echo "Iterations made:$counter<br>";
}
if (isset($_POST["memory"])) {

    $counter = $_POST["counter"];
    $x = 0;
    $array = array();
    while ($counter > $x) {
        $obj = new Obj();
        array_push($array, $obj);
        $x++;
    }
    echo "Objects created:$counter<br>";
}

$e = microtime(true);
echo "<br>Time required(seconds):" . ($e - $s);
echo "<hr>";
$needeMemory = memory_get_usage() - $start_memory;
echo 'Memory needed for loading:  (' . (($needeMemory / 1024) / 1024) . 'M) <br>';
echo 'Peak usage:(' . ( (memory_get_peak_usage() / 1024 ) / 1024) . 'M) <br>';
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <hr>
        Make N_times iteration (to measure needed time)
        <form action ="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <input type="number" name="counter" value="100000000">
            <input type="submit" value="submit">
            <input hidden name="timeout">
        </form>
        <hr>
        <form action ="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <input type="number" name="counter" value="100000">
            <input type="submit" value="submit">
            <input hidden name="memory">
        </form>

    </body>
</html>
<?php

//---------------------
class Obj {

    private $a;
    private $b;
    private $c;
    private $d;

}
?>