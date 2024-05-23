<?php

// Incluir arquivo de configuração
include '../Config/Config.php';

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se ocorreu algum erro na conexão
    if ($conexao->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conexao->connect_error);
    }

    // Recupera os dados do formulário
    $nome_marca = $_POST['nome_marca'];


    // Prepara a query de inserção
    $sql = "INSERT INTO marca(nome_marca) VALUES (?)";
    $stmt = $conexao->prepare($sql);

    // Associa os parâmetros com os valores do formulário
    $stmt->bind_param("s", $nome_marca);

    // Executa a query
    if ($stmt->execute()) {
        $retorna = ['status' => true, 'msg' => "Usuário cadastrado com sucesso!"];
    } else {
        $retorna = ['status' => false, 'msg' => "Erro: Usuário não cadastrado com sucesso!"];
    }

    echo json_encode($retorna);

    // Fecha a conexão
    $stmt->close();
    $conexao->close();
} else {
    // Se o formulário não foi enviado, redireciona para a página de cadastro
    header("Location: ../view/tela_principal.php");
    exit();
}