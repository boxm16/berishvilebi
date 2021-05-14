<?php

require_once 'DAO/DataBaseConnection.php';

class RouteDao {

    private $connection;

    function __construct() {
        $dataBaseConnection = new DataBaseConnection();
        $this->connection = $dataBaseConnection->getLocalhostConnection();
    }

    public function getRouteNumbers() {
        $returnArray = array();
        $sql = "SELECT number FROM route";
        try {

            $resultSet = $this->connection->query($sql)->fetchAll();
            foreach ($resultSet as $row) {
                array_push($returnArray, $row["number"]);
            }
            return $returnArray;
        } catch (\PDOException $e) {
            echo $e->getMessage() . " Error Code:";
            echo $e->getCode() . "<br>";
        }
    }

    public function insertRoutes($routesData) {
        try {
            $this->connection->beginTransaction();
            $stmt = $this->connection->multiPrepare('INSERT INTO route (number, prefix, suffix, a_point, b_point)', $routesData);
            $stmt->multiExecute($routesData);
            $this->connection->commit();
            echo "New route(s) inserted successfully into database.<br>";
        } catch (\PDOException $e) {
            echo $e->getMessage() . " Error Code:";
            echo $e->getCode() . "<br>";
        }
    }

    public function deleteVouchers(array $vouchersForDeletion) {
        $firstVoucher = array_shift($vouchersForDeletion);
        $firstVoucherNumber = $firstVoucher[0];
        $sql = "DELETE FROM trip_voucher WHERE number='$firstVoucherNumber' ";
        foreach ($vouchersForDeletion as $voucher) {
            $firstVoucherNumber = $voucher[0];
            $sql .= " OR number='$firstVoucherNumber' ";
        }
        $sql .= ";";
        try {
            $this->connection->exec($sql);
            echo "Records that are to be renewed deleted successfully.<br>";
        } catch (\PDOException $e) {
            echo $e->getMessage() . " Error Code:";
            echo $e->getCode() . "<br>";
        }
    }

    public function insertTripVouchers($tripVouchersData) {
        try {
            $this->connection->beginTransaction();
            $stmt = $this->connection->multiPrepare('INSERT INTO trip_voucher (number, route_number, date_stamp, exodus_number, driver_number, driver_name, bus_number, bus_type, notes)', $tripVouchersData);
            $stmt->multiExecute($tripVouchersData);
            $this->connection->commit();
            echo "TripVouchers inserted successfully into database.<br>";
        } catch (\PDOException $e) {
            echo $e->getMessage() . " Error Code:";
            echo $e->getCode() . "<br>";
        }
    }

    public function insertTripPeriods($tripPeriodsData) {
        $chunkedArray = array_chunk($tripPeriodsData, 5000);
        foreach ($chunkedArray as $data) {
            try {
                $this->connection->beginTransaction();
                $stmt = $this->connection->multiPrepare('INSERT INTO trip_period (trip_voucher_number, type, start_time_scheduled, start_time_actual, start_time_difference, arrival_time_scheduled, arrival_time_actual, arrival_time_difference)', $data);
                $stmt->multiExecute($data);
                $this->connection->commit();
                echo "Trip Periods inserted successfully into database.<br>";
            } catch (\PDOException $e) {
                echo $e->getMessage() . " Error Code:";
                echo $e->getCode() . "<br>";
            }
        }
    }

    public function getLastUploadedData() {
        try {
            $sql = "SELECT DISTINCT t1.number, date_stamp, prefix, suffix FROM last_upload t1 INNER JOIN route t2 ON t1.number=t2.number ORDER BY prefix, suffix, date_stamp DESC";
            $result = $this->connection->query($sql)->fetchAll();
        } catch (\PDOException $e) {
            echo $e->getMessage() . " Error Code:";
            echo $e->getCode() . "<br>";
        }
        $arrayOfRoutes = array();
        foreach ($result as $row) {
            $routeNumber = $row["number"];
            $dateStamp = $row["date_stamp"];
            if (array_key_exists($routeNumber, $arrayOfRoutes)) {
                $routeDate = $arrayOfRoutes[$routeNumber];
                $dates = $routeDate->getDates();
                array_push($dates, $dateStamp);
                $routeDate->setDates($dates);
            } else {
                $dates = array($dateStamp);
                $routeDate = new RouteDate();
                $routeDate->setRouteNumber($routeNumber);
                $routeDate->setDates($dates);
                $arrayOfRoutes[$routeNumber] = $routeDate;
            }
        }
        return $arrayOfRoutes;
    }

}
