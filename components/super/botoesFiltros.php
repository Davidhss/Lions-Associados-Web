<div class="linha filtros">
    <div class="line-filter up-filter">
        <div class="filtrosOrigem">
            <select name="origem" id="filtroOrigem">
                <option value="" disabled selected>Origem</option>
                <option value="">Todos</option>
                <option value="1">Diario Oficial</option>
                <option value="2">Indicação</option>
                <option value="3">Formulário (Site)</option>
                <option value="4">Whatsapp (Site)</option>
                <option value="6">Facebook</option>
                <option value="7">Instagram</option>
                <option value="8">Meta Ads</option>
                <option value="18">Google Ads</option>
                <option value="9">Ativo</option>
                <option value="10">Disparo (E-mail)</option>
                <option value="14">Disparo (Whatsapp)</option>
                <option value="11">Disparo (SMS)</option>
                <option value="17">Lista Detran</option>
                <option value="12">Outro</option>
            </select>
        </div>
        <div class="filtrosConsultor">
            <select name="consultor" id="filtroConsultor">
                <option value="" disabled selected>Consultor</option>
                <option value="">Todos</option>
                <?php
                $funcionarios = getFuncionariosAll();
                $i = 1;
                foreach ($funcionarios as $funcionario) :
                    $i++;
                ?>
                    <option value="<?php echo $funcionario['id_funcionario']; ?>"><?php echo $funcionario['nome']; ?></option>

                <?php endforeach ?>
            </select>
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
    </div>

    <div class="line-filter down-filter">
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

        <div class="filtrosData">
            <input type="date" name="data" id="filtroData">
        </div>
        <div class="filtrosData">
            <input type="date" name="dataFinal" id="filtroDataFinal">
        </div>

        <div class="btn-filter">
            <button id="botaoFiltrar" onclick="filtrarLeads()">
                <i class="ph ph-bold ph-funnel"></i>
            </button>
        </div>
    </div>


</div>