<?php
// Verifica se a variável $usuario_para_editar foi definida e não é null
// (essa variável é definida no usuarios.php quando ?acao=editar)
$em_modo_edicao = isset($usuario_para_editar) && $usuario_para_editar !== null;

// Define os valores que serão usados nos campos do formulário
// Se estiver editando, usa os dados do $usuario_para_editar, senão, deixa vazio ou com valor padrão
$id_valor = $em_modo_edicao ? $usuario_para_editar->getId() : '';
$nome_valor = $em_modo_edicao ? $usuario_para_editar->getNome() : '';
$cpf_valor = $em_modo_edicao ? $usuario_para_editar->getCpf() : ''; // Assumindo que Usuario herda getCpf de Pessoa
$data_nascimento_valor = '';
if ($em_modo_edicao && $usuario_para_editar->getDataNascimento()) {
    // Para input type="date", o formato deve ser YYYY-MM-DD
    // Se getDataNascimento() retornar um objeto DateTime, use ->format('Y-m-d')
    // Se for uma string, certifique-se que já está nesse formato ou converta.
    // Por simplicidade, vamos assumir que é uma string YYYY-MM-DD ou um objeto DateTime.
    $dataObj = $usuario_para_editar->getDataNascimento();
    if ($dataObj instanceof DateTime) {
        $data_nascimento_valor = $dataObj->format('Y-m-d');
    } else {
        $data_nascimento_valor = $dataObj; // Assume que já é uma string YYYY-MM-DD
    }
}
$email_valor = $em_modo_edicao ? $usuario_para_editar->getEmail() : '';
// A senha NUNCA é pré-preenchida em formulários de edição por segurança
$tipo_valor = $em_modo_edicao ? $usuario_para_editar->getTipo() : 'aluno'; // Padrão 'aluno' para novos cadastros
?>

<form action="controller/UsuarioController.php" method="post">
    <?php if ($em_modo_edicao): ?>
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id_valor); ?>">
    <?php endif; ?>

    <div class="mb-3">
        <label for="nome" class="form-label">Nome Completo</label>
        <input type="text" class="form-control" name="nome" id="nome" value="<?php echo htmlspecialchars($nome_valor); ?>" required>
    </div>
    <div class="mb-3">
        <label for="cpf" class="form-label">CPF</label>
        <input type="text" class="form-control" name="cpf" id="cpf" value="<?php echo htmlspecialchars($cpf_valor); ?>" required>
    </div>
    <div class="mb-3">
        <label for="data_nascimento_usuario" class="form-label">Data de Nascimento</label>
        <input type="date" class="form-control" name="data_nascimento" id="data_nascimento_usuario" value="<?php echo htmlspecialchars($data_nascimento_valor); ?>" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">E-mail</label>
        <input type="email" class="form-control" name="email" id="email" value="<?php echo htmlspecialchars($email_valor); ?>" required>
    </div>
    <div class="mb-3">
        <label for="senha" class="form-label">Senha <?php if ($em_modo_edicao) echo "<small class='text-muted'>(Deixe em branco para não alterar)</small>"; ?></label>
        <input type="password" class="form-control" name="senha" id="senha" <?php if (!$em_modo_edicao) echo "required"; ?>>
    </div>
    <div class="mb-3">
        <label for="tipo" class="form-label">Tipo de Usuário</label>
        <select class="form-select" name="tipo" id="tipo">
            <option value="aluno" <?php if ($tipo_valor == 'aluno') echo "selected"; ?>>Aluno</option>
            <option value="admin" <?php if ($tipo_valor == 'admin') echo "selected"; ?>>Administrador</option>
        </select>
    </div>
    
    <?php if ($em_modo_edicao): ?>
        <button type="submit" name="atualizar" class="btn btn-success">Atualizar</button>
    <?php else: ?>
        <button type="submit" name="cadastrar" class="btn btn-primary">Salvar</button>
    <?php endif; ?>
</form>