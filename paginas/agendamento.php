<?php
include 'config.php';

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome     = $_POST["nome"];
    $telefone = $_POST["telefone"];
    $placa    = $_POST["placa"];
    $veiculo  = $_POST["veiculo"];
    $data     = $_POST["data"];
    $horario  = $_POST["horario"];
    $servico  = $_POST["servico"];
    $extras   = isset($_POST["extras"]) ? $_POST["extras"] : [];

    $sql_cliente = "INSERT INTO clientes (nome, telefone) VALUES ('$nome', '$telefone')";
    if ($conn->query($sql_cliente) === TRUE) {
        $id_cliente = $conn->insert_id;

        $data_hora = $data . " " . $horario;
        $sql_agendamento = "INSERT INTO agendamentos (id_cliente, data_hora, placa_veiculo, modelo_veiculo)
                            VALUES ('$id_cliente', '$data_hora', '$placa', '$veiculo')";
        if ($conn->query($sql_agendamento) === TRUE) {
            $id_agendamento = $conn->insert_id;

            $conn->query("INSERT INTO agendamento_servico (id_agendamento, id_servico)
                          VALUES ('$id_agendamento', '$servico')");

            foreach ($extras as $id_servico_extra) {
                $conn->query("INSERT INTO agendamento_servico (id_agendamento, id_servico)
                              VALUES ('$id_agendamento', '$id_servico_extra')");
            }

            echo "<p style='color:green'>Agendamento salvo com sucesso!</p>";
        } else {
            echo "Erro ao salvar agendamento: " . $conn->error;
        }
    } else {
        echo "Erro ao salvar cliente: " . $conn->error;
    }
}
?>

<div class="container">
<div class="agendamento">
    <h2>REALIZE SEU <br><span>AGENDAMENTO ONLINE</span></h2>
    <p>Agende um horário para cuidar do seu carro.</p>

    <form id="formAgendamento" class="row g-3" action="agendamento.php" method="post">
      <div class="col-md-6">
        <label for="nome" class="form-label">Nome Completo</label>
        <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite seu nome completo" required>
      </div>
      <div class="col-md-6">
        <label for="telefone" class="form-label">WhatsApp</label>
        <input type="text" class="form-control" id="telefone" name="telefone" placeholder="(11) 99999-9999" required>
      </div>
      <div class="col-md-6">
        <label for="placa" class="form-label">Placa</label>
        <input type="text" class="form-control" id="placa" name="placa" placeholder="ABC-1234" required>
      </div>
      <div class="col-md-6">
        <label for="veiculo" class="form-label">Veículo</label>
        <input type="text" class="form-control" id="veiculo" name="veiculo" placeholder="Ex: Corolla Cinza 2022" required>
      </div>
      <div class="col-md-12">
        <label for="servico" class="form-label">Selecione um serviço</label>
        <select id="servico" name="servico" class="form-select" required>
          <option value="">Selecione um serviço</option>
          <option value="1">Lavagem Detalhada - R$ 80 - 150</option>
          <option value="2">Higienização Interna Completa - R$ 600 - 1200</option>
          <option value="3">Restauração de Faróis - R$ 120 - 250</option>
          <option value="4">Polimento Comercial - R$ 350 - 700</option>
          <option value="5">Limpeza de Motor - R$ 180 - 400</option>
          <option value="6">Polimento Técnico + Vitrificação - R$ 1200 - 3000</option>
          <option value="7">Vitrificação de Plástico - R$ 450 - 900</option>
          <option value="8">Limpeza de Chassi - R$ 200 - 500</option>
          <option value="9">Higienização dos Bancos - R$ 350 - 800</option>
        </select>
      </div>
      <div class="col-md-6">
        <label for="data" class="form-label">Data</label>
        <input type="date" class="form-control" id="data" name="data" required>
      </div>
      <div class="col-md-6">
        <label for="horario" class="form-label">Horário</label>
        <select id="horario" name="horario" class="form-select" required>
          <option value="">Selecione um horário</option>
          <option>08:00</option>
          <option>08:30</option>
          <option>09:00</option>
          <option>09:30</option>
          <option>10:00</option>
          <option>10:30</option>
          <option>11:00</option>
          <option>11:30</option>
          <option>12:00</option>
          <option>12:30</option>
          <option>13:00</option>
          <option>13:30</option>
          <option>14:00</option>
          <option>14:30</option>
          <option>15:00</option>
          <option>15:30</option>
          <option>16:00</option>
          <option>16:30</option>
          <option>17:00</option>
          <option>17:30</option>
        </select>
      </div>

      <div class="col-12">
        <h4>Acréscimos Opcionais</h4>
        <div class="acrescimos">
          <input type="checkbox" name="extras[]" value="10"> Polimento Técnico <br><br>
          <input type="checkbox" name="extras[]" value="11"> Hidratação de Couro <br><br>
          <input type="checkbox" name="extras[]" value="12"> Cristalização de Vidros <br><br>
          <input type="checkbox" name="extras[]" value="13"> Limpeza do Motor <br><br>
          <input type="checkbox" name="extras[]" value="14"> Cera Líquida <br><br>
        </div>
      </div>

      <div class="col-12">
        <p id="total">TOTAL ESTIMADO: R$ 0</p>
      </div>

      <div id="btn-ag" class="col-12 text-center">
        <button type="submit" class="btn btn-primary">CONFIRMAR AGENDAMENTO</button>
      </div>
    </form>

    <div id="confirmacao" class="mt-4 text-success text-center" style="display:none;">
      <h3>AGENDAMENTO CONFIRMADO!</h3>
      <p id="detalhes" class="text-center"></p>
      <button onclick="abrirWhatsapp()" class="btn btn-success">FALAR NO WHATSAPP</button>
      <button onclick="location.reload()" class="btn btn-secondary">NOVO AGENDAMENTO</button>
    </div>
  </div>

    <script>
    const form = document.getElementById("formAgendamento");
    const total = document.getElementById("total");
    const confirmacao = document.getElementById("confirmacao");
    const detalhes = document.getElementById("detalhes");

    function PrecoServico() {
      return parseInt(document.getElementById("servico").value) || 0;
    }

    form.addEventListener("change", () => {
      let soma = PrecoServico();
      const checkboxes = form.querySelectorAll("input[type=checkbox]");

      checkboxes.forEach(cb => {
        if (cb.checked) soma += parseInt(cb.value);
      });

      total.textContent = "TOTAL ESTIMADO: R$ " + soma;
    });

    form.addEventListener("submit", (e) => {
      e.preventDefault();
      confirmacao.style.display = "block";

    const nome = document.getElementById("nome").value;
    const data = document.getElementById("data").value;
    const horario = document.getElementById("horario").value;

      detalhes.textContent = "Obrigado, " + nome +
        ". Seu agendamento foi reservado para " +
        data + " às " + horario + ".";
      
      form.style.display = "none";
      
    });

    function abrirWhatsapp() {
      window.open("https://wa.me/5511981392929", "_blank");
    }
  </script>
</div>
