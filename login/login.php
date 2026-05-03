<?php 
include "../config.php";
session_start();

function autenticar($conexao, $email, $senha){
    $funcao = $conexao->prepare("SELECT id, nome, email, senha FROM usuarios WHERE email = ?");
    $funcao->bind_param("s", $email);
    $funcao->execute();

    $resultado = $funcao->get_result();
    $usuario = $resultado->fetch_assoc();

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        return true;
    }
    return false;
}

$erro = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    if (autenticar($conexao, $email, $senha)){
        header("Location: ../home/home.php");
        exit;
    } else {
        $erro = "Email ou Senha inválidos";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login da HDTECH</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<?php include "../home/header.php" ?>

<form method="POST">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="senha" placeholder="Senha" required>
    <button type="submit">Realizar Login</button> 
</form>

<?php if (!empty($erro)) echo "<p>$erro</p>"; ?>

</body>
</html>