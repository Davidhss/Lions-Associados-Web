<div id="vendaForm" class="vendaForm">
    <!-- Conteúdo -->
    <form action="" id="formulario-venda" method="post">
        <!-- Cabeçalho do Site (Botão de Voltar e Logo) -->
        <div class="parteCima">
            <!-- Icone de Seta -->
            <i class="fa-solid fa-arrow-left" onclick="formVenda()"></i>
            <img src="../img/Logotipo-Preto.png" alt="Logo" height="60px">
        </div>

        <p>Preencha abaixo para cadastrar sua venda:</p>

        <div class="grupo-info">
            <div class="info">
                <span>Valor Bruto</span>
                <div class="campo-valor">
                    <span class="cifrao">R$</span>
                    <input type="text" required autocomplete="off" id="txtValorVenda" name="txtValorVenda" maxlength="8" placeholder="0000,00">
                </div>
            </div>
            <div class="info">
                <span>Valor Líquido</span>
                <div class="campo-valor">
                    <span class="cifrao">R$</span>
                    <input type="text" required autocomplete="off" id="txtValorLiquidoVenda" name="txtValorLiquidoVenda" maxlength="8" placeholder="0000,00">
                </div>
            </div>
        </div>

        <div class="grupo-info">
            <div class="info">
                <span>Serviço</span>
                <select name="txtServico" required id="txtServico">
                    <option value="0"></option>
                    <?php
                    $servicos = getServicos();
                    $i = 1;
                    foreach ($servicos as $servico) :
                        $i++;
                    ?>
                        <option value="<?php echo $servico['id']; ?>"><?php echo $servico['nome']; ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="info">
                <span>Data</span>
                <input type="date" required autocomplete="off" id="txtDataVenda" name="txtDataVenda">
            </div>
        </div>

        <div class="grupo-info">
            <?php if ($cargo == 6): ?>
                <div class="info">
                    <span>Vendedor</span>
                    <select name="txtVendedor" required id="txtVendedor">
                        <option value=""></option>
                        <?php
                        $funcionarios = getFuncionariosCom2();
                        $i = 1;
                        foreach ($funcionarios as $funcionario) :
                            $i++;
                        ?>
                            <option value="<?php echo $funcionario['id_funcionario']; ?>"><?php echo $funcionario['nome']; ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            <?php endif; ?>

            <div class="info">
                    <span>F. Pagamento</span>
                    <select name="txtPagamento" required id="txtPagamento">
                        <option value=""></option>
                        <?php
                        $f_pgtos = getFormasPagamento();
                        $i = 1;
                        foreach ($f_pgtos as $f_pgto) :
                            $i++;
                        ?>
                            <option value="<?php echo $f_pgto['id']; ?>"><?php echo $f_pgto['nome']; ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
        </div>

        <div class="info">
            <span>Descrição</span>
            <textarea name="descricaoVenda" id="descricaoVenda"></textarea>
        </div>

        <div class="botao">
            <input type="submit" class="btnVenda" value="Mais Uma Vida Transformada">
        </div>
    </form>
</div>