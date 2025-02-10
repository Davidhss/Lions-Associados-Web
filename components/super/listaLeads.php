<?php
include "../control/conexao.php";

$leadsTotais = consultarTotalLeadsSuper();

if (isset($_GET['fase']) || isset($_GET['consultor']) || isset($_GET['data']) || isset($_GET['dataFinal']) || isset($_GET['origem']) || isset($_GET['situacao']) || isset($_GET['registros'])) {
    if (isset($_GET['registros'])) {
        if ($_GET['registros'] == 'all'){
            $total_registros = $leadsTotais;
        } else{
            $total_registros = (isset($_GET['registros'])) ? (int)$_GET['registros'] : 10;
        }
    } else {
        $total_registros = $leadsTotais;
    }
} else {
    $total_registros = (isset($_GET['registros'])) ? (int)$_GET['registros'] : 10;
}
$pagina = (isset($_GET['pagina'])) ? (int)$_GET['pagina'] : 1;

$inicio = ($total_registros * $pagina) - $total_registros;

$numero_paginas = $leadsTotais / $total_registros;

if (isset($_GET['pesquisa'])) {
    $campo_pesquisa = $_GET['pesquisa'];
    $campo_tipo = $_GET['tipo'];

    $leads = pesquisaLeadsSuper($campo_tipo, $campo_pesquisa);
} else {
    $leads = consultarLeadsSuper($inicio, $total_registros);
}
?>

