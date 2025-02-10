<?php
$totalLeads = getTotalLeadsDoDia();
$totalLeadsAtribuidas = getTotalLeadsAtribuidasDoDia();
$totalVendas = getTotalVendasDoDia();
?>

<div class="cards_relatorios">
    <div class="card">
        <div class="principal">
            <span><?php echo $totalLeads['total_leads']; ?></span>
            <div class="detalhe"></div>
        </div>
        <h4>Leads</h4>
    </div>
    <div class="card">
        <span><?php echo $totalLeadsAtribuidas['total_leads_atribuidas']; ?></span>
        <h4>Atribuídas</h4>
    </div>
    <div class="card">
        <div class="principal">
            <span><?php echo $totalVendas['total_vendas']; ?></span>
            <div class="detalhe"></div>
        </div>
        <h4>Vendas</h4>
    </div>
</div>