<?php
// Inclui os DAOs necessários
require_once __DIR__ . '/dao/ExameApiDao.php';
require_once __DIR__ . '/dao/PacienteApiDao.php';

// --- 1. Lógica de Controlo ---
$exameDao = new ExameApiDao();
$pacienteDao = new PacienteApiDao();
$dadosExame = null;
$dadosPaciente = null;

if (!isset($_GET['id'])) {
    die("Erro: ID do exame não fornecido.");
}
$exame_id = (int)$_GET['id'];

// --- 2. Buscar os dados do exame e do paciente ---
$dadosExame = $exameDao->buscarPorId($exame_id);
if (!$dadosExame) {
    die("Erro: Exame com ID $exame_id não encontrado.");
}

$paciente_id = $dadosExame['paciente_id'];
$dadosPacienteJson = @file_get_contents("http://localhost:3000/api/pacientes/" . $paciente_id);
$dadosPaciente = $dadosPacienteJson ? json_decode($dadosPacienteJson, true) : null;

// Função para calcular a idade
function calcularIdade($dataNascimento) {
    if (!$dataNascimento) return 'N/A';
    $dataNasc = new DateTime($dataNascimento);
    $hoje = new DateTime();
    $idade = $hoje->diff($dataNasc);
    return $idade->y;
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Laudo do Exame - <?php echo htmlspecialchars($exame_id); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .laudo-container { max-width: 800px; margin: 30px auto; background: white; border: 1px solid #dee2e6; padding: 40px; }
        .laudo-header, .laudo-footer { text-align: center; margin-bottom: 30px; }
        .laudo-header h4, .laudo-header p { margin: 0; }
        .laudo-footer { margin-top: 50px; font-size: 0.8em; color: #6c757d; }
        .paciente-info, .exame-info { border: 1px solid #eee; padding: 15px; margin-bottom: 20px; }
        .resultado-bloco { margin-top: 20px; }
        .resultado-bloco h5 { border-bottom: 2px solid #0d6efd; padding-bottom: 5px; color: #0d6efd; }
        .resultado-item { display: flex; justify-content: space-between; padding: 5px 0; border-bottom: 1px dotted #ccc; }
        .resultado-item span:first-child { font-weight: bold; }
        .no-print { margin-top: 20px; text-align: center; }

        @media print {
            body { background-color: white; }
            .no-print, .navbar { display: none; }
            .laudo-container { border: none; box-shadow: none; margin: 0; max-width: 100%; }
        }
    </style>
</head>
<body>

    <?php include 'view/menu.php'; ?>

    <div class="laudo-container">
        <div class="laudo-header">
            <h4>LEAC - LABORATÓRIO DE ENSINO DE ANÁLISES CLÍNICAS</h4>
            <p>Universidade Positivo</p>
        </div>

        <div class="paciente-info">
            <div class="row">
                <div class="col-sm-8"><strong>PACIENTE:</strong> <?php echo htmlspecialchars($dadosPaciente['nome'] ?? ''); ?></div>
                <div class="col-sm-4"><strong>IDADE:</strong> <?php echo htmlspecialchars(calcularIdade($dadosPaciente['data_nascimento'] ?? null)); ?> anos</div>
                <div class="col-sm-8"><strong>PRONTUÁRIO:</strong> <?php echo htmlspecialchars($paciente_id); ?></div>
                <div class="col-sm-4"><strong>SEXO:</strong> (Não disponível)</div>
            </div>
        </div>

        <div class="exame-info">
            <div class="row">
                <div class="col-sm-12"><strong>EXAME:</strong> ANÁLISE MICROBIOLÓGICA</div>
                <div class="col-sm-8"><strong>MATERIAL:</strong> <?php echo ucfirst(htmlspecialchars($dadosExame['tipo_exame'] ?? '')); ?></div>
                <div class="col-sm-4"><strong>DATA:</strong> <?php echo htmlspecialchars( (new DateTime($dadosExame['data_inicio']))->format('d/m/Y H:i') ); ?></div>
            </div>
        </div>

        <div class="resultado-bloco">
            <h5>RESULTADOS</h5>

            <?php
                function render_item($label, $value) {
                    if (!empty($value)) {
                        echo '<div class="resultado-item"><span>' . htmlspecialchars($label) . ':</span> <span>' . htmlspecialchars($value) . '</span></div>';
                    }
                }
                
                // Exibindo cada campo
                render_item('Qtd. Colônias (CLED)', $dadosExame['urina_agar_cled_qtd_colonias']);
                render_item('Resultado (Ziehl-Neelsen)', $dadosExame['escarro_ziehl_resultado']);
                render_item('Resultado (Gram)', $dadosExame['gram_resultado']);
                render_item('Qtd. Colônias (Manitol)', $dadosExame['gp_agar_manitol_qtd_colonias']);
                render_item('Coloração (Manitol)', $dadosExame['gp_agar_manitol_coloracao']);
                render_item('Resultado (Catalase)', $dadosExame['gp_catalase_resultado']);
                render_item('Resultado (Coagulase)', $dadosExame['gp_coagulase_resultado']);
                render_item('Resultado (Novobiocina)', $dadosExame['gp_novobiocina_resultado']);
                render_item('Qtd. Colônias (MacConkey)', $dadosExame['gn_agar_macconkey_qtd_colonias']);
                render_item('Coloração (MacConkey)', $dadosExame['gn_agar_macconkey_coloracao']);
                // Adicionar mais 'render_item' para outros campos que desejar exibir no laudo
            ?>
        </div>

        <div class="resultado-bloco">
            <h5>LAUDO FINAL</h5>
            <p><?php echo nl2br(htmlspecialchars($dadosExame['resultado_final'] ?? 'Nenhum laudo final inserido.')); ?></p>
        </div>

        <div class="laudo-footer">
            <p>Liberado em: <?php echo htmlspecialchars( (new DateTime($dadosExame['data_finalizado'] ?? 'now'))->format('d/m/Y H:i') ); ?></p>
            [cite_start]<p><strong>OBS: Este laudo é estritamente destinado a fins acadêmicos e, portanto, não possui validade legal.</strong> [cite: 3]</p>
        </div>
    </div>

    <div class="no-print">
        <div class="d-grid gap-2 col-6 mx-auto">
            <button class="btn btn-lg btn-primary" onclick="window.print();">Imprimir Laudo</button>
        </div>
    </div>

</body>
</html>