<div class="container">
    <div class="contato">
        <h2>VAMOS CONVERSAR <br> <span>SOBRE O SEU CARRO.</span></h2>
        <p>Tire dúvidas ou peça um orçamento personalizado. Respondemos em poucos minutos.</p>
        <br>

        <form class="row g-3" onsubmit="enviarWhatsApp();">
            <div class="col-md-6">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" placeholder="Seu nome completo" required>
            </div>
            <div class="col-6">
                <label for="telefone" class="form-label">Telefone</label>
                <input type="text" class="form-control"  style="width:190px" id="telefone" placeholder="(19) 9 1234-4321" required>
            </div>
            <div class="col-12">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" placeholder="seu.email@exemplo.com" required>
            </div>
            <div class="col-12">
                <label for="assunto" class="form-label">Assunto</label>
                <input type="text" class="form-control" id="assunto" placeholder="Orçamento, dúvida, agendamento..."
                    required>
            </div>
            <div class="col-12">
                <label for="mensagem" class="form-label">Mensagem</label>
                <textarea class="form-control" placeholder="Conte um pouco sobre o que você precisa..." id="mensagem"
                    style="height: 100px" required></textarea>
            </div>
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-primary">ENVIAR VIA WHATSAPP</button>
            </div>
        </form>
    </div>
    
    <script>
        function enviarWhatsApp() {
            let nome = document.getElementById("nome").value;
            let telefone = document.getElementById("telefone").value;
            let email = document.getElementById("email").value;
            let assunto = document.getElementById("assunto").value;
            let mensagem = document.getElementById("mensagem").value;

            let numeroEmpresa = "5519981339017";

            let texto = `Olá, meu nome é ${nome}. Mensagem: ${mensagem}. Assunto: ${assunto}`;

            let url = `https://wa.me/${numeroEmpresa}?text=${encodeURIComponent(texto)}`;

            window.open(url, '_blank');
        }
    </script>
</div>