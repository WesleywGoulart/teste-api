<?php
// login.php

// Habilita o CORS para todas as origens
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS"); // Adiciona OPTIONS aqui
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Verifica se a requisição é um OPTIONS (preflight)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

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

// Verifica se a requisição é um POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém o conteúdo do corpo da requisição como JSON
    $jsonInput = file_get_contents('php://input');
    $requestData = json_decode($jsonInput, true);

    // Verifica se os campos necessários foram enviados no formato JSON
    if (isset($requestData['username']) && isset($requestData['password'])) {
        $username = $requestData['username'];
        $password = $requestData['password'];

        // Busca o hash da senha associada ao username
        $getUserHashQuery = "SELECT password FROM usuarios WHERE username = '$username'";
        $resultUserHash = $conn->query($getUserHashQuery);

        if ($resultUserHash->num_rows === 1) {
            // Hash da senha encontrado
            $row = $resultUserHash->fetch_assoc();
            $hashedPassword = $row['password'];

            // Verifica se a senha fornecida corresponde ao hash armazenado
            if (password_verify($password, $hashedPassword)) {
                // Senha correta, login bem-sucedido
                $response = array('success' => true, 'message' => 'Login bem-sucedido.');
                echo json_encode($response);
                exit;
            } else {
                // Senha incorreta, retorna uma resposta JSON de erro
                $response = array('success' => false, 'error' => 'Senha incorreta. Tente novamente.');
                echo json_encode($response);
                exit;
            }
        } else {
            // Username não encontrado, retorna uma resposta JSON de erro
            $response = array('success' => false, 'error' => 'Usuário não encontrado.');
            echo json_encode($response);
            exit;
        }
    } else {
        // Campos necessários não fornecidos no formato JSON, retorna uma resposta JSON de erro
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
