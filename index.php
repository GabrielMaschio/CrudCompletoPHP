<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/style.css">
    <title>Cadastro Produto</title>
</head>
<body>
    <div class="container">
        <h1>Login</h1>

        <form action="controller/validar_usuario.php" method="post">
            <input type="text" name="usuario" placeholder="Nome de Usuário" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <input type="submit" value="Entrar">
        </form>

        <p>Não tem uma conta? <a href="./view/cadastrar_usuario.php">Inscreva-se</a></p>
        
       
    </div>

    
</body>
</html>