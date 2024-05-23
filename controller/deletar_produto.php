<?php

include '../Config/Config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($conexao->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conexao->connect_error);
    }

    $id = $_POST['id'];

    $sql = "DELETE FROM produto WHERE id = ?";
    $stmt = $conexao->prepare($sql);

    $stmt->bind_param("i", $id);

    // Executa a query
    if ($stmt->execute()) {
        $retorna = ['status' => true, 'msg' => "Produto deletado com sucesso!"];
    } else {
        $retorna = ['status' => false, 'msg' => "Erro: Produto não deletado!"];
    }

    echo json_encode($retorna);

    $stmt->close();
    $conexao->close();
} else {
    $retorna = ['status' => false, 'msg' => "Erro: O formulário não foi enviado!"];
    exit();
}