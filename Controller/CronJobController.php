<?php

require_once 'DAO/CronJobDao.php';
require_once 'DAO/RouteDao.php';
require 'vendor/autoload.php';
require_once 'Model/UploadChunk.php';
require_once 'TimeCalculator.php';

//in this file there are 2 classes, this one, and second at the bottom
class CronJobController {

    private $lastChunk;
    private $cronJobDao;
    private $routeDao;

    function __construct() {
        $this->lastChunk = false;
        $this->cronJobDao = new CronJobDao();
        $this->routeDao = new RouteDao();
    }

    public function getUploadingStatus(): bool {
        return ($this->cronJobDao->getUploadingCronJobId() == null) ? false : true;
    }
    public function getLastUploadedRow(){
        return $this->cronJobDao->getLastUploadedRow();
    }

    public function registerNewUpload() {
        $this->cronJobDao->deleteLastUploadedData();
        $this->cronJobDao->deleteUploadTask(); //in case there still is one working, maybe later i`ll leave two and more upload tasks in cron job
        $this->cronJobDao->registerNewUpload();
    }

    public function insertNextChunk() {

        $start_memory = memory_get_usage(); //to measure variable size, see foot

        $nextChunkStartingRow = $this->cronJobDao->getUploadingStartRowIndex();
        $chunkMaxLength = 1000; //this number is pretty much optimal, already checked, but try again ,if you want
        $nextChunkLastRow = $nextChunkStartingRow + $chunkMaxLength;
        $spreadsheet = $this->readExcelFile($nextChunkStartingRow, $nextChunkLastRow);
        $nextChunkEndRow = $this->getNextChunkEndRow($spreadsheet, $nextChunkLastRow, $chunkMaxLength);
        $nextChunk = $this->getNextChunk($spreadsheet, $nextChunkStartingRow, $nextChunkEndRow);

        if ($this->lastChunk) {
            $this->loadChunk($nextChunk);
            $this->cronJobDao->resetCronJobUploadingSatus();
            echo "End of Uploading";
            echo "<br>";
        } else {
            $this->loadChunk($nextChunk);
            $this->cronJobDao->registerNextChunk($nextChunkEndRow);
        }
        $needeMemory = memory_get_usage() - $start_memory;
        echo 'Memory needed for loading:  (' . (($needeMemory / 1024) / 1024) . 'M) <br>';
        echo 'Peak usage:(' . ( (memory_get_peak_usage() / 1024 ) / 1024) . 'M) <br>';
    }

    public function readExcelFile($startRow, $endRow) {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $reader->setReadFilter(new MyReadFilter($startRow, $endRow));
        $spreadsheet = $reader->load("uploads/uploadedExcelFile.xlsx");

        return $spreadsheet;
    }

    private function getNextChunkEndRow($spreadsheet, $lastRow, $chunkMaxLength) {

        $lastVoucherInChunk = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(7, $lastRow)->getValue();
        if ($lastVoucherInChunk == "") {
            $this->lastChunk = true;
        }

        while (true) {
            $lastRow--;
            $beforeLastVoucherInChunk = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(7, $lastRow)->getValue();
            if ($beforeLastVoucherInChunk != $lastVoucherInChunk) {
                return $lastRow + 1;
            }
            if ($lastRow == 8) {
                return $chunkMaxLength;
            }
        }
        return $lastRow;
    }

    public function getNextChunk($spreadsheet, int $startRow, int $endRow) {
        $chunk = new UploadChunk();
        $x = $startRow;
        $lastUploadedRouteDates = $this->cronJobDao->getLastUploadedData();

        while ($x < $endRow) {
            $routeNumber = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(8, $x)->getValue();

            if ($routeNumber == "") {
                $this->lastChunk = true;

                break;
            } else {
//here is actual reading of spreadsheet rows and sending values to apropriate destination
// echo $spreadsheet->getActiveSheet()->getCellByColumnAndRow(7, $x) . "---" . $spreadsheet->getActiveSheet()->getCellByColumnAndRow(17, $x) . "<br>";


                $dateStamp = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(6, $x)->getValue();
                $convertedDateStamp = $this->convertDateStamp($dateStamp);
                $routeNumberDateStamp = $routeNumber . ":" . $convertedDateStamp;
                if (in_array($routeNumberDateStamp, $lastUploadedRouteDates)) {
                    //do nothing
                } else {
                    $routeDateInsertionData = $chunk->getRouteDates();
                    $routeDateInsertionRow = array($routeNumber, $convertedDateStamp);
                    array_push($lastUploadedRouteDates, $routeNumberDateStamp);
                    array_push($routeDateInsertionData, $routeDateInsertionRow);
                    $chunk->setRouteDates($routeDateInsertionData);
                }

//---------
                $routes = $chunk->getRoutes();
                if (in_array($routeNumber, $routes)) {
//do nothing
                } else {
                    array_push($routes, $routeNumber);
                }
                $chunk->setRoutes($routes);
                $chunk = $this->getTripVoucherData($chunk, $spreadsheet, $x);
                $chunk = $this->getTripPeriodData($chunk, $spreadsheet, $x);
                $x++;
            }
        }

        return $chunk;
    }

