<form action="" method="post" class="w-100">
    <div class="mb-3">
        <label for="resultado_coagulase" class="form-label">Resultado</label>
        <select class="form-select" name="resultado_coagulase" id="resultado_coagulase" required>
            <option value="" selected disabled>-- Selecione o resultado --</option>
            <option value="Positivo">Positivo</option>
            <option value="Negativo">Negativo</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="lote_coagulase" class="form-label">Lote do Reagente</label>
        <input type="text" class="form-control" name="lote_coagulase" id="lote_coagulase">
    </div>
    <div class="mb-3">
        <label for="validade_coagulase" class="form-label">Validade do Reagente</label>
        <input type="date" class="form-control" name="validade_coagulase" id="validade_coagulase">
    </div>
    <hr>
    <div class="mb-3">
        <label for="lote_tubo" class="form-label">Lote do Tubo Estéril</label>
        <input type="text" class="form-control" name="lote_tubo" id="lote_tubo">
    </div>
    <div class="mb-3">
        <label for="validade_tubo" class="form-label">Validade do Tubo Estéril</label>
        <input type="date" class="form-control" name="validade_tubo" id="validade_tubo">
    </div>
    
    <button type="submit" name="salvar_etapa" class="btn btn-primary">Salvar Etapa</button>
</form>