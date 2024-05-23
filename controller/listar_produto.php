<?php
    include '../model/produto.php';
    include '../Config/Config.php';

    if ($conexao->connect_error) {
        die("Erro ao conectar ao banco de dados: " . $conexao->connect_error);
    }

    $query = "SELECT produto.id, nome_produto, quantidade, valor, nome_tipo, id_tipo_fk AS id_tipo, nome_marca, id_marca_fk AS id_marca
              FROM produto, tipo, marca
              WHERE id_tipo_fk = tipo.id AND id_marca_fk = marca.id 
              ORDER BY id ASC";
    $result = $conexao->query($query);
    
    $produtos = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $produto = new Produto($row["id"], $row["nome_produto"], $row["quantidade"], $row["valor"], 
                                   $row["nome_tipo"], $row["id_tipo"], $row["nome_marca"], $row["id_marca"]);
            $produtos[] = $produto;
        }
    } 

    echo json_encode($produtos);

    $conexao->close();