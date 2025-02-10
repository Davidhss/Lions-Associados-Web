<?php
$quantidadeLeadsAtribuidas = getQuantidadeLeadsAtribuidas($id_funcionario, $conn);
$quantidadeNegociacoes = getQuantidadeNegociacoes($id_funcionario, $conn);
$quantidadeNovasLeads = getQuantidadeNovasLeads($id_funcionario, $conn);
?>

<div class="cards_relatorios">
    <div class="card">
        <div class="principal">
            <span><?php echo $quantidadeLeadsAtribuidas; ?></span>
            <div class="detalhe"></div>
        </div>
        <h4>Atribuições</h4>
    </div>
    <div class="card">
        <span><?php echo $quantidadeNegociacoes; ?></span>
        <h4>Negociações</h4>
    </div>
    <div class="card">
        <div class="principal">
            <span><?php echo $quantidadeNovasLeads; ?></span>
            <div class="detalhe"></div>
        </div>
        <h4>Novas Leads</h4>
    </div>
</div>