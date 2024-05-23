<?php
    session_start();
    require_once "../config/config.php";

    function logout() {
        session_unset();
        session_destroy();
        header("Location: ../index.php");
        exit;
    }

    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        header("Location: ../index.php");
        exit;
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/tela_inicial.css">
    <title>Página Inicial</title>
</head>
<body>

<div class="container">
    <div class="nav">
        <h1>Página Inicial</h1>
        
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="submit" id="logout" name="logout" class="red" value="Log out"/>
        </form>
        <?php 
            if (isset($_POST["logout"])) {
                logout();
            }
        ?>
    </div>

    <div class="links">
        <a href="./crud/marca.php">Marca</a>
        <a href="./crud/tipo.php">Tipo</a>
        <a href="./crud/produto.php">Produto</a>
    </div>
</div>

</body>
</html>
