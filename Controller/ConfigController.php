<?php

require_once 'DAO/ConfigDao.php';

class ConfigController {

    function createTables() {
        $configDao = new ConfigDao();
        $configDao->createTables();
    }

}
