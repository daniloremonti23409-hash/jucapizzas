<?php

// Headers obrigatórios
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Incluir arquivos
include_once '../../config/Database.php';
include_once '../../models/bebida.php';

// Conexão
$database = new Database();
$db = $database->getConnection();

// Instanciar objeto
$bebida = new Bebida($db);

// 🔥 CHAMANDO O MÉTODO (FALTAVA ISSO)
$stmt = $bebida->getall();

// Criar array
$bebidas_arr = array();

// Verificar se retornou algo
if ($stmt->rowCount() > 0) {

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        extract($row);

        $bebida_item = array(
            "id" => $idBebidas,
            "nome" => $nomeBebida,
            "categoria" => $categoriaBebida,
            "valor" => $valorBebida,
            "tamanho" => $tamanho
        );

        array_push($bebidas_arr, $bebida_item);
    }

    header("HTTP/1.1 200 OK");
    echo json_encode($bebidas_arr);

} else {

    header("HTTP/1.1 404 Not Found");
    echo json_encode(array(
        "message" => "Nenhuma bebida encontrada."
    ));
}