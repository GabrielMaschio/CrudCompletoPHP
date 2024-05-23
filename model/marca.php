<?php
class Marca {
    public $id;
    public $nome_marca;

    public function __construct($id, $nome_marca) {
        $this->id = $id;
        $this->nome_marca = $nome_marca;
    }
}