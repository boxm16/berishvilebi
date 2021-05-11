<?php
require_once 'Controller/ReportController.php';
$reportController = new ReportController();

if (isset($_POST["routeDetailsReport"]) || isset($_POST["intervalsReport"]) || isset($_POST["excelFormReport"])) {
    $requestedReportsData = $_POST;
    $reportController->registerReports($requestedReportsData);
}
//$reportList = $reportController->getReportList();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>რეპორტები</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col">

                    <nav class="navbar fixed-top navbar-light bg-light">
                        <a class="btn btn-primary" href="index.php" style="font-size: 20px">საწყისი გვერდი</a>


                    </nav>
                </div>
            </div>           
        </div>


    </form>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>
