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
    <title>Sidebar</title>

    <!-- Inclusão de ícones usando Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <!-- Inclusão do arquivo de estilo personalizado -->
    <link rel="stylesheet" href="../css/plataforma/style_sidebar.css">
    <!-- Logo icone web -->
    <link rel="shortcut icon" href="../Logo.ico" type="image/x-icon">

    <!-- Local dos icones (FontAwesome) -->
    <script src="https://kit.fontawesome.com/d568686e85.js" crossorigin="anonymous"></script>

    <!-- Inclusão da biblioteca jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.js" integrity="sha512-8Z5++K1rB3U+USaLKG6oO8uWWBhdYsM3hmdirnOEWp8h2B1aOikj5zBzlXs8QOrvY9OxEnD2QDkbSKKpfqcIWw==" crossorigin="anonymous"></script>
</head>

<body>
    <?php
    if ($cargo == 1 || $cargo == 2) {
    ?>
        <!-- Container principal da página -->
        <div class="container">
            <!-- Barra lateral -->
            <div class="sidebar">
                <!-- Cabeçalho da barra lateral -->
                <div class="head">
                    <!-- Imagem do usuário -->
                    <div class="user-img">
                        <img src="<?php echo $_SESSION['Caminho_Imagem'] ?>" alt="avatar">
                    </div>
                    <!-- Detalhes do usuário -->
                    <div class="user-details">
                        <p class="name"><?php echo $_SESSION['Nome'] ?></p>
                        <p class="title"><?php echo $desc_cargo ?></p>
                    </div>
                </div>

                <!-- Navegação -->
                <div class="nav">
                    <div class="menu">
                        <!-- Lista de itens de menu -->
                        <ul>
                            <!-- Item de menu ativo -->
                            <li class="active">
                                <a href="./inicio.php">
                                    <i class="icon ph-bold ph-house-simple"></i>
                                    <span class="text">Home</span>
                                </a>
                            </li>

                            <!-- Item de menu com submenu -->
                            <li>
                                <a href="./plataformaLions.php">
                                    <i class="icon ph-bold ph-user"></i>
                                    <span class="text">Leads</span>
                                </a>
                            </li>

                            <!-- Item de menu com submenu -->
                            <li>
                                <a href="#">
                                    <i class="icon ph ph-chart-bar"></i>
                                    <span class="text">Relatórios</span>
                                    <i class="arrow ph-bold ph-caret-down"></i>
                                </a>
                                <!-- Submenu -->
                                <ul class="sub-menu">
                                    <li>
                                        <a href="#">
                                            <span class="text">Vendas</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <span class="text">Leads</span>
                                        </a>
                                    </li>
                                    <hr>
                                </ul>
                            </li>

                            <!-- Outros itens de menu -->
                            <li class="active">
                                <a href="./Metas/meta.html">
                                    <i class="fa-solid fa-trophy"></i>
                                    <span class="text">Metas</span>
                                </a>
                            </li>
                            <li class="active">
                                <a href="./pagAgendamentos.php">
                                    <i class="ph ph-calendar"></i>
                                    <span class="text">Agenda</span>
                                </a>
                            </li>
                            <li class="active">
                                <a href="#">
                                    <i class="icon ph ph-clipboard-text"></i>
                                    <span class="text">Criador de ficha</span>
                                </a>
                            </li>
                            <li class="active">
                                <a href="#">
                                    <i class="icon ph ph-bell"></i>
                                    <span class="text">Notificações</span>
                                </a>
                            </li>
                            <li class="active">
                                <a href="#">
                                    <i class="icon ph ph-chat-circle-dots"></i>
                                    <span class="text">Chat Online</span>
                                </a>
                            </li>
                            <div class="barrinha">
                                <hr>
                            </div>
                            <p class="title"></p>
                            <li class="active">
                                <a href="#">
                                    <i class="icon ph ph-info"></i>
                                    <span class="text">Suporte Técnico</span>
                                </a>
                            </li>
                            <li class="active">
                                <a href="#">
                                    <i class="icon ph ph-gear"></i>
                                    <span class="text">Configurações</span>
                                </a>
                            </li>
                            <li class="active" id="logout">
                                <a href="../control/gerenciador.php?action=sair">
                                    <i class="ph ph-sign-out"></i>
                                    <span class="text">Sair</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    <?php
    } else if (($cargo == 3)) {
    ?>
        <!-- Container principal da página -->
        <div class="container">
            <!-- Barra lateral -->
            <div class="sidebar">
                <!-- Cabeçalho da barra lateral -->
                <div class="head">
                    <!-- Imagem do usuário -->
                    <div class="user-img">
                        <img src="<?php echo $_SESSION['Caminho_Imagem'] ?>" alt="avatar">
                    </div>
                    <!-- Detalhes do usuário -->
                    <div class="user-details">
                        <p class="name"><?php echo $_SESSION['Nome'] ?></p>
                        <p class="title"><?php echo $desc_cargo ?></p>
                    </div>
                </div>

                <!-- Navegação -->
                <div class="nav">
                    <div class="menu">
                        <!-- Lista de itens de menu -->
                        <ul>
                            <!-- Item de menu ativo -->
                            <li class="active">
                                <a href="./inicio.php">
                                    <i class="icon ph-bold ph-house-simple"></i>
                                    <span class="text">Home</span>
                                </a>
                            </li>

                            <!-- Item de menu com submenu -->
                            <li>
                                <a href="#">
                                    <i class="icon ph-bold ph-user"></i>
                                    <span class="text">Público</span>
                                    <i class="arrow ph-bold ph-caret-down"></i>
                                </a>
                                <!-- Submenu -->
                                <ul class="sub-menu">
                                    <li>
                                        <a href="#">
                                            <span class="text">Clientes</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="./plataformaLions.php">
                                            <span class="text">Leads</span>
                                        </a>
                                    </li>
                                    <hr>
                                </ul>
                            </li>

                            <!-- Item de menu com submenu -->
                            <li>
                                <a href="#">
                                    <i class="icon ph ph-chart-bar"></i>
                                    <span class="text">Relatórios</span>
                                    <i class="arrow ph-bold ph-caret-down"></i>
                                </a>
                                <!-- Submenu -->
                                <ul class="sub-menu">
                                    <li>
                                        <a href="#">
                                            <span class="text">Vendas</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <span class="text">Leads</span>
                                        </a>
                                    </li>
                                    <hr>
                                </ul>
                            </li>

                            <!-- Outros itens de menu -->
                            <li class="active">
                                <a href="./Metas/meta.html">
                                    <i class="fa-solid fa-trophy"></i>
                                    <span class="text">Metas</span>
                                </a>
                            </li>
                            <li class="active">
                                <a href="./pagAgendamentos.php">
                                    <i class="ph ph-calendar"></i>
                                    <span class="text">Agenda</span>
                                </a>
                            </li>
                            <li class="active">
                                <a href="#">
                                    <i class="icon ph ph-bell"></i>
                                    <span class="text">Notificações</span>
                                </a>
                            </li>
                            <li class="active">
                                <a href="#">
                                    <i class="icon ph ph-chat-circle-dots"></i>
                                    <span class="text">Chat Online</span>
                                </a>
                            </li>
                            <div class="barrinha">
                                <hr>
                            </div>
                            <p class="title"></p>
                            <li class="active">
                                <a href="#">
                                    <i class="icon ph ph-info"></i>
                                    <span class="text">Suporte Técnico</span>
                                </a>
                            </li>
                            <li class="active">
                                <a href="#">
                                    <i class="icon ph ph-gear"></i>
                                    <span class="text">Configurações</span>
                                </a>
                            </li>
                            <li class="active" id="logout">
                                <a href="../control/gerenciador.php?action=sair">
                                    <i class="ph ph-sign-out"></i>
                                    <span class="text">Sair</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    <?php
    } else if (($cargo == 4)) {
    ?>
        <!-- Container principal da página -->
        <div class="container">
            <!-- Barra lateral -->
            <div class="sidebar">
                <!-- Cabeçalho da barra lateral -->
                <div class="head">
                    <!-- Imagem do usuário -->
                    <div class="user-img">
                        <img src="<?php echo $_SESSION['Caminho_Imagem'] ?>" alt="avatar">
                    </div>
                    <!-- Detalhes do usuário -->
                    <div class="user-details">
                        <p class="name"><?php echo $_SESSION['Nome'] ?></p>
                        <p class="title"><?php echo $desc_cargo ?></p>
                    </div>
                </div>

                <!-- Navegação -->
                <div class="nav">
                    <div class="menu">
                        <!-- Lista de itens de menu -->
                        <ul>
                            <!-- Item de menu ativo -->
                            <li class="active">
                                <a href="./inicio.php">
                                    <i class="icon ph-bold ph-house-simple"></i>
                                    <span class="text">Home</span>
                                </a>
                            </li>

                            <!-- Item de menu com submenu -->
                            <li>
                                <a href="#">
                                    <i class="icon ph-bold ph-user"></i>
                                    <span class="text">Público</span>
                                    <i class="arrow ph-bold ph-caret-down"></i>
                                </a>
                                <!-- Submenu -->
                                <ul class="sub-menu">
                                    <li>
                                        <a href="./plataformaLions.php">
                                            <span class="text">Leads</span>
                                        </a>
                                    </li>
                                    <hr>
                                </ul>
                            </li>

                            <!-- Outros itens de menu -->
                            <li class="active">
                                <a href="#">
                                    <i class="icon ph ph-magnifying-glass-plus"></i>
                                    <span class="text">Pesquisa Online</span>
                                </a>
                            </li>
                            <li class="active">
                                <a href="./pagAgendamentos.php">
                                    <i class="ph ph-calendar"></i>
                                    <span class="text">Agenda</span>
                                </a>
                            </li>
                            <li class="active">
                                <a href="#">
                                    <i class="icon ph ph-bell"></i>
                                    <span class="text">Notificações</span>
                                </a>
                            </li>
                            <li class="active">
                                <a href="#">
                                    <i class="icon ph ph-chat-circle-dots"></i>
                                    <span class="text">Chat Online</span>
                                </a>
                            </li>
                            <div class="barrinha">
                                <hr>
                            </div>
                            <p class="title"></p>
                            <li class="active">
                                <a href="#">
                                    <i class="icon ph ph-info"></i>
                                    <span class="text">Suporte Técnico</span>
                                </a>
                            </li>
                            <li class="active">
                                <a href="#">
                                    <i class="icon ph ph-gear"></i>
                                    <span class="text">Configurações</span>
                                </a>
                            </li>
                            <li class="active" id="logout">
                                <a href="../control/gerenciador.php?action=sair">
                                    <i class="ph ph-sign-out"></i>
                                    <span class="text">Sair</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    <?php
    } else if (($cargo == 5)) {
    ?>
        <!-- Container principal da página -->
        <div class="container">
            <!-- Barra lateral -->
            <div class="sidebar">
                <!-- Cabeçalho da barra lateral -->
                <div class="head">
                    <!-- Imagem do usuário -->
                    <div class="user-img">
                        <img src="<?php echo $_SESSION['Caminho_Imagem'] ?>" alt="avatar">
                    </div>
                    <!-- Detalhes do usuário -->
                    <div class="user-details">
                        <p class="name"><?php echo $_SESSION['Nome'] ?></p>
                        <p class="title"><?php echo $desc_cargo ?></p>
                    </div>
                </div>

                <!-- Navegação -->
                <div class="nav">
                    <div class="menu">
                        <!-- Lista de itens de menu -->
                        <ul>
                            <!-- Item de menu ativo -->
                            <li class="active">
                                <a href="./inicio.php">
                                    <i class="icon ph-bold ph-house-simple"></i>
                                    <span class="text">Home</span>
                                </a>
                            </li>

                            <!-- Item de menu com submenu -->
                            <li>
                                <a href="#">
                                    <i class="icon ph-bold ph-user"></i>
                                    <span class="text">Público</span>
                                    <i class="arrow ph-bold ph-caret-down"></i>
                                </a>
                                <!-- Submenu -->
                                <ul class="sub-menu">
                                    <li>
                                        <a href="#">
                                            <span class="text">Clientes</span>
                                        </a>
                                    </li>
                                    <hr>
                                </ul>
                            </li>

                            <!-- Outros itens de menu -->
                            <li class="active">
                                <a href="#">
                                    <i class="icon ph ph-magnifying-glass-plus"></i>
                                    <span class="text">Pesquisa Online</span>
                                </a>
                            </li>
                            <li class="active">
                                <a href="#">
                                    <i class="icon ph ph-bell"></i>
                                    <span class="text">Notificações</span>
                                </a>
                            </li>
                            <li class="active">
                                <a href="#">
                                    <i class="icon ph ph-chat-circle-dots"></i>
                                    <span class="text">Chat Online</span>
                                </a>
                            </li>
                            <div class="barrinha">
                                <hr>
                            </div>
                            <p class="title"></p>
                            <li class="active">
                                <a href="#">
                                    <i class="icon ph ph-info"></i>
                                    <span class="text">Suporte Técnico</span>
                                </a>
                            </li>
                            <li class="active">
                                <a href="#">
                                    <i class="icon ph ph-gear"></i>
                                    <span class="text">Configurações</span>
                                </a>
                            </li>
                            <li class="active" id="logout">
                                <a href="../control/gerenciador.php?action=sair">
                                    <i class="ph ph-sign-out"></i>
                                    <span class="text">Sair</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    ?>

    <script src="../js/script_sidbar.js"></script>
</body>

</html>