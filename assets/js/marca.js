const dbMarca = []; 
let dbLength;

const constructorMarca = (index, obj) => {
    const constructorMarca = {
        index: index,
        id: obj.id,
        nome_marca: obj.nome_marca
    };

    dbMarca.push(constructorMarca);
}

const clearTable = () => {
    const tbody = document.querySelector('#tableClient tbody');
    tbody.innerHTML = '';
}

const _getMarca = async () => {
    let index = 0;
    clearTable();
    try {
        const response = await fetch('../../controller/listar_marca.php');
        const data = await response.json();
        dbMarca.splice(0, data.length);
        clearTable();
        data.forEach(obj => {
            viewTable(index, obj)
            index++;
        });
    } catch (error) {
        console.error('Erro ao carregar o arquivo JSON:', error);
    }
}

const viewTable = (index, marca) => {
    if(index != undefined && marca.id != undefined && marca.nome_marca != undefined) {
        const newRow = document.createElement('tr');
        newRow.id = "tableRow";
        newRow.innerHTML = `
            <td>${marca.id}</td>
            <td>${marca.nome_marca}</td>
            <td id="button">
                <button type="button" class="button green" id="edit-${index}">Editar</button>
            </td>
            <td id="button">
                <button type="button" class="button red" id="delete-${index}" >Excluir</button>
            </td>
        `
        document.querySelector('#tableClient>tbody').appendChild(newRow);

        constructorMarca(index, marca);
    }
}

_getMarca();

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

const createMarca = async (nome_marca) => {
    if(nome_marca.length > 2) {
        const formData = new FormData();
        formData.append("nome_marca", nome_marca);
    
        const dados = await fetch("../../controller/gravar_marca.php", {
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

            _getMarca();
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
            text: 'O Nome da marca deve ser maior que 2',
            icon: 'error',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Fechar'
        });
    }
}

const saveCadastro = () => {
    if (isValidFields()) {
        const nomeField = document.getElementById('nome_marca').value;
        createMarca(nomeField);
    }
}

// Editar Modal
const modalEdit = document.getElementById('edit');

const objMarca = [];

const setOjbMarca = (obj) => {
    objMarca.splice(0, objMarca.length);

    const marca = {
        index: obj.index,
        id: obj.id,
        nome_marca: obj.nome_marca
    }

    objMarca.push(marca);
}

const fillFields = (obj) => {
    document.getElementById("id").value = obj.id;
    document.getElementById('nome_edit').value = obj.nome_marca;
}

const openEdit = (index) => {
    modalEdit.classList.add('active');

    const marca = dbMarca[index];

    fillFields(marca);
}

const closeEdit = () => {
    clearFields();
    modalEdit.classList.remove("active");
}

const saveEdit = async () => {
    const formEdit = new FormData();
    // Recuperar os dados
    const fixedId = dbMarca[objMarca[0].index].id;
    const id = document.getElementById("id").value;
    const nome_marca = document.getElementById('nome_edit').value;
    
    // Criar o formulário
    formEdit.append("fixed_id", fixedId);
    formEdit.append("id", id);
    formEdit.append("nome_marca", nome_marca);

    try {
        const dados = await fetch("../../controller/update_marca.php", {
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

            _getMarca();
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
const deleteMarca = (index) => {
    const marca = dbMarca[index];

    Swal.fire({
        title: `Deseja realmente deletar?`,
        text: "Você não vai poder reverter isso!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: `Sim, delete "${marca.nome_marca}"!`
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                const formData = new FormData();
                formData.append("id", marca.id);
                
                const dados = await fetch("../../controller/deletar_marca.php", {
                    method: "POST", // Enviar os dados do JavaScript para o PHP através do método POST
                    body: formData, // Enviar os dados do JavaScript para o PHP
                });
    
                const resposta = await dados.json();           
                
                if(resposta['status']) {
                    Swal.fire({
                        title: "Deletado!",
                        text: `Marca "${marca.nome_marca}" deletada com sucesso!`,
                        icon: "success"
                    });
    
                    _getMarca();
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
                    text: `Não foi possivel deletar a marca "${marca.nome_marca}"!`,
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
            setOjbMarca(dbMarca[index]);
        } else {
            deleteMarca(index);
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