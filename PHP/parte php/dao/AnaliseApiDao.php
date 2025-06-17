<?php
class AnaliseApiDao {
    private $apiUrl = 'http://localhost:3000/api';

    /**
     * Inicia uma nova análise enviando dados para a API via POST.
     * (Este método já deve existir no seu arquivo).
     */
    public function iniciarAnalise($paciente_id, $protocolo_id) {
        $endpoint = $this->apiUrl . '/analises';
        $dados = ['paciente_id' => $paciente_id, 'protocolo_id' => $protocolo_id];
        $jsonPayload = json_encode($dados);

        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonPayload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode == 201) {
            return json_decode($response, true);
        }
        return null;
    }

    /**
     * Busca uma única análise na API pelo seu ID.
     * (Este é o método que estava faltando).
     */
    public function buscarPorId($id) {
        // Monta a URL completa do endpoint, ex: http://localhost:3000/api/analises/5
        $endpoint = $this->apiUrl . '/analises/' . $id;

        try {
            // file_get_contents faz a requisição GET para a API
            $jsonResponse = @file_get_contents($endpoint);

            if ($jsonResponse === false) {
                error_log("API não encontrada ou sem resposta em " . $endpoint);
                return null;
            }
            
            // Retorna a análise decodificada como um array associativo
            return json_decode($jsonResponse, true);

        } catch (Exception $e) {
            error_log("Erro ao buscar análise por ID na API: " . $e->getMessage());
            return null;
        }
    }
}
?>