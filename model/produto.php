<?php
class Produto {
    public $id;
    public $nome_produto;
    public $quantidade;
    public $valor;
    public $nome_tipo;
    public $id_tipo;
    public $nome_marca;
    public $id_marca;

    public function __construct($id, $nome_produto, $quantidade, $valor, $nome_tipo, $id_tipo, $nome_marca, $id_marca) {
        $this->id = $id;
        $this->nome_produto = $nome_produto;
        $this->quantidade = $quantidade;
        $this->valor = $valor;
        $this->nome_tipo = $nome_tipo;
        $this->id_tipo = $id_tipo;
        $this->nome_marca = $nome_marca;
        $this->id_marca = $id_marca;
    }
}