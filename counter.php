<?php

$s = microtime(true);
$x = 0;
while ($x < 10000000000) {

    $x++;
}


$e = microtime(true);
echo "<br> Display time required:" . ($e - $s);
