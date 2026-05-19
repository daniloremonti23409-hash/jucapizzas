<?php

class Bebida {

    private $conn;
    private $tabela = 'bebidas';

    public $idBebidas;
    public $nomeBebida;
    public $valorBebida;
    public $categoriaBebida;
    public $tamanho;

    // CONSTRUTOR
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

            $this->idBebidas = $row['idBebidas'];
            $this->nomeBebida = $row['nomeBebida'];
            $this->valorBebida = $row['valorBebida'];
            $this->categoriaBebida = $row['categoriaBebida'];
            $this->tamanho = $row['tamanho'];
        }
    }

    // ADICIONAR
    public function add() {

        $query = "INSERT INTO " . $this->tabela . "
                  SET
                    nomeBebida = :nomeBebida,
                    valorBebida = :valorBebida,
                    categoriaBebida = :categoriaBebida,
                    tamanho = :tamanho";

        $stmt = $this->conn->prepare($query);

        $this->nomeBebida = htmlspecialchars(strip_tags($this->nomeBebida));
        $this->valorBebida = htmlspecialchars(strip_tags($this->valorBebida));
        $this->categoriaBebida = htmlspecialchars(strip_tags($this->categoriaBebida));
        $this->tamanho = htmlspecialchars(strip_tags($this->tamanho));

        $stmt->bindParam(':nomeBebida', $this->nomeBebida);
        $stmt->bindParam(':valorBebida', $this->valorBebida);
        $stmt->bindParam(':categoriaBebida', $this->categoriaBebida);
        $stmt->bindParam(':tamanho', $this->tamanho);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // ATUALIZAR
    public function update() {

        $query = "UPDATE " . $this->tabela . "
                  SET
                    nomeBebida = :nomeBebida,
                    categoriaBebida = :categoriaBebida,
                    valorBebida = :valorBebida,
                    tamanho = :tamanho
                  WHERE
                    idBebidas = :idBebidas";

        $stmt = $this->conn->prepare($query);

        $this->idBebidas = htmlspecialchars(strip_tags($this->idBebidas));
        $this->nomeBebida = htmlspecialchars(strip_tags($this->nomeBebida));
        $this->categoriaBebida = htmlspecialchars(strip_tags($this->categoriaBebida));
        $this->valorBebida = htmlspecialchars(strip_tags($this->valorBebida));
        $this->tamanho = htmlspecialchars(strip_tags($this->tamanho));

        $stmt->bindParam(':idBebidas', $this->idBebidas);
        $stmt->bindParam(':nomeBebida', $this->nomeBebida);
        $stmt->bindParam(':categoriaBebida', $this->categoriaBebida);
        $stmt->bindParam(':valorBebida', $this->valorBebida);
        $stmt->bindParam(':tamanho', $this->tamanho);

        if($stmt->execute()) {
            return true;
        }

        return false;
    }
}