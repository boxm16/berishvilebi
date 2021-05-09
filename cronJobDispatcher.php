<?php

require_once 'Controller/CronJobController.php';

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
        echo "ready<br>";
    }
}
?>