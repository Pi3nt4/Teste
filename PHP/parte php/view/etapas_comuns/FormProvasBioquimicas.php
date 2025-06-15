<form action="" method="post" class="w-100">
    
    <h4>Prova EPM</h4>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="epm_gas" class="form-label">Produção de gás</label>
            <select class="form-select" name="epm_gas" id="epm_gas"><option value="Positivo">Positivo</option><option value="Negativo">Negativo</option></select>
        </div>
        <div class="col-md-6 mb-3">
            <label for="epm_h2s" class="form-label">Produção de H2S</label>
            <select class="form-select" name="epm_h2s" id="epm_h2s"><option value="Positivo">Positivo</option><option value="Negativo">Negativo</option></select>
        </div>
        <div class="col-md-6 mb-3">
            <label for="epm_ureia" class="form-label">Hidrólise da uréia</label>
            <select class="form-select" name="epm_ureia" id="epm_ureia"><option value="Positivo">Positivo</option><option value="Negativo">Negativo</option></select>
        </div>
        <div class="col-md-6 mb-3">
            <label for="epm_triptofano" class="form-label">Desaminação do Triptofano</label>
            <select class="form-select" name="epm_triptofano" id="epm_triptofano"><option value="Positivo">Positivo</option><option value="Negativo">Negativo</option></select>
        </div>
        <div class="col-md-6 mb-3">
            <label for="lote_epm" class="form-label">Lote do EPM</label>
            <input type="text" class="form-control" name="lote_epm" id="lote_epm">
        </div>
        <div class="col-md-6 mb-3">
            <label for="validade_epm" class="form-label">Validade do EPM</label>
            <input type="date" class="form-control" name="validade_epm" id="validade_epm">
        </div>
    </div>
    <hr>

    <h4>Prova MILI</h4>
     <div class="row">
        <div class="col-md-4 mb-3">
            <label for="mili_indol" class="form-label">Produção de INDOL</label>
            <select class="form-select" name="mili_indol" id="mili_indol"><option value="Positivo">Positivo</option><option value="Negativo">Negativo</option></select>
        </div>
        <div class="col-md-4 mb-3">
            <label for="mili_lisina" class="form-label">Desaminação da Lisina</label>
            <select class="form-select" name="mili_lisina" id="mili_lisina"><option value="Positivo">Positivo</option><option value="Negativo">Negativo</option></select>
        </div>
        <div class="col-md-4 mb-3">
            <label for="mili_motilidade" class="form-label">Motilidade</label>
            <select class="form-select" name="mili_motilidade" id="mili_motilidade"><option value="Positivo">Positivo</option><option value="Negativo">Negativo</option></select>
        </div>
        <div class="col-md-6 mb-3">
            <label for="lote_mili" class="form-label">Lote do MILI</label>
            <input type="text" class="form-control" name="lote_mili" id="lote_mili">
        </div>
        <div class="col-md-6 mb-3">
            <label for="validade_mili" class="form-label">Validade do MILI</label>
            <input type="date" class="form-control" name="validade_mili" id="validade_mili">
        </div>
    </div>
    <hr>

    <h4>Prova Citrato</h4>
    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="citrato_utilizacao" class="form-label">Utilização do citrato como única fonte de carbono</label>
            <select class="form-select" name="citrato_utilizacao" id="citrato_utilizacao"><option value="Positivo">Positivo</option><option value="Negativo">Negativo</option></select>
        </div>
        <div class="col-md-6 mb-3">
            <label for="lote_citrato" class="form-label">Lote do Citrato</label>
            <input type="text" class="form-control" name="lote_citrato" id="lote_citrato">
        </div>
        <div class="col-md-6 mb-3">
            <label for="validade_citrato" class="form-label">Validade do Citrato</label>
            <input type="date" class="form-control" name="validade_citrato" id="validade_citrato">
        </div>
    </div>
    <hr>

    <button type="submit" name="salvar_etapa" class="btn btn-success mt-3">Finalizar Análise</button>
</form>