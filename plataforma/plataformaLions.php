<?php
include "../control/conexao.php";
include "../control/functions.php";
include "../control/dados_estatisticas.php";

protecaoPlataforma();

if (isset($_GET['notificacao'])) {
    marcarNotificacaoLida();
}

$cargo = $_SESSION['Cargo'];
$id_funcionario = $_SESSION['Id_Funcionario'];
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plataforma | Lions Associados</title>

    <!-- Inclusão de ícones usando Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <!-- Inclusão do arquivo de estilo personalizado -->
    <link rel="stylesheet" href="../css/plataforma/style_plataformaLions.css">

    <!-- Logo icone web -->
    <link rel="shortcut icon" href="../Logo.ico" type="image/x-icon">

    <script>

    </script>
</head>

<body>
    <!-- Modal para bloquear a página quando houver agendamentos atrasados -->
    <div id="agendamentoAtrasadoModal" class="modal" style="display:none;">
        <div class="modal-content">
            <img src="../img/warning.webp" alt="Cuidado" width="60px" height="60px">
            <h2>AGENDAMENTO ATRASADO</h2>
            <p>Você tem um <strong>agendamento atrasado</strong>! Estamos te redirecionando para a página do lead.</p>
        </div>
    </div>

    <?php
    if ($cargo == 1 || $cargo == 2 || $cargo == 3) {
        include('../components/navbar.php');
        include('../components/super/listaLeads.php');
    } else if ($cargo == 4 || $cargo == 5) {
        

        include('../components/navbar.php');
        include('../components/normal/listaLeads.php');
    }
    ?>

    <script src="../js/script.js"></script>
</body>

</html>