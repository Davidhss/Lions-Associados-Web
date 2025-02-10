<?php
if (!isset($_SESSION)) {
    session_start();
}

include('../control/conexao.php');
include("../control/functions.php");
include "../control/dados_estatisticas.php";

$id_funcionario = $_SESSION['Id_Funcionario'];

$id_lead = $_GET['id'];
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retorno Lead | Lions Associados</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="../Logo.ico" type="image/x-icon">
    <!-- Estilização -->
    <link rel="stylesheet" href="../css/plataforma/style_andamento.css">
    <!-- Local dos icones (FontAwesome) -->
    <script src="https://kit.fontawesome.com/d568686e85.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php include('../components/navbar.php'); ?>

    <main>
        <div class="main_form">
            <div class="left-side">
                <!-- Cabeçalho do Site (Botão de Voltar e Logo) -->
                <div class="parteCima">
                    <a href="./plataformaLions.php">
                        <!-- Icone de Seta -->
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <img src="../img/Logotipo-Preto.png" alt="Logo" height="60px">
                </div>
                <!-- Conteúdo -->
                <form action="../control/gerenciador.php?action=andamento" method="post">
                    <h2></h2>
                    <p>Nos conte um pouco sobre o que aconteceu com essa Lead: <br></p>

                    <div class="info">
                        <span>Andamento</span>
                        <select name="andamento" id="andamento">
                            <option value=""></option>
                            <option value="1">Não consegui contato nenhum com o lead</option>
                            <option value="11">Parou de responder as mensagens e não atende mais as ligações</option>
                            <option value="9">Liguei e não atendeu, mandei mensagem e estou no aguardo</option>
                            <option value="10">Achou o nosso serviço muito caro e perdeu o interesse</option>
                            <option value="2">Entrei em contato, mas não precisava de nossos serviços</option>
                            <option value="3">Não foi possível encontrar uma solução ideal para o lead</option>
                            <option value="4">Já resolveu o problema de alguma outra forma</option>
                            <option value="8">Cliente fechado da Lions Associados, não é lead</option>
                            <option value="5">Em aberto, ainda não passei valores, mas consegui contato</option>
                            <option value="6">Negociação realizada, esperando confirmação</option>
                            <option value="7">Novo cliente, venda realizada com sucesso</option>
                        </select>
                    </div>

                    <div class="info">
                        <span>Observação</span>
                        <textarea name="observacao" id="observacao"></textarea>
                    </div>
                    <input type="hidden" name="id_lead" value="<?php echo $id_lead ?>">
                    <div class="botao">
                        <input type="submit" value="Salvar">
                    </div>
                </form>
            </div>
        </div>
    </main>

</body>

</html>