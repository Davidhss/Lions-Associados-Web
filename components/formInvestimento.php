<div id="investimentoForm" class="investimentoForm">
    <!-- Conteúdo -->
    <form action="" id="formulario-investimento" method="post">
        <!-- Cabeçalho do Site (Botão de Voltar e Logo) -->
        <div class="parteCima">
            <!-- Icone de Seta -->
            <i class="fa-solid fa-arrow-left" onclick="formInvestimento()"></i>
            <img src="../img/Logotipo-Preto.png" alt="Logo" height="60px">
        </div>

        <p>Investimento em anúncios</p>

        <div class="info">
            <span>Valor Bruto</span>
            <div class="campo-valor">
                <span class="cifrao">R$</span>
                <input type="text" required autocomplete="off" id="txtValorInvestimento" name="txtValorInvestimento" maxlength="8" placeholder="0000,00">
            </div>
        </div>

        <input type="hidden" name="txtIDinvestimento" value="1">

        <div class="botao">
            <input type="submit" class="btnInvestimento" value="Atualizar">
        </div>
    </form>
</div>