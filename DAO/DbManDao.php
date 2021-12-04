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
  `generation` INT(3) NOT NULL,
  `first_name` VARCHAR(25) NOT NULL, 
  `second_name` VARCHAR(25) NULL,
  `nickname` VARCHAR(100) NULL,
  `birth_date` DATE NULL,
  `death_date` DATE NULL,
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
        $sql = "CREATE TABLE `person_child` (
  `father_id` INT(6) NOT NULL,
  `mother_id` INT(6) NOT NULL,
  `child_id` INT(6) NOT NULL,
  INDEX `father_id_idx` (`father_id` ASC) VISIBLE,
  INDEX `nother_id_idx` (`mother_id` ASC) VISIBLE,
  INDEX `child-id_idx` (`child_id` ASC) VISIBLE,
  CONSTRAINT `father_id`
    FOREIGN KEY (`father_id`)
    REFERENCES `person` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `mother_id`
    FOREIGN KEY (`mother_id`)
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
            echo "Table 'person_child' created successfully" . "<br>";
        } catch (\PDOException $e) {
            if ($e->getCode() == "42S01") {
                echo "Table 'person_child' already exists" . "<br>";
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

        $sql = "DROP TABLE person_child;";
        try {
            $this->connection->exec($sql);
            echo "Table 'person_child' deleted successfully" . "<br>";
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
        $secondName = $person->getSecondName();

        $sql = "INSERT INTO person (first_name, second_name, generation) VALUES (:firstName , :secondName, :generation)";


        $statement = $this->connection->prepare($sql);

        $statement->bindValue(':generation', $generation);
        $statement->bindValue(':firstName', $firstName);
        $statement->bindValue(':secondName', $secondName);



        $inserted = $statement->execute();


        if ($inserted) {
            echo 'Main Person Inserted!<br>';
        }
    }

}
