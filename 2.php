<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test DB</title>
</head>
<body>
    <h1>Queries</h1>
    <?php
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=ExecutingCompanies;charset=utf8', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
            catch(PDOException $e) {
            echo "Got error: " . $e->getMessage();
            return;
        }
        $sql = 'select * from OrderStatus';
        $result = $pdo->query($sql);
        /*foreach($result as $row) {
            echo "<p>" . $row['id'] . " | " . $row['Name'] . "</p>";
        }*/
        while($row = $result->fetch(PDO::FETCH_NUM)) {
            echo "<p><b>" . $row[0] . "</b> | " . $row[1] . "</p>";
        }
        ?>
        <h1>Insert</h1>
        <?php
        $fio = 'Иванов Иван Иванович';
        $doc = '7777 888888';
        $st = 0;
        $birth = '1980-01-01';
        $addr = 'New York';
        $phone = '9876543210';
        $email = 'asdfgh';
        $login = 'Ivanov';
        $pwd = '12456';
        /*$sql = 'INSERT INTO Habitants(`FIO`, `Document`, `Status`, `BirthDate`, `AddressReg`, `AddressLive`, `Phone`, `MobilePhone`, `EMail`, `AgreePhone`, `AgreeMail`, `Login`, `Password`)' .
               ' VALUES ({$fio},{$doc},{$st},{$birth},{$addr},{$addr},{$phone},{$phone},{$email},1,1,{$login},{$pwd})';
        $result = $pdo->prepare($sql);*/
        $sql = 'INSERT INTO Habitants(`FIO`, `Document`, `Status`, `BirthDate`, `AddressReg`, `AddressLive`, `Phone`, `MobilePhone`, `EMail`, `AgreePhone`, `AgreeMail`, `Login`, `Password`)' .
               ' VALUES ("' . $fio . '","' . $doc . '","' . $st . '","' . $birth . '","' . $addr . '","' .
                $addr . '","' . $phone . '","' . $phone . '","' . $email . '",1,1,"' . $login . '","' . $pwd . '")';
        $affected = $pdo->exec($sql);
        echo "Inserted <b>" . $affected . "</b> row(s)";
        ?><hr /><?php
        /* Список жильцов определенной УК */
        $sql = 'select `a`.`fio` from CompanyToHabitant b, Habitants a ' .
               'where `b`.`id_Company` = 1 and `b`.`id_Habit` = `a`.`id`';
        $result = $pdo->query($sql);
        while($row = $result->fetch(PDO::FETCH_NUM)) {
            echo "<p><i>" . $row[0] . "</i></p>";
        }
        ?><hr /><?php
        /*Просмотр заявок жильца*/
        $habit = 4;
        $sql = 'select `h`.`fio`, `c`.`name`, `o`.`orderText`, `o`.`createDateTime`, `os`.`name` from Orders o, Habitants h, ManagementCompany c, OrderStatus os' .
               ' where `o`.`id_Habit` = ' . $habit . ' and `h`.`id` = `o`.`id_Habit` and `c`.`id` = `o`.`id_Company` and `o`.`status` = `os`.`id`';
        $result = $pdo->query($sql);
        $first = true;
        while($row = $result->fetch(PDO::FETCH_NUM)) {
            if ($first) {
                echo "<p><b>" . $row[0] . "</b> (" . $row[1] . ")</p>";
                $first = false;
            }
            echo "<p><u>Заявка: " . $row[2] . "</u>" .
                 " дата: " . $row[3] . ", статус: " . $row[4] . "</p>";
        }
    ?>
</body>
</html>