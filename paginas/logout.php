    <?php
    // Inicia a sessão se ela já não estiver ativa
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Limpa todas as variáveis salvas na memória
    $_SESSION = array();

    // Destrói a sessão no servidor
    session_destroy();

    // Redireciona o usuário de volta para a tela de login (ajuste o nome do arquivo se for diferente)
    header("Location: login.php");
    exit;
    ?>