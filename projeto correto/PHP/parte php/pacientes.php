<?php
// Inclui o DAO para ter acesso aos métodos da API
require_once 'dao/PacienteApiDao.php';

$paciente_para_editar = null; // Variável para guardar o paciente a ser editado
$modo_edicao = false;         // Flag para saber se estamos em modo de edição

// Verifica se a ação é 'editar' e se um ID foi passado na URL
if (isset($_GET['acao']) && $_GET['acao'] == 'editar' && isset($_GET['id'])) {
    $id_para_editar = (int)$_GET['id'];
    $pacienteDao = new PacienteApiDao(); // Precisamos do DAO para buscar o paciente
    
    // O método buscarPorId retorna um array associativo
    $paciente_para_editar = $pacienteDao->buscarPorId($id_para_editar);
    
    if ($paciente_para_editar) {
        $modo_edicao = true;
    } else {
        echo "<div class='alert alert-danger'>Paciente não encontrado para edição.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-g">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Pacientes</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <?php 
        include 'view/menu.php'; 
    ?>
    <div class="container mt-5">

        <?php
        // --- NOVO BLOCO PARA EXIBIR MENSAGENS DE FEEDBACK ---
        if (isset($_GET['msg'])) {
            $msg = $_GET['msg'];
            if ($msg == 'excluido_sucesso') {
                echo "<div class='alert alert-success'>Paciente excluído com sucesso!</div>";
            } elseif ($msg == 'erro_excluir') {
                echo "<div class='alert alert-danger'>Erro ao excluir paciente. Verifique se a API está online e tente novamente.</div>";
            }
            // Adicione outras mensagens (como de cadastro e atualização) se desejar
        }
        ?>

        <div class="row">

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-5">
                <h2><?php echo $modo_edicao ? 'Editar Paciente' : 'Cadastro de Paciente'; ?></h2>
                <hr>
                <?php 
                    // O formulário PacienteForm.php agora terá acesso à variável $paciente_para_editar
                    include 'view/PacienteForm.php'; 
                ?>
            </div>

            <div class="col-md-7">
                <h2>Pacientes Cadastrados</h2>
                <hr>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Código</th>
                            <th scope="col">Nome</th>
                            <th scope="col">CPF</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            require_once 'controller/PacienteController.php';
                            listarPacientesApi();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>