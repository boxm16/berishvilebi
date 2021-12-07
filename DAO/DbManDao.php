<?php

require_once 'DataBaseConnection.php';

class DbManDao {

    private $connection;

    function __construct() {
        $dataBaseConnection = new DataBaseConnection();
        $this->connection = $dataBaseConnection->getConnection();
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

    public function createPersonChildTable() {
        $sql = "CREATE TABLE `parent_child` (
  `parent_id` INT(6) NOT NULL,
  `child_id` INT(6) NOT NULL,
  INDEX `parent_id_idx` (`parent_id` ASC) VISIBLE,
  INDEX `child-id_idx` (`child_id` ASC) VISIBLE,
  CONSTRAINT `parent_id`
    FOREIGN KEY (`parent_id`)
    REFERENCES `person` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
    CONSTRAINT `child-id`
    FOREIGN KEY (`child_id`)
    REFERENCES `person` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);";
        try {
            $this->connection->exec($sql);
            echo "Table 'parent_child' created successfully" . "<br>";
        } catch (\PDOException $e) {
            if ($e->getCode() == "42S01") {
                echo "Table 'parent_child' already exists" . "<br>";
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

    public function deletePersonChildTable() {

        $sql = "DROP TABLE parent_child;";
        try {
            $this->connection->exec($sql);
            echo "Table 'parent_child' deleted successfully" . "<br>";
        } catch (\PDOException $e) {
            echo $e->getMessage() . " Error Code:";
            echo $e->getCode() . "<br>";
        }
    }

    //---------------end of DELETION-----------------
    //---------------now INSERTION-----------------
    public function insertPerson($person) {

        $generation = $person->getGeneration();
        $firstName = $person->getFirstName();
        $nickname = $person->getNickname();
        $secondName = $person->getSecondName();
        $lifeStatus = $person->getLifeStatus();
        $parentId = $person->getParentId();
        $sql = "INSERT INTO person (generation, first_name, nickname, second_name, life_status, parent_id) VALUES (:generation, :firstName , :nickname, :secondName,  :lifeStatus, :parentId)";


        $statement = $this->connection->prepare($sql);

        $statement->bindValue(':generation', $generation);
        $statement->bindValue(':firstName', $firstName);
        $statement->bindValue(':nickname', $nickname);
        $statement->bindValue(':secondName', $secondName);
        $statement->bindValue(':lifeStatus', $lifeStatus);
        $statement->bindValue(':parentId', $parentId);

        $inserted = $statement->execute();


        if ($inserted) {
            echo 'Main Person Inserted!<br>';
        }
    }

}
