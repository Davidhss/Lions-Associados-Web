<?php
include('../control/conexao.php');
include('../control/functions.php');

if (!isset($_SESSION)) {
    session_start();
}

$idLead = $_GET['id'];
$id_funcionario = $_SESSION['Id_Funcionario'];

$_SESSION['LeadID'] = $idLead;

try {
    $sql = "SELECT 
                l.nome, -- Nome da Lead
                l.email, -- Email da Lead
                l.celular, -- Celular da Lead
                l.cod_horario, -- Melhor horário informado para entrar em contato
                o.id_origem, -- ID da origem que chegou a Lead
                o.nome_origem, -- Nome da origem que chegou a Lead
                s.id_situacao, -- ID da situação da Lead
                s.nome_situacao, -- Situação da Lead
                p.desc_problema, -- Descrição do Problema informado pela Lead
                h.desc_horario
            FROM tbLeads l
            INNER JOIN tbProblemaLead p ON l.id_Lead = p.cod_lead
            INNER JOIN tbSituacaoLead s ON p.cod_situacao = s.id_situacao
            INNER JOIN tbOrigemLead o ON l.cod_origem = o.id_origem
            INNER JOIN tbHorarioLead h ON l.cod_horario = h.id_horario
            WHERE l.id_Lead = :idLead";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':idLead', $idLead, PDO::PARAM_INT);
    $stmt->execute();

    // Verificar se o lead existe
    if ($stmt->rowCount() == 0) {
        echo "Lead não encontrado.";
        exit;
    }

    // Obter dados do lead
    $lead = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Registra o erro em um log
    error_log("Erro ao obter lead: " . $e->getMessage());

    // Exibe uma mensagem de erro genérica
    echo "Erro ao obter lead.";
}
?>

<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Editar Lead | Lions Associados</title>

    <!-- Estilização -->
    <link rel="stylesheet" href="../css/plataforma/style_editarLead.css">

    <!-- Favicon -->
    <link rel="shortcut icon" href="../Logo.ico" type="image/x-icon">

    <!-- Local dos icones (FontAwesome) -->
    <script src="https://kit.fontawesome.com/d568686e85.js" crossorigin="anonymous"></script>

    <!-- Tratamento de Dados (Celular) -->
    <script src="../js/mascaraCelular.js"></script>
</head>


<body>
    <?php
    include('../components/navbar.php');

    switch ($cargo) {
        case 1:
        case 2:
        case 3:
            include('../components/super/editarLead.php');
            break;
        case 4:
        case 5:
            include('../components/normal/editarLead.php');
            break;
    };
    ?>
</body>

</html>