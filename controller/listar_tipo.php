<?php
    include '../model/tipo.php';
    include '../Config/Config.php';

    if ($conexao->connect_error) {
        die("Erro ao conectar ao banco de dados: " . $conexao->connect_error);
    }
    
    $query = "SELECT * FROM tipo ORDER BY nome_tipo ASC";
    $result = $conexao->query($query);
    
    $tipos = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tipo = new Tipo($row["id"], $row["nome_tipo"]);

            $tipos[] = $tipo;
        }
    } 

    echo json_encode($tipos);

    $conexao->close();