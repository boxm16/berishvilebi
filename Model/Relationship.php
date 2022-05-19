<?php

class Relationship {

    private $type; //type can be lineal and collateral 
    private $linealRelatianshipVector = array();
    private $collateralRelationshipVector_A = array();
    private $collateralRelationshipVector_B = array();
    private $collatarealRelationshipHead;

    function getType() {
        return $this->type;
    }

    function getLinealRelatianshipVector() {
        return $this->linealRelatianshipVector;
    }

    function getCollateralRelationshipVector_A() {
        return $this->collateralRelationshipVector_A;
    }

    function getCollateralRelationshipVector_B() {
        return $this->collateralRelationshipVector_B;
    }

    function getCollatarealRelationshipHead() {
        return $this->collatarealRelationshipHead;
    }

    function setType($type): void {
        $this->type = $type;
    }

    function setLinealRelatianshipVector($linealRelatianshipVector): void {
        $this->linealRelatianshipVector = $linealRelatianshipVector;
    }

    function setCollateralRelationshipVector_A($collateralRelationshipVector_A): void {
        $this->collateralRelationshipVector_A = $collateralRelationshipVector_A;
    }

    function setCollateralRelationshipVector_B($collateralRelationshipVector_B): void {
        $this->collateralRelationshipVector_B = $collateralRelationshipVector_B;
    }

    function setCollatarealRelationshipHead($collatarealRelationshipHead): void {
        $this->collatarealRelationshipHead = $collatarealRelationshipHead;
    }

}
