

 <?php
// CRIAÇÃO ROTA GET.PHP
// Headers obrigatórios
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Incluir arquivos de banco de dados e modelo
include_once '../../config/Database.php';
include_once '../../models/Pizza.php';

// Instanciar o objeto Database e obter a conexão
$database = new Database();
$db = $database->getConnection();

// Instanciar o objeto Pizza
$pizza = new Pizza($db);

$pizza->idPizza = isset($_GET['id']) ? $_GET['id'] : null;

// 1. Verifica se o método é GET
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    
    // 2. Verifica se tem ID na URL
    if ($pizza->idPizza) {
        
        // Busca a pizza no banco
        $pizza->get();

        // 3. Verifica se a pizza foi encontrada (se o nome não é nulo)
        if ($pizza->nome != null) {
            
            // Cria o array de resposta
            $pizza_arr = array(
                "id" => $pizza->idPizza,
                "nome" => $pizza->nome,
                "ingredientes" => $pizza->ingredientes,
                "valor" => $pizza->valor
            );

            // Converte para JSON e envia a resposta com a pizza
            echo json_encode($pizza_arr, 128);
            
        } else {
            // Fecha o IF do nome nulo. Pizza não encontrada no banco (404)
            header("HTTP/1.1 404 Not Found");
            echo json_encode(
                array("Mensagem" => "Pizza não encontrada")
            );
        }

    } else {
        // Fecha o IF do $pizza->idPizza. ID não informado na URL (400)
        header("HTTP/1.1 400 Bad Request");
        echo json_encode(
            array("Mensagem" => "id não encontrado")
        );
    }
    
} else {
    // Fecha o IF do REQUEST_METHOD. Método não é GET (405)
    header("HTTP/1.1 405 Method Not Allowed");
    echo json_encode(
        array("Mensagem" => "Método não permitido.")
    );
}
