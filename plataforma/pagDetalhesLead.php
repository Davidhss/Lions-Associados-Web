<?php
include('../control/conexao.php');
include("../control/functions.php");
include "../control/dados_estatisticas.php";

$idLead = $_GET['id'];
$tipo = "lead";
$_SESSION['LeadID'] = $idLead;

$lead = consultarDadosLead($idLead);
$data_mysql = strtotime($lead["data_recebimento"]);
$data_formatada = date("d/m/Y", $data_mysql);

$id_funcionario = $_SESSION['Id_Funcionario'];

if (isset($_POST['andamento'])) {
    if (cadastrarRetorno($idLead, $_POST['andamento'], $_POST['observacao'])) {
        header("Refresh: 0");
    } else {
        echo "Não cadastrado";
    }
}

if (isset($_POST['txtValorVenda'])) {
    if (cadastrarVenda($idLead, $lead['cod_funcionario'], $_POST['txtValorVenda'], $_POST['txtValorLiquidoVenda'], $_POST['txtDataVenda'] ,$_POST['txtServico'], $_POST['descricaoVenda'], $_POST['txtPagamento'])) {
        header("Refresh: 0");
    } else {
        echo "Não cadastrado";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $lead['nome']; ?> | Lions Associados</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="../Logo.ico" type="image/x-icon">
    <!-- Local dos icones (FontAwesome) -->
    <script src="https://kit.fontawesome.com/d568686e85.js" crossorigin="anonymous"></script>
    <!-- Estilização -->
    <link rel="stylesheet" href="../css/plataforma/style_detalhesLead.css">
    <!-- Pegar função de remover lead -->
    <script src="../js/script.js"></script>
</head>

<body>
    <?php
    include('../components/navbar.php');

    // Filtro a partir do cargo do usuário
    switch ($cargo) {
        case 1:
        case 2:
        case 3:
            include('../components/super/detalhesLead.php');
            break;
        case 4:
        case 5:
            include('../components/normal/detalhesLead.php');
            break;
    };
    ?>
</body>

</html>