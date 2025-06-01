<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <title>Cadastro de Fabricante</title>
</head>
<body>
    <div class="container">
        <div class="row"> <!-- Linha de cabeçalho da página -->
            <div class="col">
                <h1 class="display-3">Cadastro de Fabricante</h1>
            </div>
        </div>
        <!-- Linha do formulário -->
        <div class="row">
            <?php include 'view/FabricanteForm.php'; ?>
        </div>
        <div class="row">
            <div class="col mx-4 mt-4">
                <form action="controller/FabricanteController.php" method="get">
                    <input type="submit"  name="listar"  value="Ver Fabricantes cadastrados"
                    class="btn btn-primary">
                </form>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Id</th> <th>Nome</th> <th>Endereço</th> <th>Documento</th> <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- chamar select * from-->
                         <?php
                         if($_SERVER["REQUEST_METHOD"] == "GET"){
                            require_once 'controller/FabricanteController.php';
                            listar();
                         }
                         ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</body>
</html>