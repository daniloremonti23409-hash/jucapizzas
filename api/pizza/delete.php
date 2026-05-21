<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
 
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header('HTTP/1.1 200 OK');
    exit();
}
 
include_once '../../config/Database.php';
include_once '../../models/Pizza.php';
 
// Instanciar o banco de dados e conectar
$database = new Database();
$db = $database->getConnection();
 
// Instanciar o objeto Pizza
$pizza = new Pizza($db);
 
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    try {
        $data = json_decode(file_get_contents('php://input'));
        $id = isset($_GET['id']) ? $_GET['id'] : (!empty($data->id) ? $data->id : null);
 
        if (!empty($id)) {
            $pizza->idPizza = $id;

            if($pizza->get()) {
                header('HTTP/1.1 404 Not found');
                echo json_encode(
                    array('Mensagem' => 'ID não informado. Não foi possível excluir a pizza.')
                );
                exit();
            }
 
            if ($pizza->delete()) {
                header('HTTP/1.1 200 OK');
                echo json_encode(
                    array('Mensagem' => 'Pizza excluída com sucesso')
                );
            } else {
                header('HTTP/1.1 503 Service Unavailable');
                echo json_encode(
                    array('Mensagem' => 'Não foi possível excluir a pizza')
                );
            }
        } else {
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(
                array('Mensagem' => 'ID não informado. Não foi possível excluir a pizza.')
            );
        }
    } catch (Exception $e) {
        echo json_encode(array('erro' => $e->getMessage()));
    }
} else {
    header('HTTP/1.1 405 Method Not Allowed');
    echo json_encode(array('erro' => 'Método não permitido.'));
}

?>

<?php
//CORRIGIDO PELO PROFESSOR
// Headers
/*header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
 
include_once '../../config/Database.php';
include_once '../../models/Pizza.php';
 
// Instanciar o banco de dados e conectar
$database = new Database();
$db = $database->getConnection();
 
// Instanciar o objeto Pizza
$pizza = new Pizza($db);
 
 
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    try {
        // Obter os dados postados
        $data = json_decode(file_get_contents("php://input"));
 
        // Sanitizar id e Atribuir para exclusão
        $pizza->idPizza = filter_var($data->id, FILTER_VALIDATE_INT);
 
        // Verificar se o ID foi fornecido
        if ($pizza->idPizza) {
 
            $pizza->get();
 
            // Tentar deletar a pizza
            if ($pizza->delete() && $pizza->nome) {
                http_response_code(200);
                // Resposta de sucesso
                echo json_encode(
                    array('Mensagem' => 'Pizza Deletada com Sucesso')
                );
            } else {
                http_response_code(404);
                // Resposta de erro
                echo json_encode(
                    array('Erro' => 'Pizza não encontrada! Não foi possivel deletar a Pizza.')
                );
            }
        } else {
            http_response_code(400);
            // Resposta se o ID não for fornecido
            echo json_encode(
                array('Erro' => 'ID inválido. Nao foi possivel deletar a Pizza.')
            );
        }
    } catch (Exception $e) {
        echo json_encode(array("Erro" => $e->getMessage()));
    }
} else {
    http_response_code(405);
    echo json_encode(array("Erro" => "Método não suportado!"));
}
 
 