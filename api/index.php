<?php
session_start();

// Verifica se o formulário de login foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se os campos de login e senha foram preenchidos
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Verifica se as credenciais são válidas
        if ($username === 'admin' && $password === 'password') {
            // Credenciais válidas, redireciona para a página de sucesso
            $_SESSION['username'] = $username;
            header('Location: success.php');
            exit;
        } else {
            // Credenciais inválidas, exibe uma mensagem de erro
            $error = 'Credenciais inválidas. Tente novamente.';
        }
    } else {
        // Campos de login e senha não preenchidos, exibe uma mensagem de erro
        $error = 'Por favor, preencha todos os campos.';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sistema de Login</title>
</head>
<body>
    <h1>Sistema de Login</h1>

    <?php if (isset($error)) : ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="username">Usuário:</label>
        <input type="text" name="username" id="username" required><br>

        <label for="password">Senha:</label>
        <input type="password" name="password" id="password" required><br>

        <button type="submit">Entrar</button>
    </form>
</body>
</html>
