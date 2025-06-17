<form action="" method="post" class="w-100">
    <div class="mb-3">
        <label for="resultado_catalase" class="form-label">Resultado</label>
        <select class="form-select" name="resultado_catalase" id="resultado_catalase" required>
            <option value="" selected disabled>-- Selecione o resultado --</option>
            <option value="Positivo">Positivo</option>
            <option value="Negativo">Negativo</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="lote_catalase" class="form-label">Lote do Reagente</label>
        <input type="text" class="form-control" name="lote_catalase" id="lote_catalase">
    </div>
    <div class="mb-3">
        <label for="validade_catalase" class="form-label">Validade do Reagente</label>
        <input type="date" class="form-control" name="validade_catalase" id="validade_catalase">
    </div>
    
    <button type="submit" name="salvar_etapa" class="btn btn-primary">Salvar Etapa</button>
</form>