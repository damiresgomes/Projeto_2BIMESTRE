<?php
require "config.php";

$base = "http://" . $_SERVER["SERVER_NAME"] . ":8080". $_SERVER["SCRIPT_NAME"];
//$base = "https://britoesteticaautomotiva.unaux.com/";

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
    <title>Brito Estética Automotiva</title>

    <base href="<?= $base ?>">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:ital,wght@0,100..800;1,100..800&display=swap"
        rel="stylesheet">

    <link rel="shortcut icon" href="imagens/icone.png">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary shadow">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">BRITO <span class="span">ESTÉTICA</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ">

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
                    <a href="agendamento" class="btn-agendamento">
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
                    <p>Telefone: (19) 9 8133-9017<br>
                        Email: contato@lavajatobrito</p>
                </div>

                <div class="col">
                    <h2>HORÁRIOS DE ATENDIMENTO</h2>
                    <p>Segunda a Sexta: 7h - 17h <br>
                        Sábado: 7h - 13h</p>
                </div>

                <div class="col">
                    <h2>ENDEREÇO</h2>
                    <p>Avenida Ana Lombardini Gasparini, 77 <br>
                        Vinhedo - São Paulo, SP</p>
                </div>

                <div class="col">
                    <h2>REDES SOCIAIS</h2>
                    <a href="https://www.instagram.com/brito_esteticaautomotiva_?igsh=NTJ3bml0amxlZ3F4" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                    <a href="https://wa.me/5519981339017" target="_blank"><i class="fa-brands fa-whatsapp"></i></a>
                </div>
            </div>
        </div>

        <p class="rodape text-center">© 2026 Brito Estética Automotiva. Todos os direitos reservados.</p>
    </footer>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/fslightbox.js"></script>
</body>
</html>