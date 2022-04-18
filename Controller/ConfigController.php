<?php

require_once 'DAO/ConfigDao.php';
require_once 'DAO/PersonDao.php';
require_once 'Model/Person.php';
require_once 'Model/MapVersion.php';
require_once 'DAO/MapVersionDao.php';

class ConfigController {

    function createTables() {
        $configDao = new ConfigDao();

        $configDao->createPersonTable();
        $configDao->createVersionTable();
        $configDao->createVersionPositionTable();
    }

    function deleteTables() {
        $configDao = new ConfigDao();


        $configDao->deleteVersionPositionTable();
        $configDao->deleteVersionTable();
        $configDao->deletePersonTable();
    }

    public function insertMainMapVersion() {
        $mapVersion = new MapVersion();
        $mapVersion->setName('საბაზისო');
        $mapVersion->setMapWidth(7000);
        $mapVersion->setMapHeight(7000);

        $mapVersionDao = new MapVersionDao();
        $insertionResult = $mapVersionDao->insertMapVersion($mapVersion);
        if ($insertionResult) {
            echo 'Main Map Version Inserted!<br>';
        }
    }

    function insertMainPerson() {

        $person = new Person();
        $person->setParentId(0);
        $person->setGeneration(0);
        $person->setPositionX(200);
        $person->setPositionY(200);
        $person->setFirstName('ილია');
        $person->setSecondName('ბერიშვილი');
        $person->setNickname('ბერი');

        $mapVersionId = 1;
        $personDao = new PersonDao();
        $insertionResult = $personDao->insertPerson($person, $mapVersionId);
        if ($insertionResult) {
            echo 'Main Person Inserted!<br>';
        }
    }

}
