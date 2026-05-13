<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
 
include_once '../../config/Database.php';

// CORREÇÃO 1: Incluir o model Bebida em vez de Pizza
include_once '../../models/Bebida.php'; 
 
// Instanciar o banco de dados e conectar
$database = new Database();
$db = $database->getConnection();
 
// CORREÇÃO 2: Variável renomeada para $bebida
$bebida = new Bebida($db);
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Obter os dados postados
        $data = json_decode(file_get_contents("php://input"));
 
        // Verificar se os dados não estão vazios
        // CORREÇÃO 3: Padronizado para valorBebida para bater com a atribuição abaixo
        if (
            isset($data->nomeBebida) && $data->nomeBebida !== "" &&
            isset($data->categoriaBebida) && $data->categoriaBebida !== "" &&
            isset($data->valorBebida) && $data->valorBebida !== "" && 
            isset($data->tamanho) && $data->tamanho !== ""
        ) {
            // CORREÇÃO 4: Atribuir os valores ao objeto $bebida (e não $pizza)
            $bebida->nomeBebida = $data->nomeBebida;
            $bebida->valorBebida = $data->valorBebida;
            $bebida->categoriaBebida = $data->categoriaBebida;
            $bebida->tamanho = $data->tamanho;
 
            // Criar a bebida
            if ($bebida->add()) {
                header("HTTP/1.1 201 Created");
                // Resposta de sucesso
                echo json_encode(
                    array('Mensagem' => 'Bebida criada com sucesso')
                );
            } else {
                header("HTTP/1.1 503 Service Unavailable");
                // Resposta de erro
                echo json_encode(
                    array('Mensagem' => 'Nao foi possivel criar a bebida')
                );
            }
        } else {
            header("HTTP/1.1 400 Bad Request");
            // Resposta se dados estiverem incompletos
            echo json_encode(
                array('Mensagem' => 'Dados Incompletos. Nao foi possivel criar a bebida.')
            );
        }
    } catch (Exception $e) {
        echo json_encode(array("erro" => $e->getMessage()));
    }
} else {
   // CORREÇÃO 5: Sintaxe do HTTP corrigida de "HTTP 1/1" para "HTTP/1.1"
   header("HTTP/1.1 400 Bad Request"); 
   echo json_encode(array("erro" => "Método não suportado!"));
}