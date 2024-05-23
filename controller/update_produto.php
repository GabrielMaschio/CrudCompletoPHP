<?php

include '../Config/Config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($conexao->connect_error) {
        $retorna = ['status' => false, 'msg' => "Erro: Erro na conexão com o banco de dados!"];
    }

    $fixed_id = $_POST['fixed_id'];
    $id = $_POST['id'];
    $nome_produto = $_POST['nome_produto'];
    $quantidade = $_POST['quantidade'];
    $valor = $_POST['valor'];
    $id_tipo_fk = $_POST['id_tipo_fk'];
    $id_marca_fk = $_POST['id_marca_fk'];


    if(empty($fixed_id)) {
        $retorna = ['status' => false, 'msg' => "Erro: Não foi possivel acessar o elemento!"];
    } else if(empty($id)) {
        $retorna = ['status' => false, 'msg' => "Erro: Necessário preencher o campo: Id!"];
    } else if($nome_produto < 2) {
        $retorna = ['status' => false, 'msg' => "Erro: Produto deve ter mais que dois caracteres!"];
    } else if($quantidade < 0) {
        $retorna = ['status' => false, 'msg' => "Erro: Quantidade deve ser maior que 0!"];
    } else if($valor < 0) {
        $retorna = ['status' => false, 'msg' => "Erro: Valor deve ser maior que 0!"];
    } else {
       
     
        $stmt = $conexao->prepare("UPDATE produto SET id = ?, nome_produto = ?, quantidade = ?, valor = ?, id_tipo_fk = ?, id_marca_fk = ? WHERE id = ?");
        $stmt->bind_param("ssssssi", $id, $nome_produto, $quantidade, $valor, $id_tipo_fk, $id_marca_fk, $fixed_id);

        
        // Executa a query
        if ($stmt->execute()) {
            $retorna = ['status' => true, 'msg' => "Produto atualizada com sucesso!"];
        } else {
            $retorna = ['status' => false, 'msg' => "Erro: Produto não atualizada com sucesso!"];
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