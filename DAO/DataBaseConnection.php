<?php

require_once 'mPDO.php';

class DataBaseConnection {

    private $db;
    private $user;

    function __construct() {
        $server = $_SERVER['SERVER_NAME'];
        if ($server == "localhost") {
            $this->db = '231185';
            $this->user = '231185';
        } else {
            $this->db = '231185';
            $this->user = '231185';
        }
    }

    public function getLocalhostConnection() {
        $host = 'localhost';
        $db = $this->db;
        $user = $this->user;
        $pass = 'athina2004';
        $charset = 'utf8';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        try {
            $pdo = new mPDO($dsn, $user, $pass, $options);
            return $pdo;
        } catch (\PDOException $e) {
            echo $e->getMessage() . " Error Code:";
            echo $e->getCode();
        }
    }

}
