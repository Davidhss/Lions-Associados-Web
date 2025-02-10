<?php
include "../control/conexao.php";
include "../control/functions.php";

protecaoPlataforma();

if (isset($_GET['notificacao'])) {
    marcarNotificacaoLida();
}

$pontos = consultarPontos();

$id_funcionario = $_SESSION['Id_Funcionario'];
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registros de Pontos | Lions Associados</title>

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
<?php include('../components/navbar.php'); ?>
    <main>
        <table>
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Funcionário</th>
                    <th>Horário</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($pontos as $ponto) { ?>
                    <tr>
                        <td data-label="Dia">
                            <?php echo $ponto['dia_ponto'] ?>
                        </td>

                        <td data-label="Nome">
                            <?php echo $ponto['nome']; ?>
                        </td>

                        <td data-label="Horário">
                            <?php echo $ponto['horario']; ?>
                        </td>
                    </tr>
                <?php }
                ?>
            </tbody>
        </table>
    </main>

    <script src="../js/script.js"></script>
</body>

</html>