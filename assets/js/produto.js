// TIPO
const constructorTipo = (obj) => {
    const newTipoOption = document.createElement('option');
    newTipoOption.value = obj.id;
    newTipoOption.innerHTML = obj.nome_tipo;
    document.getElementById("tipo").appendChild(newTipoOption);
}

const constructorEditTipo = (nome_tipo, obj) => {
    const newTipoOption = document.createElement('option');
    newTipoOption.value = obj.id;
    newTipoOption.innerHTML = obj.nome_tipo;
    if(obj.nome_tipo == nome_tipo) {
        newTipoOption.selected = true;
    }
    document.getElementById("tipo_edit").appendChild(newTipoOption);
}

const _getTipo = async (nome_tipo, isNew) => {
    try {
        const response = await fetch('../../controller/listar_tipo.php');
        const data = await response.json();
        data.forEach(obj => {
            if(isNew) {
                constructorTipo(obj)
            } else {
                constructorEditTipo(nome_tipo, obj)
            }
        });
    } catch (error) {
        console.error('Erro ao carregar o arquivo JSON:', error);
    }
}


// MARCA
const constructorMarca = (obj) => {
    const newMarcaOption = document.createElement('option');
    newMarcaOption.value = obj.id;
    newMarcaOption.innerHTML = obj.nome_marca;
    document.getElementById("marca").appendChild(newMarcaOption);

}
const constructorEditMarca = (nome_marca, obj) => {
    const newMarcaOption = document.createElement('option');
    newMarcaOption.value = obj.id;
    newMarcaOption.innerHTML = obj.nome_marca;
    if(obj.nome_marca == nome_marca) {
        newMarcaOption.selected = true;
    }
    document.getElementById("marca_edit").appendChild(newMarcaOption);
}

const _getMarca = async (nome_marca, isNew) => {
    try {
        const response = await fetch('../../controller/listar_marca.php');
        const data = await response.json();
        data.forEach(obj => {
            if(isNew) {
                constructorMarca(obj)
            } else {
                constructorEditMarca(nome_marca, obj);
            }
        });
    } catch (error) {
        console.error('Erro ao carregar o arquivo JSON:', error);
    }
}





// PRODUTO

const dbProduto = []; 

const construtorProduto = (index, obj) => {
    const construtorProduto = {
        index: index,
        id: obj.id,
        nome_produto: obj.nome_produto,
        quantidade: obj.quantidade,
        valor: obj.valor,
        nome_tipo: obj.nome_tipo,
        id_tipo: obj.id_tipo,
        nome_marca: obj.nome_marca,
        id_marca: obj.id_marca
    };

    dbProduto.push(construtorProduto);
}

const clearTable = () => {
    const tbody = document.querySelector('#tableClient tbody');
    tbody.innerHTML = '';
}

const _getProduto = async () => {
    let index = 0;
    clearTable();
    try {
        const response = await fetch('../../controller/listar_produto.php');
        const dataProduto = await response.json();
        dbProduto.splice(0, dataProduto.length);
        clearTable();
        console.log(dataProduto)
        dataProduto.forEach(obj => {
            viewTable(index, obj)
            index++;
        });
    } catch (error) {
        console.error('Erro ao carregar o arquivo JSON:', error);
    }
}

const viewTable = (index, produto) => {
    if(index != undefined && produto.id != undefined && produto.nome_produto != undefined) {
        const newRow = document.createElement('tr');
        newRow.id = "tableRow";
        newRow.innerHTML = `
            <td>${produto.id}</td>
            <td>${produto.nome_produto}</td>
            <td>${produto.quantidade}</td>
            <td>R$${produto.valor}</td>
            <td>${produto.nome_tipo}</td>
            <td>${produto.nome_marca}</td>
            <td id="button">
                <button type="button" class="button green" id="edit-${index}">Editar</button>
            </td>
            <td id="button">
                <button type="button" class="button red" id="delete-${index}" >Excluir</button>
            </td>
        `
        document.querySelector('#tableClient>tbody').appendChild(newRow);

        construtorProduto(index, produto);
    }
}

