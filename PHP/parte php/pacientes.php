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
        // Inclui o menu de navegação padrão
        include 'view/menu.php'; 
    ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-5">
                <h2>Cadastro de Paciente</h2>
                <hr>
                <?php 
                    // Inclui o formulário de cadastro de paciente (que já ajustamos)
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
                            // Inclui o novo controller e chama a função para listar os pacientes da API
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