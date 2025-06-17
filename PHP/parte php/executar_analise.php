<?php
// Inclui o DAO da API de Análises para podermos buscar os dados
require_once 'dao/AnaliseApiDao.php';

// Pega o ID da análise que foi passado pela URL. Se não houver, usa 0.
$analise_id = $_GET['analise_id'] ?? 0;
$dados_analise = null;
$form_etapa_arquivo = null;
$titulo_etapa_atual = "Etapa não definida";

if ($analise_id > 0) {
    // Se temos um ID válido, buscamos os dados na API
    $analiseApiDao = new AnaliseApiDao();
    $dados_analise = $analiseApiDao->buscarPorId($analise_id);
}

// Lógica para determinar qual formulário de etapa carregar
// TODO: Na próxima fase, a API nos dirá qual é a etapa atual.
// Por enquanto, vamos carregar a primeira etapa de cada protocolo manualmente.
if ($dados_analise) {
    // Verifica parte do nome do protocolo para carregar a primeira etapa correspondente
    if (strpos($dados_analise['nome_protocolo'], 'Urocultura') !== false) {
        $titulo_etapa_atual = "ÁGAR CLED";
        $form_etapa_arquivo = 'view/etapas_urina/FormAgarCled.php';
    } elseif (strpos($dados_analise['nome_protocolo'], 'Escarro') !== false) {
        $titulo_etapa_atual = "Coloração de Ziehl-Neelsen";
        $form_etapa_arquivo = 'view/etapas_escarro/FormZiehlNeelsen.php';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Execução de Análise</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <?php include 'view/menu.php'; ?>

    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h4>Análise em Andamento (ID: <?php echo htmlspecialchars($analise_id); ?>)</h4>
            </div>

            <?php if ($dados_analise): // Se os dados da análise foram encontrados, exibe as informações ?>
                <div class="card-body">
                    <p><strong>Paciente:</strong> <?php echo htmlspecialchars($dados_analise['paciente_nome']); ?></p>
                    <p><strong>Protocolo:</strong> <?php echo htmlspecialchars($dados_analise['nome_protocolo']); ?></p>
                    <p><strong>Status:</strong> <?php echo htmlspecialchars($dados_analise['status']); ?></p>
                    <hr>
                    
                    <h5>Etapa Atual: <?php echo htmlspecialchars($titulo_etapa_atual); ?></h5>

                    <?php 
                    // Inclui o formulário correto com base no protocolo selecionado
                    if ($form_etapa_arquivo && file_exists($form_etapa_arquivo)) {
                        include $form_etapa_arquivo;
                    } else {
                        echo "<p class='text-danger'>Formulário da etapa não encontrado.</p>";
                    }
                    ?>
                </div>
            <?php else: // Se não encontrou a análise, exibe uma mensagem de erro ?>
                <div class="card-body">
                    <div class="alert alert-danger">Análise com o ID fornecido não foi encontrada.</div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>