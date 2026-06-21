<?php

    $host = "192.168.56.101";
    $user = "brito_estetica";
    $pass = "brito28045";
    $dbname = "brito_estetica";

    //$host = "sql111.ezyro.com";
    //$user = "ezyro_42231706";
    //$pass = "brito124578";
    //$dbname = "ezyro_42231706_britoestetica";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Erro ao conectar ao banco de dados: " . $e->getMessage());
    }

?>