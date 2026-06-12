<?php
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = trim($_POST['nome']);
    $telefone = trim($_POST['telefone']);
    $placa = trim($_POST['placa']);
    $veiculo = trim($_POST['veiculo']);
    $servico_principal_id = trim($_POST['servico']);
    $data = trim($_POST['data']);
    $horario = trim($_POST['horario']);
    

    $extras_selecionados = isset($_POST['extras']) ? $_POST['extras'] : [];
    
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
        $id_agendamento = $pdo->lastInsertId();

        $sql_vinculo = "INSERT INTO agendamento_servico (id_agendamento, id_servico) VALUES (:id_agendamento, :id_servico)";
        $stmt_vinculo = $pdo->prepare($sql_vinculo);
        $stmt_vinculo->bindParam(':id_agendamento', $id_agendamento);
        $stmt_vinculo->bindParam(':id_servico', $servico_principal_id);
        $stmt_vinculo->execute();

        if (!empty($extras_selecionados)) {
            foreach ($extras_selecionados as $id_extra) {
                $stmt_vinculo->bindParam(':id_servico', $id_extra);
                $stmt_vinculo->execute();
            }
        }

        $stmt_busca_princ = $pdo->prepare("SELECT nome_servico FROM servicos WHERE id_servico = :id");
        $stmt_busca_princ->execute([':id' => $servico_principal_id]);
        $nome_servico_principal = $stmt_busca_princ->fetchColumn();

        $nomes_extras = [];
        if (!empty($extras_selecionados)) {
            $placeholders = implode(',', array_fill(0, count($extras_selecionados), '?'));
            $stmt_busca_ext = $pdo->prepare("SELECT nome_servico FROM servicos WHERE id_servico IN ($placeholders)");
            $stmt_busca_ext->execute($extras_selecionados);
            $nomes_extras = $stmt_busca_ext->fetchAll(PDO::FETCH_COLUMN);
        }

        $pdo->commit();

        $numero_whatsapp = "5519981392929";
        $texto_mensagem = "*Agendamento Solicitado!* 🚗✨\n\n";
        $texto_mensagem .= "Olá! Gostaria de confirmar o meu agendamento na estética.\n\n";
        $texto_mensagem .= "*Detalhes do Pedido:*\n";
        $texto_mensagem .= "*Cliente:* " . $nome . "\n";
        $texto_mensagem .= "*Telefone:* " . $telefone . "\n";
        $texto_mensagem .= "*Veículo:* " . $veiculo . " (Placa: " . $placa . ")\n";
        $texto_mensagem .= "*Serviço Principal:* " . $nome_servico_principal . "\n";

        if (!empty($nomes_extras)) {
            $texto_mensagem .= "*Acréscimos Opcionais:*\n";
            foreach ($nomes_extras as $nome_extra) {
                $texto_mensagem .= "  - " . $nome_extra . "\n";
            }
        }

        $texto_mensagem .= "*Data e Horário:* " . date('d/m/Y', strtotime($data)) . " às " . $horario . "\n\n";
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