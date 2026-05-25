<div class="container">
<div class="agendamento">
    <h2>REALIZE SEU <br><span>AGENDAMENTO ONLINE</span></h2>
    <p>Agende um horário para cuidar do seu carro.</p>

    <form id="formAgendamento" class="row g-3">
      <div class="col-md-6">
        <label for="nome" class="form-label">Nome Completo</label>
        <input type="text" class="form-control" id="nome" placeholder="Digite seu nome completo" >
      </div>
      <div class="col-md-6">
        <label for="telefone" class="form-label">WhatsApp</label>
        <input type="text" class="form-control" id="telefone" placeholder="(11) 99999-9999" >
      </div>
      <div class="col-md-6">
        <label for="email" class="form-label">E-mail</label>
        <input type="email" class="form-control" id="email" placeholder="seu@email.com" >
      </div>
      <div class="col-md-6">
        <label for="veiculo" class="form-label">Veículo/Placa</label>
        <input type="text" class="form-control" id="veiculo" placeholder="Ex: Corolla Cinza ABC-1234" >
      </div>
      <div class="col-md-12">
        <label for="servico" class="form-label">Selecione um serviço</label>
        <select id="servico" class="form-select" >
          <option>Lavagem Simples - R$ 35</option>
          <option>Lavagem Completa - R$ 60</option>
          <option>Lavagem Premium - R$ 80</option>
          <option>Lavagem Polimento - R$ 100</option>
        </select>
      </div>
      <div class="col-md-6">
        <label for="data" class="form-label">Data</label>
        <input type="date" class="form-control" id="data" >
      </div>
      <div class="col-md-6">
        <label for="horario" class="form-label">Horário</label>
        <select id="horario" class="form-select" >
          <option value="">Selecione um horário</option>
          <option>08:00</option>
          <option>10:00</option>
          <option>14:00</option>
        </select>
      </div>

      <div class="col-12">
        <h4>Acréscimos Opcionais</h4>
        <div class="acrescimos">
          <input type="checkbox" id="polimento" value="90"> Polimento Técnico <br> (+R$ 90)<br>
          <input type="checkbox" id="couro" value="70"> Hidratação de Couro <br>(+R$ 70)<br>
          <input type="checkbox" id="vidros" value="50"> Cristalização de Vidros <br>(+R$ 50)<br>
          <input type="checkbox" id="motor" value="80"> Lavagem do Motor <br>(+R$ 80)<br>
          <input type="checkbox" id="ozonio" value="20"> Cera Líquida (Vonixx) <br>(+R$ 20)<br>
        </div>
      </div>

      <div class="col-12">
        <p id="total">TOTAL ESTIMADO: R$ 35</p>
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

    // função para extrair o preço do serviço selecionado
    function getPrecoServico() {
    const servico = document.getElementById("servico").value;
    // procura número dentro do texto (ex: "Lavagem Completa - R$ 60")
    const match = servico.match(/R\$ ?(\d+)/);
    return match ? parseInt(match[1]) : 0;
  }

    // recalcula total quando marca/desmarca acréscimos
    form.addEventListener("change", () => {
      let soma = getPrecoServico();
      const checkboxes = form.querySelectorAll("input[type=checkbox]");
      checkboxes.forEach(cb => {
        if (cb.checked) soma += parseInt(cb.value);
      });
      total.textContent = "TOTAL ESTIMADO: R$ " + soma;
    });

    // ao enviar o formulário
    form.addEventListener("submit", (e) => {
      e.preventDefault();
      confirmacao.style.display = "block";

    const nome = document.getElementById("nome").value;
    const data = document.getElementById("data").value;
    const horario = document.getElementById("horario").value;

      detalhes.textContent = "Obrigado, " + nome +
        ". Seu agendamento foi reservado para " +
        data + " às " +
        horario + ".";
      
      form.style.display = "none"; // esconde o formulário
    });

    function abrirWhatsapp() {
      window.open("https://wa.me/5511981392929", "_blank");
    }
  </script>
</div>