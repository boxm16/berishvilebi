<?php
require_once 'Controller/PersonController.php';
if (isset($_POST["insertChild"])) {
    $personController = new PersonController();
    $id = $_POST["id"];
    $parent = $personController->getFullPerson($id);
    $parentFirstName = $parent->getFirstName();
    $parentSecondName = $parent->getSecondName();
    $parentGeneration = $parent->getGeneration();

    $child = new Person();
    $child->setParentId($_POST["id"]);
    $child->setGeneration($parentGeneration + 1);
    $child->setFirstName($_POST["firstName"]);
    $child->setSecondName($_POST["secondName"]);
    $child->setNickname($_POST["nickname"]);
    $child->setLifeStatus($_POST["lifeStatus"]);

    $personController->insertPerson($child);
    $children = $personController->getPersonsChildren($id);
} else if (isset($_GET["id"])) {
    $personController = new PersonController();
    $id = $_GET["id"];
    $parent = $personController->getFullPerson($id);
    $parentFirstName = $parent->getFirstName();
    $parentSecondName = $parent->getSecondName();
    $children = $parent->getChildren();
} else {
    echo "რაცხამ აურია, <a href='index.php'>გადადი საწყის გვერდზე</a>";
    exit;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <h1>შვილის დამატება</h1>
        <h3>მშობელი</h3>
        <?php
        echo "<h3>$parentFirstName $parentSecondName</h3>";
        echo "<br><h3>შვილები</h3><br>";
        foreach ($children as $child) {
            $childFirstName = $child->getFirstName();
            $childSecondName = $child->getSecondName();
            $childNickname = $child->getNickname();
            echo"<h3>$childFirstName $childNickname $childSecondName </h3>";
        }
        ?>
        <hr>
        <h4>შვილის დამატება</h4>
        <form action="addChild.php" method="POST">
            <input name="insertChild" hidden>
            <input name="id" value="<?php echo $id ?>" hidden>
            სახელი <input name="firstName" type="text">

            მეორე სახელი(ზედმეტსახელი) <input name="nickname" type="text">

            გვარი <input name="secondName" type="text" value="ბერიშვილი">
            <br><br>
            სტატუსი <select name="lifeStatus" >
                <option value="alive">ცოცხალი</option>
                <option value="dead">გარდაცვლილი</option>
            </select>
            &nbsp &nbsp
            <button type="submit">დამატება</button>
        </form>



    </body>
</html>
