<?php

class bebidas{

private $conn;

private $tabela = 'bebidas';

public $idBebids;
public $nomeBebida;
public $valorBebida;
public $categoriaBebida;
public $tamanho;


public function _construct($conexao){
    $this->conn = $conexao;
}

public function  getall(){

$query =    "SELECT idBebida, nomeBebida, valorBebida, categoriaBebida, tamanho FROM " . $this->tabela;


$stmt = $this->conn->prepare($query);

$stmt->execute();
return $stmt;
}
}