<?php
session_start();
// Inclui os DAOs necessários para comunicar com a API
require_once __DIR__ . '/dao/PacienteApiDao.php';
require_once __DIR__ . '/dao/ExameApiDao.php';

$pacienteDao = new PacienteApiDao();
$exameDao = new ExameApiDao();

// Lógica para processar a submissão do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Verifica se os dados necessários foram enviados
    if (isset($_POST['paciente_id']) && isset($_POST['tipo_exame'])) {
        $paciente_id = (int)$_POST['paciente_id'];
        $tipo_exame = $_POST['tipo_exame'];

        // Chama o DAO para iniciar um novo exame através da API
        $novoExame = $exameDao->iniciarExame($paciente_id, $tipo_exame);

        if ($novoExame && isset($novoExame['exame_id'])) {
            $exame_id = $novoExame['exame_id'];
            
            // Redireciona para o formulário correto com base no tipo de exame
            if ($tipo_exame === 'urina') {
                header("Location: analise_urina.php?id=" . $exame_id);
                exit();
            } elseif ($tipo_exame === 'escarro') {
                header("Location: analise_escarro.php?id=" . $exame_id);
                exit();
            }
        } else {
            // Se houver um erro na criação do exame, guarda uma mensagem de erro
            $erro_mensagem = "Não foi possível iniciar o exame. Verifique se a API está a funcionar.";
        }
    } else {
        $erro_mensagem = "Por favor, selecione um paciente e um tipo de amostra.";
    }
}

// Busca a lista de todos os pacientes para preencher o seletor (dropdown)
// Esta parte executa sempre que a página é carregada (via GET)
$lista_pacientes = $pacienteDao->read();

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Nova Análise</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <?php include 'view/menu.php'; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="text-center">Iniciar Nova Análise</h4>
                    </div>
                    <div class="card-body">
                        
                        <?php if (isset($erro_mensagem)): ?>
                            <div class="alert alert-danger"><?php echo htmlspecialchars($erro_mensagem); ?></div>
                        <?php endif; ?>

                        <form action="iniciar_analise.php" method="post">
                            <div class="mb-3">
                                <label for="paciente_id" class="form-label">Selecione o Paciente</label>
                                <select class="form-select" name="paciente_id" id="paciente_id" required>
                                    <option value="" disabled selected>-- Clique para selecionar --</option>
                                    <?php foreach ($lista_pacientes as $paciente): ?>
                                        <option value="<?php echo htmlspecialchars($paciente['id']); ?>">
                                            <?php echo htmlspecialchars($paciente['nome']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="tipo_exame" class="form-label">Selecione o Tipo de Amostra</label>
                                <select class="form-select" name="tipo_exame" id="tipo_exame" required>
                                    <option value="urina">Amostra de Urina</option>
                                    <option value="escarro">Amostra de Escarro</option>
                                </select>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Prosseguir para Análise</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>