
<?php
// api.php

// Habilita o CORS para todas as origens
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS, GET"); // Adiciona GET aqui
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Verifica se a requisição é um OPTIONS (preflight) ou GET
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Configurações de conexão com o banco de dados
    $usuario = 'ateliesogra';
    $senha = 'Atelie@1020';
    $database = 'ateliesogra';
    $host = 'ateliesogra.mysql.dbaas.com.br';

    // Conecta ao banco de dados
    $conn = new mysqli($host, $usuario, $senha, $database);

    // Verifica a conexão
    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }

    // Realiza a consulta na tabela "teste"
    $sql = "SELECT * FROM usuarios";
    $result = $conn->query($sql);

    if ($result === false) {
        // Se a consulta falhar, retorna uma resposta JSON de erro
        $response = array('success' => false, 'error' => $conn->error);
        echo json_encode($response);
        exit;
    }

    // Processa os resultados da consulta
    $users = array();
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }

    // Retorna os usuários em formato JSON
    echo json_encode($users);
    exit;
}

// Se não for uma requisição GET, verifica se é um POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Restante do seu código de login...
    // ...

} else {
    // Se a requisição não for um POST ou GET, retorna um status 404
    http_response_code(404);
    exit;
}
?>