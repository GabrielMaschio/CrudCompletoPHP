<?php

include '../Config/Config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($conexao->connect_error) {
        $retorna = ['status' => false, 'msg' => "Erro: Erro na conexão com o banco de dados!"];
    }

    $fixed_id = $_POST['fixed_id'];
    $id = $_POST['id'];
    $nome_tipo = $_POST['nome_tipo'];

    if(empty($fixed_id)) {
        $retorna = ['status' => false, 'msg' => "Erro: Não foi possivel acessar o elemento!"];
    } else if(empty($id)) {
        $retorna = ['status' => false, 'msg' => "Erro: Necessário preencher o campo: Id!"];
    } else if($nome_tipo < 2) {
        $retorna = ['status' => false, 'msg' => "Erro: O nome do tipo deve ter mais que dois caracteres!"];
    } else {
       
     
        $stmt = $conexao->prepare("UPDATE tipo SET id = ?, nome_tipo = ? WHERE id = ?");
        $stmt->bind_param("ssi", $id, $nome_tipo, $fixed_id);

        
        // Executa a query
        if ($stmt->execute()) {
            $retorna = ['status' => true, 'msg' => "Tipo atualizada com sucesso!"];
        } else {
            $retorna = ['status' => false, 'msg' => "Erro: Tipo não atualizada com sucesso!"];
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