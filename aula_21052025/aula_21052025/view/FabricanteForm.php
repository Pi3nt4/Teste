<?php
if(isset($_GET['editar'])){
    echo "Chamou via editar";
}


?>


<form action="controller/FabricanteController.php" method="post">
    <div class="mb-3">
        <label for="nome" class="form-label">Nome</label>
        <input type="text" class="form-control" name="nome">
    </div>
    <div class="mb-3">
        <label for="endereco" class="form-label">Endereço</label>
        <input type="text" class="form-control" name="endereco">
    </div>
    <div class="mb-3">
        <label for="documento" class="form-label">Documento</label>
        <input type="text" class="form-control" name="documento">
    </div>
    <input type="submit" name="cadastrar" value="Salvar" class="btn btn-primary">
</form>