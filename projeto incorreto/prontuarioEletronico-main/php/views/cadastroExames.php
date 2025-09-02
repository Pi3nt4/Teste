<?php
require_once(__DIR__ . '/../config/db.php');
require_once(__DIR__ . '/../controllers/ExameController.php');

$mensagem = '';
$exameEdit = null;

// CADASTRAR
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cadastrar'])) {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    if (ExameController::cadastrar($nome, $descricao)) {
        $mensagem = "Exame cadastrado com sucesso!";
    } else {
        $mensagem = "Erro ao cadastrar o exame.";
    }
}

// EDITAR (carregar dados)
if (isset($_GET['editar'])) {
    $exameEdit = ExameController::buscarPorId($_GET['editar']);
}

// SALVAR EDIÇÃO
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['salvar_edicao'])) {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    if (ExameController::editar($id, $nome, $descricao)) {
        $mensagem = "Exame atualizado com sucesso!";
    } else {
        $mensagem = "Erro ao atualizar o exame.";
    }
    $exameEdit = null;
}

// EXCLUIR
if (isset($_GET['excluir'])) {
    if (ExameController::excluir($_GET['excluir'])) {
        $mensagem = "Exame excluído!";
    } else {
        $mensagem = "Erro ao excluir o exame.";
    }
}

$exames = ExameController::listar();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Exames</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mt-3">
                <li class="breadcrumb-item"><a href="home.php">Início</a></li>
                <li class="breadcrumb-item active" aria-current="page">Exames</li>
            </ol>
        </nav>
        <h1 class="text-center mb-4"><?= $exameEdit ? 'Editar Exame' : 'Cadastro de Exames' ?></h1>
        <?php if ($mensagem): ?>
            <div class="alert alert-info"><?= htmlspecialchars($mensagem) ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <?php if ($exameEdit): ?>
                <input type="hidden" name="id" value="<?= $exameEdit['id'] ?>">
            <?php endif; ?>
            <div class="mb-3">
                <label for="nome" class="form-label">Nome do Exame:</label>
                <input type="text" class="form-control" id="nome" name="nome" required value="<?= $exameEdit['nome'] ?? '' ?>">
            </div>
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição:</label>
                <textarea class="form-control" id="descricao" name="descricao" rows="3"><?= $exameEdit['descricao'] ?? '' ?></textarea>
            </div>
            <div class="d-grid">
                <?php if ($exameEdit): ?>
                    <button type="submit" name="salvar_edicao" class="btn btn-warning">Salvar Alterações</button>
                    <a href="cadastroExames.php" class="btn btn-secondary mt-2">Cancelar</a>
                <?php else: ?>
                    <button type="submit" name="cadastrar" class="btn btn-custom">Cadastrar Exame</button>
                <?php endif; ?>
            </div>
        </form>

        <h2 class="mt-5 text-center">Exames Cadastrados</h2>
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($exame = $exames->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($exame['id']) ?></td>
                        <td><?= htmlspecialchars($exame['nome']) ?></td>
                        <td><?= htmlspecialchars($exame['descricao']) ?></td>
                        <td>
                            <a href="?editar=<?= $exame['id'] ?>" class="btn btn-sm btn-primary" title="Editar">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="?excluir=<?= $exame['id'] ?>" class="btn btn-sm btn-danger" title="Excluir"
                               onclick="return confirm('Tem certeza que deseja excluir este exame?');">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>