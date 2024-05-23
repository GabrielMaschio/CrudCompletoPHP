<?php

// Incluir arquivo de configuração
include '../Config/Config.php';

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se ocorreu algum erro na conexão
    if ($conexao->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conexao->connect_error);
    }

    $id = $_POST['id'];

    $sql = "DELETE FROM marca WHERE id = ?";
    $stmt = $conexao->prepare($sql);

    $stmt->bind_param("i", $id);

    // Executa a query
    if ($stmt->execute()) {
        $retorna = ['status' => true, 'msg' => "Marca deletada com sucesso!"];
    } else {
        $retorna = ['status' => false, 'msg' => "Erro: Marca não deletada!"];
    }

    echo json_encode($retorna);

    // Fecha a conexão
    $stmt->close();
    $conexao->close();
} else {
    // Se o formulário não foi enviado, redireciona para a página de cadastro
    $retorna = ['status' => false, 'msg' => "Erro: O formulário não foi enviado!"];
    exit();
}