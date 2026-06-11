<div class="container">
  <div class="agendamento">
    <h2>REALIZE SEU <br><span>AGENDAMENTO ONLINE</span></h2>
    <p>Agende um horário para cuidar do seu carro.</p>

    <form id="formAgendamento" class="row g-3" action="paginas/salvar_agendamento.php" method="POST">
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
        <input type="text" class="form-control" id="veiculo" name="veiculo" placeholder="Ex: Corolla Cinza 2022"
          required>
      </div>
      <div class="col-md-12">
        <label for="servico" class="form-label">Selecione um serviço</label>
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
          <input type="checkbox" name="extras[]" value="10" data-preco="200"> Polimento Técnico <br><br>
          <input type="checkbox" name="extras[]" value="11" data-preco="200"> Hidratação de Couro <br><br>
          <input type="checkbox" name="extras[]" value="12" data-preco="200"> Cristalização de Vidros <br><br>
          <input type="checkbox" name="extras[]" value="13" data-preco="400"> Limpeza do Motor <br><br>
          <input type="checkbox" name="extras[]" value="14" data-preco="80"> Cera Líquida <br><br>
        </div>
      </div>

      <div class="col-12">
        <p id="total" class="text-primary mt-3">TOTAL ESTIMADO: R$ 0</p>
      </div>

      <div id="btn-ag" class="col-12 text-center">
        <button type="submit" class="btn btn-primary">CONFIRMAR AGENDAMENTO</button>
      </div>
    </form>

    <script src="https://unpkg.com/imask"></script>
    <script>
      // 1. Aplica a máscara no campo de Telefone/WhatsApp
      const campoTelefone = document.getElementById('telefone');
      const mascaraTelefone = IMask(campoTelefone, {
        mask: '(00) 00000-0000'
      });

      // 2. Aplica a máscara inteligente na Placa (Padrão Antigo e Mercosul)
      const campoPlaca = document.getElementById('placa');
      const mascaraPlaca = IMask(campoPlaca, {
        mask: 'aaa-0[a0]00', // Aceita letra ou número no 5º caractere
        prepare: function (str) {
          return str.toUpperCase(); // Força todas as letras a ficarem maiúsculas
        }
      });
    </script>
    <script>
      const selectServico = document.getElementById('servico');
      const checkboxesExtras = document.querySelectorAll('input[name="extras[]"]');
      const textoTotal = document.getElementById('total');

      function calcularTotal() {
        let total = 0;

        // 1. Pega o preço do serviço selecionado
        const opcaoSelecionada = selectServico.options[selectServico.selectedIndex];
        const precoServico = parseFloat(opcaoSelecionada.getAttribute('data-preco')) || 0;
        total += precoServico;

        // 2. Soma o preço dos extras marcados
        checkboxesExtras.forEach(checkbox => {
          if (checkbox.checked) {
            const precoExtra = parseFloat(checkbox.getAttribute('data-preco')) || 0;
            total += precoExtra;
          }
        });

        // 3. Atualiza o texto na tela formatado como moeda real
        textoTotal.innerHTML = `TOTAL ESTIMADO: R$ ${total.toFixed(2).replace('.', ',')}`;
      }

      // Escuta as mudanças no select e nos checkboxes
      selectServico.addEventListener('change', calcularTotal);
      checkboxesExtras.forEach(checkbox => {
        checkbox.addEventListener('change', calcularTotal);
      });
    </script>
  </div>
</div>