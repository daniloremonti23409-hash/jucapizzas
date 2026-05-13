add.php
 
<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
 
include_once '../../config/Database.php';
include_once '../../models/Pizza.php';
 
// Instanciar o banco de dados e conectar
$database = new Database();
$db = $database->getConnection();
 
// Instanciar o objeto Pizza
$pizza = new Pizza($db);
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Obter os dados postados
        $data = json_decode(file_get_contents("php://input"));
 
        // Verificar se os dados não estão vazios
        if (
            !empty($data->nome) &&
            !empty($data->ingredientes) &&
            !empty($data->valor)
        ) {
            // Atribuir os valores ao objeto Pizza
            $pizza->nome = $data->nome;
            $pizza->ingredientes = $data->ingredientes;
            $pizza->valor = $data->valor;
 
            // Criar a pizza
            if ($pizza->add()) {
           header("HTTP/1.1 201 Created");
                // Resposta de sucesso
                echo json_encode(
                    array('Mensagem' => 'Pizza Criada com Sucesso')
                );
            } else {
                header("HTTP/1.1 503 Service Unavailable");
                // Resposta de erro
                echo json_encode(
                    array('Mensagem' => 'Nao foi possivel criar a Pizza')
                );
            }
        } else {
            header("HTTP/1.1 400 Bad Request");
            // Resposta se dados estiverem incompletos
            echo json_encode(
                array('Mensagem' => 'Dados Incompletos. Nao foi possivel criar a Pizza.')
            );
        }
    } catch (Exception $e) {
        echo json_encode(array("erro" => $e->getMessage()));
    }
} else {
   header("HTTP 1/1 400 Bad Request");
    echo json_encode(array("erro" => "Método não suportado!"));
}
 