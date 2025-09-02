<?php
require_once __DIR__ . '/../dao/PacienteApiDao.php';
// Incluímos a nova classe Paciente para poder criar objetos dela
require_once __DIR__ . '/../model/Paciente.php';

// Verifica se o formulário de salvar paciente foi submetido
if (isset($_POST['salvar_paciente'])) {
    $pacienteDao = new PacienteApiDao();

    // --- ALTERAÇÃO PRINCIPAL AQUI ---
    // Criamos um objeto Paciente em vez de um array
    $novoPaciente = new Paciente(
        $_POST['nome'],
        $_POST['cpf'],
        $_POST['data_nascimento'],
        $_POST['email']
    );

    $sucesso = $pacienteDao->criar($novoPaciente);

    if ($sucesso) {
        header("Location: ../pacientes.php?msg=cadastrado_sucesso");
    } else {
       header("Location: ../pacientes.php?msg=erro_cadastrar");
    }
    exit();

// Lógica para atualizar um paciente existente
} elseif (isset($_POST['atualizar_paciente'])) {
    $pacienteDao = new PacienteApiDao();

    // --- ALTERAÇÃO PRINCIPAL AQUI ---
    // Criamos um objeto Paciente com todos os dados, incluindo o ID
    $pacienteAtualizado = new Paciente(
        $_POST['nome'],
        $_POST['cpf'],
        $_POST['data_nascimento'],
        $_POST['email'],
        (int)$_POST['id']
    );

    $sucesso = $pacienteDao->atualizar($pacienteAtualizado);

    if ($sucesso) {
        header("Location: ../pacientes.php?msg=atualizado_sucesso");
    } else {
        header("Location: ../pacientes.php?msg=erro_atualizar");
    }
    exit();

} elseif (isset($_GET['acao']) && $_GET['acao'] == 'excluir' && isset($_GET['id'])) {
    $pacienteDao = new PacienteApiDao();
    $id = (int)$_GET['id'];
    $sucesso = $pacienteDao->excluir($id);

    if ($sucesso) {
        header("Location: ../pacientes.php?msg=excluido_sucesso");
    } else {
        header("Location: ../pacientes.php?msg=erro_excluir");
    }
    exit();
}

// --- FUNÇÃO DE LISTAGEM ATUALIZADA ---
function listarPacientesApi() {
    $pacienteApiDao = new PacienteApiDao();
    $listaDePacientes = $pacienteApiDao->read(); // Agora retorna um array de OBJETOS Paciente

    if (empty($listaDePacientes)) {
        echo "<tr><td colspan='5' class='text-center'>Nenhum paciente retornado pela API. Verifique se a API está rodando.</td></tr>";
        return;
    }

    // --- ALTERAÇÃO PRINCIPAL AQUI ---
    // Usamos os getters do objeto para acessar os dados
    foreach ($listaDePacientes as $paciente) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($paciente->getId()) . "</td>";
        echo "<td>" . htmlspecialchars($paciente->getNome()) . "</td>";
        echo "<td>" . htmlspecialchars($paciente->getCpf()) . "</td>";
        echo "<td>
                <a href='#' class='btn btn-sm btn-info'>Ver Exames</a> 
                <a href='pacientes.php?acao=editar&id=" . htmlspecialchars($paciente->getId()) . "' class='btn btn-sm btn-warning'>Editar</a> 
                <a href='controller/PacienteController.php?acao=excluir&id=" . htmlspecialchars($paciente->getId()) . "' 
                   class='btn btn-sm btn-danger' 
                   onclick='return confirm(\"Tem certeza que deseja excluir este paciente?\");'>Excluir</a> 
              </td>";
        echo "</tr>";
    }
}
?>