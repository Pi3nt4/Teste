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
    /**
     * Cria um novo paciente fazendo uma chamada POST para a API.
     * @param array $dadosPaciente Os dados do formulário (ex: $_POST).
     * @return bool True se foi criado com sucesso, false caso contrário.
     */
    public function criar($dadosPaciente) {
        $endpoint = $this->apiUrl . '/pacientes';

        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dadosPaciente));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen(json_encode($dadosPaciente))
        ]);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // A API retorna 201 (Created) em caso de sucesso
        return $http_code == 201;
    }
}
?>