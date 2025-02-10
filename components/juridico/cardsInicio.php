<?php
$totalLeads = getTotalLeadsDoDia();
$somaVendasIndividuais = getSomaValorIndividualMes($id_funcionario);
$totalVendasIndividuais = getTotalVendasIndividuaisMes($id_funcionario);
?>

<?php

if ($cargo == 6) {

$funcionarios = getFuncionariosCom2();
$i = 1;
foreach ($funcionarios as $funcionario) :
    $i++;
    $somaVendasFuncCom2 = getSomaValorIndividualMes($funcionario['id_funcionario']);
    $totalVendasFuncCom2 = getTotalVendasIndividuaisMes($funcionario['id_funcionario']);
?>

    <h3><?php echo $funcionario['nome']; ?></h3>
    <div class="cards_relatorios">
        <div class="card">
            <div class="principal">
                <span><?php echo $totalVendasFuncCom2; ?></span>
                <div class="detalhe"></div>
            </div>
            <h4>Vendas</h4>
        </div>
        <div class="card">
            <span>R$ <?php echo number_format($somaVendasFuncCom2, 2, ',', '.'); ?></span>
            <h4>Total Vendido no Mês</h4>
        </div>
    </div>
<?php endforeach;
} ?>