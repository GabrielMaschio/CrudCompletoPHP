<?php
    // Incluir arquivo de configuração com conexão de base de dados
    include '../model/marca.php';
    include '../Config/Config.php';

    if ($conexao->connect_error) {
        die("Erro ao conectar ao banco de dados: " . $conexao->connect_error);
    }
    
    $query = "SELECT * FROM marca ORDER BY nome_marca ASC";
    $result = $conexao->query($query);
    
    $marcas = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $marca = new Marca($row["id"], $row["nome_marca"]);
            // Adiciona o objeto Marca ao array de marcas
            $marcas[] = $marca;
        }
    } 

    // Transforma o array de objetos Marca em JSON
    $json_marcas = json_encode($marcas);

    // // Escreve o JSON em um arquivo
    // $file = '../json/marcas.json';
    // file_put_contents($file, $json_marcas);

    echo $json_marcas;

    $conexao->close();