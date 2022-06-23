<?php

require_once 'DAO/DataBaseConnection.php';

$dataBaseConnection = new DataBaseConnection();
$connection = $dataBaseConnection->getConnection();
$sql = "INSERT INTO cron_job (date) VALUES (:date)";

$statement = $connection->prepare($sql);

$statement->bindValue(':date', date('Y-m-d H:i:s'));
echo $insertionResult = $statement->execute();
