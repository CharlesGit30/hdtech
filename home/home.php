<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HDTECH - Página Inicial</title>

    <link rel="stylesheet" href="../style.css">
    <link rel="shortcut icon" href="../imagens/favicon.ico">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>

<?php include "../home/header.php"; ?>

<section class="inicio" id="inicio">

    <div class="inicio-overlay"></div>

    <img src="../imagens/banner_realista_esquerda.jpg" alt="HDTECH Banner">

    <div class="inicio-texto">
        <h1>HD <span>Tech</span></h1>
        <p>Sistema de gestão de produtos e tecnologia com controle completo.</p>

        <a href="../processamento/read.php" class="botao">
            Acessar Produtos
        </a>
    </div>

</section>

</body>
</html>