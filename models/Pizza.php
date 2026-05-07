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

    public function get(){
        $query = 'SELECT
            idPizza,
            nome,
            ingredientes,
            valor
        FROM
            ' . $this->tabela . '
        WHERE
            idPizza = ?
        LIMIT 1';
 
         // Prepara a query
        $stmt = $this->conn->prepare($query);
 
        // Vincula o ID
        $stmt->bindParam(1, $this->idPizza);
   
        // Executa a query
        $stmt->execute();
 
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
        // Define as propriedades
        $this->nome = $row['nome'];
        $this->ingredientes = $row['ingredientes'];
        $this->valor = $row['valor'];
    }
}