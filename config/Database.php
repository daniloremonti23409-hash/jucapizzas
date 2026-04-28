<?php

class Database
{

private $host = 'localhost';
private $db_name = 'jucapizzas';
private $username = 'root';
private $password = 'usbw';
private $port = '3306';

public $conn;

//Finally(depois do catch): Tendo erro ou não, o codigo irá rodar. Estrutura=> finally{}//

public function getConnection()
{

$this->conn = null;

try {
    //tenta executar um codigo potencialmente perigoso 
// DNS (data Source Name) = String de conexão
$dns ='mysql:host' . $this->host . ';port=' . $this->port . ';dbname=' . $this->db_name . ';charset=utf8';

// Instancia o objeto PDO
$this->conn = new PDO($dns, $this->username, $this->password);

//Define o modo de erro do PDO para execução
// isso faz com que o PDO lance exceções em caso de erros, facilitando o tratamento
$thAttribis->conn->setute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


} catch (PDOException $e) {
  // Em caso de erro na conexão, exibe mensagem de erro
  echo 'Erro de conexão: ' . $e->getMessage();
}
catch (Exception $e) {
    // erro genérico
    echo 'Erro: ' . $e->getMessage();
  
  }
return $this->conn;

}

}