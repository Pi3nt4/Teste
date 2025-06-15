<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selecionar Tipo de Análise</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <?php include 'view/menu.php'; ?>

    <div class="container mt-5 text-center">
        <h2 class="mb-4">Selecione o Tipo de Amostra para Análise</h2>
        <div class="row justify-content-center g-3">
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Amostra de Urina</h5>
                        <p class="card-text">Iniciar o protocolo padrão de urina.</p>
                        <a href="executar_analise.php?protocolo_id=1" class="btn btn-primary">Iniciar</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Amostra de Escarro</h5>
                        <p class="card-text">Iniciar o protocolo de análise de escarro.</p>
                        <a href="executar_analise.php?protocolo_id=2" class="btn btn-primary">Iniciar</a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>