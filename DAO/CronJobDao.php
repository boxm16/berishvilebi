<?php

require_once 'DAO/DataBaseConnection.php';

class CronJobDao {

    private $connection;

    function __construct() {
        $dataBaseConnection = new DataBaseConnection();
        $this->connection = $dataBaseConnection->getLocalhostConnection();
    }

    public function getUploadingJobId() {
        $sql = "SELECT id FROM cron_job WHERE type='uploading' LIMIT 1"; //maybe, later, limit 1 will be removed
        try {
            $result = $this->connection->query($sql)->fetch();
            return $result["id"];
        } catch (\PDOException $e) {
            echo $e->getMessage() . " Error Code:";
            echo $e->getCode() . "<br>";
        }
    }

    public function deleteLastUploadedData() {
        $sql = "DELETE FROM last_upload;";
        try {
            $statement = $this->connection->prepare($sql);
            $statement->execute();
            echo "All data has been deleted successfully from last_upload table.<br>";
        } catch (\PDOException $e) {
            echo $e->getMessage() . " Error Code:";
            echo $e->getCode() . "<br>";
        }
    }

    public function deleteUploadTask() {
        $sql = "DELETE FROM cron_job WHERE type='uploading';";
        try {
            $statement = $this->connection->prepare($sql);
            $statement->execute();
            echo "Upload task has been deleted successfully from cron_job table.<br>";
        } catch (\PDOException $e) {
            echo $e->getMessage() . " Error Code:";
            echo $e->getCode() . "<br>";
        }
    }

    public function registerNewUpload() {
        $sql = "INSERT INTO cron_job (type, value_1) VALUES ('uploading', '8');";
        //hre value_1 is starting row for chunk
        try {
            $statement = $this->connection->prepare($sql);
            $statement->execute();
        } catch (\PDOException $e) {
            echo $e->getMessage() . " Error Code:";
            echo $e->getCode() . "<br>";
        }
    }

    public function getUploadingStartRowIndex() {
        $sql = "SELECT value_1 FROM cron_job WHERE type='uploading'";
//value_1 is starting row for uploading chunk 
        try {
            $result = $this->connection->query($sql)->fetch();
            return $result["value_1"];
        } catch (\PDOException $e) {
            echo $e->getMessage() . " Error Code:";
            echo $e->getCode() . "<br>";
        }
    }

    public function getLastUploadedData() {
        $sql = "SELECT  number, date_stamp FROM last_upload";
        $routeDates = array();
        try {
            $result = $this->connection->query($sql)->fetchAll();
        } catch (\PDOException $e) {
            echo $e->getMessage() . " Error Code:";
            echo $e->getCode() . "<br>";
        }
        foreach ($result as $row) {
            $routeNumber = $row["number"];
            $date_stamp = $row["date_stamp"];
            $routeNumberDateStamp = $routeNumber . ":" . $date_stamp;
            array_push($routeDates, $routeNumberDateStamp);
        }
        return $routeDates;
    }

    public function resetCronJobUploadingSatus() {
        $sql = "DELETE from cron_job WHERE type='uploading'"; //maybe later , when i`ll have 2 and more uploads at the same time, i`ll need upload id
        try {
            $statement = $this->connection->prepare($sql);
            $statement->execute();
        } catch (\PDOException $e) {
            echo $e->getMessage() . " Error Code:";
            echo $e->getCode() . "<br>";
        }
    }

    public function insertLastUploadedData($routeDatesData) {
        try {
            $this->connection->beginTransaction();
            $stmt = $this->connection->multiPrepare('INSERT INTO last_upload (number, date_stamp)', $routeDatesData);
            $stmt->multiExecute($routeDatesData);
            $this->connection->commit();
            echo "New data (Last Uploaded Routes And Dates) inserted successfully into database.<br>";
        } catch (\PDOException $e) {
            echo $e->getMessage() . " Error Code:";
            echo $e->getCode() . "<br>";
        }
    }

    public function registerNextChunk(int $endRow) {

        $sql = "UPDATE cron_job SET value_1=? WHERE type='uploading';";
//value_1 is startning (ending) row
        try {
            $statement = $this->connection->prepare($sql);
            $statement->bindParam(1, $endRow);
            $statement->execute();
            echo "Next chunk with EndRow=$endRow registered successfully into database. <br>";
        } catch (\PDOException $e) {
            echo $e->getMessage() . " Error Code:";
            echo $e->getCode() . "<br>";
        }
    }

}
