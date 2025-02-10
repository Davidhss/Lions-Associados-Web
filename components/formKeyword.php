
<div id="formKeyWord" class="formKeyWord">
    <!-- Conteúdo -->
    <form action="" id="formulario-keyword" method="post">
        <!-- Cabeçalho do Site (Botão de Voltar e Logo) -->
        <div class="parteCima">
            <!-- Icone de Seta -->
            <i class="fa-solid fa-arrow-left" onclick="formKeyword()"></i>
            <img src="../img/Logotipo-Preto.png" alt="Logo" height="60px">
        </div>

        <p>Preencha abaixo para bater ponto:</p>

        <div class="grupo-info">
            <div class="info">
                <span>Palavra-Chave do Dia</span>
                <div class="campo-valor">
                    <input type="text" required autocomplete="off" id="txtNewKeyWord" name="txtNewKeyWord">
                </div>
            </div>
        </div>

        <div class="botao">
            <input type="submit" class="btnPonto presente" value="Cadastrar Palavra-Chave">
        </div>
    </form>
</div>