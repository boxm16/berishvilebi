<?php

require_once 'DataBaseConnection.php';

class DataBaseManipulationDao {

    private $connection;

    function __construct() {
        $dataBaseConnection = new DataBaseConnection();
        $this->connection = $dataBaseConnection->getLocalhostConnection();
    }

    public function createRouteTable() {
        $sql = "CREATE TABLE `route` (
  `number` VARCHAR(10) NOT NULL,
  `prefix` int(4) NOT NULL, 
  `suffix` INT(3) NULL,
  `a_point` VARCHAR(100) NULL,
  `b_point` VARCHAR(100) NULL,
   PRIMARY KEY (`number`))
   ENGINE = InnoDB
   DEFAULT CHARACTER SET = utf8;
   ";
        try {
            $this->connection->exec($sql);
            echo "Table 'route' created successfully" . "<br>";
        } catch (\PDOException $e) {
            if ($e->getCode() == "42S01") {
                echo "Table 'route' already exists" . "<br>";
            } else {
                echo $e->getMessage() . " Error Code:";
                echo $e->getCode() . "<br>";
            }
        }
    }

    public function createTripVoucherTable() {
        $sql = "CREATE TABLE `trip_voucher` (
    `number` VARCHAR(20) NOT NULL,
    `route_number` VARCHAR(10) NOT NULL,
    `date_stamp` DATE NOT NULL,
    `exodus_number` INT(2) NOT NULL,
    `driver_number` VARCHAR(10) NULL,
    `driver_name` VARCHAR(45) NULL,
    `bus_number` VARCHAR(15) NULL,
    `bus_type` VARCHAR(35) NULL,
    `notes` VARCHAR(2000) NULL,
    PRIMARY KEY (`number`),
    CONSTRAINT `route_number`
    FOREIGN KEY (`route_number`)
    REFERENCES `route` (`number`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8;
   ";
        try {
            $this->connection->exec($sql);
            echo "Table 'trip_voucher' created successfully" . "<br>";
        } catch (\PDOException $e) {
            if ($e->getCode() == "42S01") {
                echo "Table 'trip_voucher' already exists" . "<br>";
            } else {
                echo $e->getMessage() . " Error Code:";
                echo $e->getCode() . "<br>";
            }
        }
    }

    public function createTripPeriodTable() {
        $sql = "CREATE TABLE `trip_period` (
  `trip_voucher_number` VARCHAR(20) NOT NULL,
  `type` VARCHAR(15) NOT NULL,
  `start_time_scheduled` TIME(0) NULL  DEFAULT NULL,
  `start_time_actual` TIME(0) NULL  DEFAULT NULL,
  `start_time_difference` VARCHAR(10) NULL,
  `arrival_time_scheduled` TIME(0) NULL  DEFAULT NULL,
  `arrival_time_actual` TIME(0) NULL  DEFAULT NULL,
  `arrival_time_difference` VARCHAR(10) NULL,
    CONSTRAINT `trip_voucher`
    FOREIGN KEY (`trip_voucher_number`)
    REFERENCES `trip_voucher` (`number`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8
   ";
        try {
            $this->connection->exec($sql);
            echo "Table 'trip_period' created successfully" . "<br>";
        } catch (\PDOException $e) {
            if ($e->getCode() == "42S01") {
                echo "Table 'trip_period' already exists" . "<br>";
            } else {
                echo $e->getMessage() . " Error Code:";
                echo $e->getCode() . "<br>";
            }
        }
    }

    public function createLastUploadTable() {
        $sql = "CREATE TABLE `last_upload` (
  `number` VARCHAR(10) NOT NULL,
  `date_stamp` DATE NOT NULL)
   DEFAULT CHARACTER SET = utf8;";
        try {
            $this->connection->exec($sql);
            echo "Table 'last_upload' created successfully" . "<br>";
        } catch (\PDOException $e) {
            if ($e->getCode() == "42S01") {
                echo "Table 'last_upload' already exists" . "<br>";
            } else {
                echo $e->getMessage() . " Error Code:";
                echo $e->getCode() . "<br>";
            }
        }
    }

    public function createCronJobTable() {
        $sql = "CREATE TABLE `cron_job` (
  `type` VARCHAR(25) NOT NULL,
  `id` INT NOT NULL AUTO_INCREMENT,
  `value_1` VARCHAR(10) NULL,
  `value_2` VARCHAR(10) NULL,
  `value_3` VARCHAR(10) NULL,
  `value_4` VARCHAR(10) NULL,
   PRIMARY KEY (`id`))
   DEFAULT CHARACTER SET = utf8;
   ";
        try {
            $this->connection->exec($sql);
            echo "Table 'cron_job' created successfully" . "<br>";
        } catch (\PDOException $e) {
            if ($e->getCode() == "42S01") {
                echo "Table 'cron_job' already exists" . "<br>";
            } else {
                echo $e->getMessage() . " Error Code:";
                echo $e->getCode() . "<br>";
            }
        }
    }

    public function createReportsRoutesDatesTable() {
        $sql = "CREATE TABLE `reports_routes_dates` (
    `report_id` INT NOT NULL,
    `route_number` VARCHAR(10) NOT NULL,
    `date_stamp` DATE NOT NULL,
    CONSTRAINT `report_id`
    FOREIGN KEY (`report_id`)
    REFERENCES `cron_job` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
      DEFAULT CHARACTER SET = utf8;";



        try {
            $this->connection->exec($sql);
            echo "Table 'reports_routes_dates' created successfully" . "<br>";
        } catch (\PDOException $e) {
            if ($e->getCode() == "42S01") {
                echo "Table 'reports_routes_dates' already exists" . "<br>";
            } else {
                echo $e->getMessage() . " Error Code:";
                echo $e->getCode() . "<br>";
            }
        }
    }

