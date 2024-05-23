<?php
class Tipo {
    public $id;
    public $nome_tipo;

    public function __construct($id, $nome_tipo) {
        $this->id = $id;
        $this->nome_tipo = $nome_tipo;
    }
}