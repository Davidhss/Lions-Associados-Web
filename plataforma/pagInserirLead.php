<?php
include('../control/conexao.php');
include "../control/functions.php";
include "../control/dados_estatisticas.php";

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_POST['novaLead'])) {
    if (verificarCelularRepetido() == false) {
        //Aqui fazemos o insert pois se foi false, não encontrou nenhum registro igual
        if (cadastrarLead() == true) {
            header("Location: ./pagInserirLead.php");
        } else {
            echo "Lead não cadastrada";
        }
    }
}

$cargo = $_SESSION['Cargo'];
$id_funcionario = $_SESSION['Id_Funcionario'];
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserir Lead</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="../Logo.ico" type="image/x-icon">

    <!-- Estilização -->
    <link rel="stylesheet" href="../css/plataforma/style_inserir-lead.css">

    <!-- Local dos icones (FontAwesome) -->
    <script src="https://kit.fontawesome.com/d568686e85.js" crossorigin="anonymous"></script>

    <!-- Tratamento de Dados (Celular) -->
    <script src="../js/mascaraCelular.js"></script>

</head>

<body>
    <?php include('../components/navbar.php'); ?>

    <main>
        <div class="content">
            <div class="header">
                <div class="linha_head">
                    <a href="./plataformaLions.php">
                        <img src="../img/icones/Arrow-Voltar.svg" alt="Voltar">
                    </a>
                    <div class="titulo">
                        <h1>Cadastro de leads</h1>
                        <span>Preencha os campos para cadastrar uma nova lead no sistema.</span>
                    </div>

                    <a href="./cadastro-em-massa.php">
                        Cadastro em Massa
                    </a>
                </div>

                <hr>
            </div>

            <div class="contentForm">
                <form action="./pagInserirLead.php" method="post">
                    <div class="linha">
                        <div class="info">
                            <label for="txtNomes">Nome</label>
                            <input type="text" name="nomeLeadNova" id="txtNomes" class="txt" autocomplete="off">
                        </div>

                        <div class="info">
                            <label for="txtEmails">E-mail</label>
                            <input type="text" name="emailLeadNova" id="txtEmails" class="txt" autocomplete="off">
                        </div>
                        <div class="info">
                            <label for="txtCelulares">Celular
                                <?php
                                if (isset($_POST['novaLead'])) {
                                    if (verificarCelularRepetido() == true) {
                                        echo
                                        "<span class='mensagem-erro'>
                                            --- (Esse número já existe) ---
                                        </span>";
                                    }
                                }
                                ?>
                            </label>

                            <input type="text" name="celLeadNova" id="cel" class="txt" maxlength="15" placeholder="(xx) xxxxx-xxxx" required autocomplete="off">
                        </div>
                    </div>

                    <div class="linha">
                        <div class="info">
                            <label for="txtOrigens">Situação</label>
                            <select name="sitLeadNova" id="situacao">
                                <option value="11"></option>

                                <?php
                                $situacoes = getSituacoes();

                                foreach ($situacoes as $situacao) :
                                ?>
                                    <option value="<?php echo $situacao['id_situacao'] ?>"><?php echo $situacao['nome_situacao'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="info">
                            <label for="txtOrigens">Origem</label>
                            <select name="tipoPagNova" id="situacao">
                                <option value="12"></option>

                                <?php
                                $origens = getOrigens();

                                foreach ($origens as $origem) :
                                ?>
                                    <option value="<?php echo $origem['id_origem'] ?>"><?php echo $origem['nome_origem'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="info">
                            <label for="txtOrigens">Melhor Horário</label>
                            <select name="horaLeadNova" id="horario">
                                <option value="4"></option>

                                <?php
                                $horarios = getHorarios();

                                foreach ($horarios as $horario) :
                                ?>
                                    <option value="<?php echo $horario['id_horario'] ?>"><?php echo $horario['desc_horario'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>

                    <div class="info">
                        <label for="txtDescricoes">Descrição</label>
                        <textarea name="descLeadNova" id="txtDescricoes" autocomplete="off"></textarea>
                    </div>
                    <input type="hidden" name="novaLead">

                    <?php if ($cargo == 1 || $cargo == 2 || $cargo == 3) : ?>
                        <div class="selector">

                            <div class="selector-item">
                                <input type="radio" id="radio1" name="selector" value="0" class="selector-item_radio" checked>
                                <label for="radio1" class="selector-item_label">Não atribuir</label>
                            </div>

                            <?php
                            $funcionarios = getFuncionarios();
                            $i = 1;
                            foreach ($funcionarios as $funcionario) :
                                $i++;

                                $quantidadeLeadsAtribuidas = getQuantidadeLeadsAtribuidas($funcionario['id_funcionario'], $conn);
                            ?>
                                <div class="selector-item">
                                    <input type="radio" id="radio<?php echo $i; ?>" name="selector" class="selector-item_radio" value="<?php echo $funcionario['id_funcionario']; ?>">
                                    <label for="radio<?php echo $i; ?>" class="selector-item_label"><?php echo $funcionario['nome']; ?> <span class="qtde-leads-atribuidas">(<?php echo $quantidadeLeadsAtribuidas ?>)</span></label>

                                </div>

                            <?php endforeach ?>
                        </div>
                    <?php
                    endif;
                    if ($cargo === 4 || $cargo === 5) :
                    ?>
                        <input type="hidden" name="selector" value="<?php echo $id_funcionario; ?>">
                    <?php endif; ?>

                    <div class="botao">
                        <input type="submit" value="Cadastrar">
                        <input class="btnLimpar" type="reset" value="Limpar">
                    </div>
                </form>
            </div>
        </div>
    </main>

</body>

</html>