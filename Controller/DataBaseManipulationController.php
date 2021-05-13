<?php

require_once 'DAO/DataBaseManipulationDao.php';

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
    //-------------------------
     public function dropRouteTable() {
        $this->dbManDao->dropRouteTable();
    }

    public function dropTripVoucherTable() {
        $this->dbManDao->dropTripVoucherTable();
    }

    public function dropTripPeriodTable() {
        $this->dbManDao->dropTripPeriodTable();
    }

    public function dropLastUploadTable() {
        $this->dbManDao->dropLastUploadTable();
    }

    public function dropCronJobTable() {
        $this->dbManDao->dropCronJobTable();
    }

    public function dropReportsRoutesDatesTable() {
         $this->dbManDao->dropReportsRoutesDatesTable();
    }

}
