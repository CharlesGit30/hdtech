<?php
include '../config.php';
include '../login/auth.php';
verificarLogin();

function uploadImagem($file) {

    $pasta = "../uploads/";
    $nomeArquivo = time() . "_" . basename($file['name']);
    $caminho = $pasta . $nomeArquivo;

    if (move_uploaded_file($file['tmp_name'], $caminho)) {
        return $nomeArquivo;
    }

    return null;
}


function atualizarProduto($conexao, $id, $nome, $categoria, $marca, $modelo, $preco, $estoque, $descricao, $imagem) {

    if ($imagem) {

        $funcao = $conexao->prepare("
            UPDATE produtos 
            SET nome=?, categoria=?, marca=?, modelo=?, preco=?, estoque=?, descricao=?, imagem=? 
            WHERE id=?
        ");

        $funcao->bind_param(
            "ssssdissi",
            $nome,
            $categoria,
            $marca,
            $modelo,
            $preco,
            $estoque,
            $descricao,
            $imagem,
            $id
        );

    } else {

        $funcao = $conexao->prepare("
            UPDATE produtos 
            SET nome=?, categoria=?, marca=?, modelo=?, preco=?, estoque=?, descricao=? 
            WHERE id=?
        ");

        $funcao->bind_param(
            "ssssdisi",
            $nome,
            $categoria,
            $marca,
            $modelo,
            $preco,
            $estoque,
            $descricao,
            $id
        );
    }

    return $funcao->execute();
}

if (isset($_POST['id'], $_POST['nome'], $_POST['preco'], $_POST['estoque'])) {

    $id = (int) $_POST['id'];
    $nome = $_POST['nome'];
    $categoria = $_POST['categoria'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $preco = $_POST['preco'];
    $estoque = $_POST['estoque'];
    $descricao = $_POST['descricao'];

  
    $imagem = null;
    if (isset($_FILES['imagem']) && $_FILES['imagem']['name'] != "") {
        $imagem = uploadImagem($_FILES['imagem']);
    }

    if (empty($nome) || empty($preco) || empty($estoque)) {
        echo "Preencha os campos obrigatórios!";
        exit;
    }

    if (atualizarProduto($conexao, $id, $nome, $categoria, $marca, $modelo, $preco, $estoque, $descricao, $imagem)) {
        header("Location: ../processamento/read.php");
        exit;
    } else {
        echo "Erro ao atualizar!";
    }
}

?>




<?php 
  

    function buscarProduto($conexao, $id){
        $funcao = $conexao->prepare("SELECT * FROM produtos WHERE id = ?");
        $funcao->bind_param("i", $id);
        $funcao->execute();
        return $funcao->get_result()->fetch_assoc();
    }

    if (isset($_GET['id'])) {
        $id = (int) $_GET['id'];
        $produto = buscarProduto($conexao, $id);
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto da HDTECH</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <?php include "../home/header.php" ?>

    
    <form method="POST" enctype="multipart/form-data">
    <h2>Editar Produto</h2>
    <input type="hidden" name="id" value="<?= $produto['id'] ?>">
    <?php if (!empty($produto['imagem'])): ?>
            <img src="../uploads/<?= $produto['imagem'] ?>" class="preview-img">
            <?php endif; ?>
    <input type="file" name="imagem">

    <input type="text" name="nome" value="<?= htmlspecialchars($produto['nome']) ?>">
    <input type="text" name="categoria" value="<?= htmlspecialchars($produto['categoria']) ?>">
    <input type="text" name="marca" value="<?= htmlspecialchars($produto['marca']) ?>">
    <input type="text" name="modelo" value="<?= htmlspecialchars($produto['modelo']) ?>">

    <input type="number" name="preco" step="0.01" value="<?= $produto['preco'] ?>" required>
    <input type="number" name="estoque" value="<?= $produto['estoque'] ?>" required>

    <textarea name="descricao"><?= htmlspecialchars($produto['descricao']) ?></textarea>

    <button type="submit">Atualizar Produto</button>
</form>

</body>
</html>
