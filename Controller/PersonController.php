<?php

require_once 'DAO/PersonDao.php';
require_once 'Model/Person.php';

class PersonController {

    public function getAllPersonsForMap($mapVersionId) {
        $personDao = new PersonDao();
        return $personDao->getAllPersonsForMap($mapVersionId);
    }

    public function getPerson($personId, $mapVersionId) {
        $personDao = new PersonDao();
        return $personDao->getPerson($personId, $mapVersionId);
    }

    public function insertChild($person, $mapVersionId) {
        $personDao = new PersonDao();
        $parentId = $person->getParentId();
        $parent = $personDao->getPerson($parentId, $mapVersionId);
        $person->setPositionX($parent->getPositionX() + 50);
        $person->setPositionY($parent->getPositionY() + 50);
        $personDao->insertPerson($person, $mapVersionId);
    }

    public function saveAllPositions($allPersonsPositions, $mapVersionId) {
        $personDao = new PersonDao();
        $personDao->saveAllPositions($allPersonsPositions, $mapVersionId);
    }

}
