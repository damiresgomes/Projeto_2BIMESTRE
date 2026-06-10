<?php
include 'config.php';

$sql = "SELECT a.id_agendamento, a.data_hora, a.placa_veiculo, a.modelo_veiculo,
               c.nome AS cliente_nome, c.telefone,
               GROUP_CONCAT(s.nome_servico SEPARATOR ', ') AS servicos
        FROM agendamentos a
        INNER JOIN clientes c ON a.id_cliente = c.id_cliente
        INNER JOIN agendamento_servico ags ON a.id_agendamento = ags.id_agendamento
        INNER JOIN servicos s ON ags.id_servico = s.id_servico
        GROUP BY a.id_agendamento";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    echo "<h2>Agendamentos</h2><table border='1'>";
    echo "<tr><th>ID</th><th>Data/Hora</th><th>Cliente</th><th>Veículo</th><th>Serviços</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id_agendamento"] . "</td>";
        echo "<td>" . $row["data_hora"] . "</td>";
        echo "<td>" . $row["cliente_nome"] . " (" . $row["telefone"] . ")</td>";
        echo "<td>" . $row["placa_veiculo"] . " - " . $row["modelo_veiculo"] . "</td>";
        echo "<td>" . $row["servicos"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Nenhum agendamento encontrado ou erro na consulta.";
}
?>
