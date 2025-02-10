<main>


    <div class="content">
        <div class="header">
            <div class="linha_head">
                <a href="pagDetalhesLead.php?id=<?php echo $idLead; ?>">
                    <img src="../img/icones/Arrow-Voltar.svg" alt="Voltar">
                </a>
                <div class="titulo">
                    <h1>Editar Lead</h1>
                    <span>Substitua os valores que serão alterados da lead</span>
                </div>
            </div>
            <hr>
        </div>

        <form action="../control/gerenciador.php?action=alterar" method="post">
            <div class="linha">
                <div class="info">
                    <span>Nome</span>
                    <input type="text" name="newNomeLead" id="newNome" value="<?php echo $lead['nome']; ?>">
                </div>
                <div class="info">
                    <span>Celular</span>
                    <input type="text" name="newCelLead" id="newCel" value="<?php echo $lead['celular']; ?>">
                </div>
                <div class="info">
                    <span>E-mail</span>
                    <input type="text" name="newEmailLead" id="newEmail" value="<?php echo $lead['email']; ?>">
                </div>
            </div>
            <div class="linha">
                <div class="info">
                    <span>Situação</span>
                    <select name="newSitLead" id="newSit">
                        <option value="<?php echo $lead['id_situacao']; ?>"> <?php echo $lead['nome_situacao']; ?></option>
                        <option value="11"></option>
                        <option value="1">CNH Suspensa</option>
                        <option value="2">CNH Cassada</option>
                        <option value="3">Renovação</option>
                        <option value="12">Primeira Habilitação</option>
                        <option value="13">Consulta na CNH</option>
                        <option value="4">Reciclagem</option>
                        <option value="5">Bafômetro</option>
                        <option value="6">Pontuação na CNH</option>
                        <option value="7">Problemas com Multas</option>
                        <option value="14">Permissão/Provisória</option>
                        <option value="8">Nome Sujo</option>
                        <option value="9">Divida imobiliaria</option>
                        <option value="10">Outros</option>
                    </select>
                </div>
                <div class="info">
                    <span>Origem</span>
                    <select name="newOrigemLead" id="situacao">
                        <option value="<?php echo $lead['id_origem']; ?>"><?php echo $lead['nome_origem']; ?></option>
                        <option value="12"></option>
                        <option value="1">Diario Oficial</option>
                        <option value="2">Indicação</option>
                        <option value="3">Formulário (Site)</option>
                        <option value="4">Whatsapp (Site)</option>
                        <option value="15">Xlab (Facebook)</option>
                        <option value="16">Xlab (Instagram)</option>
                        <option value="13">Xlab (Google)</option>
                        <option value="6">Facebook</option>
                        <option value="7">Instagram</option>
                        <option value="8">Meta Ads</option>
                        <option value="18">Google Ads</option>
                        <option value="9">Ativo</option>
                        <option value="10">Disparo (E-mail)</option>
                        <option value="14">Disparo (Whatsapp)</option>
                        <option value="11">Disparo (SMS)</option>
                        <option value="17">Lista Detran</option>
                        <option value="19">CreativeLeads</option>
                        <option value="20">Google-X</option>
                        <option value="12">Outro</option>
                    </select>
                </div>
                <div class="info">
                    <span>Melhor Horário</span>
                    <select name="newHorarioLead" id="horario">
                        <option value="<?php echo $lead['cod_horario']; ?>"><?php echo $lead['desc_horario']; ?></option>
                        <option value="4"></option>
                        <option value="1">Manhã (09h às 12h)</option>
                        <option value="2">Tarde (13h às 17h)</option>
                        <option value="3">Noite (18h às 20h)</option>
                    </select>
                </div>
            </div>
            <div class="info">
                <span>Descrição</span>
                <textarea name="newDescLead" id="descLead"><?php echo $lead['desc_problema']; ?></textarea>
            </div>
            <div class="botoes">
                <button type="submit" name="editar_lead" id="enviar">
                    Salvar
                </button>
            </div>
        </form>
    </div>
</main>