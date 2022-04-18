<?php

class MapVersion {
   
    private $id;
    private $name;
    private $mapWidth;
    private $mapHeight;
    
    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getMapWidth() {
        return $this->mapWidth;
    }

    function getMapHeight() {
        return $this->mapHeight;
    }

    function setId($id): void {
        $this->id = $id;
    }

    function setName($name): void {
        $this->name = $name;
    }

    function setMapWidth($mapWidth): void {
        $this->mapWidth = $mapWidth;
    }

    function setMapHeight($mapHeight): void {
        $this->mapHeight = $mapHeight;
    }


            
    
}
