<?php

require_once 'mPDO.php';

class DataBaseConnection {

    private $db;
    private $user;
    private $pass;

    function __construct() {
        $server = $_SERVER['SERVER_NAME'];
        if ($server == "localhost") {
            $this->db = '231185';
            $this->user = '231185';
            $this->pass = 'athina2004';
        } else {
            //$this->db = '257831';
            //$this->user = '257831';
           // $this->db = 'athina2004';
            
            $this->db = 'id16806060_berishvilidb';
            $this->user = 'id16806060_berishvili';
            $this->pass = 'RI&ETCNC^CR5=Fl+';
        }
    }

    public function getLocalhostConnection() {
        $host = 'localhost';
        $db = $this->db;
        $user = $this->user;
        $pass = $this->pass;
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
