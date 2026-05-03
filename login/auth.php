<?php
    session_start();
    function verificarLogin(){
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: ../login/login.php");
            exit;
        }
    }
?>