_getProduto();

// MODAL
const modalFields = document.querySelectorAll('.modal-field');

const clearFields = () => {
    modalFields.forEach(field => field.value = "");
}

const clearSelect = () => {
    document.querySelector('#tipo').innerHTML = '';
    document.querySelector('#marca').innerHTML = '';
    document.querySelector('#tipo_edit').innerHTML = '';
    document.querySelector('#marca_edit').innerHTML = '';
}

// CADASTRAR
const modalCadastro = document.getElementById('cadastro');

const openCadastro = () => {
    modalCadastro.classList.add('active');
    _getMarca("", true);
    _getTipo("", true);
}

const closeCadastro = () => {
    clearFields();
    clearSelect();
    modalCadastro.classList.remove('active');
}

const isValidFields = () => {
    return document.getElementById('formCadastro').reportValidity()
}

const createProduto = async (nome_produto, quantidade, valor, id_tipo, id_marca) => {
    if(nome_produto.length > 2) {
        try {
            const formData = new FormData();
            formData.append("nome_produto", nome_produto);
            formData.append("quantidade", quantidade);
            formData.append("valor", valor);
            formData.append("id_tipo", id_tipo);
            formData.append("id_marca", id_marca);
        
            const dados = await fetch("../../controller/gravar_produto.php", {
                method: "POST", // Enviar os dados do JavaScript para o PHP através do método POST
                body: formData, // Enviar os dados do JavaScript para o PHP
            });
    
            const resposta = await dados.json();
    
            if(resposta["status"]){
                closeCadastro();
    
                Swal.fire({
                    text: resposta['msg'],
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Fechar'
                });
    
                _getProduto();
            } else {
                Swal.fire({
                    text: resposta['msg'],
                    icon: 'error',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Fechar'
                });
            }
        } catch {
            Swal.fire({
                text: 'Não foi possivel enviar o formulário!',
                icon: 'error',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Fechar'
            });
        }
    } else {
        closeCadastro();

        Swal.fire({
            text: 'O Nome da produto deve ser maior que 2',
            icon: 'error',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Fechar'
        });
    }
}

const saveCadastro = () => {
    if (isValidFields()) {
        const nomeField = document.getElementById('nome_produto').value;
        const quantidadeField = document.getElementById('quantidade').value;
        const valorField = document.getElementById('valor').value;

        const selectTipoElement = document.getElementById("tipo");
        const selectedTipoIndex = selectTipoElement.selectedIndex;
        const selectedTipoOption = selectTipoElement.options[selectedTipoIndex];
        const idTipoField = selectedTipoOption.value;
        
        const selectMarcaElement = document.getElementById("marca");
        const selectedMarcaIndex = selectMarcaElement.selectedIndex;
        const selectedMarcaOption = selectMarcaElement.options[selectedMarcaIndex];
        const idMarcaField = selectedMarcaOption.value;

        createProduto(nomeField, quantidadeField, valorField, idTipoField, idMarcaField);
    }
}

// Editar Modal
const modalEdit = document.getElementById('edit');

const objproduto = [];

const setOjbproduto = (obj) => {
    objproduto.splice(0, objproduto.length);

    const produto = {
        index: obj.index,
        id: obj.id,
        nome_produto: obj.nome_produto
    }

    objproduto.push(produto);
}

const fillFields = (obj) => {
    document.getElementById("id").value = obj.id;
    document.getElementById('nome_edit').value = obj.nome_produto;
    document.getElementById('quantidade_edit').value = obj.quantidade;
    document.getElementById('valor_edit').value = obj.valor;
    _getTipo(obj.nome_tipo, false);
    _getMarca(obj.nome_marca, false);
}

const openEdit = (index) => {
    modalEdit.classList.add('active');
    const produto = dbProduto[index];
    fillFields(produto);
}

const closeEdit = () => {
    clearFields();
    clearSelect();
    modalEdit.classList.remove("active");
}

