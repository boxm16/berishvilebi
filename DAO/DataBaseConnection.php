<?php

class DataBaseConnection {

    private $db;
    private $user;
    private $pass;

    function __construct() {
        $this->db = '6sxSaLPk6d';
        $this->user = '6sxSaLPk6d';
        $this->pass = 'eyL1ogMwP0';
    }

    public function getConnection() {
        $host = 'remotemysql.com';
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
