
 
<?php
//CRIAÇÃO ROTA GET.PHP
// Headers obrigatórios
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// Incluir arquivos de banco de dados e modelo
include_once '../../config/Database.php';
include_once '../../models/bebida.php';
 
// Instanciar o objeto Database e obter a conexão
$database = new Database();
$db = $database->getConnection();
 
// Instanciar o objeto Pizza
$bebida = new Bebida($db);
 
$bebida->idBebida = isset($_GET['id']) ? $_GET['id'] : null;
 
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ($bebida->idBebida) {
        // Busca a pizza
        $bebida->get();
 
        // Cria o array de resposta
        $bebida_arr = array(
            "id" => $bebida->idBebidas,
            "nomeBebida" => $bebida->nomeBebida,
            "categoriaBebida" => $bebida->categoriaBebida,
            "valorBebida" => $bebida->valorBebida,
            "tamanho" => $bebida->tamanho
        );
        if ($bebida->nomeBebida != null) {
            
            // Cria o array de resposta
            $bebida_arr = array(
                "id" => $bebida->idBebidas,
                "nomeBebida" => $bebida->nomeBebida,
                "categoriaBebida" => $bebida->categoriaBebida,
                "valorBebida" => $bebida->valorBebida,
                "tamanho" => $bebida->tamanho
            );

            // Converte para JSON e envia a resposta com a pizza
            echo json_encode($bebida_arr, 128);
            
        } else {
            // Fecha o IF do nome nulo. Pizza não encontrada no banco (404)
            header("HTTP/1.1 404 Not Found");
            echo json_encode(
                array("Mensagem" => "Bebida não encontrada")
            );
        }


        // Converte para JSON e envia a resposta
        // `JSON_PRETTY_PRINT` é opcional, mas deixa o JSON mais legível
       
    } 
}else {
    header("HTTP/1.1 405 Method Not Allowed");
    echo json_encode(
            array("Mensagem" => "Método não permitido.")
        );
}
 
 