<?php
include "../control/conexao.php";
include "../control/functions.php";
include "../control/dados_estatisticas.php";

protecaoPlataforma();

$quantidadeLeads = consultarTotalLeadsSuper();

$negociacoes = count(getQuantiaFasesTotaisMes("Negociação"));
$emaberto = count(getQuantiaFasesTotaisMes("Em Aberto"));
$vendasCom1 = getTotalVendasDepartamento(1);
$vendasCom2 = getTotalVendasDepartamento(2);
$totalSomaVendasComercial1 = getTotalSomaVendasDepartamento(1);
$totalSomaVendasComercial2 = getTotalSomaVendasDepartamento(2);
$somaValorBrutoMes = getSomaValorBrutoMes();
$somaValorLiquidoMes = getSomaValorLiquidoMes();
$somaVendasMeta = somaVendasPorOrigem(8);
$valorInvestimento = getValorInvestimento();
$totalLeadsDia = getTotalLeadsDoDia();
$totalLeadsMes = getTotalLeadsDoMes();
$totalLeadsMetaAdsMes = contarLeadsPorOrigemMes(8);
$metaComercial1 = getMetaDepartamento(1);
$metaComercial2 = getMetaDepartamento(2);

$metaMes = $metaComercial1 + $metaComercial2;
$valorRestanteMes = $metaMes - $somaValorBrutoMes;
$metaSemanal = $metaMes / 4;
$metaDiaria = $metaMes / 22; //Dias Úteis
$oportunidades = $negociacoes + $emaberto + $vendasCom1;
$roas = $somaVendasMeta / $valorInvestimento;
$percentOp = ($oportunidades / $totalLeadsMes['total_leads']) * 100;

$mediaDiaria = calcularMediaDiaria($somaValorBrutoMes, '2024-12-01', ['2024-12-25']);

$cargo = $_SESSION['Cargo'];
$id_funcionario = $_SESSION['Id_Funcionario'];

if (isset($_POST['txtValorInvestimento'])) {
    if (atualizarInvestimento($_POST['txtIDinvestimento'], $_POST['txtValorInvestimento'])) {
        header('Refresh: 0');
    } else {
        echo "Não cadastrado";
    }
}

