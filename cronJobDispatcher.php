<?php

require_once 'Controller/CronJobController.php';
require_once 'Controller/ReportController.php';
$s = microtime(true);
$cronJobController = new CronJobController();
if (isset($_GET["uploadingStatusRequest"])) {//this request comes from index.php ajax every second
    if ($cronJobController->getUploadingStatus()) {
        echo "uploading";
    } else {
        echo "ready<br>";
    }
} else {//this request comes mainly from cronJob site evrey minute
    if ($cronJobController->getUploadingStatus()) {
        echo "uploading...<br>";
        $cronJobController->insertNextChunk();
    } else {
        $ids = $cronJobController->getRouteDetailsReportIds();
        if (count($ids) > 0) {
            echo "creating Route Details Report...<br>";
            $reportController = new ReportController();
            $reportId = $ids[0];
            $reportController->createRouteDetailsReport($reportId);
        } else {
            echo "ready<br>";
        }
    }
}
$e = microtime(true);
echo "<br> Display time required:" . ($e - $s);
