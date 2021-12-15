<?php

class Person {

    private $id;
    private $generation;
    private $positionX;
    private $positionY;
    private $firstName;
    private $secondName;
    private $nickname;
    private $lifeStatus;
    private $birth_date;
    private $death_date;
    private $parentId;
    private $children;

    function __construct() {
        $this->children = array();
    }

    function getId() {
        return $this->id;
    }

    function getGeneration() {
        return $this->generation;
    }

    function getPositionX() {
        return $this->positionX;
    }

    function getPositionY() {
        return $this->positionY;
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

    function getLifeStatus() {
        return $this->lifeStatus;
    }

    function getBirth_date() {
        return $this->birth_date;
    }

    function getDeath_date() {
        return $this->death_date;
    }

    function getParentId() {
        return $this->parentId;
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

    function setPositionX($positionX): void {
        $this->positionX = $positionX;
    }

    function setPositionY($positionY): void {
        $this->positionY = $positionY;
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

    function setLifeStatus($lifeStatus): void {
        $this->lifeStatus = $lifeStatus;
    }

    function setBirth_date($birth_date): void {
        $this->birth_date = $birth_date;
    }

    function setDeath_date($death_date): void {
        $this->death_date = $death_date;
    }

    function setParentId($parentId): void {
        $this->parentId = $parentId;
    }

    function setChildren($children): void {
        $this->children = $children;
    }



}
