<?php
include "../config.php";
include "../login/auth.php";
verificarLogin();

function uploadImagem($file) {

    $pasta = "../uploads/";

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    
    $permitidos = ['jpg', 'jpeg', 'png', 'webp'];

    if (!in_array($ext, $permitidos)) {
        return null;
    }

    
    $nomeArquivo = uniqid("img_", true) . "." . $ext;

    $caminho = $pasta . $nomeArquivo;

    if (move_uploaded_file($file['tmp_name'], $caminho)) {
        return $nomeArquivo;
    }

    return null;
}


function inserirProduto($conexao, $nome, $categoria, $marca, $modelo, $preco, $estoque, $descricao, $imagem) {

    $funcao = $conexao->prepare("INSERT INTO produtos (nome, categoria, marca, modelo, preco, estoque, descricao, imagem) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    $funcao->bind_param("ssssdiss", $nome, $categoria, $marca, $modelo, $preco, $estoque, $descricao, $imagem);

    return $funcao->execute();
}


if (isset($_POST['nome'], $_POST['categoria'], $_POST['marca'], $_POST['modelo'], $_POST['preco'], $_POST['estoque'])) {

    $nome = $_POST['nome'];
    $categoria = $_POST['categoria'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $preco = (float) $_POST['preco'];
    $estoque = (int) $_POST['estoque'];
    $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : "";

    $imagem = null;
    if (isset($_FILES['imagem']) && $_FILES['imagem']['name'] != "") {
        $imagem = uploadImagem($_FILES['imagem']);
    }

 
    if (empty($nome) || empty($preco) || empty($estoque)) {

        $erro = "Preencha os campos obrigatórios!";

    } else {

        if (inserirProduto($conexao, $nome, $categoria, $marca, $modelo, $preco, $estoque, $descricao, $imagem)) {

            header("Location: ../processamento/read.php");
            exit;

        } else {
            $erro = "Erro ao cadastrar produto!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produtos HDTECH</title>
    <link rel="stylesheet" href="/hdtech/style.css">
</head>
<body>
    <?php include "../home/header.php" ?>
    
        <form method="POST" enctype="multipart/form-data">
            <h2>Cadastrar Produto</h2>
           
            <input type="file" name="imagem">
            <input type="text" name="nome" placeholder="Nome do Produto" required>
            <input type="text" name="categoria" placeholder="Categoria" required>
            <input type="text" name="marca" placeholder="Marca do Produto" required>
            <input type="text" name="modelo" placeholder="Modelo do Produto" required>
            <input type="number" name="preco" step="0.01" placeholder="Preço do Produto" required>
            <input type="number" name="estoque" placeholder="Estoque do Produto" required>
            <textarea name="descricao" placeholder="Descrição do Produto"></textarea>
            <button type="submit">Cadastrar Produto</button>
        </form>

</body>
</html>