//---------------------
    public function dropRouteTable() {
        $sql = "DROP TABLE route;";
        try {
            $this->connection->exec($sql);
            echo "Table 'route' deleted successfully" . "<br>";
        } catch (\PDOException $e) {
            echo $e->getMessage() . " Error Code:";
            echo $e->getCode() . "<br>";
        }
    }

    public function dropTripVoucherTable() {
        $sql = "DROP TABLE trip_voucher;";
        try {
            $this->connection->exec($sql);
            echo "Table 'trip_voucher' deleted successfully" . "<br>";
        } catch (\PDOException $e) {
            echo $e->getMessage() . " Error Code:";
            echo $e->getCode() . "<br>";
        }
    }

    public function dropTripPeriodTable() {
        $sql = "DROP TABLE trip_period;";
        try {
            $this->connection->exec($sql);
            echo "Table 'trip_period' deleted successfully" . "<br>";
        } catch (\PDOException $e) {
            echo $e->getMessage() . " Error Code:";
            echo $e->getCode() . "<br>";
        }
    }

    public function dropLastUploadTable() {
        $sql = "DROP TABLE last_upload;";
        try {
            $this->connection->exec($sql);
            echo "Table 'las_upload' deleted successfully" . "<br>";
        } catch (\PDOException $e) {
            echo $e->getMessage() . " Error Code:";
            echo $e->getCode() . "<br>";
        }
    }

    public function dropCronJobTable() {
        $sql = "DROP TABLE cron_job;";
        try {
            $this->connection->exec($sql);
            echo "Table 'cron_job' deleted successfully" . "<br>";
        } catch (\PDOException $e) {
            echo $e->getMessage() . " Error Code:";
            echo $e->getCode() . "<br>";
        }
    }

    public function dropReportsRoutesDatesTable() {
        $sql = "DROP TABLE reports_routes_dates;";
        try {
            $this->connection->exec($sql);
            echo "Table 'reports_routes_dates' deleted successfully" . "<br>";
        } catch (\PDOException $e) {
            echo $e->getMessage() . " Error Code:";
            echo $e->getCode() . "<br>";
        }
    }

    //---------//----------//-----------//------------

    public function getDataBases() {
        $sql = "SELECT table_schema AS 'Database', 
     ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) AS 'Size' 
     FROM information_schema.TABLES 
     GROUP BY table_schema;"; //shows all databases and their size

        $dataBases = array();
        try {
            $result = $this->connection->query($sql)->fetchAll();
        } catch (\PDOException $e) {
            echo $e->getMessage() . " Error Code:";
            echo $e->getCode() . "<br>";
        }
        foreach ($result as $row) {
            $dbName = $row["Database"];
            $dbSize = $row["Size"];
            $db = array($dbName, $dbSize);
            array_push($dataBases, $db);
        }
        return $dataBases;
    }

}
