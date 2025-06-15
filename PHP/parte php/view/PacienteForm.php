<form action="" method="post">
    <div class="mb-3">
        <label for="nome_paciente" class="form-label">Nome Completo</label>
        <input type="text" class="form-control" name="nome" id="nome_paciente" required>
    </div>
    <div class="mb-3">
        <label for="cpf_paciente" class="form-label">CPF</label>
        <input type="text" class="form-control" name="cpf" id="cpf_paciente" required>
    </div>
    <div class="mb-3">
        <label for="data_nascimento_paciente" class="form-label">Data de Nascimento</label>
        <input type="date" class="form-control" name="data_nascimento" id="data_nascimento_paciente" required>
    </div>
    <div class="mb-3">
        <label for="email_paciente" class="form-label">E-mail</label>
        <input type="email" class="form-control" name="email" id="email_paciente">
    </div>
    
    <button type="submit" name="salvar_paciente" class="btn btn-primary">Salvar</button>
</form>