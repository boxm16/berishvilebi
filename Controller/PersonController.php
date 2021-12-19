<?php

require_once 'DAO/PersonDao.php';
require_once 'Model/Person.php';

class PersonController {

    private $personDao;
    private $descendantsList;

    public function __construct() {
        $this->personDao = new PersonDao();
        $this->descendantsList = array();
    }

    public function getPerson($id) {
        return $person = $this->personDao->getPerson($id);
    }

    public function getAllPersons() {
        return $this->personDao->getPersonsMap();
    }

    public function getPersonsChildren($id) {
        return $this->personDao->getPersonsChildren($id);
    }

    public function getPersonsDescendantsList($id) {

        $mainPerson = $this->getPersonsDescendantsTree($id);
        $mainPersonId = $mainPerson->getId();
        $this->descendantsList = array($mainPerson);
        $this->recurs($mainPerson);

        return $this->descendantsList;
    }

    private function recurs($person) {
        $children = $person->getChildren();

        if ($children == null || count($children) == 0) {
            return;
        } else {
            foreach ($children as $child) {
                array_push($this->descendantsList, $child);
                $this->recurs($child);
            }
        }
    }

    public function getPersonsDescendantsTree($id) {
        $personsArray = $this->personDao->getAllPersons();
        $personsMap = array();

        while (count($personsArray) > 1) {
            $child = $personsArray[count($personsArray) - 1];

            if ($this->findMyParent($child, $personsArray)) {
                $person = $personsArray[count($personsArray) - 1];
                $personId = $person->getId();
                $personsMap[$personId] = $person;
                unset($personsArray[count($personsArray) - 1]);
            } else {
                echo "SOMETHING IS WRONG";
                exit;
            }
        }
        if ($id == 1) {
            return $personsArray[0];
        } else {
            return $personsMap[$id];
        }
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
