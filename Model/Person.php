<?php

class Person {

    private $id;
    private $parentId;
    private $generation;
    private $positionX;
    private $positionY;
    private $parentPositionX;
    private $parentPositionY;
    private $firstName;
    private $secondName;
    private $nickname;
    private $lifeStatus;
    private $birthDate;
    private $deathDate;
    private $children;

    function __construct() {
        $this->children = array();
    }

    function getId() {
        return $this->id;
    }

    function getParentId() {
        return $this->parentId;
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

    function getParentPositionX() {
        return $this->parentPositionX;
    }

    function getParentPositionY() {
        return $this->parentPositionY;
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

    function getBirthDate() {
        return $this->birthDate;
    }

    function getDeathDate() {
        return $this->deathDate;
    }

    function getChildren() {
        return $this->children;
    }

    function setId($id): void {
        $this->id = $id;
    }

    function setParentId($parentId): void {
        $this->parentId = $parentId;
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

    function setParentPositionX($parentPositionX): void {
        $this->parentPositionX = $parentPositionX;
    }

    function setParentPositionY($parentPositionY): void {
        $this->parentPositionY = $parentPositionY;
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

    function setBirthDate($birthDate): void {
        $this->birthDate = $birthDate;
    }

    function setDeathDate($deathDate): void {
        $this->deathDate = $deathDate;
    }

    function setChildren($children): void {
        $this->children = $children;
    }

    public function addChild($child): void {
        array_push($this->children, $child);
    }

}
