<?php
    include "../config.php";
    include "../login/auth.php";
    verificarLogin();

    function listarProdutos($conexao) {
        $sql = "SELECT * FROM produtos ORDER BY id DESC";
        return $conexao->query($sql);
    }
        $resultado = listarProdutos($conexao);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos Cadastrados da HDTECH</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<?php include "../home/header.php" ?>
<div class="container">

    <h2>Meus Produtos</h2>

    <a href="../processamento/create.php" class="btn">
        Novo Produto
    </a>

    <table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Imagem</th>
        <th>Nome</th>
        <th>Categoria</th>
        <th>Marca</th>
        <th>Modelo</th>
        <th>Preco</th>
        <th>Estoque</th>
        <th></th>
        <th></th>
    </tr>

    <?php while ($produto = $resultado->fetch_assoc()): ?>
<tr>
    <td><?= $produto['id'] ?></td>
    <td>
    <?php if ($produto['imagem']): ?>
        <img src="../uploads/<?= $produto['imagem'] ?>" width="60">
    <?php endif; ?>
</td>

    <td><?= $produto['nome'] ?></td>
    <td><?= $produto['categoria'] ?></td>
    <td><?= $produto['marca'] ?></td>
    <td><?= $produto['modelo'] ?></td>
    <td><?= number_format($produto['preco'], 2, ',', '.') ?></td>
    <td><?= $produto['estoque'] ?></td>
    <td><a href="../processamento/update.php?id=<?= $produto['id'] ?>">Editar</a></td>
    <td><a href="../processamento/delete.php?id=<?= $produto['id'] ?>">Deletar</a></td>
</tr>
<?php endwhile; ?>
</table>
</div>

</body>
</html>

