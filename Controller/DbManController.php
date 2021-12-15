<?php

require_once 'DAO/DbManDao.php';
require_once 'Model/Person.php';

class DbManController {

    private $dbManDao;

    public function __construct() {
        $this->dbManDao = new DbManDao();
    }

    public function createTables() {
        $this->dbManDao->createPersonTable();
        $this->dbManDao->createConfigTable();
    }

    public function deleteTables() {

        $this->dbManDao->deletePersonTable();
        $this->dbManDao->deleteConfigTable();
    }

    public function deletePersonChildTable() {
        $this->dbManDao->deletePersonTable();
    }

    public function setSpace($width, $height) {

        $this->dbManDao->setSpace($width, $height);
    }

    public function insertMainPerson() {

        $person = new Person();
        $person->setGeneration(0);
        $person->setPositionX(50);
        $person->setPositionY(50);
        $person->setFirstName("ილია");
        $person->setNickname("ბერი");
        $person->setSecondName("ბერიშვილი");
        $person->setLifeStatus("dead");
        $person->setParentId(0);

        $this->dbManDao->insertPerson($person);
    }

}
