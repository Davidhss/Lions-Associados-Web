<?php
if (isset($_POST['login'])) {
    include('./control/conexao.php');
    include "./control/functions.php";
    
    verificarLogin();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Lions Associados</title>
    <link rel="stylesheet" href="./css/style_login.css">
    <link rel="shortcut icon" href="./Logo.ico" type="ico">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
   
</head>

<body>

    <div class="box-degrade">

        <div class="logotipo">
            <img src="./img/Logotipo-Branco_2.png" alt="Lions">
        </div>
        <div class="wrapper">
            <form action="index.php" method="post">
                <h3>Seja muito bem vindo,</h3>
                <span>Insira as informações para entrar:</span> 

                <div class="input-box">
                    <input type="text" placeholder="Login" required autocomplete="off" name="login">
                    <i class='bx bxs-user'></i>
                </div>
    
    
                <div class="input-box">
                    <input type="password" autocomplete="off" placeholder="Senha" required name="senha">
                    <i class='bx bxs-lock'></i>
                </div>
    
                <!-- <div class="remember-forgot">
                    <label><input type="checkbox">Lembrar minha senha</label>
                    <a href="#">Esqueci minha senha</a>
                </div> -->
                
                <input type="submit" value="Entrar" class="btn">
    
                <!-- <div class="register-link">
                    <p>Não possui uma conta? <a href="#">Registra-se</a></p>
                </div> -->
    
    
            </form>
    
    
        </div>

    </div>

</body>

</html>