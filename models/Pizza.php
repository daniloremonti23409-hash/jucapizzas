<?php

class Pizza{

    private $conn;

    // Nome da tabela
    private $tabela = 'pizzas';

    public $idPizza;
    public $nome;
    public $ingredientes;
    public $valor;

    public function __construct($conexao){
        $this->conn = $conexao;
    }

    public function getall(){
        // Salvando a query em SQL em uma variavel
        $query = "SELECT idPizza, nome, ingredientes, valor FROM " . $this->tabela;

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

        // CORREÇÃO AQUI: Verifica se a busca realmente retornou algo antes de preencher
        if ($row) {
            $this->nome = $row['nome'];
            $this->ingredientes = $row['ingredientes'];
            $this->valor = $row['valor'];
        } else {
            // Se não encontrou, deixa nulo (Isso faz o Erro 404 do get.php funcionar!)
            $this->nome = null;
        }
    }

    public function add(){
        // CORREÇÃO AQUI: Trocado $this->table_name por $this->tabela
        $query = 'INSERT INTO ' . $this->tabela . ' SET nome = :nome, ingredientes = :ingredientes, valor = :valor';

        // Preparar a query
        $stmt = $this->conn->prepare($query);

        // Limpar os dados
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->ingredientes = htmlspecialchars(strip_tags($this->ingredientes));
        $this->valor = htmlspecialchars(strip_tags($this->valor));

        // Vincular os parâmetros
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':ingredientes', $this->ingredientes);
        $stmt->bindParam(':valor', $this->valor);

        // Executar a query
        if ($stmt->execute()) {
            return true;
        }        
        return false;

    }
}