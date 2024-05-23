<?php
    session_start();

    if(empty($_POST) || (empty($_POST["usuario"])) || (empty($_POST["senha"]))) {
        header("Location: ../index.php");
    }

    include '../Config/Config.php';

    $usuario = $_POST["usuario"];
    $senha = $_POST["senha"];

    $sql = "SELECT * FROM usuarios WHERE nome_usuario = ?";
    $stmt  = $conexao->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();

    $result = $stmt->get_result();

    if($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if(password_verify($senha, $row['senha'])) {
            $_SESSION["loggedin"] = true;
            header("location: ../view/tela_principal.php");
            exit;
        } else {
            header("location: ../index.php");
        }
    } else {
        header("location: ../view/cadastrar_usuario.php");
    }

    $stmt->close();
    $conexao->close();