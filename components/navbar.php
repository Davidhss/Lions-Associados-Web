<?php
include "../control/conexao.php";


$cargo = $_SESSION['Cargo'];

// Prepara consulta para obter cargo do usuário (prepared statement)
$sql_cargo = "SELECT desc_cargo FROM tbCargos WHERE id_cargo = :id_cargo;";
$stmt_cargo = $conn->prepare($sql_cargo);
// Vincula o parâmetro ao valor
$stmt_cargo->bindParam(":id_cargo", $cargo, PDO::PARAM_INT);
// Executa a consulta
$stmt_cargo->execute();

// Obter informações do cargo
$cargo_fun = $stmt_cargo->fetch(PDO::FETCH_ASSOC);
// Acessa a descrição do cargo
$desc_cargo = $cargo_fun['desc_cargo'];
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>

    <!-- Inclusão de ícones usando Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <!-- Inclusão do arquivo de estilo personalizado -->
    <link rel="stylesheet" href="../css/plataforma/style_navbar.css">
    <!-- Logo icone web -->
    <link rel="shortcut icon" href="../Logo.ico" type="image/x-icon">

    <!-- Local dos icones (FontAwesome) -->
    <script src="https://kit.fontawesome.com/d568686e85.js" crossorigin="anonymous"></script>

    <!-- Inclusão da biblioteca jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.js" integrity="sha512-8Z5++K1rB3U+USaLKG6oO8uWWBhdYsM3hmdirnOEWp8h2B1aOikj5zBzlXs8QOrvY9OxEnD2QDkbSKKpfqcIWw==" crossorigin="anonymous"></script>
</head>

