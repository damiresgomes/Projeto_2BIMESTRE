<div class="container">
  <div class="agendamento">
    <h2>REALIZE SEU <br><span>AGENDAMENTO ONLINE</span></h2>
    <p>Agende um horário para cuidar do seu carro.</p>

    <form id="formAgendamento" class="row g-3" action="paginas/salvar_agendamento.php" method="POST">
      <div class="col-md-6">
        <label for="nome" class="form-label">NOME COMPLETO</label>
        <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite seu nome completo" autocomplete="off" required>
      </div>
      <div class="col-md-6">
        <label for="telefone" class="form-label">WHATSAPP</label>
        <input type="text" class="form-control" id="telefone" name="telefone" placeholder="(11) 99999-9999" autocomplete="off" required>
      </div>
      <div class="col-md-6">
        <label for="placa" class="form-label">PLACA</label>
        <input type="text" class="form-control" id="placa" name="placa" placeholder="ABC-1234" autocomplete="off" required>
      </div>
      <div class="col-md-6">
        <label for="veiculo" class="form-label">VEÍCULO</label>
        <input type="text" class="form-control" id="veiculo" name="veiculo" autocomplete="off" placeholder="Ex: Corolla Cinza 2022"
          required>
      </div>
      <div class="col-md-12">
        <label for="servico" class="form-label">SELECIONE UM SERVIÇO</label>
        <select id="servico" name="servico" class="form-select" required>
          <option value="" data-preco="0">Selecione um serviço</option>
          <option value="1" data-preco="150">Lavagem Detalhada - R$ 150</option>
          <option value="2" data-preco="1200">Higienização Interna Completa - R$ 1200</option>
          <option value="3" data-preco="250">Restauração de Faróis - R$ 250</option>
          <option value="4" data-preco="700">Polimento Comercial - R$ 700</option>
          <option value="5" data-preco="400">Limpeza de Motor - R$ 400</option>
          <option value="6" data-preco="2500">Polimento Técnico + Vitrificação - R$ 2500</option>
          <option value="7" data-preco="700">Vitrificação de Plástico - R$ 700</option>
          <option value="8" data-preco="500">Limpeza de Chassi - R$ 500</option>
          <option value="9" data-preco="800">Higienização dos Bancos - R$ 800</option>
        </select>
      </div>
      <div class="col-md-6">
        <label for="data" class="form-label">DATA</label>
        <input type="date" class="form-control" id="data" name="data" required>
      </div>
      <div class="col-md-6">
        <label for="horario" class="form-label">HORÁRIO</label>
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
        <h4 class="titulo-secao">ACRÉSCIMOS OPCIONAIS</h4>
        <div class="cards-grid">
          <?php
          try {
              $query_extras = "SELECT id_servico, nome_servico, preco FROM servicos WHERE tipo_servico = 'extra'";
              $stmt_extras = $pdo->query($query_extras);
              $extras = $stmt_extras->fetchAll(PDO::FETCH_ASSOC);

              if (count($extras) > 0) {
                  foreach ($extras as $servico) {
                      $id = $servico['id_servico'];
                      $nome = $servico['nome_servico'];
                      $preco_cru = $servico['preco']; 
                      $preco_formatado = number_format($preco_cru, 0, ',', '.');
                      
                      echo '
                      <label class="card-opcao" for="extra_' . $id . '">
                          <input type="checkbox" name="extras[]" value="' . $id . '" data-preco="' . $preco_cru . '" id="extra_' . $id . '" class="checkbox-servico-extra">
                          <div class="card-conteudo">
                              <span class="nome-servico">' . htmlspecialchars($nome) . '</span>
                              <span class="preco-servico">+R$ ' . $preco_formatado . '</span>
                          </div>
                      </label>
                      ';
                  }
              } else {
                  echo '<p class="text-muted">Nenhum acréscimo disponível no momento.</p>';
              }
          } catch (PDOException $e) {
              echo '<p class="text-danger">Erro ao carregar opcionais: ' . htmlspecialchars($e->getMessage()) . '</p>';
          }
          ?>
        </div>
      </div>

      <div class="col-12">
        <p id="total" class="text-primary mt-3">TOTAL ESTIMADO: R$ 0</p>
      </div>

      <div id="btn-ag" class="col-12 text-center">
        <button type="submit" class="btn btn-primary">CONFIRMAR AGENDAMENTO</button>
      </div>
    </form>
    
    <script>
      const selectServico = document.getElementById('servico');
      const textoTotal = document.getElementById('total');

      function calcularTotal() {
        let total = 0;

        const opcaoSelecionada = selectServico.options[selectServico.selectedIndex];
        const precoServico = parseFloat(opcaoSelecionada.getAttribute('data-preco')) || 0;
        total += precoServico;

        const checkboxesExtras = document.querySelectorAll('input[name="extras[]"]');
        checkboxesExtras.forEach(checkbox => {
          if (checkbox.checked) {
            const precoExtra = parseFloat(checkbox.getAttribute('data-preco')) || 0;
            total += precoExtra;
          }
        });

        textoTotal.innerHTML = `TOTAL ESTIMADO: R$ ${total.toFixed(2).replace('.', ',')}`;
      }

      selectServico.addEventListener('change', calcularTotal);
      
      const gridCards = document.querySelector('.cards-grid');
      if (gridCards) {
        gridCards.addEventListener('change', function(e) {
          if(e.target && e.target.name === 'extras[]') {
              calcularTotal();
          }
        });
      }
    </script>

    <script src="https://unpkg.com/imask"></script>
    <script>
      const campoTelefone = document.getElementById('telefone');
      const mascaraTelefone = IMask(campoTelefone, {
        mask: '(00) 00000-0000'
      });

      const campoPlaca = document.getElementById('placa');
      const mascaraPlaca = IMask(campoPlaca, {
        mask: 'aaa-0[a0]00',
        prepare: function (str) {
          return str.toUpperCase();
        }
      });
    </script>
  </div>
</div>