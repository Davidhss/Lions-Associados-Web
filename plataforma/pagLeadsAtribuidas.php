<?php
include "../control/conexao.php";
include "../control/functions.php";

if (!isset($_SESSION)) {
    session_start();
}

$cargo = $_SESSION['Cargo'];
$id_funcionario = $_SESSION['Id_Funcionario'];

// Executar consulta com paginação
try {
    $filtroAndamento = isset($_GET['andamento']) ? $_GET['andamento'] : 'Todos';
    // Definir a cláusula WHERE com base no filtro selecionado
    $where = '';
    switch ($filtroAndamento) {
        case 'SemContato':
            $where = "AND fl.nome_fase = 'Sem contato'";
            break;
        case 'QuerNada':
            $where = "AND fl.nome_fase = 'Não queria nada'";
            break;
        case 'SemAjuda':
            $where = "AND fl.nome_fase = 'Não podemos ajudar'";
            break;
        case 'Regularizado':
            $where = "AND fl.nome_fase = 'Problema já solucionado'";
            break;
        case 'EmAberto':
            $where = "AND fl.nome_fase = 'Em aberto'";
            break;
        case 'Negociacao':
            $where = "AND fl.nome_fase = 'Negociação'";
            break;
        case 'Venda':
            $where = "AND fl.nome_fase = 'Venda'";
            break;
        case 'SemRetorno':
            $where = "AND fl.nome_fase IS NULL";
            break;
        default:
            // Nenhum filtro específico selecionado
            break;
    }

    $sql = "SELECT
    l.id_Lead,
    l.nome,
    l.data_recebimento,
    l.cod_funcionario,
    o.nome_origem,
    s.nome_situacao,
    f.nome AS funcionario,
    fl.nome_fase AS fase,
    MAX(rt.data_protocolo) AS ultima_data_retorno
FROM tbLeads l
INNER JOIN tbProblemaLead p ON l.id_Lead = p.cod_lead
INNER JOIN tbSituacaoLead s ON p.cod_situacao = s.id_situacao
INNER JOIN tbOrigemLead o ON l.cod_origem = o.id_origem
LEFT JOIN tbFuncionarios f ON l.cod_funcionario = f.id_funcionario
LEFT JOIN tbRetornos rt ON l.id_Lead = rt.cod_lead
LEFT JOIN tbFaseLead fl ON rt.cod_fase = fl.id_fase
WHERE l.cod_funcionario = $id_funcionario $where
GROUP BY l.id_Lead
ORDER BY ultima_data_retorno DESC, l.id_Lead DESC";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Registra o erro em um log
    error_log("Erro ao obter leads do funcionário: " . $e->getMessage());

    // Exibe uma mensagem de erro genérica
    echo "Erro ao obter leads do funcionário.";
}
?>

<!DOCTYPE html>

<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leads Atribuídas</title>

    <!-- Inclusão de ícones usando Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <!-- Inclusão do arquivo de estilo personalizado -->
    <link rel="stylesheet" href="../css/plataforma/style_plataformaLions.css">

    <!-- Logo icone web -->
    <link rel="shortcut icon" href="../Logo.ico" type="image/x-icon">
</head>

