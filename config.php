<?php
    //conectar no banco de dados

    $host = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "brito_estetica";

    try {
          $pdo = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8", $user, $pass);
    } catch (PDOException $e) {
        die("Erro ao conectar" . $e->getMessage());
        
    }
?>