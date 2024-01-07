<?php
// api.php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Inicializa a sessão
session_start();

// Verifica se a requisição é um POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém o conteúdo do corpo da requisição como JSON
    $jsonInput = file_get_contents('php://input');
    $requestData = json_decode($jsonInput, true);

    // Verifica se os campos de login e senha foram enviados no formato JSON
    if (isset($requestData['username']) && isset($requestData['password'])) {
        $username = $requestData['username'];
        $password = $requestData['password'];

        // Verifica se as credenciais são válidas
        if ($username === 'admin' && $password === 'password') {
            // Credenciais válidas, retorna uma resposta JSON de sucesso
            $response = array('success' => true, 'message' => 'Login bem-sucedido.');
            echo json_encode($response);
            exit;
        } else {
            // Credenciais inválidas, retorna uma resposta JSON de erro
            $response = array('success' => false, 'error' => 'Credenciais inválidas. Tente novamente.');
            echo json_encode($response);
            exit;
        }
    } else {
        // Campos de login e senha não fornecidos no formato JSON, retorna uma resposta JSON de erro
        $response = array('success' => false, 'error' => 'Dados de login ausentes no formato JSON.');
        echo json_encode($response);
        exit;
    }
} else {
    // Se a requisição não for um POST, retorna um status 404
    http_response_code(404);
    exit;
}
?>
