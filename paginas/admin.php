<?php
require_once 'config.php';

try {
    $total_agendamentos = $pdo->query("SELECT COUNT(*) FROM agendamentos")->fetchColumn();
    $hoje_atender = $pdo->query("SELECT COUNT(*) FROM agendamentos WHERE DATE(data_hora) = CURDATE()")->fetchColumn();
    $confirmados = $pdo->query("SELECT COUNT(*) FROM agendamentos WHERE data_hora >= NOW()")->fetchColumn();
    $clientes_unicos = $pdo->query("SELECT COUNT(DISTINCT id_cliente) FROM agendamentos")->fetchColumn();

    $receita_total = $pdo->query("SELECT SUM(s.preco) 
                                   FROM agendamentos a 
                                   INNER JOIN agendamento_servico asv ON a.id_agendamento = asv.id_agendamento
                                   INNER JOIN servicos s ON asv.id_servico = s.id_servico
                                   WHERE a.data_hora < NOW()")->fetchColumn() ?? 0;

    $a_receber = $pdo->query("SELECT SUM(s.preco) 
                               FROM agendamentos a 
                               INNER JOIN agendamento_servico asv ON a.id_agendamento = asv.id_agendamento
                               INNER JOIN servicos s ON asv.id_servico = s.id_servico
                               WHERE a.data_hora >= NOW()")->fetchColumn() ?? 0;

    $ticket_medio = $pdo->query("SELECT AVG(sub.total_por_agendamento) FROM (
                                    SELECT SUM(s.preco) as total_por_agendamento
                                    FROM agendamentos a
                                    INNER JOIN agendamento_servico asv ON a.id_agendamento = asv.id_agendamento
                                    INNER JOIN servicos s ON asv.id_servico = s.id_servico
                                    WHERE a.data_hora < NOW()
                                    GROUP BY a.id_agendamento
                                 ) sub")->fetchColumn() ?? 0;

    $finalizados = $pdo->query("SELECT COUNT(*) FROM agendamentos WHERE data_hora < NOW()")->fetchColumn();

    $sql_lista = "SELECT 
                    a.id_agendamento,
                    c.nome AS cliente_nome,
                    c.telefone AS cliente_telefone,
                    a.modelo_veiculo,
                    a.placa_veiculo,
                    a.data_hora,
                    GROUP_CONCAT(s.nome_servico SEPARATOR ' + ') AS todos_servicos,
                    SUM(s.preco) AS valor_total
                  FROM agendamentos a
                  INNER JOIN clientes c ON a.id_cliente = c.id_cliente
                  INNER JOIN agendamento_servico asv ON a.id_agendamento = asv.id_agendamento
                  INNER JOIN servicos s ON asv.id_servico = s.id_servico
                  GROUP BY a.id_agendamento
                  ORDER BY a.data_hora DESC";

    $resultado_lista = $pdo->query($sql_lista)->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erro ao executar consultas: " . $e->getMessage());
}
?>

<div class="container">
    <div class="admin">
        <div class="header-sub">// PAINEL ADMINISTRATIVO</div>
        <div class="header-main">
            <h1>Dashboard</h1>
            <div class="header-buttons">
                <button class="btn-top" onclick="baixarCSV()"><i class="fa-solid fa-download"></i> CSV</button>
                <button class="btn-top" onclick="window.location.reload();"><i class="fa-solid fa-arrows-rotate"></i>
                    Atualizar</button>
                <button class="btn-top btn-sair" onclick="window.location.href='logout.php';"><i
                        class="fa-solid fa-arrow-right-from-bracket"></i> Sair</button>
            </div>
        </div>
        <div class="header-desc">Visão geral dos agendamentos do banco compartilhado.</div>

        <div class="row g-3 mb-4">
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card h-100">
                    <div class="card-top">
                        <span class="card-title">Total</span>
                        <i class="fa-regular fa-calendar card-icon"></i>
                    </div>
                    <div class="card-value"><?php echo $total_agendamentos; ?></div>
                    <div class="card-footer">Agendamentos</div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card h-100">
                    <div class="card-top">
                        <span class="card-title">Hoje</span>
                        <i class="fa-regular fa-clock card-icon"></i>
                    </div>
                    <div class="card-value"><?php echo $hoje_atender; ?></div>
                    <div class="card-footer">Para Atender</div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card h-100">
                    <div class="card-top">
                        <span class="card-title">Futuros</span>
                        <i class="fa-regular fa-circle-check card-icon"></i>
                    </div>
                    <div class="card-value"><?php echo $confirmados; ?></div>
                    <div class="card-footer">Confirmados</div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card h-100">
                    <div class="card-top">
                        <span class="card-title">Clientes</span>
                        <i class="fa-solid fa-users card-icon"></i>
                    </div>
                    <div class="card-value"><?php echo $clientes_unicos; ?></div>
                    <div class="card-footer">Únicos</div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card h-100">
                    <div class="card-top">
                        <span class="card-title">Receita Total</span>
                        <i class="fa-solid fa-dollar-sign card-icon blue-icon"></i>
                    </div>
                    <div class="card-value">R$ <?php echo number_format($receita_total, 2, ',', '.'); ?></div>
                    <div class="card-footer">Bruta</div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card h-100">
                    <div class="card-top">
                        <span class="card-title">A Receber</span>
                        <i class="fa-solid fa-chart-line card-icon blue-icon"></i>
                    </div>
                    <div class="card-value">R$ <?php echo number_format($a_receber, 2, ',', '.'); ?></div>
                    <div class="card-footer">Futuros</div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card h-100">
                    <div class="card-top">
                        <span class="card-title">Ticket Médio</span>
                        <i class="fa-solid fa-dollar-sign card-icon blue-icon"></i>
                    </div>
                    <div class="card-value">R$ <?php echo number_format($ticket_medio, 2, ',', '.'); ?></div>
                    <div class="card-footer">Por Serviço</div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card h-100">
                    <div class="card-top">
                        <span class="card-title">Passados</span>
                        <i class="fa-regular fa-circle-xmark card-icon"></i>
                    </div>
                    <div class="card-value"><?php echo $finalizados; ?></div>
                    <div class="card-footer">Finalizados</div>
                </div>
            </div>
        </div>

        <div class="filter-section">
            <div class="search-container">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" placeholder="Buscar por nome, telefone, veículo, serviço...">
            </div>
            <div class="filter-tabs">
                <button class="tab active">Todos</button>
                <button class="tab">Hoje</button>
                <button class="tab">Futuros</button>
                <button class="tab">Passados</button>
            </div>
        </div>
    </div>

    <?php
    if (!empty($resultado_lista)):
        $agora = time();

        foreach ($resultado_lista as $row):
            $data_do_compromisso = strtotime($row['data_hora']);

            if ($data_do_compromisso < $agora) {
                $status_texto = "Passado";
                $status_classe = "badge-passado";
            } else {
                $status_texto = "Futuro";
                $status_classe = "badge-confirmado";
            }
            ?>
            <div class="booking-card" data-id="<?php echo $row['id_agendamento']; ?>">
                <div class="booking-info">
                    <div class="booking-meta">
                        <span class="meta-id">#<?php echo $row['id_agendamento']; ?></span>
                        <span class="meta-name"><?php echo htmlspecialchars($row['cliente_nome']); ?></span>

                        <span class="badge <?php echo $status_classe; ?>"><?php echo $status_texto; ?></span>

                        <span
                            class="meta-details"><?php echo htmlspecialchars($row['cliente_telefone']) . " • " . htmlspecialchars($row['modelo_veiculo']) . " (" . htmlspecialchars($row['placa_veiculo']) . ")"; ?></span>
                    </div>

                    <div class="booking-service">
                        <?php echo htmlspecialchars($row['todos_servicos']); ?>
                    </div>

                    <div class="booking-time-value">
                        <span class="time"><?php echo date('Y-m-d \à\s H:i', $data_do_compromisso); ?></span>
                        <span class="price">R$ <?php echo number_format($row['valor_total'], 2, ',', '.'); ?></span>
                    </div>
                </div>

                <div class="booking-actions">
                    <button class="btn-action btn-whatsapp"
                        onclick="abrirWhatsapp('<?php echo $row['cliente_telefone']; ?>')"><i class="fa-brands fa-whatsapp"></i>
                        Whatsapp</button>
                    <button class="btn-action btn-editar" onclick="editarAgendamento(<?php echo $row['id_agendamento']; ?>)"><i
                            class="fa-solid fa-pen"></i> Editar</button>
                    <button class="btn-action btn-confirmar"><i class="fa-regular fa-circle-check"></i> Confirmar</button>
                    <button class="btn-action btn-cancelar"><i class="fa-regular fa-circle-xmark"></i> Cancelar</button>
                    <button class="btn-action btn-remover"
                        onclick="removerAgendamento(<?php echo $row['id_agendamento']; ?>)"><i
                            class="fa-regular fa-trash-can"></i> Remover</button>
                </div>
            </div>
        <?php
        endforeach;
    else:
        ?>
        <div class="alert alert-info" style="color: #fff; padding: 15px; background: #1e1e2d; border-radius: 8px;">Nenhum
            agendamento encontrado no banco de dados.</div>
    <?php endif; ?>

</div>

<style>
    .booking-card {
        background-color: #061022;
        border: 1px solid #0b1a30;
        border-radius: 5px;
        padding: 25px;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .booking-info {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .booking-meta {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .meta-id {
        color: blue;
        font-family: 'JetBrains Mono', monospace;
        font-size: 12px;
    }

    .meta-name {
        font-size: 18px;
        font-weight: 800;
        text-transform: uppercase;
    }

    .badge {
        font-size: 9px;
        font-weight: 700;
        padding: 4px 6px;
        border-radius: 2px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .badge-passado {
        background-color: #1a2233;
        color: #718096;
    }

    .badge-novo {
        background-color: #162a2b;
        color: #2dd4bf;
    }

    .meta-details {
        color: #718096;
        font-size: 12px;
    }

    .booking-service {
        font-size: 15px;
        font-weight: 700;
    }

    .booking-service span {
        color: #718096;
        font-weight: 400;
    }

    .booking-time-value {
        font-family: "JetBrains Mono", Arial;
        display: flex;
        align-items: center;
        gap: 15px;
        font-size: 13px;
        color: #718096;
    }

    .booking-time-value .time {
        font-weight: 500;
    }

    .booking-time-value .price {
        color: blue;
        font-weight: 700;
        font-family: 'JetBrains Mono', monospace;
    }

    .booking-time-value .created-at {
        color: #4a5568;
        font-size: 12px;
    }

    .booking-actions {
        display: flex;
        flex-direction: column;
        gap: 8px;
        width: 140px;
    }

    .btn-action {
        width: 100%;
        background-color: transparent;
        border: 1px solid #0f213d;
        color: #ffffff;
        padding: 10px;
        border-radius: 4px;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        gap: 10px;
        transition: all 0.2s ease-in-out;
    }

    .btn-action i {
        font-size: 11px;
        width: 14px;
        text-align: center;
    }

    .btn-action.btn-whatsapp {
        background-color: #359056;
        border-color: #25d366;
        color: #ffffff;
    }

    .btn-action.btn-whatsapp:hover {
        background-color: #128c7e;
        border-color: #128c7e;
    }

    .btn-action.btn-cancelar {
        color: #e52e3d;
        border-color: #0f213d;
    }

    .btn-action.btn-cancelar:hover {
        background-color: #19141d;
        border-color: #3d141d;
        color: #ff3344;
    }

    .btn-action.btn-remover {
        background-color: #e52e3d;
        color: #ffffff;
    }

    .btn-action.btn-remover:hover {
        background-color: #c70011;
        border-color: #e52e3d;
        color: #ffffff;
    }

    .btn-action:not(.btn-whatsapp):not(.btn-cancelar):not(.btn-remover):hover {
        background-color: #0f213d;
        border-color: #1e3a8a;
        color: #ffffff;
    }
</style>

<script>

    function baixarCSV() {
        let csv = [];
        // Cabeçalho do arquivo Excel
        csv.push("ID Agendamento;Cliente;Telefone;Veiculo;Servicos;Data/Hora;Valor Total");

        // Captura os dados diretamente de todos os .booking-card renderizados na tela
        const cards = document.querySelectorAll('.booking-card');

        cards.forEach(card => {
            const id = card.querySelector('.meta-id').innerText.replace('#', '').trim();
            const nome = card.querySelector('.meta-name').innerText.trim();

            // Separa o telefone e o veículo que estão na classe .meta-details
            const detalhesText = card.querySelector('.meta-details').innerText;
            const partes = detalhesText.split(' • ');
            const telefone = partes[0] ? partes[0].trim() : '';
            const veiculo = partes[1] ? partes[1].trim() : '';

            const servico = card.querySelector('.booking-service').innerText.trim();
            const time = card.querySelector('.booking-time-value .time').innerText.trim();
            const preco = card.querySelector('.booking-time-value .price').innerText.replace('R$', '').trim();

            // Monta a linha limpando possíveis pontos e vírgulas textuais para não quebrar as colunas
            csv.push(`${id};${nome};${telefone};${veiculo};${servico};${time};${preco}`);
        });

        // Gera o arquivo para download com suporte a acentos em português (BOM)
        const csv_string = "\uFEFF" + csv.join("\n");
        const blob = new Blob([csv_string], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement("a");

        link.href = URL.createObjectURL(blob);
        link.setHTML(""); // Proteção padrão contra injeções
        link.download = "relatorio_agendamentos.csv";
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    function abrirWhatsapp(telefone) {
        window.open(`https://wa.me/${telefone.replace(/[^0-9]/g, '')}`, '_blank');
    }

    function removerAgendamento(id) {
        if (confirm("Tem certeza que deseja remover este agendamento?")) {
            window.location.href = `remover.php?id=${id}`;
        }
    }

    function editarAgendamento(id) {
        window.location.href = `editar.php?id=${id}`;
    }
</script>