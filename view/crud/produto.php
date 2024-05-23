<?php
    session_start();
    require_once "../../config/config.php";

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
    <link rel="stylesheet" href="../../assets/css/produto.css">
    <link rel="stylesheet" href="../../assets/css/button.css">
    <title>Cadastro Produto</title>
</head>
<body>
<nav>
        <button id="voltar" class="blue" onclick="window.location.href = '../tela_principal.php'">Voltar</button>
        
        <h1>Cadastro Produto</h1>

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
        <button type="button" class="button blue mobile" onclick="openCadastro()" id="open-cadastro">Cadastrar Produto</button>
        <table id="tableClient" class="records">
            <thead>
                <tr>
                    <th class="td-id">Id</th>
                    <th class="td-Produto">Produto</th>
                    <th class="td-quantidade">Quantidade</th>
                    <th class="td-valor">Valor</th>
                    <th class="td-Produto">Produto</th>
                    <th class="td-marca">Marca</th>
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
                    <h2>Novo Produto</h2>
                    <span class="modal-close" onclick="closeCadastro()">&#10006;</span>
                </header>

                <form id="formCadastro" class="modal-form">
                    <label for="nome_produto">Nome Produto:</label>
                    <input type="text" id="nome_produto" name="nome_produto" class="modal-field" placeholder="Produto" required>

                    <label for="quantidade">Quantidade:</label>
                    <input type="number" id="quantidade" name="quantidade" class="modal-field" placeholder="Quantidade" required>

                    <label for="valor">Valor:</label>
                    <input type="number" id="valor" name="valor" class="modal-field" placeholder="Valor" required>
                    <div>
                        <label for="tipo">Escolha um Tipo:</label>
                        <select name="tipo" id="tipo">
                        
                        </select>
                    </div>
                    <div>
                        <label for="marca">Escolha um Marca:</label>
                        <select name="marca" id="marca">
                        </select>
                    </div>
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
                    <h2>Editar Produto</h2>
                    <span class="modal-close" onclick="closeEdit()">&#10006;</span>
                </header>

                <form id="formEdit" class="modal-form">
                    <label for="id">Id:</label>
                    <input type="number" id="id" name="id" class="modal-field" placeholder="Id" required min="1">

                    <label for="nome_produto">Nome Produto:</label>
                    <input type="text" id="nome_edit" name="nome_produto" class="modal-field" placeholder="Produto" required>

                    <label for="quantidade">Quantidade:</label>
                    <input type="number" id="quantidade_edit" name="quantidade" class="modal-field" placeholder="Quantidade" required>

                    <label for="valor">Valor:</label>
                    <input type="number" id="valor_edit" name="valor" class="modal-field" placeholder="Valor" required>
                    <div>
                        <label for="tipo">Escolha um Tipo:</label>
                        <select name="tipo" id="tipo_edit">
                        
                        </select>
                    </div>
                    <div>
                        <label for="marca">Escolha um Marca:</label>
                        <select name="marca" id="marca_edit">

                        </select>
                    </div>
                </form>

                <footer class="modal-footer">
                    <button id="salvar-edit" class="button green">Salvar</button>
                    <button id="cancelar" onclick="closeEdit()" class="button orange">Cancelar</button>
                </footer>
            </div>
        </div>
    </section>

    <script src="../../assets/js/sweetalert2.js"></script>
    
    <script src="../../assets/js/produto.js"></script>
</body>
</html>