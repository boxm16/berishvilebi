<?php

require_once 'DAO/DataBaseManipulationDAO.php';

class DataBaseManipulationController {

    private $dbManDao;

    public function __construct() {
        $this->dbManDao = new DataBaseManipulationDAO();
    }

    public function createRouteTable() {
        $this->dbManDao->createRouteTable();
    }

    public function createTripVoucherTable() {
        $this->dbManDao->createTripVoucherTable();
    }

    public function createTripPeriodTable() {
        $this->dbManDao->createTripPeriodTable();
    }

    public function createLastUploadTable() {
        $this->dbManDao->createLastUploadTable();
    }

    public function createCronJobTable() {
        $this->dbManDao->createCronJobTable();
    }

    public function createReportsRoutesDatesTable() {
         $this->dbManDao->createReportsRoutesDatesTable();
    }

}
