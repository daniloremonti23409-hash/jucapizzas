<?php

class Database
{

private $host = 'localhost';
private $db_name = 'jucapizza';
private $username = 'root';
private $password = 'usbw';
private $port = '3306';

public $conn;

//Finally(depois do catch): Tendo erro ou não, o codigo irá rodar. Estrutura=> finally{}//

public function getConnection()
{

$this->conn = null;

try {

  // isso vai gerar um erro de índice fora do intervalo, mas o código dentro do finally ainda será executado
    //tenta executar um codigo potencialmente perigoso 
// DSN (data Source Name) = String de conexão
$dsn ='mysql:host' . $this->host . ';port=' . $this->port . ';dbname=' . $this->db_name . ';charset=utf8';

// Instancia o objeto PDO
$this->conn = new PDO($dsn, $this->username, $this->password);

//Define o modo de erro do PDO para execução
// isso faz com que o PDO lance exceções em caso de erros, facilitando o tratamento
$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


} catch (PDOException $e) {
  // Em caso de erro na conexão, exibe mensagem de erro
  echo 'Erro de conexão: ' . $e->getMessage();
}
catch (throwable $e) {
    // erro genérico
    echo 'Erro generico: ' . $e->getMessage();
  
  }
return $this->conn;

}

}