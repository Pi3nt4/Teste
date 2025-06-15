<?php
// Lógica para decidir qual formulário de etapa carregar
$protocolo_id = $_GET['protocolo_id'] ?? 0;

// Variáveis padrão
$titulo_protocolo = "Protocolo Desconhecido";
$titulo_etapa = "Nenhuma etapa encontrada";
$form_etapa_arquivo = null;

// Lógica para carregar a PRIMEIRA ETAPA de cada protocolo
if ($protocolo_id == 1) { // Protocolo de Urina
    $titulo_protocolo = "Protocolo de Urocultura (Análise de Urina)";
    $titulo_etapa = "ÁGAR CLED";
    // Caminho para o formulário específico da urina
    $form_etapa_arquivo = 'view/etapas_urina/FormAgarCled.php'; 
} 
elseif ($protocolo_id == 2) { // Protocolo de Escarro
    $titulo_protocolo = "Protocolo de Análise de Escarro";
    $titulo_etapa = "Coloração de Ziehl-Neelsen";
    // Caminho para o formulário específico do escarro
    $form_etapa_arquivo = 'view/etapas_escarro/FormZiehlNeelsen.php';
}

// NOTA: No futuro, para as próximas etapas (ex: Coloração de Gram), a lógica seria:
// $titulo_etapa = "Coloração de Gram";
// $form_etapa_arquivo = 'view/etapas_comuns/FormColoracaoGram.php';

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
                <h4>Análise em Andamento</h4>
            </div>
            <div class="card-body">
                <p><strong>Paciente:</strong> (Exemplo) Ana Silva</p>
                <p><strong>Protocolo:</strong> <?php echo htmlspecialchars($titulo_protocolo); ?></p>
                <hr>
                
                <h5>Etapa Atual: <?php echo htmlspecialchars($titulo_etapa); ?></h5>

                <?php 
                if ($form_etapa_arquivo && file_exists($form_etapa_arquivo)) {
                    include $form_etapa_arquivo;
                } else {
                    echo "<p class='text-danger'>Erro: Formulário da etapa não encontrado no caminho especificado.</p>";
                }
                ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>