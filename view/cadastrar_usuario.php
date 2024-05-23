<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Cadastrar Usuario</title>
</head>
<body>
    <div class="container">
        <h1>Cadastrar</h1>

        <form action="../controller/gravar_usuario.php" method="post">
            <input type="text" name="nome_usuario" placeholder="Nome de Usuário" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <input type="submit" value="Cadastrar">
        </form>
        <p><a href="../index.php">Login</a></p>
    </div>
</body>
</html>