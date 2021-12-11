<?php

class Generation {

    private $number;
    private $persons;
    private $orderedPersons;
    private $xPoint;
    private $yPoint;
    private $parentsGeneration;

    function __construct() {
        $this->persons = array();
        $this->orderedPersons = array();
    }

    function getNumber() {
        return $this->number;
    }

    function setNumber($number): void {
        $this->number = $number;
    }

    function addPerson($person) {

        $this->persons[$person->getId()] = $person;
    }

    function getCount() {
        return count($this->persons);
    }

    function getXPoint() {
        return $this->xPoint;
    }

    function getYPoint() {
        return $this->yPoint;
    }

    function setXPoint($xPoint): void {
        $this->xPoint = $xPoint;
    }

    function setYPoint($yPoint): void {
        $this->yPoint = $yPoint;
    }

    function calculateSpaceForPersons() {
        if ($this->parentsGeneration == null) {
            $this->orderedPersons = $this->persons;
        } else {
            $this->orderedPersons = $this->reshapePersonsOrderByParentsOrder($this->parentsGeneration);
        }

        $personXPoint = $this->xPoint - ((count($this->persons) - 1) * 65);
        $personYPoint = 60 + ($this->getNumber() * 100);
        foreach ($this->orderedPersons as $person) {
            $person->setMyX($personXPoint);
            $person->setMyY($personYPoint);
            $personXPoint += 130;
        }
    }

    function getPersons() {
        return $this->persons;
    }

    function getParentsGeneration() {
        return $this->parentsGeneration;
    }

    function setParentsGeneration($parentsGeneration): void {
        $this->parentsGeneration = $parentsGeneration;
    }

    function reshapePersonsOrderByParentsOrder($parentsGeneration) {

        $parents = $parentsGeneration->getPersons();
        foreach ($this->persons as $person) {
            $parentId = $person->getParentId();
            $parent = $parents[$parentId];
            $children = $parent->getChildren();
            array_push($children, $person);
            $parent->setChildren($children);
        }

        foreach ($parents as $parent) {
            $children = $parent->getChildren();
            foreach ($children as $child) {
                array_push($this->orderedPersons, $child);
            }
        }


        return $this->orderedPersons;
    }

}
