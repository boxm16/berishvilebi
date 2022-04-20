<?php

require_once 'DAO/PersonDao.php';
require_once 'Model/Person.php';

class PersonController {

    public function getAllPersonsForMap($mapVersionId) {
        $personDao = new PersonDao();
        return $personDao->getAllPersonsForMap($mapVersionId);
    }

    public function getPerson($personId) {
        $personDao = new PersonDao();
        return $personDao->getPerson($personId);
    }

}
