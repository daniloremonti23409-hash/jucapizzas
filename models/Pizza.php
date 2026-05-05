<?php


class Pizza{

    private $conn;

    private $tabela = 'pizzas';

    public $idPizza;
    public $nome;
    public $ingredientes;
    public $valor;

    public function __construct($conexao){
        $this->conn = $conexao;
    }

   public function  getall(){
//Salvando a query em SQL em uma variavel
        $query =    "SELECT idPizza, nome, ingredientes, valor FROM " . $this->tabela;


        // Preparando a query para ser executada, ou seja, vinculando ela a conexão
        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }
}