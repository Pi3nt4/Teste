<?php
require_once(__DIR__ . '/../config/db.php');

class ResultadoController {
    public static function cadastrar() {
        global $conn;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cadastrar_resultados'])) {
            $requisicao_id = intval($_POST['requisicao_id']);
            $exames = $_POST['exames'];

            // Validação básica
            if (empty($requisicao_id) || empty($exames)) {
                throw new Exception('Requisição e exames são obrigatórios.');
            }

            foreach ($exames as $exame_id => $dados_exame) {
                $resultado = $dados_exame['resultado'];

                // Validação do resultado
                if (empty($resultado)) {
                    throw new Exception("O resultado do exame ID $exame_id não pode estar vazio.");
                }

                // Verificar se o resultado já existe
                $stmt = $conn->prepare("SELECT id FROM resultados WHERE requisicao_id = ? AND exame_id = ?");
                $stmt->bind_param("ii", $requisicao_id, $exame_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    // Atualizar resultado existente
                    $stmt = $conn->prepare("UPDATE resultados SET resultado = ?, data = NOW() WHERE requisicao_id = ? AND exame_id = ?");
                    $stmt->bind_param("sii", $resultado, $requisicao_id, $exame_id);
                } else {
                    // Inserir novo resultado
                    $stmt = $conn->prepare("INSERT INTO resultados (requisicao_id, exame_id, resultado, data) VALUES (?, ?, ?, NOW())");
                    $stmt->bind_param("iis", $requisicao_id, $exame_id, $resultado);
                }

                if (!$stmt->execute()) {
                    throw new Exception('Erro ao salvar o resultado: ' . $stmt->error);
                }
            }

            $stmt->close();
        }
    }

    public static function editar() {
        global $conn;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar_resultado'])) {
            $resultado_id = intval($_POST['resultado_id']);
            $resultado = $_POST['resultado'];

            // Validação básica
            if (empty($resultado_id) || empty($resultado)) {
                throw new Exception('ID do resultado e o resultado são obrigatórios.');
            }

            $stmt = $conn->prepare("UPDATE resultados SET resultado = ?, data = NOW() WHERE id = ?");
            $stmt->bind_param("si", $resultado, $resultado_id);
            if (!$stmt->execute()) {
                throw new Exception('Erro ao editar o resultado: ' . $stmt->error);
            }

            $stmt->close();
        }
    }

    public static function excluir() {
        global $conn;

        if (isset($_GET['excluir_resultado'])) {
            $resultado_id = intval($_GET['excluir_resultado']);

            // Validação básica
            if (empty($resultado_id)) {
                throw new Exception('ID do resultado é obrigatório para exclusão.');
            }

            $stmt = $conn->prepare("DELETE FROM resultados WHERE id = ?");
            $stmt->bind_param("i", $resultado_id);
            if (!$stmt->execute()) {
                throw new Exception('Erro ao excluir o resultado: ' . $stmt->error);
            }

            $stmt->close();
        }
    }

    public static function listarPorRequisicao($requisicao_id) {
        global $conn;

        // Validação básica
        if (empty($requisicao_id)) {
            throw new Exception('ID da requisição é obrigatório para listar os resultados.');
        }

        $stmt = $conn->prepare("SELECT r.exame_id, r.resultado, e.nome AS exame_nome, r.data 
                                FROM resultados r 
                                JOIN exame e ON r.exame_id = e.id 
                                WHERE r.requisicao_id = ?");
        $stmt->bind_param("i", $requisicao_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result) {
            throw new Exception('Erro ao listar os resultados: ' . $stmt->error);
        }

        $resultados = [];
        while ($row = $result->fetch_assoc()) {
            $resultados[] = $row; // Retorna os resultados como array associativo
        }

        return $resultados;
    }
}