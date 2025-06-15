<form action="" method="post" class="w-100">
    <div class="mb-3">
        <label for="resultado_gram" class="form-label">Resultado</label>
        <select class="form-select" name="resultado_gram" id="resultado_gram" required>
            <option value="" selected disabled>-- Selecione o resultado --</option>
            <option value="Gram Positivo">Gram Positivo</option>
            <option value="Gram Negativo">Gram Negativo</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="lote_gram" class="form-label">Lote do Reagente Gram</label>
        <input type="text" class="form-control" name="lote_gram" id="lote_gram">
    </div>
    <div class="mb-3">
        <label for="validade_gram" class="form-label">Validade do Reagente Gram</label>
        <input type="date" class="form-control" name="validade_gram" id="validade_gram">
    </div>
    
    <button type="submit" name="salvar_etapa" class="btn btn-primary">Salvar Etapa</button>
</form>