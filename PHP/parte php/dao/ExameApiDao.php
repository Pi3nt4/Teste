<?php

class ExameApiDao {
    
    private $apiUrl = 'http://localhost:3000/api';

    /**
     * Inicia um novo exame fazendo uma chamada POST para a API.
     * @param int $paciente_id O ID do paciente.
     * @param string $tipo_exame 'urina' ou 'escarro'.
     * @return array|null Retorna a resposta da API (com o novo exame_id) ou null em caso de erro.
     */
  public function iniciarExame($paciente_id, $tipo_exame) {
    $endpoint = $this->apiUrl . '/exames';
    $dados = ['paciente_id' => $paciente_id, 'tipo_exame' => $tipo_exame];

    // Para POST e PUT, usamos cURL, que é mais robusto que file_get_contents.
    $ch = curl_init($endpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dados));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen(json_encode($dados))
    ]);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code == 201) { // 201 Created
        return json_decode($response, true);
    }
    
    // Se a chamada falhar, regista o erro no log do servidor (se configurado) e retorna nulo
    error_log("Erro ao iniciar exame. Código HTTP: $http_code. Resposta: $response");
    return null;
}

    /**
     * Busca os dados completos de um exame específico.
     * @param int $id O ID do exame.
     * @return array|null Os dados do exame ou null se não for encontrado.
     */
    public function buscarPorId($id) {
        $endpoint = $this->apiUrl . '/exames/' . $id;
        $response = @file_get_contents($endpoint);

        if ($response === false) {
            return null;
        }

        return json_decode($response, true);
    }
    
    /**
     * Atualiza um exame com os dados do formulário.
     * @param int $id O ID do exame a ser atualizado.
     * @param array $dados Os dados do formulário a serem salvos.
     * @return bool True se a atualização foi bem-sucedida, false caso contrário.
     */
    public function atualizar($id, $dados) {
        $endpoint = $this->apiUrl . '/exames/' . $id;

        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT'); // Usamos o método PUT
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dados));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen(json_encode($dados))
        ]);

        curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $http_code == 200; // 200 OK
    }

    /**
     * Lista todos os exames de um paciente específico.
     * @param int $paciente_id O ID do paciente.
     * @return array A lista de exames.
     */
    public function listarPorPaciente($paciente_id) {
        $endpoint = $this->apiUrl . '/pacientes/' . $paciente_id . '/exames';
        $response = @file_get_contents($endpoint);

        if ($response === false) {
            return [];
        }

        return json_decode($response, true);
    }
}