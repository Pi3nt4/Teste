<?php
require_once __DIR__ . '/../dao/PacienteApiDao.php';

function listarPacientesApi() {
    $pacienteApiDao = new PacienteApiDao();
    $listaDePacientes = $pacienteApiDao->read();

    if (empty($listaDePacientes)) {
        echo "<tr><td colspan='4' class='text-center'>Nenhum paciente encontrado. Você pode cadastrar um novo ao lado.</td></tr>";
        return;
    }

    foreach ($listaDePacientes as $paciente) {
        echo "<tr>";
        // Usamos htmlspecialchars para segurança, prevenindo ataques de XSS
        echo "<td>" . htmlspecialchars($paciente['id']) . "</td>";
        echo "<td>" . htmlspecialchars($paciente['nome']) . "</td>";
        echo "<td>" . htmlspecialchars($paciente['cpf']) . "</td>";
        echo "<td>
                <a href='#' class='btn btn-sm btn-info'>Ver Análises</a> 
                
                <a href='pacientes.php?acao=editar&id=" . htmlspecialchars($paciente['id']) . "' class='btn btn-sm btn-warning'>Editar</a> 
              </td>";
        echo "</tr>";
    }
}
?>