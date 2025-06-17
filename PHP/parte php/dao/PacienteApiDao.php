<?php
class PacienteApiDao {
    // URL base da nossa API Node.js
    private $apiUrl = 'http://localhost:3000/api';

    /**
     * Busca todos os pacientes da API.
     * @return array Retorna uma lista de pacientes ou um array vazio em caso de erro.
     */
    public function read() {
        try {
            // Monta a URL completa do endpoint que queremos acessar
            $endpoint = $this->apiUrl . '/pacientes';

            // @file_get_contents faz uma requisição GET para a URL e pega a resposta
            // O @ na frente suprime warnings caso a API esteja offline.
            $jsonResponse = @file_get_contents($endpoint);

            // Se a resposta for false, significa que a API não respondeu.
            if ($jsonResponse === false) {
                // Você pode logar o erro ou simplesmente retornar uma lista vazia
                error_log("Não foi possível conectar à API em " . $endpoint);
                return [];
            }
            
            // json_decode transforma a resposta JSON (string) em um array associativo do PHP
            // O 'true' como segundo parâmetro força a criação de um array associativo
            $pacientesArray = json_decode($jsonResponse, true);

            // Se o decode falhar ou a resposta não for um array, retorna um array vazio para evitar erros
            return is_array($pacientesArray) ? $pacientesArray : [];

        } catch (Exception $e) {
            // Em caso de erro na comunicação com a API, loga o erro e retorna um array vazio.
            error_log('Erro ao buscar pacientes da API: ' . $e->getMessage());
            return [];
        }
    }
    
    // Futuramente, adicionaremos aqui os métodos para criar, atualizar e deletar,
    // que usarão POST, PUT e DELETE.
}
?>