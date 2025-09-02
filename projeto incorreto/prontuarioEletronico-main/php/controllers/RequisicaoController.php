<?php
require_once(__DIR__ . '/../config/db.php');

class RequisicaoController {
    public static function salvar($paciente_id, $exames) {
        global $conn;

        // Validação básica
        if (empty($paciente_id) || empty($exames)) {
            throw new Exception('Paciente e exames são obrigatórios.');
        }

        // Verificar se o paciente existe
        $stmt = $conn->prepare("SELECT id FROM paciente WHERE id = ?");
        $stmt->bind_param("i", $paciente_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            throw new Exception('Paciente não encontrado.');
        }
        $stmt->close();

        // Gerar o próximo número da requisição
        $result = $conn->query("SELECT MAX(numero) AS max_numero FROM requisicoes");
        $row = $result->fetch_assoc();
        $novo_numero = isset($row['max_numero']) ? $row['max_numero'] + 1 : 1;

        // Inserir a requisição no banco de dados
        $stmt = $conn->prepare("INSERT INTO requisicoes (numero, paciente_id, data) VALUES (?, ?, NOW())");
        $stmt->bind_param("ii", $novo_numero, $paciente_id);
        if (!$stmt->execute()) {
            throw new Exception('Erro ao salvar a requisição: ' . $stmt->error);
        }
        $requisicao_id = $stmt->insert_id; // ID da requisição gerado automaticamente
        $stmt->close();

        // Inserir os exames relacionados à requisição
        $stmt = $conn->prepare("INSERT INTO requisicao_exames (requisicao_id, exame_id) VALUES (?, ?)");
        foreach ($exames as $exame_id) {
            $stmt->bind_param("ii", $requisicao_id, $exame_id);
            if (!$stmt->execute()) {
                throw new Exception('Erro ao salvar os exames relacionados: ' . $stmt->error);
            }
        }
        $stmt->close();

        return $requisicao_id; // Retorna o ID da requisição criada
    }

    public static function atualizar($requisicao_id, $paciente_id, $exames) {
        global $conn;

        // Validação básica
        if (empty($requisicao_id) || empty($paciente_id)) {
            throw new Exception('ID da requisição e ID do paciente são obrigatórios para atualização.');
        }

        // Verificar se o paciente existe
        $stmt = $conn->prepare("SELECT id FROM paciente WHERE id = ?");
        $stmt->bind_param("i", $paciente_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            throw new Exception('Paciente não encontrado.');
        }
        $stmt->close();

        // Atualizar o paciente da requisição
        $stmt = $conn->prepare("UPDATE requisicoes SET paciente_id = ? WHERE id = ?");
        $stmt->bind_param("ii", $paciente_id, $requisicao_id);
        if (!$stmt->execute()) {
            throw new Exception('Erro ao atualizar a requisição: ' . $stmt->error);
        }
        $stmt->close();

        // Remover exames antigos relacionados à requisição
        $stmt = $conn->prepare("DELETE FROM requisicao_exames WHERE requisicao_id = ?");
        $stmt->bind_param("i", $requisicao_id);
        if (!$stmt->execute()) {
            throw new Exception('Erro ao remover exames antigos: ' . $stmt->error);
        }
        $stmt->close();

        // Adicionar os novos exames relacionados à requisição
        $stmt = $conn->prepare("INSERT INTO requisicao_exames (requisicao_id, exame_id) VALUES (?, ?)");
        foreach ($exames as $exame_id) {
            $stmt->bind_param("ii", $requisicao_id, $exame_id);
            if (!$stmt->execute()) {
                throw new Exception('Erro ao adicionar exames: ' . $stmt->error);
            }
        }
        $stmt->close();
    }

    public static function buscarPorId($requisicao_id) {
        global $conn;

        // Buscar os dados do paciente
        $stmt = $conn->prepare("SELECT p.id AS paciente_id, p.nome AS paciente_nome FROM requisicoes r JOIN paciente p ON r.paciente_id = p.id WHERE r.id = ?");
        $stmt->bind_param("i", $requisicao_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $paciente = $result->fetch_assoc();
        $stmt->close();

        // Verificar se a requisição existe
        if (!$paciente) {
            throw new Exception('Requisição não encontrada.');
        }

        // Buscar os exames relacionados à requisição
        $stmt = $conn->prepare("SELECT e.id, e.nome AS exame_nome FROM requisicao_exames re JOIN exame e ON re.exame_id = e.id WHERE re.requisicao_id = ?");
        $stmt->bind_param("i", $requisicao_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $exames = [];
        while ($row = $result->fetch_assoc()) {
            $exames[] = $row; // Inclui o ID e o nome do exame
        }
        $stmt->close();

        return [
            'paciente' => $paciente,
            'exames' => $exames
        ];
    }

    public static function listar() {
        global $conn;

        $result = $conn->query("SELECT r.id, r.numero, r.data, p.nome AS paciente_nome 
                                FROM requisicoes r 
                                JOIN paciente p ON r.paciente_id = p.id");
        if (!$result) {
            throw new Exception('Erro ao listar as requisições: ' . $conn->error);
        }

        return $result;
    }

    public static function excluir($requisicao_id) {
        global $conn;

        // Validação básica
        if (empty($requisicao_id)) {
            throw new Exception('ID da requisição é obrigatório para exclusão.');
        }

        // Excluir os exames relacionados à requisição
        $stmt = $conn->prepare("DELETE FROM requisicao_exames WHERE requisicao_id = ?");
        $stmt->bind_param("i", $requisicao_id);
        if (!$stmt->execute()) {
            throw new Exception('Erro ao excluir os exames relacionados: ' . $stmt->error);
        }
        $stmt->close();

        // Excluir a requisição
        $stmt = $conn->prepare("DELETE FROM requisicoes WHERE id = ?");
        $stmt->bind_param("i", $requisicao_id);
        if (!$stmt->execute()) {
            throw new Exception('Erro ao excluir a requisição: ' . $stmt->error);
        }
        $stmt->close();
    }
}