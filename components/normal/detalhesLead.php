<?php include "../components/formRetorno.php"; 
    include "../components/formVenda.php"; ?>

<main id="lead">
    <div class="Lead">
        <?php
        ?>
        <div class="headLead">
            <div class="info_controle">
                <div class="andamento">
                    <div class="infoGeral">
                        <a href="./plataformaLions.php">
                            <img src="../img/icones/Arrow-Voltar.svg" alt="Voltar">
                        </a>

                        <div class="info_principais">
                            <h1>
                                <?php echo $lead['nome']; ?>
                            </h1>
                            <span>Cadastrada em <?php echo $data_formatada; ?></span>
                        </div>
                    </div>
                </div>
                <div class="acoes">
                <?php if (procuraAgendamentosLead($idLead)): ?>
                        <a href="#" class="editar" onclick="formAgendamento()">
                            <div class="icone_cabecalho"><i class="fa-regular fa-calendar"></i></div>

                            <span>Agendar</span>
                        </a>
                    <?php else: ?>
                        <?php
                        $agendamento = verificarAgendamento($idLead);

                        $data_mod_mysql = strtotime($agendamento);
                        if ($data_mod_mysql == null) {
                            echo "";
                        } else {
                            $data_mod_formatada = date("d/m - H:i", $data_mod_mysql);
                            
                            echo "<span class='agendado' onclick='formAgendamento()'>$data_mod_formatada</span>";
                        }

                        ?>
                    <?php endif; ?>
                    <a href="javascript:formVenda();" class="retorno">
                        <div class="icone_cabecalho"><i class="fa-solid fa-circle-dollar-to-slot"></i></div>

                        <span>Venda</span>
                    </a>

                    <a href="javascript:formRetorno();" class="retorno">
                        <div class="icone_cabecalho"><i class="fa-solid fa-note-sticky"></i></div>

                        <span>Retorno</span>
                    </a>

                    <a href="./pagEditarLead.php?id=<?php echo $idLead; ?>" class="editar">
                        <div class="icone_cabecalho"><i class="fa-solid fa-pen-to-square"></i></div>

                        <span>Editar</span>
                    </a>
                </div>
            </div>

            <hr>
        </div>

        <div class="contentLead">
            <div class="bloco info">
                <h3>Informações</h3>
                <div class="quadro">
                    <div class="info">
                        <span class="titulo_info">ID</span>
                        <p><?php echo $idLead; ?></p>
                    </div>
                    <div class="info">
                        <span class="titulo_info">EMAIL</span>
                        <p><?php echo $lead['email']; ?></p>
                    </div>
                    <div class="info">
                        <span class="titulo_info">CELULAR</span>
                        <p><?php echo $lead['celular']; ?></p>
                    </div>
                    <div class="info">
                        <span class="titulo_info">MELHOR HORÁRIO</span>
                        <p><?php consultarMelhorHorarioLead($lead["cod_horario"])?></p>
                    </div>
                </div>
            </div>

            <div class="origem">
                <div class="quadro">
                    <div class="info_origem">
                        <?php include("../components/origemLead.php"); ?>

                        <span class="titulo_info">
                            <?php
                            echo $lead['nome_origem']
                            ?>
                        </span>
                    </div>
                </div>
            </div>


            <div class="bloco situacao">
                <h3>Situação</h3>
                <div class="quadro">
                    <div class="sit">
                        <span class="titulo_info">PROBLEMA</span>
                        <p><?php echo $lead['nome_situacao'] ?></p>
                    </div>
                    <div class="sit">
                        <span class="titulo_info">DESCRIÇÃO</span>
                        <p><?php echo $lead['desc_problema']; ?></p>
                    </div>
                </div>


            </div>

            <div class="bloco consultor">
                <div class="quadro">
                    <div class="con">
                        <span class="titulo_info">CONSULTOR</span>
                        <p><?php echo $lead['consultor'] ?></p>
                    </div>
                </div>
            </div>

            <div class="bloco observacao">
                <div class="quadro">
                    <span class="titulo_info">OBSERVAÇÕES</span>
                    <?php consultarRetornosLead($idLead) ?>
                </div>
            </div>
        </div>
    </div>
</main>