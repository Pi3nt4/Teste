<?php
require_once(__DIR__ . '/../controllers/RequisicaoController.php');
require_once(__DIR__ . '/../controllers/ResultadoController.php');

// Obter todas as requisições para exibição no campo de seleção
$requisicoes = RequisicaoController::listar();

// Obter o ID da requisição selecionada
$requisicao_id = $_GET['requisicao_id'] ?? null;

// Obter os dados da requisição e seus resultados
$requisicao = $requisicao_id ? RequisicaoController::buscarPorId($requisicao_id) : null;
$resultados = $requisicao_id ? ResultadoController::listarPorRequisicao($requisicao_id) : [];

// Processar o envio do formulário para cadastrar ou atualizar resultados
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cadastrar_resultados'])) {
    try {
        ResultadoController::cadastrar();
        $mensagem = "Resultado digitado com êxito!";
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
    <title>Lançamento de Resultados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <?php include 'navbar.php'; ?> <!-- Inclui a barra de navegação -->
    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mt-3">
                <li class="breadcrumb-item"><a href="home.php">Início</a></li>
                <li class="breadcrumb-item active" aria-current="page">Lançamento de Resultados</li>
                <li class="breadcrumb-item"><a href="gerenciarRequisicoes.php">Gerenciar requisicoes</a></li>
            </ol>
        </nav>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Lançamento de Resultados</h1>

        <!-- Exibir mensagens de erro ou sucesso -->
        <?php if (isset($erro)): ?>
            <div class="alert alert-danger text-center"><?= htmlspecialchars($erro) ?></div>
        <?php elseif (isset($mensagem)): ?>
            <div class="alert alert-success text-center"><?= htmlspecialchars($mensagem) ?></div>
        <?php endif; ?>

        <!-- Formulário para selecionar a requisição -->
        <form method="GET" action="" class="mb-4">
            <div class="mb-3">
                <label for="requisicao_id" class="form-label">Selecione a Requisição:</label>
                <select name="requisicao_id" id="requisicao_id" class="form-select" required>
                    <option value="">-- Escolha uma Requisição --</option>
                    <?php while ($row = $requisicoes->fetch_assoc()): ?>
                        <option value="<?= $row['id'] ?>" <?= $requisicao_id == $row['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($row['numero']) ?> - <?= htmlspecialchars($row['paciente_nome']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Selecionar</button>
        </form>

        <?php if ($requisicao): ?>
            <h3 class="text-center">Paciente: <?= htmlspecialchars($requisicao['paciente']['paciente_nome']) ?></h3>
        <?php else: ?>
            <p class="text-danger text-center">Requisição não encontrada.</p>
        <?php endif; ?>

        <?php if (!empty($requisicao['exames']) && is_array($requisicao['exames'])): ?>
            <form method="POST" action="">
                <input type="hidden" name="requisicao_id" value="<?= $requisicao_id ?>">
                <div class="mb-3">
                    <label for="exames" class="form-label">Exames:</label>
                    <?php foreach ($requisicao['exames'] as $exame): ?>
                        <?php
                        // Buscar o resultado do exame, se existir
                        $resultado = '';
                        foreach ($resultados as $row) {
                            if ($row['exame_id'] == $exame['id']) {
                                $resultado = $row['resultado'];
                                break;
                            }
                        }
                        ?>
                        <div class="form-group">
                            <label><?= htmlspecialchars($exame['exame_nome']) ?></label>
                            <textarea class="form-control" name="exames[<?= $exame['id'] ?>][resultado]" rows="2" required><?= htmlspecialchars($resultado) ?></textarea>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="submit" name="cadastrar_resultados" class="btn btn-primary">Salvar Resultados</button>
            </form>
        <?php else: ?>
            <p class="text-danger text-center">Nenhum exame encontrado para esta requisição.</p>
        <?php endif; ?>
    </div>
</body>
</html>