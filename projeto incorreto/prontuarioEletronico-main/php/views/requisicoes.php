<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requisições - Sistema de Gerenciamento</title>
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
                <li class="breadcrumb-item active" aria-current="page">Requisições</li>
            </ol>
        </nav>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Requisições</h1>
        <p class="text-center">Escolha uma das opções abaixo:</p>
        <div class="d-grid gap-3">
            <a href="novaRequisicao.php" class="btn btn-custom btn-lg">Cadastrar Requisição</a>
            <a href="gerenciarRequisicoes.php" class="btn btn-custom btn-lg">Gerenciar Requisições</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>