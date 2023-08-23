<?php
require_once 'Controller/RouteXLController.php';
require_once 'clientId.php'; //here i take clientId from cookie, or set new
$s = microtime(true);
$routesController = new RouteXLController();
$routes = $routesController->getFullRoutes($clientId);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>საწყისი გვერდი</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
       
    </head>
    <body>
<center>
 
<a href="http://ec2-34-245-183-24.eu-west-1.compute.amazonaws.com:8080/berishvili/index.htm"> <h1>ირლანდიის სერვერი</h1> </h1> </a>
       </center>   
       
    </body>
</html>
