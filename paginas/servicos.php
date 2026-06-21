<div class="container">
    <div class="servicos">
        <h1>NOSSOS <span>SERVIÇOS</span></h1>
        <p class="descr">
            Escolha o nível de acabamento ideal para o seu veículo.
        </p>

        <div class="dropdown">
            <button class="btn btn-outline-primary btn-sm d-inline-flex align-items-center gap-1 dropdown-toggle"
                type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                <i class="bi bi-filter-left"></i>
                Preço
            </button>

            <div class="dropdown-menu p-3 shadow-sm" style="min-width: 260px;">
                <div class="d-flex gap-2 align-items-end mb-2">
                    <div>
                        <label class="form-label small text-muted mb-1" style="font-size: 0.75rem;">Mín.</label>
                        <input type="number" id="precoMin" class="form-control form-control-sm" placeholder="R$ 0">
                    </div>
                    <div>
                        <label class="form-label small text-muted mb-1" style="font-size: 0.75rem;">Máx.</label>
                        <input type="number" id="precoMax" class="form-control form-control-sm" placeholder="R$ 500">
                    </div>
                    <button id="btnFiltrar" class="btn btn-primary btn-sm px-3" type="button">Ok</button>
                </div>
            </div>
        </div>

        <div class="row g-4 row-cols-1 row-cols-md-3">
            <?php
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
                <div class="col-12 col-md-4 mb-4 item-servico" data-preco="<?= $dados->preco ?>">
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
                        <button class="btn btn-outline-primary mt-3">
                            <a href="agendamento">AGENDAR AGORA</a>
                        </button>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <script>
        document.getElementById('btnFiltrar').addEventListener('click', function () {
            const precoMinimo = parseFloat(document.getElementById('precoMin').value) || 0;
            const precoMaximo = parseFloat(document.getElementById('precoMax').value) || Infinity;

            const servicos = document.querySelectorAll('.item-servico');

            servicos.forEach(servico => {
                const precoDoServico = parseFloat(servico.getAttribute('data-preco'));

                if (precoDoServico >= precoMinimo && precoDoServico <= precoMaximo) {
                    servico.style.display = 'block';
                } else {
                    servico.style.display = 'none';
                }
            });
        });
    </script>
</div>