<?php

require_once 'DataBaseConnection.php';

class ConfigDao {

    private $connection;

    function __construct() {
        $dbConnection = new DataBaseConnection();
        $this->connection = $dbConnection->getConnection();
    }

    public function createPersonTable() {

        $sql = "CREATE TABLE `person` (
  `id` INT(6) NOT NULL AUTO_INCREMENT,
  `parent_id` INT(6) NOT NULL,
  `generation` INT(3) NOT NULL,
  `first_name` VARCHAR(25) NOT NULL, 
  `second_name` VARCHAR(25) NULL,
  `nickname` VARCHAR(100) NULL,
  `life_status` VARCHAR(5) NULL,
  `birth_date` VARCHAR(20) NULL,
  `death_date` VARCHAR(20) NULL,
   
   PRIMARY KEY (`id`))
   ENGINE = InnoDB
   DEFAULT CHARACTER SET = utf8;
   ";
        try {
            $this->connection->exec($sql);
            echo "Table 'person' created successfully" . "<br>";
        } catch (\PDOException $e) {
            if ($e->getCode() == "42S01") {
                echo "Table 'person' already exists" . "<br>";
            } else {
                echo $e->getMessage() . " Error Code:";
                echo $e->getCode() . "<br>";
            }
        }
    }

    public function createVersionTable() {
        $sql = "CREATE TABLE `version` (
  `id` INT(6) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(20) NULL,
  `map_width` INT(6) NOT NULL DEFAULT 7000, 
  `map_height` INT(6) NOT NULL DEFAULT 7000, 
   PRIMARY KEY (`id`))
   ENGINE = InnoDB
   DEFAULT CHARACTER SET = utf8;
   ";
        try {
            $this->connection->exec($sql);
            echo "Table 'version' created successfully" . "<br>";
        } catch (\PDOException $e) {
            if ($e->getCode() == "42S01") {
                echo "Table 'version' already exists" . "<br>";
            } else {
                echo $e->getMessage() . " Error Code:";
                echo $e->getCode() . "<br>";
            }
        }
    }

    public function createVersionPositionTable() {
        $sql = "CREATE TABLE `version_position`  ( 
            `version_id` INT(6) NOT NULL , 
            `person_id` INT(6) NOT NULL , 
            `position_X` INT(6) NOT NULL , 
            `position_Y` INT(6) NOT NULL,
             FOREIGN KEY (version_id) REFERENCES version(id) ON DELETE CASCADE ,
             FOREIGN KEY (person_id) REFERENCES person(id) ON DELETE CASCADE 
             )
            ENGINE = InnoDB;
       ";
        try {
            $this->connection->exec($sql);
            echo "Table 'version_position' created successfully" . "<br>";
        } catch (\PDOException $e) {
            if ($e->getCode() == "42S01") {
                echo "Table 'version_position' already exists" . "<br>";
            } else {
                echo $e->getMessage() . " Error Code:";
                echo $e->getCode() . "<br>";
            }
        }
    }

    //----------------now DELETION-----------------
    public function deletePersonTable() {

        $sql = "DROP TABLE person;";
        try {
            $this->connection->exec($sql);
            echo "Table 'person' deleted successfully" . "<br>";
        } catch (\PDOException $e) {
            echo $e->getMessage() . " Error Code:";
            echo $e->getCode() . "<br>";
        }
    }

    public function deleteVersionTable() {

        $sql = "DROP TABLE version;";
        try {
            $this->connection->exec($sql);
            echo "Table 'version' deleted successfully" . "<br>";
        } catch (\PDOException $e) {
            echo $e->getMessage() . " Error Code:";
            echo $e->getCode() . "<br>";
        }
    }

    public function deleteVersionPositionTable() {

        $sql = "DROP TABLE version_position;";
        try {
            $this->connection->exec($sql);
            echo "Table 'version_position' deleted successfully" . "<br>";
        } catch (\PDOException $e) {
            echo $e->getMessage() . " Error Code:";
            echo $e->getCode() . "<br>";
        }
    }

    
    //--------------------INSERT MAIN PERSON------------------------
    public function insertMainPerson(){
        
    }
}
