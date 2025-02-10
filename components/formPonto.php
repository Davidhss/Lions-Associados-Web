<div id="formPonto" class="formPonto">
    <!-- Conteúdo -->
    <form action="" id="formulario-ponto" method="post">
        <!-- Cabeçalho do Site (Botão de Voltar e Logo) -->
        <div class="parteCima">
            <!-- Icone de Seta -->
            <i class="fa-solid fa-arrow-left" onclick="formPonto()"></i>
            <img src="../img/Logotipo-Preto.png" alt="Logo" height="60px">
        </div>

        <p>Preencha abaixo para bater ponto:</p>

        <div class="grupo-info">
            <div class="info">
                <span>Palavra-Chave</span>
                <div class="campo-valor">
                    <input type="text" required autocomplete="off" id="txtKeyWord" name="txtKeyWord">
                </div>
            </div>
        </div>

        <div class="botao">
            <input type="submit" class="btnPonto presente" value="Estou Presente!">
            <?php if ($cargo == 1 || $cargo == 2): ?>
            <div class="comandosPonto">
                <button class="btnPonto comands" onclick="formKeyword()"><i class="ph-bold ph-key"></i> CADASTRAR</button>
                <button class="btnPonto comands" onclick="window.location='pagPontos.php';"><i class="ph-bold ph-list-bullets"></i> REGISTROS</button>
            </div>
            <?php endif; ?>
        </div>
    </form>
</div>