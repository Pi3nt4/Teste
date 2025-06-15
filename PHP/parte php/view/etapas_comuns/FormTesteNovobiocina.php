<form action="" method="post" class="w-100">
    <div class="mb-3">
        <label for="resultado_novobiocina" class="form-label">Resultado</label>
        <select class="form-select" name="resultado_novobiocina" id="resultado_novobiocina" required>
            <option value="" selected disabled>-- Selecione o resultado --</option>
            <option value="Sensível">Sensível (S)</option>
            <option value="Resistente">Resistente (R)</option>
        </select>
    </div>
    <hr>
    <div class="mb-3">
        <label for="lote_antibiotico" class="form-label">Lote do Antibiótico (Novobiocina)</label>
        <input type="text" class="form-control" name="lote_antibiotico" id="lote_antibiotico">
    </div>
    <div class="mb-3">
        <label for="validade_antibiotico" class="form-label">Validade do Antibiótico</label>
        <input type="date" class="form-control" name="validade_antibiotico" id="validade_antibiotico">
    </div>
    <hr>
    <div class="mb-3">
        <label for="lote_agar" class="form-label">Lote do Ágar Muller Hinton</label>
        <input type="text" class="form-control" name="lote_agar" id="lote_agar">
    </div>
    
    <button type="submit" name="salvar_etapa" class="btn btn-success">Finalizar Análise</button>
</form>