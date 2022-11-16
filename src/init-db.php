<?php
try {
    $dbh = new PDO("mysql:host=php_homework;dbname=php_homework", "tars", "tars");
    // вибірка всіх записів
    $data = $dbh->query('SELECT * from first')->fetchAll(PDO::FETCH_ASSOC);

    // вибірка одного запису по визначеній умові
    $data = $dbh->query('SELECT * from first WHERE id = 1')->fetch(PDO::FETCH_ASSOC);

    // вибірка одного запису по визначеній умові, через підготовлені запити
    $sth = $dbh->prepare('SELECT * from first WHERE id = :id');
    $sth->execute(['id' => 1]);
    $data = $sth->fetch(PDO::FETCH_ASSOC);

    $dbh = null;
} catch(PDOException $e) {
    echo $e->getMessage();
}
