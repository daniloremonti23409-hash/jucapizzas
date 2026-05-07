<?php

class Bebida {

    private $conn;

    private $tabela = 'bebidas';

    public $idBebidas;
    public $nomeBebida;
    public $valorBebida;
    public $categoriaBebida;
    public $tamanho;

    // construtor
    public function __construct($conexao){
        $this->conn = $conexao;
    }

    // LISTAR TODAS
    public function getall(){

        $query = "SELECT 
                    idBebidas,
                    nomeBebida,
                    valorBebida,
                    categoriaBebida,
                    tamanho
                  FROM " . $this->tabela;

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    // BUSCAR UMA BEBIDA
    public function get(){

        $query = "SELECT 
                    idBebidas,
                    nomeBebida,
                    valorBebida,
                    categoriaBebida,
                    tamanho
                  FROM " . $this->tabela . "
                  WHERE idBebidas = ?
                  LIMIT 1";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->idBebidas);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row){

            $this->nomeBebida = $row['nomeBebida'];
            $this->valorBebida = $row['valorBebida'];
            $this->categoriaBebida = $row['categoriaBebida'];
            $this->tamanho = $row['tamanho'];
        }
    }
}