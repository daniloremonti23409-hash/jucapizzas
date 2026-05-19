<?php
// CRIAÇÃO ROTA GET.PHP

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Incluir arquivos
include_once '../../config/Database.php';
include_once '../../models/bebida.php';

// Conexão com banco
$database = new Database();
$db = $database->getConnection();

// Instanciar objeto
$bebida = new Bebida($db);

// Receber ID da URL
$bebida->idBebidas = isset($_GET['id']) ? $_GET['id'] : null;

// Verificar método
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    // Verificar se ID existe
    if ($bebida->idBebidas) {

        // Buscar bebida
        $bebida->get();

        // Verificar se encontrou
        if ($bebida->nomeBebida != null) {

            $bebida_arr = array(
                "id" => $bebida->idBebidas,
                "nomeBebida" => $bebida->nomeBebida,
                "categoriaBebida" => $bebida->categoriaBebida,
                "valorBebida" => $bebida->valorBebida,
                "tamanho" => $bebida->tamanho
            );

            echo json_encode($bebida_arr);

        } else {

            header("HTTP/1.1 404 Not Found");

            echo json_encode(array(
                "Mensagem" => "Bebida não encontrada"
            ));
        }

    } else {

        header("HTTP/1.1 400 Bad Request");

        echo json_encode(array(
            "Mensagem" => "ID não informado"
        ));
    }

} else {

    header("HTTP/1.1 405 Method Not Allowed");

    echo json_encode(array(
        "Mensagem" => "Método não permitido"
    ));
}