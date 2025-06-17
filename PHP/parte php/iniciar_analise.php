<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
echo "DEBUG: Iniciando o script iniciar_analise.php...<br>";
// Inclui os DAOs da API que vamos precisar
require_once 'dao/PacienteApiDao.php';
require_once 'dao/ProtocoloApiDao.php';
require_once 'dao/AnaliseApiDao.php'; // Para a lógica de criar a análise

// --- LÓGICA PARA INICIAR UMA NOVA ANÁLISE (PROCESSAR O FORMULÁRIO) ---
// Verifica se o formulário foi enviado clicando em um dos botões de protocolo
if (isset($_POST['protocolo_id'])) {
    $paciente_id = $_POST['paciente_id'] ?? null;
    $protocolo_id = $_POST['protocolo_id'];

    if ($paciente_id && $protocolo_id) {
        $analiseApiDao = new AnaliseApiDao();
        $resultado = $analiseApiDao->iniciarAnalise($paciente_id, $protocolo_id);

        if ($resultado && isset($resultado['analise']['id'])) {
            // Se a análise foi criada, redireciona para a página de execução
            header("Location: executar_analise.php?analise_id=" . $resultado['analise']['id']);
            exit();
        } else {
            // Se deu erro na API, redireciona de volta com uma mensagem
            header("Location: iniciar_analise.php?msg=erro_api");
            exit();
        }
    } else {
        // Se o paciente não foi selecionado
        header("Location: iniciar_analise.php?msg=paciente_nao_selecionado");
        exit();
    }
}


// --- LÓGICA PARA BUSCAR OS DADOS E EXIBIR NA PÁGINA ---
$pacienteApiDao = new PacienteApiDao();
$listaDePacientes = $pacienteApiDao->read(); // Busca pacientes para o dropdown

$protocoloApiDao = new ProtocoloApiDao();
$listaDeProtocolos = $protocoloApiDao->read(); // Busca protocolos para os cartões
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Nova Análise</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <?php include 'view/menu.php'; ?>

    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h2>Iniciar Nova Análise</h2>
            </div>
            <div class="card-body">
                <form action="iniciar_analise.php" method="post">
                    <div class="mb-4">
                        <label for="paciente_id" class="form-label fs-5">1. Selecione o Paciente</label>
                        <select class="form-select" name="paciente_id" id="paciente_id" required>
                            <option value="" selected disabled>-- Escolha um paciente da lista --</option>
                            <?php if(!empty($listaDePacientes)): foreach ($listaDePacientes as $paciente): ?>
                                <option value="<?php echo htmlspecialchars($paciente['id']); ?>">
                                    <?php echo htmlspecialchars($paciente['nome']); ?> (CPF: <?php echo htmlspecialchars($paciente['cpf']); ?>)
                                </option>
                            <?php endforeach; else: ?>
                                <option disabled>Nenhum paciente encontrado. Cadastre um primeiro.</option>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fs-5">2. Selecione o Protocolo de Análise</label>
                        <div class="row g-3">
                            <?php if (!empty($listaDeProtocolos)): ?>
                                <?php foreach ($listaDeProtocolos as $protocolo): ?>
                                    <div class="col-md-6">
                                        <div class="card h-100">
                                            <div class="card-body text-center d-flex flex-column">
                                                <h5 class="card-title"><?php echo htmlspecialchars($protocolo['nome_protocolo']); ?></h5>
                                                <p class="card-text small flex-grow-1"><?php echo htmlspecialchars($protocolo['descricao']); ?></p>
                                                <button type="submit" name="protocolo_id" value="<?php echo htmlspecialchars($protocolo['id']); ?>" class="btn btn-primary mt-auto">
                                                    Iniciar este Protocolo
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="col-12"><div class="alert alert-warning">Nenhum protocolo encontrado.</div></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>