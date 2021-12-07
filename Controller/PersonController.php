<?php

require_once 'DAO/PersonDao.php';
require_once 'Model/Person.php';

class PersonController {

    private $personDao;

    public function __construct() {
        $this->personDao = new PersonDao();
    }

    public function getFullGenTree() {
        $persons = $this->personDao->getAllPersons();
        while (count($persons) > 1) {
            $child = $persons[count($persons) - 1];
            if ($this->findMyParent($child, $persons)) {
                unset($persons[count($persons) - 1]);
            } else {

                echo "SOMETHING IS WRONG";
                exit;
            }
        }

        return $persons[0];
    }

    public function getGenerationsLayers() {
        $persons = $this->personDao->getAllPersons();
        $generationsLayers = $this->createGenerationsLayers($persons);
        return $generationsLayers;
    }

    public function createGenerationsLayers($persons) {
        $generationsLayers = array();
        foreach ($persons as $person) {
            $generation = $person->getGeneration();
            if (array_key_exists($generation, $generationsLayers)) {
                $sameGenerationsPersons = $generationsLayers[$generation];
                array_push($sameGenerationsPersons, $person);
                $generationsLayers[$generation] = $sameGenerationsPersons;
            } else {
                $generationsLayers[$generation] = array($person);
            }
        }
        return $generationsLayers;
    }

    public function getPerson($id) {
        return $person = $this->personDao->getPerson($id);
    }

    public function getPersonsChildren($id) {
        return $person = $this->personDao->getPersonsChildren($id);
    }

    public function getFullPerson($id) {
        $person = $this->personDao->getPerson($id);
        $children = $this->personDao->getPersonsChildren($id);
        $person->setChildren($children);
        return $person;
    }

    public function insertPerson($person) {
        $this->personDao->insertPerson($person);
    }

    private function findMyParent($child, $persons) {

        for ($x = count($persons) - 1; $x >= 0; $x--) {
            $potentialParent = $persons[$x];

            if ($child->getParentId() == $potentialParent->getId()) {

                $children = $potentialParent->getChildren();

                array_push($children, $child);
                $potentialParent->setChildren($children);
                $persons[$x] = $potentialParent;
                return true;
            }
        } return false;
    }

}
