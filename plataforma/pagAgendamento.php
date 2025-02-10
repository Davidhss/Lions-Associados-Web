<?php
include('../control/conexao.php');
include "../control/functions.php";

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
    <link rel="stylesheet" href="../css/plataforma/style_agendar-lead.css">

    <!-- Local dos icones (FontAwesome) -->
    <script src="https://kit.fontawesome.com/d568686e85.js" crossorigin="anonymous"></script>

</head>

<body>
    <?php include('../components/sidebar.php'); ?>

    <main>
        <div class="content">
            <div class="header">
                <img class="logoLions" src="../img/Logotipo-Preto.png" alt="logo">

                <div class="linha_head">
                    <a href="./plataformaLions.php">
                        <img src="../img/icones/Arrow-Voltar.svg" alt="Voltar">
                    </a>
                    <div class="titulo">
                        <h1>Agendar Lead</h1>
                        <span>Preencha os campos para agendamento no sistema.</span>
                    </div>
                </div>
                <hr>
            </div>

            <div class="contentForm">
                <form action="./pagInserirLead.php" method="post">
                    <div class="linha">
                        <div class="info">
                            <label for="txtIdLead">ID da Lead</label>
                            <input type="text" name="idLead" id="txtIdLead" class="txt" autocomplete="off" disabled>
                        </div>

                        <div class="info">
                            <label for="txtConsultor">Consultor</label>
                            <input type="text" name="consultorAgenda" id="txtConsultor" class="txt" autocomplete="off">
                        </div>
                    </div>

                    <div class="linha">
                        <div class="info">
                            <label for="txtDesc">Descrição</label>
                            <input type="text" name="descAgenda" id="txtDesc" class="txt" autocomplete="off">
                        </div>
                    </div>

                    <div class="linha">
                        <div class="info">
                            <label for="txtDesc">Data e Hora</label>
                            <input type="datetime-local" name="dataAgenda" id="txtHora" class="txt" autocomplete="off">
                        </div>
                    </div>

                    <input type="hidden" name="novaLead">

                    <div class="botao">
                        <input type="submit" value="Agendar">
                        <input class="btnLimpar" type="reset" value="Limpar">
                    </div>
                </form>

                <div class="img_side">
                    <img src="../img/calendario-img.svg" alt="Calendar Image">
                </div>
            </div>
        </div>
    </main>

</body>

</html>