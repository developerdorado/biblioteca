<?php
$database = "biblioteca";
$hostname = "localhost";
$usuario = "root";
$pass = '';

$servidor = "mysql:dbname=$database;host=127.0.0.1";

try{
   $pdo = new PDO($servidor,$usuario,$pass, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8"));
}catch(PDOException $e){
    echo "No se puede conectar".$e->getMessage();
}