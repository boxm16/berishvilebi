<?php

require_once 'DAO/ConfigDao.php';

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

}
