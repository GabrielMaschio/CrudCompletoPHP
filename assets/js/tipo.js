const dbTipo = []; 

const constructorTipo = (index, obj) => {
    const constructorTipo = {
        index: index,
        id: obj.id,
        nome_tipo: obj.nome_tipo
    };

    dbTipo.push(constructorTipo);
}

const clearTable = () => {
    const tbody = document.querySelector('#tableClient tbody');
    tbody.innerHTML = '';
}

const _getTipo = async () => {
    let index = 0;
    clearTable();
    try {
        const response = await fetch('../../controller/listar_tipo.php');
        const data = await response.json();
        dbTipo.splice(0, data.length);
        clearTable();
        data.forEach(obj => {
            viewTable(index, obj)
            index++;
        });
    } catch (error) {
        console.error('Erro ao carregar o arquivo JSON:', error);
    }
}

const viewTable = (index, tipo) => {
    if(index != undefined && tipo.id != undefined && tipo.nome_tipo != undefined) {
        const newRow = document.createElement('tr');
        newRow.id = "tableRow";
        newRow.innerHTML = `
            <td>${tipo.id}</td>
            <td>${tipo.nome_tipo}</td>
            <td id="button">
                <button type="button" class="button green" id="edit-${index}">Editar</button>
            </td>
            <td id="button">
                <button type="button" class="button red" id="delete-${index}" >Excluir</button>
            </td>
        `
        document.querySelector('#tableClient>tbody').appendChild(newRow);

        constructorTipo(index, tipo);
    }
}

_getTipo();

// MODAL
const modalFields = document.querySelectorAll('.modal-field');

const clearFields = () => {
    modalFields.forEach(field => field.value = "");
}

// CADASTRAR
const modalCadastro = document.getElementById('cadastro');

const openCadastro = () => {
    modalCadastro.classList.add('active');
}

const closeCadastro = () => {
    clearFields();
    modalCadastro.classList.remove('active');
}

const isValidFields = () => {
    return document.getElementById('formCadastro').reportValidity()
}

const createtipo = async (nome_tipo) => {
    if(nome_tipo.length > 2) {
        const formData = new FormData();
        formData.append("nome_tipo", nome_tipo);
    
        const dados = await fetch("../../controller/gravar_tipo.php", {
            method: "POST", // Enviar os dados do JavaScript para o PHP através do método POST
            body: formData, // Enviar os dados do JavaScript para o PHP
        });

        // Ler o retorno do PHP com JavaScript
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

            _getTipo();
        } else {
            Swal.fire({
                text: resposta['msg'],
                icon: 'error',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Fechar'
            });
        }
    } else {
        closeCadastro();

        Swal.fire({
            text: 'O Nome da tipo deve ser maior que 2',
            icon: 'error',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Fechar'
        });
    }
}

const saveCadastro = () => {
    if (isValidFields()) {
        const nomeField = document.getElementById('nome_tipo').value;
        createtipo(nomeField);
    }
}

// Editar Modal
const modalEdit = document.getElementById('edit');

const objtipo = [];

const setOjbtipo = (obj) => {
    objtipo.splice(0, objtipo.length);

    const tipo = {
        index: obj.index,
        id: obj.id,
        nome_tipo: obj.nome_tipo
    }

    objtipo.push(tipo);
}

const fillFields = (obj) => {
    document.getElementById("id").value = obj.id;
    document.getElementById('nome_edit').value = obj.nome_tipo;
}

const openEdit = (index) => {
    modalEdit.classList.add('active');

    const tipo = dbTipo[index];

    fillFields(tipo);
}

const closeEdit = () => {
    clearFields();
    modalEdit.classList.remove("active");
}

const saveEdit = async () => {
    const formEdit = new FormData();
    // Recuperar os dados
    const fixedId = dbTipo[objtipo[0].index].id;
    const id = document.getElementById("id").value;
    const nome_tipo = document.getElementById('nome_edit').value;
    
    // Criar o formulário
    formEdit.append("fixed_id", fixedId);
    formEdit.append("id", id);
    formEdit.append("nome_tipo", nome_tipo);

    try {
        const dados = await fetch("../../controller/update_tipo.php", {
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

            _getTipo();
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
const deletetipo = (index) => {
    const tipo = dbTipo[index];

    Swal.fire({
        title: `Deseja realmente deletar?`,
        text: "Você não vai poder reverter isso!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: `Sim, delete "${tipo.nome_tipo}"!`
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                const formData = new FormData();
                formData.append("id", tipo.id);
                
                const dados = await fetch("../../controller/deletar_tipo.php", {
                    method: "POST", // Enviar os dados do JavaScript para o PHP através do método POST
                    body: formData, // Enviar os dados do JavaScript para o PHP
                });
    
                const resposta = await dados.json();           
                
                if(resposta['status']) {
                    Swal.fire({
                        title: "Deletado!",
                        text: `tipo "${tipo.nome_tipo}" deletada com sucesso!`,
                        icon: "success"
                    });
    
                    _getTipo();
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
                    text: `Não foi possivel deletar a tipo "${tipo.nome_tipo}"!`,
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
            setOjbtipo(dbTipo[index]);
        } else {
            deletetipo(index);
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