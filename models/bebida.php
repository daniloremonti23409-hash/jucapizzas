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

    // ADICIONAR UMA BEBIDA
    public function add() {
        // Query de inserção
        $query = "INSERT INTO " . $this->tabela . " 
                  SET nomeBebida = :nomeBebida, 
                      valorBebida = :valorBebida, 
                      categoriaBebida = :categoriaBebida, 
                      tamanho = :tamanho";

        // Preparar a declaração
        $stmt = $this->conn->prepare($query);

        // Limpar os dados para evitar injeção de código (segurança)
        $this->nomeBebida = htmlspecialchars(strip_tags($this->nomeBebida));
        $this->valorBebida = htmlspecialchars(strip_tags($this->valorBebida));
        $this->categoriaBebida = htmlspecialchars(strip_tags($this->categoriaBebida));
        $this->tamanho = htmlspecialchars(strip_tags($this->tamanho));

        // Fazer o bind dos valores
        $stmt->bindParam(':nomeBebida', $this->nomeBebida);
        $stmt->bindParam(':valorBebida', $this->valorBebida);
        $stmt->bindParam(':categoriaBebida', $this->categoriaBebida);
        $stmt->bindParam(':tamanho', $this->tamanho);

        // Executar a query e retornar true se der certo
        if ($stmt->execute()) {
            return true;
        }

        // Correção para versões mais antigas do PHP
        $erro = $stmt->errorInfo();
        printf("Error: %s.\n", $erro[2]);
        
        return false;
    }
}