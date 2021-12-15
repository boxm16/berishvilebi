<?php

require_once 'DAO/DataBaseConnection.php';
$dataBaseConnection = new DataBaseConnection();
$connection = $dataBaseConnection->getConnection();
$query = "UPDATE person SET second_name='ბერიშვილი' WHERE id=1";

try {
   $connection->exec($query);
    echo "Done!. <br>";
} catch (\PDOException $e) {
    echo $e->getMessage() . " Error Code:";
    echo $e->getCode() . "<br>";
}

    