<body>
    <?php include('../components/sidebar.php') ?>

    <!-- Container principal da página -->
    <main>
        <div class="partecima">
            <img src="../img/Logotipo-Preto.png" alt="logo" class="logo">

            <div class="apresentacao">
                <div class="bem-vindo">
                    <h3>Bem-vindo(a) <?php echo $_SESSION['Nome'] ?>!</h3>
                    <span><?php echo $usuario2['desc_cargo']; ?></span>
                </div>

                <a href="../control/gerenciador.php?action=sair">
                    <i class="fa-solid fa-right-from-bracket"></i> Sair
                </a>
            </div>
        </div>

        <div class="meio">
            <hr>
            <div class="titulo">
                <h2>Leads Atribuídas</h2>

                <div class="botoes_head">
                        <div class="linha filtros">
                            <a href="./plataformaLions.php?andamento=Todos"> <!-- Adiciona filtro para 'Todos' -->
                                <i class="fa-solid fa-list"></i>
                            </a>

                            <a class="status semretorno" href="./plataformaLions.php?andamento=SemRetorno"> <!-- Adiciona filtro para 'Sem Contato' -->
                                <i class="ph ph-phone"></i>
                            </a>

                            <a class="status semcontato" href="./plataformaLions.php?andamento=SemContato"> <!-- Adiciona filtro para 'Sem Contato' -->
                                <i class="ph ph-phone-slash"></i>
                            </a>

                            <a class="status querianada" href="./plataformaLions.php?andamento=QuerNada"> <!-- Adiciona filtro para 'Sem Contato' -->
                                <i class="fa-solid fa-user-slash"></i>
                            </a>

                            <a class="status regularizado" href="./plataformaLions.php?andamento=Regularizado"> <!-- Adiciona filtro para 'Sem Contato' -->
                                <i class="ph ph-car-profile"></i>
                            </a>

                            <a class="status semajuda" href="./plataformaLions.php?andamento=SemAjuda"> <!-- Adiciona filtro para 'Sem Contato' -->
                                <i class="ph ph-smiley-sad"></i>
                            </a>

                            <a class="status emaberto" href="./plataformaLions.php?andamento=EmAberto"> <!-- Adiciona filtro para 'Sem Contato' -->
                                <i class="ph ph-phone-call"></i>
                            </a>

                            <a class="status negociacao" href="./plataformaLions.php?andamento=Negociacao"> <!-- Adiciona filtro para 'Sem Contato' -->
                                <i class="ph ph-tag"></i>
                            </a>

                            <a class="status venda" href="./plataformaLions.php?andamento=Venda"> <!-- Adiciona filtro para 'Sem Contato' -->
                                <i class="ph ph-currency-dollar"></i>
                            </a>
                        </div>
                        <!-- Adicione mais botões de filtro conforme necessário -->
                    </div>
            </div>
            <hr>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Situação</th>
                    <th>Entrada</th>
                    <th>Origem</th>
                    <th>Consultor</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($result as $lead) {
                    $idLead = $lead['id_Lead'];

                    try {
                        // Prepare consulta para obter última fase do lead (prepared statement)
                        $sql_registros = "SELECT
                           z.id_fase AS fase
                        FROM tbRetornos r
                        INNER JOIN tbFaseLead z ON r.cod_fase = z.id_fase
                       WHERE r.cod_lead = :idLead
                    ORDER BY r.data_protocolo DESC
                       LIMIT 1;";
                        $stmt = $conn->prepare($sql_registros);

                        // Vincula o parâmetro ao valor
                        $stmt->bindParam(":idLead", $idLead, PDO::PARAM_INT);

                        // Executa a consulta
                        $stmt->execute();

                        // Obter o resultado da consulta (máximo 1 registro)
                        $retorno = $stmt->fetch(PDO::FETCH_ASSOC);
                    } catch (PDOException $e) {
                        // Registra o erro em um log
                        error_log("Erro ao obter última fase do lead: " . $e->getMessage());
                    }

                    $fase = ($retorno) ? $retorno['fase'] : null;

                ?>
                    <tr>
                        <td class="campo-nome" data-label="Nome">
                            <?php
                            if ($fase) {
                                switch ($fase) {
                                    case 1:
                                        echo "<span class='status semcontato'></span>";
                                        break;
                                    case 2:
                                        echo "<span class='status querianada'></span>";
                                        break;
                                    case 3:
                                        echo "<span class='status semajuda'></span>";
                                        break;
                                    case 4:
                                        echo "<span class='status regularizado'></span>";
                                        break;
                                    case 5:
                                        echo "<span class='status emaberto'></span>";
                                        break;
                                    case 6:
                                        echo "<span class='status negociacao'></span>";
                                        break;
                                    case 7:
                                        echo "<span class='status venda'></span>";
                                        break;
                                    default:
                                        echo "<span class='status semretorno'></span>";
                                        break;
                                }
                            } else {
                                echo "<span class='status semretorno'></span>";
                            }
                            ?>


                            <a href="pagDetalhesLead.php?id=<?php echo $lead['id_Lead']; ?>">
                                <?php echo $lead['nome']; ?>
                            </a>
                        </td>
                        <td data-label="Situação">
                            <?php
                            if ($lead['nome_situacao'] == "" || $lead['nome_situacao'] == NULL) {
                                echo "Não Informado";
                            } else {
                                echo $lead['nome_situacao'];
                            }
                            ?>
                        </td>
                        <td data-label="Entrada">
                            <?php
                            $data_mysql = strtotime($lead['data_recebimento']);
                            $data_formatada = date("d/m", $data_mysql);
                            echo $data_formatada;
                            ?>
                        </td>
                        <td data-label="Origem">
                            <?php echo $lead['nome_origem']; ?>
                        </td>
                        <td data-label="Atribuicao">
                            <?php
                            if ($lead['cod_funcionario'] == NULL) { ?>
                                <a href="./pagAtribuirLead.php?id_lead=<?php echo $lead['id_Lead']; ?>" class='naoAtribuido'> Não atribuído </a>
                            <?php
                            } else { ?>

                                <a href="./pagAtribuirLead.php?id_lead=<?php echo $lead['id_Lead']; ?>">
                                    <?php echo $lead['funcionario']; ?>
                                </a>
                            <?php
                            }
                            ?>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>

    </main>
</body>

</html>