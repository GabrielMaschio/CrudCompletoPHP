<?php

include '../Config/Config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($conexao->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conexao->connect_error);
    }

    $nome_tipo = $_POST['nome_tipo'];

    $sql = "INSERT INTO tipo(nome_tipo) VALUES (?)";
    $stmt = $conexao->prepare($sql);

    $stmt->bind_param("s", $nome_tipo);

    if ($stmt->execute()) {
        $retorna = ['status' => true, 'msg' => "Tipo cadastrado com sucesso!"];
    } else {
        $retorna = ['status' => false, 'msg' => "Erro: Não foi possivel realizar o cadastrado!"];
    }

    echo json_encode($retorna);

    $stmt->close();
    $conexao->close();
} else {
    header("Location: ../view/tela_principal.php");
    exit();
}