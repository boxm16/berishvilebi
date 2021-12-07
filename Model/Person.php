<?php

class Person {

    private $id;
    private $generation;
    private $firstName;
    private $secondName;
    private $nickname;
    private $lifeStatus;
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

    function setParentId($parentId): void {
        $this->parentId = $parentId;
    }

    function setChildren($children): void {
        $this->children = $children;
    }

}
