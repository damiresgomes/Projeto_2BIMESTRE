<?php
$servername = "10.0.2.15";
$username = "britoesteticca";
$password = "brito28045";
$dbname = "projeto2bimestre";

//criar conexão usando MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

//verificar conexão
if ($conn->connect_error){
    die("Falha na conexão: " . $conn->connect_error);
    }
    echo "Conectado com sucesso ao banco externo!";
?>