    private function convertDateStamp($dateStamp) {
        $time = strtotime(str_replace('/', '-', $dateStamp));
        return $dateStamp = date('Y-m-d', $time);
    }

    private function getTripVoucherData(UploadChunk $chunk, $spreadsheet, $x) {
        $tripVoucherNumber = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(7, $x)->getValue();
        $tripVouchersDoubler = $chunk->getTripVouchersDoubler();

        if (in_array($tripVoucherNumber, $tripVouchersDoubler)) {
            return $chunk;
        } else {
            $tripVouchers = $chunk->getTripVouchers();
            $routeNumber = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(8, $x)->getValue();
            $dateStamp = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(6, $x)->getValue();
            $convertedDateStamp = $this->convertDateStamp($dateStamp);
            $exodusNumber = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(9, $x)->getValue();
            $driverNumber = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(4, $x)->getValue();
            $driverName = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(5, $x)->getValue();
            $busNumber = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(3, $x)->getValue();
            $busType = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(2, $x)->getValue();
            $notes = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(29, $x)->getValue();
            $tripVoucher = array($tripVoucherNumber, $routeNumber, $convertedDateStamp, $exodusNumber, $driverNumber, $driverName, $busNumber, $busType, $notes);
            array_push($tripVouchers, $tripVoucher);
            array_push($tripVouchersDoubler, $tripVoucherNumber);
            $chunk->setTripVouchers($tripVouchers);
        }


        $chunk->setTripVouchersDoubler($tripVouchersDoubler);
        return $chunk;
    }

    private function getTripPeriodData(UploadChunk $chunk, $spreadsheet, $x) {

        $tripPeriodType = $this->getTripTypeFromRowCell($spreadsheet, $x);
        $tripPeriods = $chunk->getTripPeriods();

        if ($tripPeriodType == "baseLeaving") {
            $tripPeriod = $this->createBaseLeavingPeriod($spreadsheet, $x);
            array_push($tripPeriods, $tripPeriod);
        }
        if ($tripPeriodType == "baseReturn") {
            $tripPeriod = $this->createBaseReturnPeriod($spreadsheet, $x);
            array_push($tripPeriods, $tripPeriod);
        }
        if ($tripPeriodType == "break") {
            $tripPeriod = $this->createBreakPeriod($spreadsheet, $x);
            array_push($tripPeriods, $tripPeriod);
        }
        if ($tripPeriodType == "round") {
            $tripPeriodsOfRound = $this->createTripPeridsOfRound($spreadsheet, $x);
            foreach ($tripPeriodsOfRound as $tripPeriod) {
                array_push($tripPeriods, $tripPeriod);
            }
        }

        $chunk->setTripPeriods($tripPeriods); //not sure if needed, maybe array is already pushed
        return $chunk;
    }

    private function getTripTypeFromRowCell($spreadsheet, $x) {
        //baseLeaving, baseReturn, ab, ba, break
        $tripPeriodTypeStampInRowCell = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(16, $x)->getValue();
        if (strpos($tripPeriodTypeStampInRowCell, "გასვლა") != null) {
            return "baseLeaving";
        }
        if (strpos($tripPeriodTypeStampInRowCell, "შესვენება") != null) {
            return "break";
        }
        if (strpos($tripPeriodTypeStampInRowCell, "დაბრუნება") != null) {
            return "baseReturn";
        }
        if (strpos($tripPeriodTypeStampInRowCell, "ბრუნი") != null) {
            return "round";
        }
    }

    private function createBaseLeavingPeriod($spreadsheet, $x) {

        if ($spreadsheet->getActiveSheet()->getCellByColumnAndRow(17, $x)->getValue() != "") {
            $tripPeriodType = "baseLeaving_A";
            $tripPeriod = $this->createTripPeriodFromLeftSide($spreadsheet, $x, $tripPeriodType);
        } else {
            $tripPeriodType = "baseLeaving_B";
            $tripPeriod = $this->createTripPeriodFromRightSide($spreadsheet, $x, $tripPeriodType);
        }
        return $tripPeriod;
    }

