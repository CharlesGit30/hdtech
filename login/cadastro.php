<?php 
include "../config.php";
session_start();

function registrar($conexao, $nome, $email, $senha){
    $funcao = $conexao->prepare("SELECT id FROM usuarios WHERE email = ?");
    $funcao->bind_param("s", $email);
    $funcao->execute();

    if ($funcao->get_result()->num_rows > 0) {
        return "Email já cadastrado";
    }

    $hash = password_hash($senha, PASSWORD_DEFAULT);

    $funcao = $conexao->prepare("INSERT INTO usuarios(nome, email, senha) VALUES (?, ?, ?)");
    $funcao->bind_param("sss", $nome, $email, $hash);

    if ($funcao->execute()) {
        return true;
    }
    return "Erro ao cadastrar usuário";
}

$erro = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $resultado = registrar($conexao, $nome, $email, $senha);

    if ($resultado === true) {
        header("Location: ../login/login.php");
        exit;
    } else {
        $erro = $resultado;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro da HDTECH</title>
</head>
<body>

<form method="POST">
    <input type="text" name="nome" placeholder="Nome" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="senha" placeholder="Senha" required>
    <button type="submit">Cadastrar</button>
</form>

<?php if (!empty($erro)) echo "<p>$erro</p>"; ?>

</body>
</html>