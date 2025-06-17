<?php
// Inclui os arquivos necessários do DAO e Model
require_once __DIR__ . '/../dao/ConnectionFactory.php';
require_once __DIR__ . '/../model/Usuario.php';
require_once __DIR__ . '/../dao/UsuarioDao.php';


// --- LÓGICA PARA INSERIR UM NOVO USUÁRIO ---
if (isset($_POST['cadastrar'])) {
    // ... (seu código de cadastro existente aqui) ...
    $usuario = new Usuario();
    $usuario->setNome($_POST['nome']);
    $usuario->setCpf($_POST['cpf']); 
    $usuario->setDataNascimento($_POST['data_nascimento']); 
    $usuario->setEmail($_POST['email']);
    $usuario->setSenha($_POST['senha']);
    $usuario->setTipo($_POST['tipo']);

    $usuarioDao = new UsuarioDao();
    $usuarioDao->inserir($usuario);

    header("Location: ../usuarios.php?msg=cadastrado");
    exit();

// --- LÓGICA PARA ATUALIZAR UM USUÁRIO EXISTENTE ---
} elseif (isset($_POST['atualizar'])) {
    // ... (seu código de atualização existente aqui) ...
    $usuario = new Usuario();
    $usuario->setId((int)$_POST['id']); 
    $usuario->setNome($_POST['nome']);
    $usuario->setCpf($_POST['cpf']);
    $usuario->setDataNascimento($_POST['data_nascimento']);
    $usuario->setEmail($_POST['email']);
    $usuario->setTipo($_POST['tipo']);
    
    if (!empty($_POST['senha'])) {
        $usuario->setSenha($_POST['senha']);
    }

    $usuarioDao = new UsuarioDao();
    $usuarioDao->atualizar($usuario); 

    header("Location: ../usuarios.php?msg=atualizado");
    exit();

// --- NOVA LÓGICA PARA EXCLUIR UM USUÁRIO ---
} elseif (isset($_GET['acao']) && $_GET['acao'] == 'excluir' && isset($_GET['id'])) {
    
    $id_para_excluir = (int)$_GET['id']; // Pega o ID da URL

    $usuarioDao = new UsuarioDao();
    $sucesso = $usuarioDao->excluir($id_para_excluir); // Precisaremos criar este método no DAO

    if ($sucesso) {
        header("Location: ../usuarios.php?msg=excluido_sucesso");
    } else {
        // Você pode adicionar uma mensagem de erro mais específica se desejar
        header("Location: ../usuarios.php?msg=erro_excluir");
    }
    exit();
}


// --- FUNÇÃO PARA LISTAR OS USUÁRIOS NA TABELA (EXISTENTE E ATUALIZADA) ---
function listarUsuarios() {
    // ... (seu código da função listarUsuarios, com o link de excluir já atualizado) ...
    $usuarioDao = new UsuarioDao();
    $lista = $usuarioDao->read(); 

    foreach ($lista as $usuario) {
        echo "<tr>";
        echo "<td>" . $usuario->getId() . "</td>";
        echo "<td>" . htmlspecialchars($usuario->getNome()) . "</td>";
        echo "<td>" . htmlspecialchars($usuario->getEmail()) . "</td>";
        echo "<td>" . htmlspecialchars($usuario->getTipo()) . "</td>";
        echo "<td> 
                <a href='usuarios.php?acao=editar&id=" . $usuario->getId() . "' class='btn btn-warning btn-sm'>Editar</a> 
                <a href='controller/UsuarioController.php?acao=excluir&id=" . $usuario->getId() . "' 
                   class='btn btn-danger btn-sm' 
                   onclick='return confirm(\"Tem certeza que deseja excluir este usuário?\");'>Excluir</a> 
              </td>";
        echo "</tr>";
    }
}
?>