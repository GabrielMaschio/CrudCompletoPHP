<?php

include '../Config/Config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($conexao->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conexao->connect_error);
    }

    $nome_produto = $_POST['nome_produto'];
    $quantidade = $_POST['quantidade'];
    $valor = $_POST['valor'];
    $id_tipo = $_POST['id_tipo'];
    $id_marca = $_POST['id_marca'];

    $sql = "INSERT INTO produto(nome_produto, quantidade, valor, id_tipo_fk, id_marca_fk) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conexao->prepare($sql);

    $stmt->bind_param("sssss", $nome_produto, $quantidade, $valor, $id_tipo, $id_marca);

    if ($stmt->execute()) {
        $retorna = ['status' => true, 'msg' => "Produto cadastrado com sucesso!"];
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