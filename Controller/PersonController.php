<?php

require_once 'DAO/PersonDao.php';
require_once 'Model/Person.php';

class PersonController {

    private $personDao;

    public function __construct() {
        $this->personDao = new PersonDao();
    }

    public function getPerson($id) {
        return $person = $this->personDao->getPerson($id);
    }

    public function getAllPersons() {
        return $this->personDao->getPersonsMap();
    }

}
