<?php
function openConnection(){
    $connString = "mysql:host=localhost; dbname=cosc360";
    $user="root";
    $pass="";
    $pdo=new PDO($connString, $user, $pass);
    return $pdo; //important to return the connection
}
function closeConnection($pdo){
    $pdo=null;
}
?>
