<form action="" method="post" class="w-100">
    <div class="mb-3">
        <label for="resultado_ziehl" class="form-label">Resultado</label>
        <select class="form-select" name="resultado_ziehl" id="resultado_ziehl" required>
            <option value="" selected disabled>-- Selecione o resultado --</option>
            <option value="BAAR Positivo">BAAR Positivo (+)</option>
            <option value="BAAR Negativo">BAAR Negativo (-)</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="lote_ziehl" class="form-label">Lote do Reagente</label>
        <input type="text" class="form-control" name="lote_ziehl" id="lote_ziehl">
    </div>
    <div class="mb-3">
        <label for="validade_ziehl" class="form-label">Validade do Reagente</label>
        <input type="date" class="form-control" name="validade_ziehl" id="validade_ziehl">
    </div>
    
    <button type="submit" name="salvar_etapa" class="btn btn-primary">Salvar Etapa</button>
</form>