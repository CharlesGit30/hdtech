<?php 
    include "../config.php";
    include "../login/auth.php";
    verificarLogin();

    function deletarProduto($conexao, $id){
        $funcao = $conexao->prepare("DELETE FROM produtos WHERE id = ?");
        $funcao->bind_param("i", $id);
        return $funcao->execute();
    }

    if(isset($_GET['id'])){
        $id = $_GET['id'];

        if ($id) {
            if(deletarProduto($conexao, $id)) {
                header("Location: ../processamento/read.php");
                exit;
            } else {
                echo "Erro ao Deletar";
            }
        } else{
            echo "ID invalido";
        }
    }
?>