const saveEdit = async () => {
    const formEdit = new FormData();
    // Recuperar os dados
    const fixedId = dbProduto[objproduto[0].index].id;
    const id = document.getElementById("id").value;
    const nome_produto = document.getElementById('nome_edit').value;
    const quantidade = document.getElementById('quantidade_edit').value;
    const valor = document.getElementById('valor_edit').value;

    const selectTipoElement = document.getElementById("tipo_edit");
    const selectedTipoIndex = selectTipoElement.selectedIndex;
    const selectedTipoOption = selectTipoElement.options[selectedTipoIndex];
    const idTipoField = selectedTipoOption.value;
    
    const selectMarcaElement = document.getElementById("marca_edit");
    const selectedMarcaIndex = selectMarcaElement.selectedIndex;
    const selectedMarcaOption = selectMarcaElement.options[selectedMarcaIndex];
    const idMarcaField = selectedMarcaOption.value;
    
    // Criar o formulário
    formEdit.append("fixed_id", fixedId);
    formEdit.append("id", id);
    formEdit.append("nome_produto", nome_produto);
    formEdit.append("quantidade", quantidade);
    formEdit.append("valor", valor);
    formEdit.append("id_tipo_fk", idTipoField);
    formEdit.append("id_marca_fk", idMarcaField);

    try {
        const dados = await fetch("../../controller/update_produto.php", {
            method: "POST", 
            body: formEdit, 
        });

        const resposta = await dados.json();

        if(resposta["status"]) {
            closeEdit();

            Swal.fire({
                text: resposta['msg'],
                icon: 'success',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Fechar'
            });

            _getProduto();
        } else {
            closeEdit();

            Swal.fire({
                text: resposta['msg'],
                icon: 'error',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Fechar'
            });
        }
    } catch {
            closeEdit();

            Swal.fire({
                text: "Não foi possivel fazer a edição!",
                icon: 'error',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Fechar'
            });
    }
}

// DELETE
const deleteproduto = (index) => {
    const produto = dbProduto[index];

    Swal.fire({
        title: `Deseja realmente deletar?`,
        text: "Você não vai poder reverter isso!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: `Sim, delete "${produto.nome_produto}"!`
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                const formData = new FormData();
                formData.append("id", produto.id);
                
                const dados = await fetch("../../controller/deletar_produto.php", {
                    method: "POST", // Enviar os dados do JavaScript para o PHP através do método POST
                    body: formData, // Enviar os dados do JavaScript para o PHP
                });
    
                const resposta = await dados.json();           
                
                if(resposta['status']) {
                    Swal.fire({
                        title: "Deletado!",
                        text: `produto "${produto.nome_produto}" deletada com sucesso!`,
                        icon: "success"
                    });
    
                    _getProduto();
                } else {
                    Swal.fire({
                        title: "ERRO!",
                        text: resposta['msg'],
                        icon: "error"
                    });
                }
            } catch {
                Swal.fire({
                    title: "ERRO!",
                    text: `Não foi possivel deletar a produto "${produto.nome_produto}"!`,
                    icon: "error"
                });
            }
            
        }
    });
}

// EDIT-DELETE BUTTONS
const editDelete = (e) => {
    if(e.target.type == 'button') {

        const [action, index] = e.target.id.split('-')

        if(action == 'edit') {
            openEdit(index);
            setOjbproduto(dbProduto[index]);
        } else {
            deleteproduto(index);
        }
    }
}

// EVENTOS
document.getElementById('salvar-cadastro').addEventListener('click', saveCadastro);

document.getElementById('salvar-edit').addEventListener('click', saveEdit);

document.querySelector("#formCadastro").addEventListener("submit", (e) => {
    e.preventDefault();
    saveCadastro();
});

document.querySelector('#tableClient>tbody').addEventListener('click', editDelete);

document.onkeydown = function(e) {
    if(e.key === 'Escape') {
        if(modalCadastro.classList == "modal active") {
            closeCadastro();
        } else if(modalEdit.classList == "modal active") {
            closeEdit();
        }
    }
}