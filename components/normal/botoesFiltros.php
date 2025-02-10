<div class="linha filtros consultor">
    <div class="filtrosData">
        <input type="date" name="data" id="filtroData">
    </div>

    <div class="filtrosFase">
        <select name="fase" id="filtroFase">
            <option value="Todos" disabled selected>Fase da Lead</option>
            <option value="Todos">Todas</option>
            <option value="SemRetorno">Novas</option>
            <option value="SemContato">Sem Contato</option>
            <option value="NaoResponde">Parou de Responder</option>
            <option value="Mensagem">Enviado Mensagem</option>
            <option value="EmAberto">Em aberto</option>
            <option value="Negociacao">Cotações</option>
            <option value="Venda">Vendas</option>
            <option value="QuerNada">Não queriam nada</option>
            <option value="AchouCaro">Achou muito caro</option>
            <option value="Regularizado">Já regularizaram</option>
            <option value="SemAjuda">Não podemos ajudar</option>
        </select>
    </div>

    <div class="filtrosSit">
        <select name="situacao" id="filtroSit">
            <option value="" disabled selected>Situação</option>

            <?php
            $situacoes = getSituacoes();
            $i = 1;
            foreach ($situacoes as $situacao) :
                $i++;
            ?>
                <option value="<?php echo $situacao['id_situacao']; ?>"><?php echo $situacao['nome_situacao']; ?></option>

            <?php endforeach ?>
        </select>
    </div>

    <input type="hidden" name="consultor" id="filtroConsultor" value="">

    <input type="hidden" name="origem" id="filtroOrigem" value="">

    <input type="hidden" value="" name="dataFinal" id="filtroDataFinal">

    <button id="botaoFiltrar" onclick="filtrarLeads()">
    <i class="ph ph-bold ph-funnel"></i>
    </button>
</div>