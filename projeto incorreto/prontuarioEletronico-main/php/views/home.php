<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Prontuário Eletrônico - Início</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
    <?php include 'navbar.php'; ?>


<!-- Feedback visual de exemplo -->
<div class="container">
  <!-- Exemplo de mensagem de sucesso -->
  <!--
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    Cadastro realizado com sucesso!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
  </div>
  -->
</div>

<!-- Cards de navegação -->
<div class="container py-4">
  <div class="row g-4">
    <div class="col-md-4">
      <div class="card shadow-sm h-100">
        <div class="card-body text-center">
          <i class="bi bi-person-plus display-4 text-primary"></i>
          <h5 class="card-title mt-3">Pacientes</h5>
          <p class="card-text">Cadastre, edite e visualize pacientes.</p>
          <a href="cadastroPacientes.php" class="btn btn-primary">Acessar</a>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-sm h-100">
        <div class="card-body text-center">
          <i class="bi bi-clipboard2-pulse display-4 text-success"></i>
          <h5 class="card-title mt-3">Exames</h5>
          <p class="card-text">Solicite e consulte exames disponíveis.</p>
          <a href="cadastroExames.php" class="btn btn-success">Acessar</a>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-sm h-100">
        <div class="card-body text-center">
          <i class="bi bi-file-earmark-medical display-4 text-danger"></i>
          <h5 class="card-title mt-3">Resultados</h5>
          <p class="card-text">Lance e visualize resultados de exames.</p>
          <a href="lancamentoDeExame.php" class="btn btn-danger">Acessar</a>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-sm h-100">
        <div class="card-body text-center">
          <i class="bi bi-journal-arrow-up display-4 text-warning"></i>
          <h5 class="card-title mt-3">Requisições</h5>
          <p class="card-text">Acesse as opções de requisições de exames.</p>
          <div class="dropdown">
            <button class="btn btn-warning dropdown-toggle" type="button" id="dropdownRequisicoes" data-bs-toggle="dropdown" aria-expanded="false">
              Opções
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownRequisicoes">
              <li><a class="dropdown-item" href="gerenciarRequisicoes.php">Gerenciar Requisições</a></li>
              <li><a class="dropdown-item" href="novaRequisicao.php">Nova Requisição</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Botão flutuante para voltar ao topo -->
<button onclick="window.scrollTo({top: 0, behavior: 'smooth'});" class="btn btn-secondary position-fixed bottom-0 end-0 m-4 rounded-circle shadow" style="z-index: 999;">
  <i class="bi bi-arrow-up"></i>
</button>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>