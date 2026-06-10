<?php
include 'config.php';

$sql = "SELECT a.id_agendamento, a.data_hora, c.nome AS cliente_nome,
               s.nome_servico, s.preco
        FROM agendamentos a
        INNER JOIN clientes c ON a.id_cliente = c.id_cliente
        INNER JOIN agendamento_servico ags ON a.id_agendamento = ags.id_agendamento
        INNER JOIN servicos s ON ags.id_servico = s.id_servico
        ORDER BY a.id_agendamento";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    echo "<h2>Agendamentos com Serviços</h2><ul>";
    while($row = $result->fetch_assoc()) {
        echo "<li>Agendamento #" . $row["id_agendamento"] . " - " . $row["data_hora"] .
             " | Cliente: " . $row["cliente_nome"] .
             " | Serviço: " . $row["nome_servico"] . " (R$" . $row["preco"] . ")</li>";
    }
    echo "</ul>";
} else {
    echo "Nenhum agendamento com serviços encontrado ou erro na consulta.";
}
?>