if (isset($_POST['txtValorMeta'])) {
    if (cadastrarMeta($_POST['txtCodDepartamento'], $_POST['txtValorMeta'], $_POST['txtDataInicioMeta'], $_POST['txtDataFimMeta'], 0)) {
        header('Refresh: 0');
    } else {
        echo "Não cadastrado";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios | Lions Associados</title>

    <!-- Inclusão de ícones usando Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <!-- Inclusão do arquivo de estilo personalizado -->
    <link rel="stylesheet" href="../css/plataforma/style_relatorios.css">
    <link rel="stylesheet" href="../css/plataforma/style_plataformaLions.css">

    <!-- Logo icone web -->
    <link rel="shortcut icon" href="../Logo.ico" type="image/x-icon">

    <script src="../js/script.js"></script>

</head>

<body>
    <?php
    include('../components/navbar.php');
    include('../components/formInvestimento.php');
    include('../components/formMeta.php');

    if ($cargo > 3) {
        echo "Você não tem autorização para acessar essa página.";
    } else {
    ?>


        <main id="pagina-relatorios">
            <div class="partecima supervisor">
                <img src="../img/Logotipo-Preto.png" alt="logo" class="logo">

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
                <div>
                    <div class="infos_head">
                        <h2>Relatório do Mês</h2>

                        <div class="controle-relatorios">
                            <button onclick="formInvestimento()">Investimento</button>
                            <button onclick="formMeta()">Meta</button>
                        </div>
                    </div>

                    <section>
                        <span class="titulo-section">
                            Empresa
                        </span>

                        <div class="group-cards">
                            <div class="card">
                                <div class="card faturamento">
                                    <div class="titulo-card">
                                        Faturamento Bruto
                                    </div>

                                    <div id="valorBruto" class="valor-card">
                                        R$ <?php echo number_format($somaValorBrutoMes, 2, ',', '.') ?>
                                    </div>

                                    <div class="progress">
                                        <div class="progress-done" data - done="80">
                                        </div>
                                    </div>
                                </div>

                                <div class="card faturamento">
                                    <div class="titulo-card">
                                        Faturamento Líquido
                                    </div>

                                    <div id="valorLiquido" class="valor-card">
                                        R$ <?php echo number_format($somaValorLiquidoMes, 2, ',', '.') ?>
                                    </div>
                                </div>
                            </div>


                            <div class="linha1">
                                <div class="card vendas">
                                    <div class="titulo-card">
                                        Vendas Comercial 1
                                    </div>

                                    <div id="qtdeVendas" class="valor-card">
                                        <?php echo $vendasCom1; ?>
                                    </div>
                                </div>

                                <div class="card vendas">
                                    <div class="titulo-card">
                                        Vendas Comercial 2
                                    </div>

                                    <div id="qtdeVendas" class="valor-card">
                                        <?php echo $vendasCom2; ?>
                                    </div>
                                </div>
                                <div class="card orcamentos">
                                    <div class="titulo-card">
                                        Orçamentos
                                    </div>

                                    <div id="qtdeOrcamentos" class="valor-card">
                                        <?php echo $negociacoes; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section>
                        <span class="titulo-section">
                            Metas
                        </span>

                        <div class="group-cards">
                            <div class="linha1">
                                <div class="card faturamento">
                                    <div class="card">
                                        <div class="titulo-card">
                                            Meta Mensal
                                        </div>
                                        <div id="metaMensal" class="valor-card">
                                            R$ <?php echo number_format($metaMes, 2, ',', '.'); ?>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="titulo-card">
                                            Valor Restante
                                        </div>

                                        <div id="valorRestanteMensal" class="valor-card">
                                            R$ <?php echo number_format($valorRestanteMes, 2, ',', '.'); ?>
                                        </div>
                                    </div>
                                </div>



                                <div class="card">
                                    <div class="linha-card">
                                        <div class="coluna">
                                            <div class="titulo-card">
                                                Faturamento Com 1
                                            </div>
                                            <div id="valorRestanteMensal" class="valor">
                                                R$ <?php echo number_format($totalSomaVendasComercial1, 2, ',', '.'); ?>
                                            </div>
                                        </div>
                                        <div class="coluna">
                                            <div class="titulo-card">
                                                Faturamento Com 2
                                            </div>
                                            <div id="valorRestanteMensal" class="valor">
                                                R$ <?php echo number_format($totalSomaVendasComercial2, 2, ',', '.'); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <canvas id="chartVendasDepartamento" width="400" height="100"></canvas>
                                </div>
                            </div>

                            <div class="linha1">
                                <div class="card">
                                    <div class="titulo-card">
                                        Meta Com 1
                                    </div>

                                    <div id="valorRestanteMensal" class="valor-card-chart">
                                        <canvas id="chartMetaCom1" width="150px" height="150px"></canvas>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="titulo-card">
                                        Meta Com 2
                                    </div>

                                    <div id="valorRestanteMensal" class="valor-card-chart">
                                        <canvas id="chartMetaCom2" width="150px" height="150px"></canvas>
                                    </div>
                                </div>

                                <div class="card comercial">
                                    <div class="card">
                                        <div class="titulo-card">
                                            Semanal
                                        </div>
                                        <div id="metaSemanal" class="valor-card">
                                            R$ <?php echo number_format($metaSemanal, 2, ',', '.'); ?>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="titulo-card">
                                            Meta Diária
                                        </div>

                                        <div id="metaDiaria" class="valor-card">
                                            R$ <?php echo number_format($metaDiaria, 2, ',', '.'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="linha1">


                                <div class="card orcamentos">
                                    <div class="titulo-card">
                                        Média Real Diária
                                    </div>

                                    <div id="mediaRealDiaria" class="valor-card">
                                        R$ <?php echo number_format($mediaDiaria, 2, ',', '.') ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section>
                        <span class="titulo-section">
                            Marketing
                        </span>

                        <div class="group-cards">
                            <div class="linha1">
                                <div class="card leads">
                                    <div class="titulo-card">
                                        Leads (Dia)
                                    </div>

                                    <div id="qtdeLeadsDia" class="valor-card">
                                        <?php echo $totalLeadsDia['total_leads']; ?>
                                    </div>
                                </div>

                                <div class="card leads">
                                    <div class="titulo-card">
                                        Total Leads <span class="detalheMetrica">(Meta Ads)</span>
                                    </div>

                                    <div id="qtdeLeadsMeta" class="valor-card">
                                        <?php
                                        echo $totalLeadsMetaAdsMes ?>
                                    </div>
                                </div>

                                <div class="card leads">
                                    <div class="titulo-card">
                                        Total Leads <span class="detalheMetrica">(Mês)</span>
                                    </div>

                                    <div id="qtdeLeadsMes" class="valor-card">
                                        <?php echo $totalLeadsMes['total_leads']; ?>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="titulo-card">
                                        Oportunidades
                                    </div>

                                    <div id="qtdeOportunidades" class="valor-card">
                                        <?php echo $oportunidades; ?>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="titulo-card">
                                        Aproveitamento
                                    </div>

                                    <div id="txAproveitamento" class="valor-card">
                                        <?php echo number_format($percentOp, 1, '.') . "%"; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="linha1">
                                <div class="card investimento">
                                    <div class="titulo-card">
                                        Investimento
                                    </div>

                                    <div id="valorInvestimento" class="valor-card">
                                        R$ <?php echo number_format($valorInvestimento, 2, ',', '.'); ?>
                                    </div>
                                </div>

                                <div class="card comercial">
                                    <div class="titulo-card">
                                        Retorno <span class="detalheMetrica">(Meta Ads)</span>
                                    </div>

                                    <div id="valorRetorno" class="valor-card">
                                        R$ <?php echo number_format($somaVendasMeta, 2, ',', '.'); ?>
                                    </div>
                                </div>

                                <div class="card comercials">
                                    <div class="titulo-card">
                                        ROAS
                                    </div>

                                    <div id="valorROAS" class="valor-card">
                                        <?php echo number_format($roas, 1, '.'); ?>
                                    </div>
                                </div>

                                <div class="card vendas">
                                    <div class="titulo-card">
                                        CPL
                                    </div>

                                    <div id="valorCPL" class="valor-card">
                                        R$ <?php $cpl = $valorInvestimento / $totalLeadsMetaAdsMes;
                                            echo number_format($cpl, 2, ',', '.'); ?>
                                    </div>
                                </div>
                            </div>
                    </section>

                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                    <script>
                        var counter = 0;
                        window.addEventListener("DOMContentLoaded", move = () => {
                            if (counter == 0) {
                                j = 1;
                                var elem = document.querySelector(".progress-done");
                                var width = 0;
                                var main = setInterval(frame, 50);

                                function frame() {
                                    if (width >= <?php
                                                    $percentual = ($metaMes > 0) ? (($somaValorBrutoMes / $metaMes) * 100) : 0;
                                                    echo $percentual; ?>) {
                                        clearInterval(main);
                                    } else {
                                        width++;
                                        elem.style.width = width + "%";
                                        elem.innerHTML = width + "%";
                                    }
                                }
                            }
                        });

                        const ctx = document.getElementById('chartVendasDepartamento');
                        const ctxMetaCom1 = document.getElementById('chartMetaCom1');
                        const ctxMetaCom2 = document.getElementById('chartMetaCom2');

                        new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: ['Com 1', 'Com 2'],
                                datasets: [{
                                    label: 'Valor Vendido R$',
                                    data: [<?php echo $totalSomaVendasComercial1; ?>, <?php echo $totalSomaVendasComercial2; ?>],
                                    backgroundColor: [
                                        'rgba(255, 26, 76, 0.78)',
                                        'rgba(255, 159, 64, 0.2)',
                                    ],
                                    borderColor: [
                                        'rgb(255, 99, 132)',
                                        'rgb(255, 159, 64)',
                                    ],
                                    borderWidth: 1,
                                    borderRadius: 10
                                }]
                            },
                            options: {
                                indexAxis: 'y',
                                scales: {
                                    y: {

                                        grid: {
                                            display: false,
                                        },
                                    },
                                    x: {
                                        display: false, // Remove o eixo X
                                    },
                                },
                                plugins: {
                                    legend: {
                                        display: false, // Desabilita a legenda
                                    },
                                },
                            }
                        });

                        new Chart(ctxMetaCom1, {
                            type: 'doughnut',
                            data: {
                                labels: ['Com 1', 'Meta'],
                                datasets: [{
                                    label: 'Valor R$',
                                    data: [<?php echo $totalSomaVendasComercial1; ?>, <?php echo $metaComercial1 - $totalSomaVendasComercial1; ?>],
                                    backgroundColor: [
                                        'rgba(248, 38, 255, 0.2)',
                                        'rgba(252, 252, 252, 0.2)',
                                    ],
                                    borderColor: [
                                        'rgb(190, 27, 255)',
                                        'rgb(138, 138, 138)',
                                    ],
                                    borderWidth: 1,
                                }]
                            },
                            options: {
                                scales: {
                                    y: {

                                        display: false, // Remove o eixo X
                                    },
                                    x: {
                                        display: false, // Remove o eixo X

                                    },
                                },
                                plugins: {
                                    legend: {
                                        display: false, // Desabilita a legenda
                                    },
                                },
                            }
                        });

                        new Chart(ctxMetaCom2, {
                            type: 'doughnut',
                            data: {
                                labels: ['Com 2', 'Meta'],
                                datasets: [{
                                    label: 'Valor R$',
                                    data: [<?php echo $totalSomaVendasComercial2; ?>, <?php echo $metaComercial2 - $totalSomaVendasComercial2; ?>],
                                    backgroundColor: [
                                        'rgba(253, 19, 19, 0.29)',
                                        'rgba(252, 252, 252, 0.2)',
                                    ],
                                    borderColor: [
                                        'rgb(255, 48, 65)',
                                        'rgb(138, 138, 138)',
                                    ],
                                    borderWidth: 1,
                               }]
                            },
                            options: {
                                scales: {
                                    y: {

                                        display: false, // Remove o eixo X
                                    },
                                    x: {
                                        display: false, // Remove o eixo X

                                    },
                                },
                                plugins: {
                                    legend: {
                                        display: false, // Desabilita a legenda
                                    },
                                },
                            }
                        });
                    </script>
                </div>
        </main>
    <?php } ?>
</body>

</html>