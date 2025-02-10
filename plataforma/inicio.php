<?php
include "../control/conexao.php";
include "../control/functions.php";
include "../control/dados_estatisticas.php";

protecaoPlataforma();

$cargo = $_SESSION['Cargo'];
$id_funcionario = $_SESSION['Id_Funcionario'];

if (isset($_GET['notificacao'])) {
    marcarNotificacaoLida();
}

if (isset($_POST['txtValorVenda'])) {
    if (cadastrarVenda(null, $_POST['txtVendedor'], $_POST['txtValorVenda'], $_POST['txtValorLiquidoVenda'], $_POST['txtDataVenda'], $_POST['txtServico'], $_POST['descricaoVenda'], $_POST['txtPagamento'])) {
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
    <title>Plataforma | Lions Associados</title>
    <link rel="stylesheet" href="../css/plataforma/style_inicio.css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="shortcut icon" href="../Logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="../css/plataforma/style_detalhesLead.css">
    <script src="../js/script.js"></script>
</head>

<body>
    <?php include('../components/navbar.php');
    include "../components/formVenda.php";
    include "../components/formKeyWord.php";
    include "../components/formPonto.php";
    ?>

    <main id="lead">
        <div class="content">
            <?php
            if (isset($_POST['txtNewKeyWord'])) {
                $palavra = $_POST['txtNewKeyWord'];
                $stmt = $conn->prepare("INSERT INTO tbPalavrasChave (palavra) VALUES (:palavra)");
                $stmt->execute([':palavra' => $palavra]);
                echo "Palavra-chave cadastrada com sucesso!";
            }

            if (isset($_POST['txtKeyWord'])) {
                $palavra = $_POST['txtKeyWord'];

                $hoje = date('Y-m-d');
                // Verifica se a palavra-chave existe para o dia
                $stmt = $conn->prepare("SELECT id_palavra as id FROM tbPalavrasChave WHERE palavra = :palavra AND DATE(data_cadastro) = :hoje");
                $stmt->bindParam(":palavra", $palavra, PDO::PARAM_STR);
                $stmt->bindParam(':hoje', $hoje, PDO::PARAM_STR);
                $stmt->execute();
                $palavraId = $stmt->fetch(PDO::FETCH_ASSOC); 
                if ($palavraId) {
                    
                    // Registra o ponto
                    $stmt = $conn->prepare("INSERT INTO tbPonto (cod_funcionario, cod_palavra) VALUES (:funcionario, :palavra)");
                    $stmt->bindParam(':funcionario', $id_funcionario, PDO::PARAM_STR);
                    $stmt->bindParam(":palavra", $palavraId["id"], PDO::PARAM_INT);

                    $stmt->execute();

                    echo "<span style='color: green;'>Ponto registrado com sucesso!</span>";
                } else {
                    echo "<span style='color: red;'>Palavra-chave inválida ou não cadastrada para hoje.</span>";
                }
            }
            ?>

            <h2>Bem-vindo(a), <?php echo $_SESSION['Nome'] ?>!</h2>
            <hr>

            <div class="primeiras-info">
                <h3>Início</h3>
                <div class="aviso_desenvolvimento">
                    <h4>Plataforma em desenvolvimento</h4>

                    <p>Estamos trabalhando em mais funcionalidades no sistema, estamos cientes das necessidades e pedimos paciência pois tudo está em desenvolvimento.</p>
                </div>

                <?php
                if ($cargo == 1 || $cargo == 2 || $cargo == 3) {
                    include "../components/super/cardsInicio.php";
                } else if ($cargo == 4) {
                    include "../components/normal/cardsInicio.php";
                } else {
                    include "../components/juridico/cardsInicio.php";
                } ?>
            </div>

            <?php if ($cargo == 1 || $cargo == 2 || $cargo == 3 || $cargo == 4): ?>
                <div class="cards_options">
                    <div class="card-menu leads">
                        <div class="icone-card">
                            <img src="../img/icones/leadsIcon.svg" alt="">
                        </div>

                        <div class="content-card">
                            <div class="texto-card">
                                <h4>Leads</h4>
                                <p>Veja a lista com todas as leads e realize o controle completo de todas elas.</p>
                            </div>
                            <div class="botao-card">
                                <a href="./plataformaLions.php">Consultar -></a>
                            </div>
                        </div>
                    </div>

                    <div class="card-menu relatorios">
                        <div class="icone-card">
                            <img src="../img/icones/relatoriosIcon.svg" alt="">
                        </div>

                        <div class="content-card">
                            <div class="texto-card">
                                <h4>Relatórios</h4>
                                <p>Verifique métricas, números e estatísticas mais detalhadas sobre a situação atual.</p>
                            </div>
                            <div class="botao-card">
                                <a href="./pagRelatorios.php">Saiba mais -></a>
                            </div>
                        </div>
                    </div>

                    <div class="card-menu ponto">
                        <div class="icone-card">
                            <i class="icon fa-solid fa-check-to-slot"></i>
                        </div>

                        <div class="content-card">
                            <div class="texto-card">
                                <h4>Marcar Ponto</h4>
                                <p>Preencha para cadastrar sua presença na empresa.</p>
                            </div>
                            <div class="botao-card">
                                <a href="javascript:formPonto();">Marcar -></a>
                            </div>
                        </div>
                    </div>

                    <div class="card-menu desativado">
                        <div class="icone-card">
                            <img src="../img/icones/chamadoIcon.svg" alt="">
                        </div>

                        <div class="content-card">
                            <div class="texto-card">
                                <h4>Precisa de Ajuda?</h4>
                                <p>Não hesite em realizar um chamado para receber auxílio.</p>
                            </div>
                            <div class="botao-card">
                                <a href="">Realizar um chamado -></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </main>

</body>

</html>