<?php
//Chamar a conexão com Banco de Dados
include "./conexao.php";
include "./functions.php";

//Iniciar uma sessão se ela não estiver aberta
if (!isset($_SESSION)) {
    session_start();
}

//Identifica qual função será usada
if ($_GET['action'] == 'excluir') { //Exclusão de Lead
    include('./conexao.php');

    //Captar qual lead vamos controlar
    $id = $_SESSION['LeadID'];
    excluirLead($_SESSION['LeadID']);

} else if ($_GET['action'] == 'alterar') { //Alterar dados da Lead
    include('./conexao.php');

    //Captar qual lead vamos controlar
    $id = $_SESSION['LeadID'];

    editarInfoLead($id, $_POST['newNomeLead'], $_POST['newCelLead'], $_POST['newEmailLead'], $_POST['newSitLead'], $_POST['newOrigemLead'], $_POST['newHorarioLead'], $_POST['newDescLead']);

} 
/*else if ($_GET['action'] == 'alterar_consultor') { //Alterar dados da Lead
    include('./conexao.php');

    //Captar qual lead vamos controlar
    $id = $_SESSION['LeadID'];
    editarInfoLead_Consultor($id, $_POST['newNomeLead'], $_POST['newCelLead'], $_POST['newEmailLead'], $_POST['newSitLead'], $_POST['newHorarioLead'], $_POST['newDescLead']);

} */
else if ($_GET['action'] == 'sair') { //Deslogar
    if (!isset($_SESSION)) {
        session_start();
    }

    session_destroy();

    header("Location: ../index.php");

} else if ($_GET['action'] == 'atribuir') { //Atribuir Lead
    include('./conexao.php');

    $idLead = $_POST['id_lead'];
    $idConsultor = $_POST['id_consultor'];

    atribuirLead($idLead, $idConsultor);

} else if ($_GET['action'] == 'andamento') { //Retorno do consultor em relação à lead
    include('./conexao.php');

    $idLead = $_POST['id_lead'];

    cadastrarRetorno($idLead, $_POST['andamento'], $_POST['observacao']);
} else if ($_GET['action'] == 'agendamento') {
    include('./conexao.php');

    $idLead = $_POST['txtId'];
    if(cadastrarAgendamento()){
        header("Location: ../plataforma/plataformaLions.php");
    }
}



if (isset($_POST['nomeLead'])) {
    if (verificaEmailRepetido() == false) {
        //Aqui fazemos o insert pois se foi false, não encontrou nenhum registro igual
        inserirLead();
    } else {
        echo "Já existe um usuário usando este LOGIN";
    }
}

if (isset($_POST['horaLead'])) {
    alterarHorarioLead();
}