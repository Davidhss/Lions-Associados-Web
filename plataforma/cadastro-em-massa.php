<?php
include "../control/conexao.php";
include "../control/functions.php";

protecaoPlataforma();

$cargo = $_SESSION['Cargo'];
$id_funcionario = $_SESSION['Id_Funcionario'];



?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro em Massa | Lions Associados</title>

    <!-- Local dos icones (FontAwesome) -->
    <script src="https://kit.fontawesome.com/d568686e85.js" crossorigin="anonymous"></script>

    <!-- Inclusão do arquivo de estilo personalizado -->
    <link rel="stylesheet" href="../css/plataforma/style_cadastro-em-massa.css">


    <!-- Logo icone web -->
    <link rel="shortcut icon" href="../Logo.ico" type="image/x-icon">
</head>

<body>
    <?php
    include('../components/sidebar.php');
    ?>
    <main>
        <div class="content">
            <div class="header">
                <img class="logoLions" src="../img/Logotipo-Preto.png" alt="logo">

                <div class="linha_head">
                    <a href="./plataformaLions.php">
                        <img src="../img/icones/Arrow-Voltar.svg" alt="Voltar">
                    </a>
                    <div class="titulo">
                        <h1>Cadastro de leads em massa</h1>
                        <span>Preencha os campos separando cada lead por linha</span>
                    </div>
                </div>
                <hr>
            </div>

            <div class="contentForm">
                <form action="./cadastro-em-massa.php" method="post">
                    <div class="linha">
                        <div class="info">
                            <label for="txtNomes">Nome</label>
                            <textarea name="txtNomes" id="txtNomes"></textarea>
                        </div>
                        <div class="info">
                            <label for="txtEmails">E-Mail</label>
                            <textarea name="txtEmails" id="txtEmails"></textarea>
                        </div>
                        <div class="info">
                            <label for="txtCelulares">Celular</label>
                            <textarea name="txtCelulares" id="txtCelulares"></textarea>
                        </div>
                        <div class="info">
                            <label for="txtOrigens">Origem</label>
                            <textarea name="txtOrigens" id="txtOrigens"></textarea>
                        </div>
                    </div>
                    <div class="info">
                        <label for="txtDescricoes">Descrição</label>
                        <textarea name="txtDescricoes" id="txtDescricoes"></textarea>
                    </div>
                    <input type="hidden" name="novasLeads">

                    <div class="botao">
                        <input type="submit" value="Cadastrar">
                        <input class="btnLimpar" type="reset" value="Limpar">
                    </div>
                </form>

                <div class="resultados">
                    <?php
                    if (isset($_POST['novasLeads'])) {
                        inserirLeadsEmMassa();
                    }
                    ?>
                </div>
            </div>
        </div>
    </main>

</body>

</html>