    private function createBaseReturnPeriod($spreadsheet, $x) {
        if ($spreadsheet->getActiveSheet()->getCellByColumnAndRow(17, $x)->getValue() != "") {
            $tripPeriodType = "A_baseReturn";
            $tripPeriod = $this->createTripPeriodFromLeftSide($spreadsheet, $x, $tripPeriodType);
        } else {
            $tripPeriodType = "B_baseReturn";
            $tripPeriod = $this->createTripPeriodFromRightSide($spreadsheet, $x, $tripPeriodType);
        }
        return $tripPeriod;
    }

    private function createBreakPeriod($spreadsheet, $x) {
        $tripPeriodType = "break";
        if ($spreadsheet->getActiveSheet()->getCellByColumnAndRow(17, $x)->getValue() != "") {
            $tripPeriod = $this->createTripPeriodFromLeftSide($spreadsheet, $x, $tripPeriodType);
        } else {
            $tripPeriod = $this->createTripPeriodFromRightSide($spreadsheet, $x, $tripPeriodType);
        }
        return $tripPeriod;
    }

    private function createTripPeridsOfRound($spreadsheet, $x) {
        $tripPeriodsOfRound = array();
        if ($spreadsheet->getActiveSheet()->getCellByColumnAndRow(17, $x)->getValue() != "" &&
                $spreadsheet->getActiveSheet()->getCellByColumnAndRow(23, $x)->getValue() != "") {
            $leftSideTime = $this->time24($spreadsheet->getActiveSheet()->getCellByColumnAndRow(17, $x)->getValue());
            $rightSideTime = $this->time24($spreadsheet->getActiveSheet()->getCellByColumnAndRow(23, $x)->getValue());
            $timeCalculator = new TimeCalculator();
            $leftSideTimeInSeconds = $timeCalculator->getSecondsFromTimeStamp($leftSideTime);
            $rightSideTimeInSeconds = $timeCalculator->getSecondsFromTimeStamp($rightSideTime);
            if ($leftSideTimeInSeconds < $rightSideTimeInSeconds) {
                $tripPeriodType = "ab";
                $tripPeriod = $this->createTripPeriodFromLeftSide($spreadsheet, $x, $tripPeriodType);
                array_push($tripPeriodsOfRound, $tripPeriod);
                $tripPeriodType = "ba";
                $tripPeriod = $this->createTripPeriodFromRightSide($spreadsheet, $x, $tripPeriodType);
                array_push($tripPeriodsOfRound, $tripPeriod);
                return $tripPeriodsOfRound;
            } else {

                $tripPeriodType = "ba";
                $tripPeriod = $this->createTripPeriodFromRightSide($spreadsheet, $x, $tripPeriodType);
                array_push($tripPeriodsOfRound, $tripPeriod);
                $tripPeriodType = "ab";
                $tripPeriod = $this->createTripPeriodFromLeftSide($spreadsheet, $x, $tripPeriodType);
                array_push($tripPeriodsOfRound, $tripPeriod);
                return $tripPeriodsOfRound;
            }
        }
        if ($spreadsheet->getActiveSheet()->getCellByColumnAndRow(17, $x)->getValue() != "") {
            $tripPeriodType = "ab";
            $tripPeriod = $this->createTripPeriodFromLeftSide($spreadsheet, $x, $tripPeriodType);
            array_push($tripPeriodsOfRound, $tripPeriod);
        }
        if ($spreadsheet->getActiveSheet()->getCellByColumnAndRow(23, $x)->getValue() != "") {
            $tripPeriodType = "ba";
            $tripPeriod = $this->createTripPeriodFromRightSide($spreadsheet, $x, $tripPeriodType);
            array_push($tripPeriodsOfRound, $tripPeriod);
        }
        return $tripPeriodsOfRound;
    }

    private function createTripPeriodFromLeftSide($spreadsheet, $x, $type) {
        $tripVoucherNumber = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(7, $x)->getValue();
        $startTimeScheduled = $this->time24($spreadsheet->getActiveSheet()->getCellByColumnAndRow(17, $x)->getValue());
        $startTimeActual = $this->time24($spreadsheet->getActiveSheet()->getCellByColumnAndRow(18, $x)->getValue());
        $startTimeDifference = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(19, $x)->getValue();
        $arrivalTimeScheduled = $this->time24($spreadsheet->getActiveSheet()->getCellByColumnAndRow(20, $x)->getValue());
        $arrivalTimeActual = $this->time24($spreadsheet->getActiveSheet()->getCellByColumnAndRow(21, $x)->getValue());
        $arrivalTimeDifference = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(22, $x)->getValue();
        $tripPeriod = array($tripVoucherNumber, $type, $startTimeScheduled, $startTimeActual, $startTimeDifference, $arrivalTimeScheduled, $arrivalTimeActual, $arrivalTimeDifference);
        return $tripPeriod;
    }

