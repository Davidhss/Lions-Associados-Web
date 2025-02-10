<form action="../control/gerenciador.php?action=agendamento" method="post" class="cadastrar-agendamento">
    <div class="titulo-modal">
        <div class="inicio-modal">
            <img src="../img/calendario-img.svg" alt="">
        </div>
    </div>

    <div class="dados-modal">
        <h3>Criar Agendamento</h3>
        <div class="info">
            <label for="txtId">ID</label>
            <input type="text" id="txtId" name="txtId" readonly value="<?php echo $idLead; ?>">
        </div>
        <div class="info">
            <label for="txtConsultor">Consultor (<?php echo $lead['consultor']; ?>)</label>
            <input type="text" id="txtConsultor" name="txtConsultor" autocomplete="off" value="<?php echo $lead['cod_funcionario']; ?>" readonly>
        </div>
        <div class="info">
            <label for="txtDataAgenda">Data</label>
            <input type="datetime-local" autocomplete="off" id="txtDataAgenda" name="txtDataAgenda">
        </div>
        <div class="info">
            <label for="txtDescAgenda">Descrição</label>
            <input type="text" id="txtDescAgenda" name="txtDescAgenda" autocomplete="off">
        </div>
    </div>

    <input type="hidden" name="txtTipoPag" value="<?php echo $tipo; ?>">
    <div class="botoes">
        <a href="" onclick="formAgendamento()" class="cancel-button">Cancelar</a>

        <button type="submit">Criar</button>
    </div>

</form>