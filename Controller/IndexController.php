<?php

require_once 'DAO/RouteDao.php';
require_once 'Model/RouteDate.php';

class IndexController {

    private $routeDao;

    function __construct() {
        $this->routeDao = new RouteDao();
    }

    public function getLastUploadedData() {
       
        return $this->routeDao->getLastUploadedData();
    }

}
