<?php
    session_start();
    require_once "../../config/config.php";

    function logout() {
        session_unset();
        session_destroy();
        header("Location: ../../index.php");
        exit;
    }

    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        header("Location: .../../index.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/marca.css">
    <link rel="stylesheet" href="../../assets/css/button.css">
    <title>Cadastro Tipo</title>
</head>
<body>
    <nav>
        <button id="voltar" class="blue" onclick="window.location.href = '../tela_principal.php'">Voltar</button>
        
        <h1>Cadastro Tipo</h1>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="submit" id="logout" name="logout" class="red" value="Log out"/>
        </form>
        <?php 
            if (isset($_POST["logout"])) {
                logout();
            }
        ?>
    </nav>

    <section>
        <button type="button" class="button blue mobile" onclick="openCadastro()" id="open-cadastro">Cadastrar Tipo</button>
        <table id="tableClient" class="records">
            <thead>
                <tr>
                    <th class="td-id">Id</th>
                    <th class="td-tipo">Tipo</th>
                    <th class="td-editar">Editar</th>
                    <th class="td-excluir">Excluir</th>
                </tr>
            </thead>
            <tbody id="tbody">
                
            </tbody>
        </table>

        <div class="modal" id="cadastro">
            <div class="modal-content">
                <header class="modal-header">
                    <h2>Novo Tipo</h2>
                    <span class="modal-close" onclick="closeCadastro()">&#10006;</span>
                </header>

                <form id="formCadastro" class="modal-form">
                    <input type="text" id="nome_tipo" name="nome_tipo" class="modal-field" placeholder="Tipo" required>
                </form>

                <footer class="modal-footer">
                    <button id="salvar-cadastro" class="button green">Salvar</button>
                    <button id="cancelar" onclick="closeCadastro()" class="button orange">Cancelar</button>
                </footer>
            </div>
        </div>

        <div class="modal" id="edit">
            <div class="modal-content">
                <header class="modal-header">
                    <h2>Editar Tipo</h2>
                    <span class="modal-close" onclick="closeEdit()">&#10006;</span>
                </header>

                <form id="formEdit" class="modal-form">
                    <input type="number" id="id" name="id" class="modal-field" placeholder="Id" required min="1">
                    <input type="text" id="nome_edit" name="nome_tipo" class="modal-field" placeholder="Tipo" required>
                </form>

                <footer class="modal-footer">
                    <button id="salvar-edit" class="button green">Salvar</button>
                    <button id="cancelar" onclick="closeEdit()" class="button orange">Cancelar</button>
                </footer>
            </div>
        </div>
    </section>

    <script src="../../assets/js/sweetalert2.js"></script>
    
    <script src="../../assets/js/tipo.js"></script>
</body>
</html>