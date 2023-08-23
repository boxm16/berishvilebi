<?php

class DataBaseConnection {

    private $db;
    private $user;
    private $pass;

    function __construct() {
        /* $this->db = '6sxSaLPk6d';
          $this->user = '6sxSaLPk6d';
          $this->pass = 'eyL1ogMwP0';
         
        $this->db = 'id20610445_berisvhilebi_db';
        $this->user = 'id20610445_berishvilebi';
        $this->pass = 'Athina2004!Elena';*/
         $this->db = '535262';
        $this->user = '535262';
        $this->pass = 'athina2004';
    }

    public function getConnection() {
        // $host = 'remotemysql.com';
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
            $pdo = new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }

        return $pdo;
    }

}
