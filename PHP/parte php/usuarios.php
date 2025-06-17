<?php
// Inclui o controller para ter acesso à função listarUsuarios() e aos DAOs/Models
// O UsuarioController.php já deve estar incluindo o UsuarioDao.php e Usuario.php
require_once 'controller/UsuarioController.php';

$usuario_para_editar = null; // Variável para guardar o usuário a ser editado
$modo_edicao = false;       // Flag para saber se estamos em modo de edição

// Verifica se a ação é 'editar' e se um ID foi passado na URL
if (isset($_GET['acao']) && $_GET['acao'] == 'editar' && isset($_GET['id'])) {
    $id_para_editar = (int)$_GET['id'];
    $usuarioDao = new UsuarioDao(); // Precisamos do DAO para buscar o usuário
    $usuario_para_editar = $usuarioDao->buscarPorId($id_para_editar);
    
    if ($usuario_para_editar) {
        $modo_edicao = true;
    } else {
        // Opcional: adicionar uma mensagem se o usuário não for encontrado
        echo "<div class='alert alert-danger'>Usuário não encontrado para edição.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Usuários</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <?php include 'view/menu.php'; ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-5">
                <h2><?php echo $modo_edicao ? 'Editar Usuário' : 'Cadastro de Usuário'; ?></h2>
                <hr>
                <?php 
                    // O formulário UsuarioForm.php agora terá acesso à variável $usuario_para_editar
                    include 'view/UsuarioForm.php'; 
                ?>
            </div>

            <div class="col-md-7">
                <h2>Usuários Cadastrados</h2>
                <hr>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#ID</th>
                            <th scope="col">Nome</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            // A função listarUsuarios() já está no UsuarioController.php
                            listarUsuarios();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>