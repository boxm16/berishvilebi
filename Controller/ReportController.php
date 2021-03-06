<?php

require_once 'DAO/ReportDao.php';

class ReportController {

    private $reportDao;

    function __construct() {
        $this->reportDao = new ReportDao();
    }

    public function getReportList(): array {
        $dir = "reports";
        $list = scandir($dir); //in ascending order
        // $list= scandir($dir,1);//in descending order
        if ($list == null) {
            return array();
        } else {
            return $list;
        }
    }

    public function registerReports($requestedReportsData) {
        $requestedRoutesDates = $requestedReportsData["routes:dates"];
        if (strlen($requestedRoutesDates) == 0) {
            echo "No routes and dates has been selected<br>";
        } else {
            if (isset($requestedReportsData["routeDetailsReport"]) && $requestedReportsData["routeDetailsReport"] == "on") {
                $lastInsertdionId = $this->reportDao->registerRouteDetailsReport(); //this function inserts data to report_tech and return id numbero of this(last)insertion
                $nsertionData = $this->convertRequestedRoutesAndDatesToInsertionData($lastInsertdionId, $requestedRoutesDates);
                $this->reportDao->registerReportData($nsertionData);
            }
            if (isset($requestedReportsData["intervalsReport"]) && $requestedReportsData["intervalsReport"] == "on") {
                
            }
            if (isset($requestedReportsData["excelFormReport"]) && $requestedReportsData["excelFormReport"] == "on") {
                //registerRouteDetailsReport
            }
        }
    }

    private function convertRequestedRoutesAndDatesToInsertionData($reportId, $requestedRoutesAndDates) {
        $insertionData = array();
        $routesAndDates = explode(",", $requestedRoutesAndDates);
        foreach ($routesAndDates as $routeAndDate) {
            if ($routeAndDate != "") {
                $d = explode(":", $routeAndDate);
                $routNumber = $d[0];
                $date = $d[1];
                $insertionRow = array($reportId, $routNumber, $date);
                array_push($insertionData, $insertionRow);
            }
        }
        return $insertionData;
    }

    public function createRouteDetailsReport($reportId) {
        $limit = 50000;
        $result = $this->reportDao->getRegisteredRouteDetailsReportLimitedData($reportId, $limit, $reportId);
        $reportChunk = $this->checkReportChunk($result, $limit, $reportId);
        $routeNumbersToBeDeleted = $this->createRouteDetailsXLSX($reportChunk); //returns data to be deleted
    }

    private function checkReportChunk($reportChunk, $limit, $reportId) {
        if (count($reportChunk) < $limit) {
            $this->reportDao->unregisterRouteDetailsReport($reportId);
            return $reportChunk;
        } else {
            $index = count($reportChunk) - 1;
            $lastRouteNumber = $reportChunk[$index]["route_number"];
            while ($index > -1) {
                $routeNumber = $reportChunk[$index]["route_number"];
                if ($routeNumber != $lastRouteNumber) {
                    array_splice($reportChunk, $index);
                    return $reportChunk;
                }
                $index--;
            }
            return $reportChunk;
        }
    }

    private function createRouteDetailsXLSX($reportChunk): array {
        return array();
    }

}
