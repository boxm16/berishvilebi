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
        // $this->dbManDao->createPersonChildTable();
    }

    public function deleteTables() {
        // $this->dbManDao->deletePersonChildTable();
        $this->dbManDao->deletePersonTable();
    }

    public function deletePersonChildTable() {
        $this->dbManDao->deletePersonTable();
    }

    public function insertMainPerson() {

        $person = new Person();
        $person->setGeneration(0);
        $person->setFirstName("ილია");
        $person->setNickname("ბერი");
        $person->setSecondName("შეყლაშვილი");
        $person->setLifeStatus("dead");
        $person->setParentId(0);

        $this->dbManDao->insertPerson($person);
    }

}
