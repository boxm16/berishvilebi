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
  `position_X` INT(5) NULL,
  `position_Y` INT(5) NULL,
  `parent_position_X` INT(5) NULL,
  `parent_position_Y` INT(5) NULL,
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

    public function createConfigTable() {

        $sql = "CREATE TABLE `config` (
  `config_type` VARCHAR(20) NOT NULL,
  `int_value` INT(6) NULL,
  `string_value` VARCHAR(20) NULL)
   ENGINE = InnoDB
   DEFAULT CHARACTER SET = utf8;
   ";
        try {
            $this->connection->exec($sql);
            echo "Table 'config' created successfully" . "<br>";
        } catch (\PDOException $e) {
            if ($e->getCode() == "42S01") {
                echo "Table 'config' already exists" . "<br>";
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

    public function deleteConfigTable() {

        $sql = "DROP TABLE config;";
        try {
            $this->connection->exec($sql);
            echo "Table 'config' deleted successfully" . "<br>";
        } catch (\PDOException $e) {
            echo $e->getMessage() . " Error Code:";
            echo $e->getCode() . "<br>";
        }
    }

    //---------------end of DELETION-----------------
    //------------setting space ----------


    public function setSpace($svg_width, $svg_height) {

        $sql_width = "INSERT INTO config (config_type, int_value) VALUES ('svg_width', :svg_width);";
        $sql_height = "INSERT INTO config (config_type, int_value) VALUES ('svg_height', :svg_height);";

        $statement_width = $this->connection->prepare($sql_width);
        $statement_width->bindValue(':svg_width', $svg_width);
        $inserted_width = $statement_width->execute();

        $statement_height = $this->connection->prepare($sql_height);
        $statement_height->bindValue(':svg_height', $svg_height);
        $inserted_height = $statement_height->execute();

        if ($inserted_width && $inserted_height) {
            echo 'Space Dimensions Inserted!<br>';
        }
    }

    public function updateSpace($svg_width, $svg_height) {

        $sql_width = "UPDATE config SET int_value=:svg_width WHERE  config_type='svg_width';";
        $sql_height = "UPDATE config SET int_value=:svg_height WHERE  config_type='svg_height';";


        $statement_width = $this->connection->prepare($sql_width);
        $statement_width->bindValue(':svg_width', $svg_width);
        $updated_width = $statement_width->execute();

        $statement_height = $this->connection->prepare($sql_height);
        $statement_height->bindValue(':svg_height', $svg_height);
        $updated_height = $statement_height->execute();

        if ($updated_width && $updated_height) {
            echo 'Space Dimensions Changed!<br>';
        }
    }

    //-----------------end of setting space ----------
    //---------------now INSERTION-----------------
    public function insertPerson($person) {

        $generation = $person->getGeneration();
        $firstName = $person->getFirstName();
        $nickname = $person->getNickname();
        $secondName = $person->getSecondName();
        $lifeStatus = $person->getLifeStatus();
        $parentId = $person->getParentId();
        $positionX = $person->getPositionX();
        $positionY = $person->getPositionY();
        $sql = "INSERT INTO person (generation, position_X, position_Y, first_name, nickname, second_name, life_status, parent_id) VALUES (:generation, :position_X, :position_Y, :firstName , :nickname, :secondName,  :lifeStatus, :parentId)";


        $statement = $this->connection->prepare($sql);

        $statement->bindValue(':generation', $generation);
        $statement->bindValue(':position_X', $positionX);
        $statement->bindValue(':position_Y', $positionY);
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
