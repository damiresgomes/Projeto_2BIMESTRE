<?php
$servername = "192.168.1.100";  //IP do Servidor
$username = "usuario_remoto";
$password = "senha_segura";
$dbname = "meu_banco_de_dados";

//criar conexão usando MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

//verificar conexão
if ($conn->connect_error){
    die("Falha na conexão: " . $conn->connect_error);
    }
    echo "Conectado com sucesso ao banco externo!";
?>