    private function createTripPeriodFromRightSide($spreadsheet, $x, $type) {
        $tripVoucherNumber = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(7, $x)->getValue();
        $startTimeScheduled = $this->time24($spreadsheet->getActiveSheet()->getCellByColumnAndRow(23, $x)->getValue());
        $startTimeActual = $this->time24($spreadsheet->getActiveSheet()->getCellByColumnAndRow(24, $x)->getValue());
        $startTimeDifference = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(25, $x)->getValue();
        $arrivalTimeScheduled = $this->time24($spreadsheet->getActiveSheet()->getCellByColumnAndRow(26, $x)->getValue());
        $arrivalTimeActual = $this->time24($spreadsheet->getActiveSheet()->getCellByColumnAndRow(27, $x)->getValue());
        $arrivalTimeDifference = $spreadsheet->getActiveSheet()->getCellByColumnAndRow(28, $x)->getValue();
        $tripPeriod = array($tripVoucherNumber, $type, $startTimeScheduled, $startTimeActual, $startTimeDifference, $arrivalTimeScheduled, $arrivalTimeActual, $arrivalTimeDifference);
        return $tripPeriod;
    }

    private function time24($shortTimeStamp) {
        if ($shortTimeStamp == "") {
            return $shortTimeStamp;
        }
        $splittedTime = explode(":", $shortTimeStamp);
        $hours = $splittedTime[0];
        $minutes = $splittedTime[1];
        $totalSeconds = ($hours * 60 * 60) + ($minutes * 60);
        if ($totalSeconds > 3 * 60 * 60) {
            return $shortTimeStamp;
        } else {
            $totalSeconds += 24 * 60 * 60;
            $h = floor($totalSeconds / 3600);
            $m = floor(($totalSeconds - ($h * 3600)) / 60);

            return sprintf('%02d', $h) . ":" . sprintf('%02d', $m);
        }
    }

    private function loadChunk($chunk) {

        $tripPeriods = $chunk->getTripPeriods();

        if (count($tripPeriods) > 0) {
            //first register new uploaded routes and datestamps
            $routeDatesData = $chunk->getRouteDates();
            $this->cronJobDao->insertLastUploadedData($routeDatesData);
            //now get routeNumbers from database to compare if there is some new route number in uploaded file 
            $routeNumbersFromChunk = $chunk->getRoutes();
            $routNumbersFromDB = $this->routeDao->getRouteNumbers();
            $routeNumbersForInsertion = array();
            foreach ($routeNumbersFromChunk as $routeNumberFromChunk) {
                if (in_array($routeNumberFromChunk, $routNumbersFromDB)) {
                    //do nothing
                } else {
                    array_push($routeNumbersForInsertion, $routeNumberFromChunk);
                }
            }
            if (count($routeNumbersForInsertion) > 0) {
                $insertData = array();
                foreach ($routeNumbersForInsertion as $routeNumber) {

                    $exploded = explode("-", $routeNumber);
                    $prefix = $exploded[0];
                    $suffix = null;
                    if (count($exploded) > 1) {
                        $suffix = $exploded[1];
                    }
                    $insertRow = array($routeNumber, $prefix, $suffix, "A-პუნკტი", "B-პუნკტი");
                    array_push($insertData, $insertRow);
                }
                $this->routeDao->insertRoutes($insertData);
            }
            //now trip vouchers
            $tripVouchers = $chunk->getTripVouchers();

            $tripPeriodsForInsertion = $chunk->getTripPeriods();
            $this->routeDao->deleteVouchers($tripVouchers);
            $this->routeDao->insertTripVouchers($tripVouchers);

            $this->routeDao->insertTripPeriods($tripPeriodsForInsertion);
        }
    }

// =========//==========//===========//==================//==============/////=======
    public function getRouteDetailsReportIds(): array {
        return $this->cronJobDao->getRouteDetailsReportsCronJobIds();
    }

}

//--------------//---------------//----------------

class MyReadFilter implements \PhpOffice\PhpSpreadsheet\Reader\IReadFilter {

    private $startRow;
    private $endRow;

    function __construct($startRow, $endRow) {
        $this->startRow = $startRow;
        $this->endRow = $endRow;
    }

    public function readCell($column, $row, $worksheetName = '') {
// Read  rows startRow - endRow
        if ($row >= $this->startRow && $row <= $this->endRow) {
            return true;
        }
        return false;
    }

}
