<?php
require_once(__DIR__ . '/../controllers/PacienteController.php');
require_once(__DIR__ . '/../controllers/ExameController.php');
require_once(__DIR__ . '/../controllers/RequisicaoController.php');

// Obter todas as informações necessárias
$pacientes = PacienteController::listar();
$exames = ExameController::listar();

// Obter o ID da requisição para edição (se fornecido)
$requisicao_id = $_GET['requisicao_id'] ?? null;
$requisicao = $requisicao_id ? RequisicaoController::buscarPorId($requisicao_id) : null;

// Processar o envio do formulário para salvar ou atualizar a requisição
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['salvar_requisicao'])) {
    try {
        if ($requisicao_id) {
            // Atualizar requisição existente
            RequisicaoController::atualizar($requisicao_id, $_POST['paciente_id'], $_POST['exames']);
            $mensagem = "Requisição atualizada com sucesso!";
        } else {
            // Criar nova requisição
            RequisicaoController::salvar($_POST['paciente_id'], $_POST['exames']);
            $mensagem = "Requisição criada com sucesso!";
        }
        header("Location: novaRequisicao.php");
        exit;
    } catch (Exception $e) {
        $erro = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $requisicao_id ? 'Editar Requisição' : 'Nova Requisição' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <?php include 'navbar.php'; ?> <!-- Inclui a barra de navegação -->
    
    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mt-3">
                <li class="breadcrumb-item"><a href="home.php">Início</a></li>
                <li class="breadcrumb-item active" aria-current="page">Nova requisição</li>
                <li class="breadcrumb-item"><a href="gerenciarRequisicoes.php">Gerenciar requisicoes</a></li>
            </ol>
        </nav>

    <div class="container mt-5">
        <h1 class="text-center mb-4"><?= $requisicao_id ? 'Editar Requisição' : 'Nova Requisição' ?></h1>

        <!-- Exibir mensagens de erro ou sucesso -->
        <?php if (isset($erro)): ?>
            <div class="alert alert-danger text-center"><?= htmlspecialchars($erro) ?></div>
        <?php elseif (isset($mensagem)): ?>
            <div class="alert alert-success text-center"><?= htmlspecialchars($mensagem) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-3">
                <label for="paciente_id" class="form-label">Paciente:</label>
                <select class="form-select" id="paciente_id" name="paciente_id" required>
                    <option value="">Selecione um paciente</option>
                    <?php while ($p = $pacientes->fetch_assoc()): ?>
                        <option value="<?= $p['id'] ?>" <?= $requisicao && $requisicao['paciente']['id'] == $p['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($p['nome']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
                <div class="mt-2">
                    <a href="cadastroPacientes.php" class="btn btn-sm btn-secondary">Cadastrar Novo Paciente</a>
                </div>
            </div>
            <div class="mb-3">
                <label for="exames" class="form-label">Exames:</label>
                <?php while ($e = $exames->fetch_assoc()): ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="exame_<?= $e['id'] ?>" name="exames[]" value="<?= $e['id'] ?>"
                            <?= $requisicao && in_array($e['id'], array_column($requisicao['exames'], 'id')) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="exame_<?= $e['id'] ?>">
                            <?= htmlspecialchars($e['nome']) ?>
                        </label>
                    </div>
                <?php endwhile; ?>
            </div>
            <div class="d-grid">
                <button type="submit" name="salvar_requisicao" class="btn btn-custom"><?= $requisicao_id ? 'Atualizar Requisição' : 'Salvar Requisição' ?></button>
            </div>
        </form>
    </div>
</body>
</html>