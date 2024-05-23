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
    $nome_usuario = $_POST['nome_usuario'];
    $senha = $_POST['senha'];

    // Cria o hash da senha (substitua o método de hash conforme necessário)
    $hashed_password = password_hash($senha, PASSWORD_DEFAULT);

    // Prepara a query de inserção
    $sql = "INSERT INTO usuarios (nome_usuario, senha) VALUES (?, ?)";
    $stmt = $conexao->prepare($sql);

    // Associa os parâmetros com os valores do formulário
    $stmt->bind_param("ss", $nome_usuario, $hashed_password);

    // Executa a query
    if ($stmt->execute()) {
        header("Location: ../index.php");
    } else {
        echo "Erro ao cadastrar o usuário: " . $stmt->error;
    }

    // Fecha a conexão
    $stmt->close();
    $conexao->close();
} else {
    // Se o formulário não foi enviado, redireciona para a página de cadastro
    header("Location: ../view/cadastrar_usuario.php");
    exit();
}