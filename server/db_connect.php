<?php

function openConnection(){
    $connStr = "mysql:host=localhost; dbname=cosc360";
    $user = "root";
    $pass = "";
    $pdo = new PDO($connStr, $user, $pass);
    return $pdo;
}

function closeConnection($pdo){
    $pdo = null;
}

?>