<body>
    <?php
    if ($cargo == 1 || $cargo == 2 || $_SESSION['Nome'] == "Maisa Moreira") {
    ?>
        <!-- Container principal da página -->
        <div class="container">
            <!-- Barra lateral -->
            <div class="navbar">
                <a href="./inicio.php">
                    <img src="../img/Logotipo-Preto.png" style="cursor: default;" alt="logo" class="logo">
                </a>
                <!-- Navegação -->
                <div class="nav">
                    <div class="menu">
                        <!-- Lista de itens de menu -->
                        <ul>
                            <li class="active">
                                <a href="./inicio.php">
                                    <i class="icon ph-bold ph-house-simple"></i>
                                </a>
                            </li>
                            <!-- Item de menu com submenu -->
                            <li>
                                <a href="./plataformaLions.php">
                                    <i class="icon ph-bold ph-user"></i>
                                </a>
                            </li>

                            <li>
                                <a href="./pagRelatorios.php">
                                    <i class="icon ph-bold ph-chart-line"></i>
                                </a>
                            </li>

                            <li>
                                <a href="../control/gerenciador.php?action=sair">
                                    <i class="icon ph-bold ph-sign-out"></i>
                                </a>
                            </li>
                            
                        </ul>
                    </div>
                </div>

                <!-- Cabeçalho da barra lateral -->
                <div class="head">
                    <div class="user">
                        <!-- Detalhes do usuário -->
                        <div class="user-details">
                            <p class="name"><?php echo $_SESSION['Nome'] ?></p>
                            <p class="title"><?php echo $desc_cargo ?></p>
                        </div>
                        <!-- Imagem do usuário -->

                        <div class="user-img">
                            <img src="<?php echo $_SESSION['Caminho_Imagem'] ?>" alt="avatar">
                        </div>
                    </div>

                    <?php if (verificarNotificacaoNova()): ?>
                        <a href="./inicio.php?notificacao=lida" class="notification">
                            <i class="ph-fill ph-fire" id="fire-icon"></i>
                        </a>
                    <?php else: ?>
                        <div class="notification">
                            <i class="ph-fill ph-bell" id="bell-icon"></i>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    <?php
    } else if (($cargo == 3)) {
    ?>
         <!-- Container principal da página -->
         <div class="container">
            <!-- Barra lateral -->
            <div class="navbar">
                <a href="./inicio.php">
                    <img src="../img/Logotipo-Preto.png" style="cursor: default;" alt="logo" class="logo">
                </a>
                <!-- Navegação -->
                <div class="nav">
                    <div class="menu">
                        <!-- Lista de itens de menu -->
                        <ul>
                            <li class="active">
                                <a href="./inicio.php">
                                    <i class="icon ph-bold ph-house-simple"></i>
                                </a>
                            </li>
                            <!-- Item de menu com submenu -->
                            <li>
                                <a href="./plataformaLions.php">
                                    <i class="icon ph-bold ph-user"></i>
                                </a>
                            </li>
                            <li>
                                <a href="../control/gerenciador.php?action=sair">
                                    <i class="icon ph-bold ph-sign-out"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Cabeçalho da barra lateral -->
                <div class="head">
                    <div class="user">
                        <!-- Detalhes do usuário -->
                        <div class="user-details">
                            <p class="name"><?php echo $_SESSION['Nome'] ?></p>
                            <p class="title"><?php echo $desc_cargo ?></p>
                        </div>
                        <!-- Imagem do usuário -->
                        <div class="user-img">
                            <img src="<?php echo $_SESSION['Caminho_Imagem'] ?>" alt="avatar">
                        </div>
                    </div>

                    <?php if (verificarNotificacaoNova()): ?>
                        <a href="./inicio.php?notificacao=lida" class="notification">
                            <i class="ph-fill ph-fire" id="fire-icon"></i>
                        </a>
                    <?php else: ?>
                        <div class="notification">
                            <i class="ph-fill ph-bell" id="bell-icon"></i>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    <?php
    } else if (($cargo == 4)) {
    ?>
         <!-- Container principal da página -->
         <div class="container">
            <!-- Barra lateral -->
            <div class="navbar">
                <a href="./inicio.php">
                    <img src="../img/Logotipo-Preto.png" style="cursor: default;" alt="logo" class="logo">
                </a>
                <!-- Navegação -->
                <div class="nav">
                    <div class="menu">
                        <!-- Lista de itens de menu -->
                        <ul>
                            <li class="active">
                                <a href="./inicio.php">
                                    <i class="icon ph-bold ph-house-simple"></i>
                                </a>
                            </li>
                            <!-- Item de menu com submenu -->
                            <li>
                                <a href="./plataformaLions.php">
                                    <i class="icon ph-bold ph-user"></i>
                                </a>
                            </li>
                            <li>
                                <a href="../control/gerenciador.php?action=sair">
                                    <i class="icon ph-bold ph-sign-out"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Cabeçalho da barra lateral -->
                <div class="head">
                    <div class="user">
                        <!-- Detalhes do usuário -->
                        <div class="user-details">
                            <p class="name"><?php echo $_SESSION['Nome'] ?></p>
                            <p class="title"><?php echo $desc_cargo ?></p>
                        </div>
                        <!-- Imagem do usuário -->
                        <div class="user-img">
                            <img src="<?php echo $_SESSION['Caminho_Imagem'] ?>" alt="avatar">
                        </div>
                    </div>

                    <?php if (verificarNotificacaoNova()): ?>
                        <a href="./inicio.php?notificacao=lida" class="notification">
                            <i class="ph-fill ph-fire" id="fire-icon"></i>
                        </a>
                    <?php else: ?>
                        <div class="notification">
                            <i class="ph-fill ph-bell" id="bell-icon"></i>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    <?php
    } else if ($cargo == 5 || $cargo == 6) {
    ?>
         <!-- Container principal da página -->
         <div class="container">
            <!-- Barra lateral -->
            <div class="navbar">
                <a href="./inicio.php">
                    <img src="../img/Logotipo-Preto.png" style="cursor: default;" alt="logo" class="logo">
                </a>
                <!-- Navegação -->
                <div class="nav">
                    <div class="menu">
                        <!-- Lista de itens de menu -->
                        <ul>
                            <li class="active">
                                <a href="./inicio.php">
                                    <i class="icon ph-bold ph-house-simple"></i>
                                </a>
                            </li>
                            <!-- Item de menu com submenu -->
                            <li>
                                <a href="javascript:formVenda();">
                                <i class="icon ph-bold ph-currency-circle-dollar"></i>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:formPonto();">
                                    <i class="icon fa-solid fa-check-to-slot"></i>
                                </a>
                            </li>
                            <li>
                                <a href="../control/gerenciador.php?action=sair">
                                    <i class="icon ph-bold ph-sign-out"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Cabeçalho da barra lateral -->
                <div class="head">
                    <div class="user">
                        <!-- Detalhes do usuário -->
                        <div class="user-details">
                            <p class="name"><?php echo $_SESSION['Nome'] ?></p>
                            <p class="title"><?php echo $desc_cargo ?></p>
                        </div>
                        <!-- Imagem do usuário -->
                        <div class="user-img">
                            <img src="<?php echo $_SESSION['Caminho_Imagem'] ?>" alt="avatar">
                        </div>
                    </div>

                    <?php if (verificarNotificacaoNova()): ?>
                        <a href="./inicio.php?notificacao=lida" class="notification">
                            <i class="ph-fill ph-fire" id="fire-icon"></i>
                        </a>
                    <?php else: ?>
                        <div class="notification">
                            <i class="ph-fill ph-bell" id="bell-icon"></i>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    <?php
    }
    ?>

    <script src="../js/script_sidbar.js"></script>
</body>

</html>