<div id="retornoForm" class="retornoForm">
    <!-- Conteúdo -->
    <form action="" id="formulario-retorno" method="post">
        <!-- Cabeçalho do Site (Botão de Voltar e Logo) -->
        <div class="parteCima">
            <!-- Icone de Seta -->
            <i class="fa-solid fa-arrow-left" onclick="formRetorno()"></i>
            <img src="../img/Logotipo-Preto.png" alt="Logo" height="60px">
        </div>

        <p>Nos conte um pouco sobre o que aconteceu com essa lead</p>

        <div class="info">
            <span>Andamento</span>
            <select name="andamento" id="andamento">
                <option value=""></option>
                <option value="1">(Sem Contato) Não consegui contato nenhum com o lead</option>
                <option value="11">(Não Responde) Parou de responder as mensagens e não atende mais as ligações</option>
                <option value="9">(Enviado Mensagem) Liguei e não atendeu, mandei mensagem e estou no aguardo</option>
                <option value="10">(Achou Caro) Achou o nosso serviço muito caro e perdeu o interesse</option>
                <option value="2">(Sem Interesse) Entrei em contato, mas não precisava de nossos serviços</option>
                <option value="3">(Sem Solução) Não foi possível encontrar uma solução ideal para o lead</option>
                <option value="4">(Já Resolveu) Resolveu o problema de alguma outra forma</option>
                <option value="8">(Cliente Lions) Cliente fechado da Lions Associados, não é lead</option>
                <option value="5">(Em aberto) Ainda não passei valores, mas consegui contato</option>
                <option value="6">(Negociação) Passei valores, esperando uma confirmação</option>
            </select>
        </div>

        <div class="info">
            <span>Observação</span>
            <textarea name="observacao" id="observacao"></textarea>
        </div>
        <div class="botao">
            <input type="submit" class="btnRetorno" value="Salvar">
        </div>
    </form>
</div>