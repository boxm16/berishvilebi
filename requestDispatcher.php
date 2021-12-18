<?php

include_once 'DAO/PersonDao.php';
var_dump($_POST);
if (isset($_POST["setNewPosition"])) {
    $id = $_POST["id"];
    $x = $_POST["x"];
    $y = $_POST["y"];
    $personDao = new PersonDao();
    $personDao->setPosition($id, $x, $y);
    header("Location: admin.php");
}

