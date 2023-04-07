<?php
include("config/dbConfig.php");
try{
    return new PDO($dsn, $dbUsername, $dbPassword);
}
catch(Exception $e){
    die("Bład krytyczny! Nie udało się połączyć z bazą danych.");
}
