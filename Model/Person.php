<?php

class Person {

    private $id;
    private $generation;
    private $firstName;
    private $secondName;
    private $nickname;
    private $birthDate;
    private $deathDate;
    private $fatherId;
    private $motherId;
    private $spouses;
    private $children;

    function getId() {
        return $this->id;
    }

    function getGeneration() {
        return $this->generation;
    }

    function getFirstName() {
        return $this->firstName;
    }

    function getSecondName() {
        return $this->secondName;
    }

    function getNickname() {
        return $this->nickname;
    }

    function getBirthDate() {
        return $this->birthDate;
    }

    function getDeathDate() {
        return $this->deathDate;
    }

    function getFatherId() {
        return $this->fatherId;
    }

    function getMotherId() {
        return $this->motherId;
    }

    function getSpouses() {
        return $this->spouses;
    }

    function getChildren() {
        return $this->children;
    }

    function setId($id): void {
        $this->id = $id;
    }

    function setGeneration($generation): void {
        $this->generation = $generation;
    }

    function setFirstName($firstName): void {
        $this->firstName = $firstName;
    }

    function setSecondName($secondName): void {
        $this->secondName = $secondName;
    }

    function setNickname($nickname): void {
        $this->nickname = $nickname;
    }

    function setBirthDate($birthDate): void {
        $this->birthDate = $birthDate;
    }

    function setDeathDate($deathDate): void {
        $this->deathDate = $deathDate;
    }

    function setFatherId($fatherId): void {
        $this->fatherId = $fatherId;
    }

    function setMotherId($motherId): void {
        $this->motherId = $motherId;
    }

    function setSpouses($spouses): void {
        $this->spouses = $spouses;
    }

    function setChildren($children): void {
        $this->children = $children;
    }



}
