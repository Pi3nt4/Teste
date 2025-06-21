<?php
require_once __DIR__ . '/../dao/PacienteApiDao.php';

// Verifica se o formulário de salvar paciente foi submetido
if (isset($_POST['salvar_paciente'])) {
    $pacienteDao = new PacienteApiDao();

    // Organiza os dados recebidos do formulário
    $dadosNovoPaciente = [
        'nome' => $_POST['nome'],
        'cpf' => $_POST['cpf'],
        'dataNascimento' => $_POST['data_nascimento'],
        'email' => $_POST['email']
    ];

    // Chama o método criar do DAO
    $sucesso = $pacienteDao->criar($dadosNovoPaciente);

    // Redireciona de volta para a página de pacientes com uma mensagem
    if ($sucesso) {
        header("Location: /PROJETO/PHP/parte php/pacientes.php?msg=cadastrado_sucesso");
    } else {
       header("Location: /PROJETO/PHP/parte php/pacientes.php?msg=erro_cadastrar");
    }
    exit();
}
function listarPacientesApi() {
    $pacienteApiDao = new PacienteApiDao();
    $listaDePacientes = $pacienteApiDao->read();

    // Na nossa API simplificada, a rota GET /pacientes retorna um objeto com uma chave "message".
    // Vamos verificar se a resposta é o que esperamos. Se for, exibimos a mensagem.
    // Na Entrega 4, quando a API retornar uma lista de verdade, este 'if' pode ser removido.
    if (isset($listaDePacientes['message'])) {
        echo "<tr><td colspan='4' class='text-center'>" . htmlspecialchars($listaDePacientes['message']) . "</td></tr>";
        return;
    }

    if (empty($listaDePacientes)) {
        echo "<tr><td colspan='4' class='text-center'>Nenhum paciente retornado pela API. Verifique se a API está rodando.</td></tr>";
        return;
    }

    // Se a API retornar uma lista de pacientes (como no primeiro exemplo que fizemos)
    foreach ($listaDePacientes as $paciente) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($paciente['id']) . "</td>";
        echo "<td>" . htmlspecialchars($paciente['nome']) . "</td>";
        echo "<td>" . htmlspecialchars($paciente['cpf']) . "</td>";
        echo "<td>
                <a href='#' class='btn btn-sm btn-info'>Ver Exames</a> 
                <a href='#' class='btn btn-sm btn-warning'>Editar</a> 
              </td>";
        echo "</tr>";
    }
}
?>