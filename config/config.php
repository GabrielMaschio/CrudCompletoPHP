<?php
// Configurações do banco de dados
$hostname = "localhost"; // Endereço do servidor MySQL
$username = "root";      // Nome de usuário do MySQL
$password = "";          // Senha do MySQL
$database = "loja_unifunec";  // Nome do banco de dados

// Tentar estabelecer a conexão com o banco de dados
$conexao = mysqli_connect($hostname, $username, $password, $database);

// Verificar se a conexão foi estabelecida com sucesso
    if ($conexao->connect_error) {
        // Se ocorreu um erro ao conectar, exibir mensagem de erro
        die("Falha na conexão: " . $conn->connect_error);
    }

// Fechar a conexão
//mysqli_close($conexao);