<?php

require_once 'DAO/ConfigDao.php';
require_once 'DAO/DbManDao.php';

class adminController {

    private $configDao;

    function __construct() {
        $this->configDao = new ConfigDao();
    }

    public function getSvgWidth() {
        return $this->configDao->getSvgWidth();
    }

    public function getSvgHeight() {
        return $this->configDao->getSvgHeight();
    }

    public function updateSpace($width, $height) {
        $dbManDao = new DbManDao();
        $dbManDao->updateSpace($width, $height);
    }

}
