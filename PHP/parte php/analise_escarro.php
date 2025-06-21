<?php
// Inclui os DAOs necessários
require_once __DIR__ . '/dao/ExameApiDao.php';
require_once __DIR__ . '/dao/PacienteApiDao.php';

// --- 1. Lógica de Controlo ---
$exameDao = new ExameApiDao();
$pacienteDao = new PacienteApiDao();
$dadosExame = null;
$dadosPaciente = null;
$mensagem = null;

if (!isset($_GET['id'])) {
    die("Erro: ID do exame não fornecido. Volte à página de 'Iniciar Análise'.");
}
$exame_id = (int)$_GET['id'];

// --- 2. Processar a Submissão do Formulário (Salvar Dados) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dadosParaSalvar = $_POST;
    if (isset($_POST['finalizar_analise'])) {
        $dadosParaSalvar['status'] = 'finalizado';
    }
    $sucesso = $exameDao->atualizar($exame_id, $dadosParaSalvar);
    if ($sucesso) {
        $mensagem = ['tipo' => 'success', 'texto' => 'Dados salvos com sucesso!'];
    } else {
        $mensagem = ['tipo' => 'danger', 'texto' => 'Erro ao salvar os dados. Verifique a API.'];
    }
}

// --- 3. Buscar Dados Atuais do Exame para Exibir ---
$dadosExame = $exameDao->buscarPorId($exame_id);
if (!$dadosExame) {
    die("Erro: Exame com ID $exame_id não encontrado.");
}
$paciente_id = $dadosExame['paciente_id'];
$dadosPacienteJson = @file_get_contents("http://localhost:3000/api/pacientes/" . $paciente_id);
$dadosPaciente = $dadosPacienteJson ? json_decode($dadosPacienteJson, true) : null;

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Análise de Escarro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <?php include 'view/menu.php'; ?>

    <div class="container mt-5 mb-5">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h3>Análise de Escarro (Baciloscopia)</h3>
                <p class="mb-0">
                    <strong>Paciente:</strong> <?php echo htmlspecialchars($dadosPaciente['nome'] ?? 'Não encontrado'); ?> |
                    <strong>ID do Exame:</strong> <?php echo htmlspecialchars($exame_id); ?>
                </p>
            </div>

            <div class="card-body">
                <?php if ($mensagem): ?>
                    <div class="alert alert-<?php echo $mensagem['tipo']; ?> alert-dismissible fade show" role="alert">
                        <?php echo htmlspecialchars($mensagem['texto']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form action="analise_escarro.php?id=<?php echo $exame_id; ?>" method="post">
                    
                    <fieldset class="border p-3 mb-3">
                        <legend class="w-auto px-2 h5">1. Coloração de Ziehl-Neelsen</legend>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Resultado</label>
                                <select class="form-select" name="escarro_ziehl_resultado">
                                     <option value="" <?php echo empty($dadosExame['escarro_ziehl_resultado']) ? 'selected' : ''; ?>>-- Selecione --</option>
                                     <option value="BAAR Positivo" <?php echo ($dadosExame['escarro_ziehl_resultado'] ?? '') === 'BAAR Positivo' ? 'selected' : ''; ?>>BAAR Positivo (+)</option>
                                     <option value="BAAR Negativo" <?php echo ($dadosExame['escarro_ziehl_resultado'] ?? '') === 'BAAR Negativo' ? 'selected' : ''; ?>>BAAR Negativo (-)</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3"><label class="form-label">Lote</label><input type="text" class="form-control" name="escarro_ziehl_lote" value="<?php echo htmlspecialchars($dadosExame['escarro_ziehl_lote'] ?? ''); ?>"></div>
                            <div class="col-md-4 mb-3"><label class="form-label">Validade</label><input type="date" class="form-control" name="escarro_ziehl_validade" value="<?php echo htmlspecialchars($dadosExame['escarro_ziehl_validade'] ?? ''); ?>"></div>
                        </div>
                    </fieldset>

                    <fieldset class="border p-3 mb-3">
                        <legend class="w-auto px-2 h5">2. Coloração de Gram</legend>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Resultado</label>
                                <select class="form-select" name="gram_resultado">
                                    <option value="" <?php echo empty($dadosExame['gram_resultado']) ? 'selected' : ''; ?>>-- Selecione --</option>
                                    <option value="Gram Positivo" <?php echo ($dadosExame['gram_resultado'] ?? '') === 'Gram Positivo' ? 'selected' : ''; ?>>Gram Positivo</option>
                                    <option value="Gram Negativo" <?php echo ($dadosExame['gram_resultado'] ?? '') === 'Gram Negativo' ? 'selected' : ''; ?>>Gram Negativo</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3"><label class="form-label">Lote</label><input type="text" class="form-control" name="gram_lote" value="<?php echo htmlspecialchars($dadosExame['gram_lote'] ?? ''); ?>"></div>
                            <div class="col-md-4 mb-3"><label class="form-label">Validade</label><input type="date" class="form-control" name="gram_validade" value="<?php echo htmlspecialchars($dadosExame['gram_validade'] ?? ''); ?>"></div>
                        </div>
                    </fieldset>

                    <p class="text-center text-muted">A partir daqui, preencha o caminho correspondente ao resultado do Gram.</p>

                    <div class="row">
                        <div class="col-md-6">
                            <fieldset class="border p-3 mb-3 h-100">
                                <legend class="w-auto px-2 h5 text-primary">Caminho Gram-Positivo</legend>
                                
                                <label class="form-label fw-bold">3A. Ágar Manitol</label>
                                <div class="row g-2 mb-3">
                                    <div class="col-sm-6"><input type="text" class="form-control" name="gp_agar_manitol_qtd_colonias" placeholder="Qtd. Colônias" value="<?php echo htmlspecialchars($dadosExame['gp_agar_manitol_qtd_colonias'] ?? ''); ?>"></div>
                                    <div class="col-sm-6"><input type="text" class="form-control" name="gp_agar_manitol_coloracao" placeholder="Coloração" value="<?php echo htmlspecialchars($dadosExame['gp_agar_manitol_coloracao'] ?? ''); ?>"></div>
                                    <div class="col-sm-6"><input type="text" class="form-control" name="gp_agar_manitol_lote" placeholder="Lote" value="<?php echo htmlspecialchars($dadosExame['gp_agar_manitol_lote'] ?? ''); ?>"></div>
                                    <div class="col-sm-6"><input type="date" title="Validade" class="form-control" name="gp_agar_manitol_validade" value="<?php echo htmlspecialchars($dadosExame['gp_agar_manitol_validade'] ?? ''); ?>"></div>
                                </div><hr>
                                
                                <label class="form-label fw-bold">4A. Testes Adicionais</label>
                                <div class="row g-2 mb-2">
                                    <div class="col-12"><label class="form-label small">Catalase</label></div>
                                    <div class="col-sm-6"><select class="form-select" name="gp_catalase_resultado"><option value="">-- Resultado --</option><option value="Positivo" <?php echo ($dadosExame['gp_catalase_resultado'] ?? '') == 'Positivo' ? 'selected' : '';?>>Positivo</option><option value="Negativo" <?php echo ($dadosExame['gp_catalase_resultado'] ?? '') == 'Negativo' ? 'selected' : '';?>>Negativo</option></select></div>
                                    <div class="col-sm-6"><input type="text" class="form-control" name="gp_catalase_lote" placeholder="Lote" value="<?php echo htmlspecialchars($dadosExame['gp_catalase_lote'] ?? ''); ?>"></div>
                                </div>
                                <div class="row g-2 mb-3">
                                    <div class="col-12"><label class="form-label small">Coagulase</label></div>
                                    <div class="col-sm-6"><select class="form-select" name="gp_coagulase_resultado"><option value="">-- Resultado --</option><option value="Positivo" <?php echo ($dadosExame['gp_coagulase_resultado'] ?? '') == 'Positivo' ? 'selected' : '';?>>Positivo</option><option value="Negativo" <?php echo ($dadosExame['gp_coagulase_resultado'] ?? '') == 'Negativo' ? 'selected' : '';?>>Negativo</option></select></div>
                                    <div class="col-sm-6"><input type="text" class="form-control" name="gp_coagulase_lote_reagente" placeholder="Lote Reagente" value="<?php echo htmlspecialchars($dadosExame['gp_coagulase_lote_reagente'] ?? ''); ?>"></div>
                                    <div class="col-sm-6"><input type="text" class="form-control" name="gp_coagulase_lote_tubo" placeholder="Lote Tubo" value="<?php echo htmlspecialchars($dadosExame['gp_coagulase_lote_tubo'] ?? ''); ?>"></div>
                                </div>
                                 <div class="row g-2">
                                    <div class="col-12"><label class="form-label small">Novobiocina</label></div>
                                    <div class="col-sm-6"><select class="form-select" name="gp_novobiocina_resultado"><option value="">-- Resultado --</option><option value="Sensível" <?php echo ($dadosExame['gp_novobiocina_resultado'] ?? '') == 'Sensível' ? 'selected' : '';?>>Sensível</option><option value="Resistente" <?php echo ($dadosExame['gp_novobiocina_resultado'] ?? '') == 'Resistente' ? 'selected' : '';?>>Resistente</option></select></div>
                                    <div class="col-sm-6"><input type="text" class="form-control" name="gp_novobiocina_lote_antibiotico" placeholder="Lote Antibiótico" value="<?php echo htmlspecialchars($dadosExame['gp_novobiocina_lote_antibiotico'] ?? ''); ?>"></div>
                                </div>
                            </fieldset>
                        </div>

                        <div class="col-md-6">
                            <fieldset class="border p-3 mb-3 h-100">
                                <legend class="w-auto px-2 h5 text-danger">Caminho Gram-Negativo</legend>
                                
                                <label class="form-label fw-bold">3B. Ágar MacConkey</label>
                                <div class="row g-2 mb-3">
                                     <div class="col-sm-6"><input type="text" class="form-control" name="gn_agar_macconkey_qtd_colonias" placeholder="Qtd. Colônias" value="<?php echo htmlspecialchars($dadosExame['gn_agar_macconkey_qtd_colonias'] ?? ''); ?>"></div>
                                     <div class="col-sm-6"><input type="text" class="form-control" name="gn_agar_macconkey_coloracao" placeholder="Coloração" value="<?php echo htmlspecialchars($dadosExame['gn_agar_macconkey_coloracao'] ?? ''); ?>"></div>
                                     <div class="col-sm-6"><input type="text" class="form-control" name="gn_agar_macconkey_lote" placeholder="Lote" value="<?php echo htmlspecialchars($dadosExame['gn_agar_macconkey_lote'] ?? ''); ?>"></div>
                                     <div class="col-sm-6"><input type="date" title="Validade" class="form-control" name="gn_agar_macconkey_validade" value="<?php echo htmlspecialchars($dadosExame['gn_agar_macconkey_validade'] ?? ''); ?>"></div>
                                </div><hr>
                                
                                <label class="form-label fw-bold">4B. Provas Bioquímicas</label>
                                <div class="row g-2 mb-2">
                                    <div class="col-12"><label class="form-label small">EPM (Gás/H2S/Ureia/Triptofano)</label></div>
                                    <div class="col-sm-3"><input type="text" class="form-control" name="gn_epm_gas" placeholder="Gás" value="<?php echo htmlspecialchars($dadosExame['gn_epm_gas'] ?? ''); ?>"></div>
                                    <div class="col-sm-3"><input type="text" class="form-control" name="gn_epm_h2s" placeholder="H2S" value="<?php echo htmlspecialchars($dadosExame['gn_epm_h2s'] ?? ''); ?>"></div>
                                    <div class="col-sm-3"><input type="text" class="form-control" name="gn_epm_ureia" placeholder="Ureia" value="<?php echo htmlspecialchars($dadosExame['gn_epm_ureia'] ?? ''); ?>"></div>
                                    <div class="col-sm-3"><input type="text" class="form-control" name="gn_epm_triptofano" placeholder="Triptofano" value="<?php echo htmlspecialchars($dadosExame['gn_epm_triptofano'] ?? ''); ?>"></div>
                                </div>
                                 <div class="row g-2 mb-2">
                                    <div class="col-12"><label class="form-label small">MILI (Indol/Lisina/Motilidade)</label></div>
                                    <div class="col-sm-4"><input type="text" class="form-control" name="gn_mili_indol" placeholder="Indol" value="<?php echo htmlspecialchars($dadosExame['gn_mili_indol'] ?? ''); ?>"></div>
                                    <div class="col-sm-4"><input type="text" class="form-control" name="gn_mili_lisina" placeholder="Lisina" value="<?php echo htmlspecialchars($dadosExame['gn_mili_lisina'] ?? ''); ?>"></div>
                                    <div class="col-sm-4"><input type="text" class="form-control" name="gn_mili_motilidade" placeholder="Motilidade" value="<?php echo htmlspecialchars($dadosExame['gn_mili_motilidade'] ?? ''); ?>"></div>
                                </div>
                                <div class="row g-2">
                                    <div class="col-12"><label class="form-label small">Citrato</label></div>
                                    <div class="col-sm-12"><input type="text" class="form-control" name="gn_citrato_utilizacao" placeholder="Utilização do Citrato" value="<?php echo htmlspecialchars($dadosExame['gn_citrato_utilizacao'] ?? ''); ?>"></div>
                                </div>
                            </fieldset>
                        </div>
                    </div>

                    <fieldset class="border p-3 mb-3">
                        <legend class="w-auto px-2 h5">Finalização do Exame</legend>
                        <div class="mb-3">
                            <label for="resultado_final" class="form-label">Resultado Final (Laudo)</label>
                            <textarea class="form-control" name="resultado_final" id="resultado_final" rows="4"><?php echo htmlspecialchars($dadosExame['resultado_final'] ?? ''); ?></textarea>
                        </div>
                    </fieldset>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="submit" name="salvar_progresso" class="btn btn-secondary">Salvar Progresso</button>
                        <button type="submit" name="finalizar_analise" class="btn btn-primary">Finalizar Análise e Salvar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>