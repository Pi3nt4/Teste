<?php
// Inclui os controllers necessários para manipular requisições e exames
require_once(__DIR__ . '/../controllers/RequisicaoController.php');
require_once(__DIR__ . '/../controllers/ExameController.php');

// Busca todas as requisições para exibir no campo de seleção do formulário
$requisicoes = RequisicaoController::listar();

// Busca todos os exames para exibir como opções de checkbox
$exames = ExameController::listar();

// Obtém o ID da requisição selecionada pelo usuário (via GET)
$requisicao_id = $_GET['requisicao_id'] ?? null;

// Se um ID de requisição foi selecionado, busca os dados completos dessa requisição
$requisicao = $requisicao_id ? RequisicaoController::buscarPorId($requisicao_id) : null;

// Processa o envio do formulário (POST) para atualizar ou excluir uma requisição
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Se o botão de atualizar foi pressionado
        if (isset($_POST['atualizar_requisicao'])) {
            // Valida se o ID do paciente foi enviado
            if (empty($_POST['paciente_id'])) {
                throw new Exception('ID do paciente é obrigatório.');
            }

            // Garante que exames seja sempre um array (mesmo se nenhum for selecionado)
            $exames_selecionados = $_POST['exames'] ?? [];
            // Atualiza a requisição com os novos dados
            RequisicaoController::atualizar($requisicao_id, $_POST['paciente_id'], $exames_selecionados);
            $mensagem = "Requisição atualizada com sucesso!";
            // Redireciona para a mesma página para evitar reenvio do formulário
            header("Location: gerenciarRequisicoes.php?requisicao_id=$requisicao_id");
            exit;
        }

        // Se o botão de excluir foi pressionado
        if (isset($_POST['excluir_requisicao'])) {
            // Exclui a requisição selecionada
            RequisicaoController::excluir($requisicao_id);
            $mensagem = "Requisição excluída com sucesso!";
            // Redireciona para a página sem requisição selecionada
            header("Location: gerenciarRequisicoes.php");
            exit;
        }
    } catch (Exception $e) {
        // Captura e exibe qualquer erro ocorrido durante o processamento
        $erro = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Requisições</title>
    <!-- Bootstrap para estilização -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <?php include 'navbar.php'; ?> <!-- Inclui a barra de navegação do sistema -->
    <div class="container mt-5">
        <!-- Breadcrumb para navegação entre páginas -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mt-3">
                <li class="breadcrumb-item"><a href="home.php">Início</a></li>
                <li class="breadcrumb-item"><a href="novaRequisicao.php">Nova Requisição</a></li>
                <li class="breadcrumb-item active" aria-current="page">Gerenciar requisições</li>
                <li class="breadcrumb-item"><a href="lancamentoDeExame.php">Lançamento de Resultados</a></li>
            </ol>
        </nav>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Gerenciar Requisições</h1>

        <!-- Exibe mensagens de erro ou sucesso para o usuário -->
        <?php if (isset($erro)): ?>
            <div class="alert alert-danger text-center"><?= htmlspecialchars($erro) ?></div>
        <?php elseif (isset($mensagem)): ?>
            <div class="alert alert-success text-center"><?= htmlspecialchars($mensagem) ?></div>
        <?php endif; ?>

        <!-- Formulário para selecionar qual requisição será gerenciada -->
        <form method="GET" action="" class="mb-4">
            <div class="mb-3">
                <label for="requisicao_id" class="form-label">Selecione a Requisição:</label>
                <select name="requisicao_id" id="requisicao_id" class="form-select" required>
                    <option value="">-- Escolha uma Requisição --</option>
                    <!-- Lista todas as requisições disponíveis -->
                    <?php while ($row = $requisicoes->fetch_assoc()): ?>
                        <option value="<?= $row['id'] ?>" <?= $requisicao_id == $row['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($row['numero']) ?> - <?= htmlspecialchars($row['paciente_nome']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Selecionar</button>
        </form>

        <!-- Se uma requisição foi selecionada, exibe os dados dela para edição/exclusão -->
        <?php if ($requisicao): ?>
            <h3 class="text-center">Paciente: <?= htmlspecialchars($requisicao['paciente']['paciente_nome']) ?></h3>

            <!-- Formulário para atualizar os exames da requisição -->
            <form method="POST" action="">
                <!-- Campo oculto com o ID do paciente -->
                <input type="hidden" name="paciente_id" value="<?= htmlspecialchars($requisicao['paciente']['paciente_id']) ?>">
                <div class="mb-3">
                    <label for="exames" class="form-label">Exames:</label>
                    <!-- Lista todos os exames disponíveis como checkboxes -->
                    <?php while ($e = $exames->fetch_assoc()): ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="exame_<?= $e['id'] ?>" name="exames[]" value="<?= $e['id'] ?>"
                                <?= in_array($e['id'], array_column($requisicao['exames'], 'id')) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="exame_<?= $e['id'] ?>">
                                <?= htmlspecialchars($e['nome']) ?>
                            </label>
                        </div>
                    <?php endwhile; ?>
                </div>
                <div class="d-grid mb-3">
                    <button type="submit" name="atualizar_requisicao" class="btn btn-primary">Atualizar Requisição</button>
                </div>
            </form>

            <!-- Formulário para excluir a requisição selecionada -->
            <form method="POST" action="">
                <div class="d-grid">
                    <button type="submit" name="excluir_requisicao" class="btn btn-danger">Excluir Requisição</button>
                </div>
            </form>
        <?php else: ?>
            <!-- Caso nenhuma requisição tenha sido selecionada -->
            <p class="text-danger text-center">Nenhuma requisição selecionada.</p>
        <?php endif; ?>
    </div>
</body>
</html>