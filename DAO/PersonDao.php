<?php

class PersonDao {

    public function insertPerson($person) {

        $generation = $person->getGeneration();
        $firstName = $person->getFirstName();
        $secondName = $person->getSecondName();

        $nickname = $person->getNickname();
        $birthDate = $person->getBirthDate();
        $deathDate = $person->getDeathDate();

        $sql = "INSERT INTO person (generation, first_name, second_name, nickname, birth_date, death_date ) VALUES (:generation, :firstName , :secondName, :nickname, :birthDate, :deathDate)";


        $statement = $this->connection->prepare($sql);

        $statement->bindValue(':generation', $generation);
        $statement->bindValue(':firstName', $firstName);
        $statement->bindValue(':secondName', $secondName);

        $statement->bindValue(':nickname', $nickname);
        $statement->bindValue(':birthDate', $birthDate);
        $statement->bindValue(':deathDate', $deathDate);


        $inserted = $statement->execute();


        if ($inserted) {
            echo 'Person Inserted!<br>';
        }
    }

}
