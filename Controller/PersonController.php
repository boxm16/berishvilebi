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

    public function getPersonsDescendantsList($id) {

        $mainPerson = $this->getPersonsDescendantsTree($id);
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
        $personDao = new PersonDao();
        $personsArray = $personDao->getAllPersons();
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

    public function getAllPersonsPerGeneration() {
        $personDao = new PersonDao();
        $allPersonsList = $personDao->getAllPersons();
        return $allPersonsList;
    }

    public function getGenerationsStatistic() {
        $generationsStatistic = array();
        $personDao = new PersonDao();
        $allPersons = $personDao->getAllPersons();
        foreach ($allPersons as $person) {
            $generation = $person->getGeneration();
            if (array_key_exists($generation, $generationsStatistic)) {
                $generationsStatistic[$generation] = $generationsStatistic[$generation] + 1;
            } else {
                $generationsStatistic[$generation] = 1;
            }
        }
        $generationsStatistic["სულ"] = count($allPersons);
        return $generationsStatistic;
    }

}
