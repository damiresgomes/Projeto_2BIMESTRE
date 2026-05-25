<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
    <title>Lava Jato Brito</title>

    <base href="#">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:ital,wght@0,100..800;1,100..800&display=swap"
        rel="stylesheet">

    <link rel="shortcut icon" href="#">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">LAVA JATO <span class="brito">BRITO</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    <li class="nav-item">
                        <a class="nav-link" href="home">HOME</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="servicos">SERVIÇOS</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="sobre">SOBRE</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="contato">CONTATO</a>
                    </li>

                </ul>

                <div class="d-flex">
                    <a href="#" class="btn" data-bs-toggle="modal" data-bs-target="#modalLogin">
                        AGENDAMENTO
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main>
        <?php
        if (isset($_GET["param"])) {
            $p = explode("/", $_GET["param"]);
        }

        $page = $p[0] ?? "home";
        $pagina = "paginas/{$page}.php";

        if (file_exists($pagina)) {
            include $pagina;
        } else {
            include "paginas/erro.php";
        }
        ?>
    </main>

    <footer class="footer">
        <div class="container text-center">
            <div class="row">
                <div class="col">
                    <h2>CONTATO</h2>
                    <p>Telefone: (19) 9 1234-4321 <br>
                        Email: contato@lavajatobrito</p>
                </div>

                <div class="col">
                    <h2>HORÁRIOS DE ATENDIMENTO</h2>
                    <p>Segunda a Sexta: 7h - 17h <br>
                        Sábado: 7h - 13h</p>
                </div>

                <div class="col">
                    <h2>ENDEREÇO</h2>
                    <p>Avenida invernada, 1341 <br>
                        Valinhos - São Paulo, SP</p>
                </div>

                <div class="col">
                    <h2>REDES SOCIAIS</h2>
                </div>
            </div>
        </div>

        <p class="rodape text-center">© 2026 Lava Jato Brito. Todos os direitos reservados.</p>
    </footer>

    <div class="modal fade" id="modalLogin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">REALIZE O SEU AGENDAMENTO!</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3">
                        <div class="col-md-6">
                            <label for="nome" class="form-label">Nome Completo</label>
                            <input type="text" class="form-control" id="nome" placeholder="Digite seu nome completo:" required>
                        </div>
                        <div class="col-md-6">
                            <label for="telefone" class="form-label">Telefone</label>
                            <input type="tel" class="form-control" id="telefone" placeholder="(00) 1234-4321" required>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="seu@gmail.com" required>
                        </div>
                        <div class="col-6">
                            <label for="veiculo" class="form-label">Veículo/Placa</label>
                            <input type="text" class="form-control" id="veiculo"
                                placeholder="Digite modelo e placa:" required>
                        </div>
                        
                        <div class="col-md-12">
                            <label for="servico" class="form-label">Serviço Desejado</label>
                            <select id="servico" class="form-select" required>
                                <option>Selecione uma opção</option>
                                <option>Lavagem Simples</option>
                                <option>Lavagem Completa</option>
                        </div>

                        <div class="col-6">
                            <label for="data" class="form-label">Data</label>
                            <input type="date" class="form-control" id="data" required>
                        </div>
                        <div class="col-md-6">
                            <label for="horario" class="form-label">Horários</label>
                            <select id="horario" class="form-select" required>
                                <option>Selecione uma opção</option>
                                <option>8:00</option>
                                <option>9:00</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secodary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary">Enviar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/fslightbox.js"></script>
</body>

</html>