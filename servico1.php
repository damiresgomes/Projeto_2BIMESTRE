<?php
include 'config.php';

$sql = "SELECT nome_servico, descricao, preco FROM servicos";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>Serviços disponíveis</h2><ul>";
    while($row = $result->fetch_assoc()) {
        echo "<li><b>" . $row["nome_servico"] . "</b> - " 
             . $row["descricao"] . " | R$" . $row["preco"] . "</li>";
    }
    echo "</ul>";
} else {
    echo "Nenhum serviço encontrado.";
}
?>
