<div id="metaForm" class="metaForm">
    <!-- Conteúdo -->
    <form action="" id="formulario-meta" method="post">
        <!-- Cabeçalho do Site (Botão de Voltar e Logo) -->
        <div class="parteCima">
            <!-- Icone de Seta -->
            <i class="fa-solid fa-arrow-left" onclick="formMeta()"></i>
            <img src="../img/Logotipo-Preto.png" alt="Logo" height="60px">
        </div>

        <p>Insira abaixo as metas do mês:</p>
        <div class="info">
                <span>Departamento</span>
                <select name="txtCodDepartamento" required id="txtCodDepartamento">
                    <option value="0"></option>
                    <option value="1">Comercial 1</option>
                    <option value="2">Comercial 2</option>
                </select>
            </div>
       
            

            <div class="info">
                <span>Valor da Meta</span>
                <div class="campo-valor">
                    <span class="cifrao">R$</span>
                    <input type="text" required autocomplete="off" id="txtValorMeta" name="txtValorMeta" maxlength="8" placeholder="0000,00">
                </div>
            </div>
       

        <div class="grupo-info">
            <div class="info">
                <span>Data</span>
                <input type="date" required autocomplete="off" id="txtDataInicioMeta" name="txtDataInicioMeta">
            </div>

            <div class="info">
                <span>Data</span>
                <input type="date" required autocomplete="off" id="txtDataFimMeta" name="txtDataFimMeta">
            </div>
        </div>

        <div class="botao">
            <input type="submit" class="btnMeta" value="Inserir Meta">
        </div>
    </form>
</div>