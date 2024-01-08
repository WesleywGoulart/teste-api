<?php
// cadastro.php

// ...

// Verifica se a requisição é um POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém o conteúdo do corpo da requisição como JSON
    $jsonInput = file_get_contents('php://input');
    $requestData = json_decode($jsonInput, true);

    // Verifica se os campos necessários foram enviados no formato JSON
    if (isset($requestData['username']) && isset($requestData['password'])) {
        $username = $requestData['username'];
        $password = $requestData['password'];

        // Verifica se o username já está cadastrado
        $checkExistingUser = "SELECT * FROM usuarios WHERE username = '$username'";
        $resultExistingUser = $conn->query($checkExistingUser);

        if ($resultExistingUser->num_rows > 0) {
            // Username já cadastrado, retorna uma resposta JSON de erro
            $response = array('success' => false, 'error' => 'Username já cadastrado. Escolha outro.');
            echo json_encode($response);
            exit;
        }

        // Realiza o cadastro do usuário na tabela "usuarios"
        $sql = "INSERT INTO usuarios (username, senha) VALUES ('$username', '$password')";
        $result = $conn->query($sql);

        if ($result === true) {
            // Cadastro bem-sucedido, retorna uma resposta JSON de sucesso
            $response = array('success' => true, 'message' => 'Cadastro bem-sucedido.');
            echo json_encode($response);
            exit;
        } else {
            // Erro durante o cadastro, retorna uma resposta JSON de erro
            $response = array('success' => false, 'error' => 'Erro durante o cadastro: ' . $conn->error);
            echo json_encode($response);
            exit;
        }
    } else {
        // Campos necessários não fornecidos no formato JSON, retorna uma resposta JSON de erro
        $response = array('success' => false, 'error' => 'Dados de cadastro ausentes no formato JSON.');
        echo json_encode($response);
        exit;
    }
} else {
    // Se a requisição não for um POST, retorna um status 404
    http_response_code(404);
    exit;
}
?>
