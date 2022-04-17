<?php

//require_once 'DAO/PersonDao.php';
require_once 'Model/Person.php';

class PersonController {

    public function getAllPersons() {
        $allPersons = array();
        $mainPerson = new Person();
        $mainPerson->setId(1);
        $mainPerson->setParentId(0);
        $mainPerson->setFirstName('ILIA');
        $mainPerson->setSecondName('Berishvili');
        $mainPerson->setPositionX(500);
        $mainPerson->setPositionY(500);

        $sonPerson = new Person();
        $sonPerson->setId(2);
        $sonPerson->setParentId(1);
        $sonPerson->setFirstName('GIORGI');
        $sonPerson->setSecondName('Berishvili');
        $sonPerson->setParentPositionX(500);
        $sonPerson->setParentPositionY(500);
        $sonPerson->setPositionX(590);
        $sonPerson->setPositionY(590);
        $mainPerson->addChild($sonPerson);

        $grandsonPerson = new Person();
        $grandsonPerson->setId(1);
        $grandsonPerson->setParentId(2);
        $grandsonPerson->setFirstName('LashareI');
        $grandsonPerson->setSecondName('Berishvili');
        $grandsonPerson->setParentPositionX(590);
        $grandsonPerson->setParentPositionY(590);
        $grandsonPerson->setPositionX(690);
        $grandsonPerson->setPositionY(690);
        $sonPerson->addChild($grandsonPerson);
        array_push($allPersons, $mainPerson);
        array_push($allPersons, $sonPerson);
        array_push($allPersons, $grandsonPerson);
        return $allPersons;
    }

}
