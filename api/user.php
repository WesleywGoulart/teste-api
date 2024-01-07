<?php
// user.php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Simula uma base de dados de usuários
$users = array(
    1 => array('username' => 'admin', 'password' => 'password', 'admin' => true),
    2 => array('username' => 'user1', 'password' => 'pass123', 'admin' => false),
    // Adicione mais usuários conforme necessário
);

// Verifica se a requisição é um GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Verifica se um ID de usuário foi fornecido
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $userId = intval($_GET['id']);

        // Verifica se o usuário existe na "base de dados"
        if (isset($users[$userId])) {
            // Retorna as informações do usuário em formato JSON
            $userData = $users[$userId];
            echo json_encode($userData);
            exit;
        } else {
            // Usuário não encontrado, retorna uma resposta JSON de erro
            $response = array('success' => false, 'error' => 'Usuário não encontrado.');
            echo json_encode($response);
            exit;
        }
    } else {
        // ID de usuário ausente ou inválido, retorna uma resposta JSON de erro
        $response = array('success' => false, 'error' => 'ID de usuário ausente ou inválido.');
        echo json_encode($response);
        exit;
    }
} else {
    // Se a requisição não for um GET, retorna um status 404
    http_response_code(404);
    exit;
}
?>
