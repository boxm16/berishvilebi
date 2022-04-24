<?php
session_start();
$message = "";
if (isset($_GET["authorizationResult"])) {
    $authorizationResult = $_GET["authorizationResult"];
    if ($authorizationResult == "fail") {
        $message = "შეყვანილი იყო მომხმარებლის არასწორი სახელი ან პაროლი";
    }
    if ($authorizationResult == "notAuthorized") {
        $message = "ადმინისტრატიული ფუნქციებთან წვდომისთვის აუცილებელია ავტორიზაცია";
    }
}
if (isset($_SESSION["authorized"]) && $_SESSION["authorized"] == "true") {
    header("Location: adminMenu.php?");
    exit;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>ავტორიზაცია</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    </head>
    <body><div class="container">
            <div class="row">
                <div class="col-md-auto">
                    <center><h1>გაიარეთ ავტორიზაცია</h1></center>
                    <hr>
                    <form action="requestDispatcher.php" method="POST">
                        <input hidden name="authorization">
                        <hr>
                        <!-- Email input -->
                        <center>
                            <table>
                                <tr>
                                    <td> <label>მომხმარებლი &nbsp; &nbsp;</label></td>
                                    <td><input value="" name ="username" type="text" /></td>
                                </tr>
                                <tr height="20"></tr>
                                <tr>
                                    <td>  <label>პაროლი</label></td>
                                    <td>        <input value="" name="password" type="password"  /></td>
                                </tr>
                                <tr height="20"></tr>
                                <tr>
                                    <td colspan="2">
                                        <button type="submit" class="btn btn-primary btn-block mb-4">შესვლა</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"><h3 style="color: red"><?php echo $message ?></h3></td>
                                </tr>
                            </table>   <!-- Password input -->

                        </center>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
