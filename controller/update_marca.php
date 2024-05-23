<?php

include '../Config/Config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($conexao->connect_error) {
        $retorna = ['status' => false, 'msg' => "Erro: Erro na conexão com o banco de dados!"];
    }

    $fixed_id = $_POST['fixed_id'];
    $id = $_POST['id'];
    $nome_marca = $_POST['nome_marca'];

    if(empty($fixed_id)) {
        $retorna = ['status' => false, 'msg' => "Erro: Não foi possivel acessar o elemento!"];
    } else if(empty($id)) {
        $retorna = ['status' => false, 'msg' => "Erro: Necessário preencher o campo: Id!"];
    } else if($nome_marca < 2) {
        $retorna = ['status' => false, 'msg' => "Erro: O nome da marca deve ter mais que dois caracteres!"];
    } else {
       
     
        $stmt = $conexao->prepare("UPDATE marca SET id = ?, nome_marca = ? WHERE id = ?");
        $stmt->bind_param("ssi", $id, $nome_marca, $fixed_id);

        
        // Executa a query
        if ($stmt->execute()) {
            $retorna = ['status' => true, 'msg' => "Marca atualizada com sucesso!"];
        } else {
            $retorna = ['status' => false, 'msg' => "Erro: Marca não atualizada com sucesso!"];
        }
    }

    echo json_encode($retorna);

    // Fecha a conexão
    $stmt->close();
    $conexao->close();
} else {
    // Se o formulário não foi enviado, redireciona para a página de cadastro
    $retorna = ['status' => false, 'msg' => "Erro: O formulário não foi enviado!"];
    echo json_encode($retorna);
    exit();
}