<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/bebida.php';

// Conexão
$database = new Database();
$db = $database->getConnection();

// Instanciar objeto
$bebida = new Bebida($db);

// Verificar método
if ($_SERVER['REQUEST_METHOD'] == 'PUT') {

    // Receber JSON
    $data = json_decode(file_get_contents("php://input"));

    // DEBUG
    // descomente se quiser testar
    /*
    var_dump($data);
    exit;
    */

    // Verificar se veio JSON válido
    if ($data != null) {

        // Verificar campos obrigatórios
        if (
            isset($data->idBebidas) &&
            isset($data->nomeBebida) &&
            isset($data->categoriaBebida) &&
            isset($data->valorBebida) &&
            isset($data->tamanho)
        ) {

            // Atribuir valores
            $bebida->idBebidas = $data->idBebidas;
            $bebida->nomeBebida = $data->nomeBebida;
            $bebida->categoriaBebida = $data->categoriaBebida;
            $bebida->valorBebida = $data->valorBebida;
            $bebida->tamanho = $data->tamanho;

            // Atualizar
            if ($bebida->update()) {

                header("HTTP/1.1 200 OK");

                echo json_encode(array(
                    "Mensagem" => "Bebida atualizada com sucesso"
                ));

            } else {

                header("HTTP/1.1 503 Service Unavailable");

                echo json_encode(array(
                    "Mensagem" => "Não foi possível atualizar a bebida"
                ));
            }

        } else {

            header("HTTP/1.1 400 Bad Request");

            echo json_encode(array(
                "Mensagem" => "Dados incompletos"
            ));
        }

    } else {

        header("HTTP/1.1 400 Bad Request");

        echo json_encode(array(
            "Mensagem" => "JSON inválido"
        ));
    }

} else {

    header("HTTP/1.1 405 Method Not Allowed");

    echo json_encode(array(
        "Mensagem" => "Método não permitido"
    ));
}