<main>
    <div class="partecima supervisor">
        <div class="apresentacao">
            <div class="bem-vindo">
                <h3>Bem-vindo(a) <?php echo $_SESSION['Nome'] ?>!</h3>
                <span><?php echo $desc_cargo; ?></span>
            </div>

            <a href="../control/gerenciador.php?action=sair">
                <i class="fa-solid fa-right-from-bracket"></i> Sair
            </a>
        </div>
    </div>

    <div class="meio">
        <div class="titulo supervisor">
            <h2>Lista de Leads <span id="qtde_leads">(<?php echo $leadsTotais; ?>) - exibindo <?php echo $quantidadeLeads ?></span></h2>
            <div class="botoes_head">
                <div class="infos_head">
                    <div class="dados_head">
                        <a href="./pagInserirLead.php">
                            <button class="add-new">
                                <i class="icon ph-bold ph-plus"></i>
                            </button>
                        </a>
                        <form method="get" class="pesquisa">
                            <button id="btnPesquisa" type="submit"><i class="icon ph-bold ph-magnifying-glass"></i></button>
                            <input type="text" name="pesquisa" id="txtPesquisa" placeholder="Pesquisa..." autocomplete="off">
                            <select name="tipo" id="selectPesquisa">
                                <option value="id_Lead">ID</option>
                                <option value="nome">Nome</option>
                                <option value="celular">Celular</option>
                                <option value="email">Email</option>
                            </select>
                        </form>

                        <select name="paginacao" id="selectPaginacao" onchange="controlaPaginacao()">
                            <option value=""></option>
                            <option value="10">10</option>
                            <option value="50">50</option>
                            <option value="150">150</option>
                            <option value="500">500</option>
                            <option value="all">Todas</option>
                        </select>
                    </div>

                    <div class="linha controle">
                        <div class="resumos_head">
                            <a href="../plataforma/plataformaLions.php?fase=Venda&consultor=<?php echo $id_funcionario; ?>" class="resumo vendas">
                                <span class="num-resumo"><?php $vendas = getQuantiaFase($id_funcionario, 'Venda');
                                                            echo $vendas;
                                                            ?></span> <span class="desc-resumo">Vendas</span>
                            </a>

                            <a href="../plataforma/plataformaLions.php?fase=EmAberto&consultor=<?php echo $id_funcionario; ?>" class="resumo emabertos">
                                <span class="num-resumo"><?php $emaberto = getQuantiaFase($id_funcionario, 'Em Aberto');

                                                            echo $emaberto;
                                                            ?></span> <span class="desc-resumo">Em aberto</span>
                            </a>

                            <a href="../plataforma/plataformaLions.php?fase=Negociacao&consultor=<?php echo $id_funcionario; ?>" class="resumo negociacoes">
                                <span class="num-resumo"><?php $negociacoes = getQuantiaFase($id_funcionario, 'Negociação');

                                                            echo $negociacoes;
                                                            ?></span> <span class="desc-resumo">Negociações</span>
                            </a>

                            <a href="../plataforma/plataformaLions.php?fase=Mensagem&consultor=<?php echo $id_funcionario; ?>" class="resumo negociacoes">
                                <span class="num-resumo"><?php $negociacoes = getQuantiaFase($id_funcionario, 'Enviado Mensagem');

                                                            echo $negociacoes;
                                                            ?></span> <span class="desc-resumo">Mensagens</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="filtragem">
                    <?php include("../components/super/botoesFiltros.php"); ?>
                </div>
            </div>
        </div>
    </div>

    <table>
        <div class="paginacao">
            <?php if ($pagina > 1): ?>
                <a href="?pagina=<?php echo $anterior; ?>">Anterior</a>
            <?php endif;

            if ($pagina < $numero_paginas): ?>
                <a href="?pagina=<?php echo $proximo; ?>">Proximo</a>
            <?php endif; ?>
        </div>
        <thead>
            <tr>
                <th>Lead</th>
                <th>Origem</th>
                <th class="ultima-moficacao">Última Alteração</th>
                <th>Consultor</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($leads as $lead) {
                $idLead = $lead['id_Lead'];
            ?>
                <tr>
                    <td class="campo-nome" data-label="Nome">
                        <a href="pagDetalhesLead.php?id=<?php echo $lead['id_Lead']; ?>">
                            <span class="nome-text"><?php echo $lead['nome']; ?></span>
                            <span class="situacao-lead">

                                <?php
                                echo $lead['celular'];
                                //if ($lead['nome_situacao'] == "" || $lead['nome_situacao'] == NULL) {
                                //    echo "Não Informado";
                                //} else {
                                //    echo $lead['nome_situacao'];
                                //}
                                ?>
                            </span>
                        </a>
                    </td>
                    <!-- <td data-label="Entrada">
                        <?php
                        //$data_mysql = strtotime($lead['data_recebimento']);
                        //$data_formatada = date("d/m", $data_mysql);
                        //echo $data_formatada;
                        ?>
                    </td> -->
                    <td data-label="Origem">
                        <?php echo $lead['nome_origem']; ?>
                    </td>

                    <td class="ultima-modificacao" data-label="Modificação">
                        <?php
                        $data_mod_mysql = strtotime($lead['data_modificacao']);
                        if ($data_mod_mysql == null) {
                            echo "";
                        } else {
                            $data_mod_formatada = date("d/m", $data_mod_mysql);
                            echo $data_mod_formatada;
                        }
                        ?>
                    </td>



                    <td data-label="Atribuicao">
                        <?php
                        if ($lead['cod_funcionario'] == NULL) { ?>
                            <a href="./pagAtribuirLead.php?id_lead=<?php echo $lead['id_Lead']; ?>" class='naoAtribuido'> Não atribuído </a>
                        <?php
                        } else { ?>

                            <a href="./pagAtribuirLead.php?id_lead=<?php echo $lead['id_Lead']; ?>">
                                <?php echo $lead['funcionario']; ?>
                            </a>
                        <?php
                        }
                        ?>
                    </td>
                    <td class="status-lead">
                        <div class="status-card"><?php include("../components/corFaseLead.php"); ?></div>


                        <?php
                        $agendamento = verificarAgendamento($lead['id_Lead']);

                        $data_mod_mysql = strtotime($agendamento);
                        if ($data_mod_mysql == null) {
                            echo "";
                        } else {
                            $data_mod_formatada = date("d/m - H:i", $data_mod_mysql);
                            $data_agendamento_dia = date("d/m", $data_mod_mysql);

                            // Pegar o horário no formato timestamp para comparar no JavaScript
                            $timestamp_agendamento = date("Y-m-d H:i:s", $data_mod_mysql);

                            // Obter a data atual
                            $data_atual = date("d/m"); // Obtém apenas o dia atual no formato ano-mês-dia

                            $classe = ($data_atual === $data_agendamento_dia) ? 'agendamento-hoje' : 'hora_agendamento';

                            echo "<p class='$classe' data-agendamento='$timestamp_agendamento'>$data_mod_formatada</span>";
                        }

                        ?>
                    </td>
                </tr>
            <?php }
            ?>
        </tbody>
    </table>



    <script>
        // Função para piscar o título da aba
        let tituloOriginal = document.title;
        let alertaAtivo = false;
        let intervaloPiscar = null;

        function piscarTitulo(mensagem) {
            if (!alertaAtivo) {
                alertaAtivo = true;
                intervaloPiscar = setInterval(() => {
                    document.title = document.title === tituloOriginal ? mensagem : tituloOriginal;
                }, 1000); // Alterna a cada 1 segundo
            }
        }

        function pararPiscarTitulo() {
            if (alertaAtivo) {
                clearInterval(intervaloPiscar);
                document.title = tituloOriginal; // Restaurar o título original
                alertaAtivo = false;
            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            if (Notification.permission === 'default') {
                Notification.requestPermission().then(permission => {
                    if (permission !== 'granted') {
                        console.log('Permissão para notificações negada.');
                    }
                });
            }

            // Verificar agendamentos atrasados a cada 60 segundos
            setInterval(verificarAgendamentosAtrasados, 20000);

            // Inicia a verificação assim que a página carrega
            verificarAgendamentosAtrasados();
        });

        // Função para verificar se há agendamentos atrasados
        function verificarAgendamentosAtrasados() {
            fetch('../control/verifica_agendamento.php')
                .then(response => response.json())
                .then(data => {
                    if (data.atrasados) {
                        // Pega o primeiro agendamento atrasado da lista
                        const leadAtrasado = data.atrasados[0];

                        mostrarNotificacao(
                            'Agendamento Atingido!',
                            `O lead com ID ${leadAtrasado.cod_lead} tem um agendamento para agora.`
                        );
                        piscarTitulo('⏰ Agendamento Atingido!');

                        // Exibir o modal bloqueando o consultor
                        abrirModalAtrasado(leadAtrasado.cod_lead);
                    }
                })
                .catch(error => {
                    console.error('Erro ao verificar agendamentos atrasados:', error);
                });
        }

        // Função para abrir o modal de agendamento atrasado
        function abrirModalAtrasado(idLead) {
            const modal = document.getElementById('agendamentoAtrasadoModal');
            modal.style.display = 'block';

            // Bloquear a interação com o restante da página
            document.body.style.pointerEvents = 'none';
            modal.style.pointerEvents = 'auto'; // Permite interação apenas com o modal

            // Redirecionar o consultor para a página do lead atrasado após 3 segundos
            setTimeout(function() {
                window.location.href = `../plataforma/pagDetalhesLead.php?id=${idLead}`;
            }, 3000); // Redireciona após 3 segundos
        }

        // Função para mostrar notificação na área de trabalho
        function mostrarNotificacao(titulo, mensagem) {
            if (Notification.permission === 'granted') {
                new Notification(titulo, {
                    body: mensagem,
                    icon: '' // Você pode usar um ícone personalizado aqui
                });
            }
        }
    </script>
</main>