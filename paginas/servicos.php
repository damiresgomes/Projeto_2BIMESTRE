<div class="container">
    <div class="servicos">
        <h1>NOSSOS <span>SERVIÇOS</span></h1>
        <p class="descr">
            Escolha o nível de acabamento ideal para o seu veículo.
            Toque no + para ver os acréscimos disponíveis.
        </p>

        <div class="row">
            <?php
            // Ajuste os nomes das colunas conforme estão no seu banco
            $sqlServicos = "SELECT nome_servico, preco, descricao, duracao_horas 
                            FROM servicos 
                            WHERE tipo_servico = 'principal' 
                            ORDER BY RAND() 
                            LIMIT 9";

            $consulta = $pdo->prepare($sqlServicos);
            $consulta->execute();

            $dadosServicos = $consulta->fetchAll(PDO::FETCH_OBJ);

            foreach ($dadosServicos as $dados) {
                ?>
                <div class="col-12 col-md-4 mb-4">
                    <div class="card shadow p-4 h-100">
                        <h3><?= $dados->nome_servico ?></h3>
                        <div class="preco">
                            <p>R$ </p>
                            <h4><?= number_format($dados->preco, 2, ',', '.') ?></h4>
                        </div>
                        <p><?= $dados->descricao ?></p>
                        <?php
                        $horas = floor($dados->duracao_horas);
                        $minutos = ($dados->duracao_horas - $horas) * 60;

                        $duracaoFormatada = $horas . "h";
                        if ($minutos > 0) {
                            $duracaoFormatada .= " " . round($minutos) . "m";
                        }
                        ?>
                        <h6 class="duracao"><i class="fa fa-clock"></i> <?= $duracaoFormatada ?></h6>
                        <button class="btn btn-outline-primary mt-3">AGENDAR AGORA</button>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>