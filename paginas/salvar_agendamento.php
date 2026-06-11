<?php
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $nome = trim($_POST['nome']);
    $telefone = trim($_POST['telefone']);
    $placa = trim($_POST['placa']);
    $veiculo = trim($_POST['veiculo']);
    $servico = trim($_POST['servico']);
    $data = trim($_POST['data']);
    $horario = trim($_POST['horario']);
    
    $data_hora = $data . ' ' . $horario . ':00';

    try {
        $pdo->beginTransaction();

        $sql_cliente = "INSERT INTO clientes (nome, telefone) VALUES (:nome, :telefone)";
        $stmt_cliente = $pdo->prepare($sql_cliente);
        $stmt_cliente->bindParam(':nome', $nome);
        $stmt_cliente->bindParam(':telefone', $telefone);
        $stmt_cliente->execute();
        $id_cliente = $pdo->lastInsertId();


        $sql_agendamento = "INSERT INTO agendamentos (data_hora, placa_veiculo, modelo_veiculo, id_cliente) 
                VALUES (:data_hora, :placa_veiculo, :modelo_veiculo, :id_cliente)";
        $stmt_agendamento = $pdo->prepare($sql_agendamento);
        $stmt_agendamento->bindParam(':data_hora', $data_hora);
        $stmt_agendamento->bindParam(':placa_veiculo', $placa);
        $stmt_agendamento->bindParam(':modelo_veiculo', $veiculo);
        $stmt_agendamento->bindParam(':id_cliente', $id_cliente);
        $stmt_agendamento->execute();

        $pdo->commit();



        $numero_whatsapp = "5519981392929";
        $texto_mensagem = "*Agendamento Solicitado!* 🚗✨\n\n";
        $texto_mensagem .= "Olá! Gostaria de confirmar o meu agendamento na estética.\n\n";
        $texto_mensagem .= "*Detalhes do Pedido: *\n";
        $texto_mensagem .= "*Cliente:* " . $nome . "\n";
        $texto_mensagem .= "*Telefone:* " . $telefone . "\n";
        $texto_mensagem .= "*Veículo:* " . $veiculo . " (Placa: " . $placa . ")\n";
        $texto_mensagem .= "*Data e Horário:* " . $data . " às " . $horario . "\n\n";
        $texto_mensagem .= "_Aguardo a confirmação de vocês! Obrigada(o)._";

        $texto_url = urlencode($texto_mensagem);

        $link_whatsapp = "https://api.whatsapp.com/send?phone=" . $numero_whatsapp . "&text=" . $texto_url;

        echo "<script>
                window.location.href = '" . $link_whatsapp . "';
              </script>";

    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "Erro no banco de dados: " . $e->getMessage();
    }
}
?>