<?php
if (!isset($_SESSION)) {
    session_start();
}

include('../control/conexao.php');
include("../control/functions.php");
include "../control/dados_estatisticas.php";

$id_funcionario = $_SESSION['Id_Funcionario'];

$id_lead = $_GET['id_lead'];
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atribuir Lead | Lions Associados</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="../Logo.ico" type="image/x-icon">
    <!-- Estilização -->
    <link rel="stylesheet" href="../css/plataforma/style_atribuirLead.css">
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
                <form action="../control/gerenciador.php?action=atribuir" method="post">
                    <h2></h2>
                    <p>Para qual consultor você deseja enviar esta Lead: <br></p>

                    <div class="info">
                        <span>Consultores</span>
                        <select name="id_consultor" id="consultor">
                            <option value="0"></option>

                            <?php
                            $funcionarios = getFuncionarios();
                            $i = 1;
                            foreach ($funcionarios as $funcionario) :
                                $i++;
                            ?>
                                <option value="<?php echo $funcionario['id_funcionario']; ?>"><?php echo $funcionario['nome']; ?></option>

                            <?php endforeach ?>
                        </select>
                    </div>
                    <input type="hidden" name="id_lead" value="<?php echo $id_lead ?>">
                    <div class="botao">
                        <input type="submit" value="Atribuir">
                    </div>
                </form>
            </div>
        </div>
    </main>

</body>

</html>