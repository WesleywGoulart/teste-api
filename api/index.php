<?php
// api.php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json")

// Verifica se a requisição é um GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Lógica para o endpoint
    $data = array('message' => 'Hello, this is your API endpoint!');
    
    // Define o cabeçalho como JSON
    header('Content-Type: application/json');

    // Retorna os dados em formato JSON
    echo json_encode($data);
} else {
    // Se o método da requisição não for suportado, retorna um erro
    http_response_code(405);
    echo json_encode(array('error' => 'Method Not Allowed'));
}
?>
