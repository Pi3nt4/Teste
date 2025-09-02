<?php
// É necessário incluir o novo Model para que o DAO possa criar os objetos
require_once __DIR__ . '/../model/Paciente.php';

class PacienteApiDao {
    private $apiUrl = 'http://localhost:3000/api';

    /**
     * MÉTODO NOVO: Converte uma linha de dados (array) em um objeto Paciente.
     * @param array $row Dados de um paciente.
     * @return Paciente Um objeto Paciente preenchido.
     */
    private function converterParaObjeto($row) {
        return new Paciente(
            $row['nome'] ?? '',
            $row['cpf'] ?? '',
            $row['data_nascimento'] ?? '',
            $row['email'] ?? '',
            $row['id'] ?? null
        );
    }

    /**
     * Busca todos os pacientes da API.
     * @return Paciente[] Retorna uma lista de objetos Paciente. // ALTERADO
     */
    public function read() {
        try {
            $endpoint = $this->apiUrl . '/pacientes';
            $jsonResponse = @file_get_contents($endpoint);

            if ($jsonResponse === false) {
                error_log("Não foi possível conectar à API em " . $endpoint);
                return [];
            }
            
            $pacientesArray = json_decode($jsonResponse, true);

            // --- ALTERAÇÃO PRINCIPAL AQUI ---
            $listaPacientesObj = [];
            if (is_array($pacientesArray)) {
                foreach ($pacientesArray as $pacienteData) {
                    $listaPacientesObj[] = $this->converterParaObjeto($pacienteData);
                }
            }
            return $listaPacientesObj;

        } catch (Exception $e) {
            error_log('Erro ao buscar pacientes da API: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Busca um único paciente pelo seu ID na API.
     * @param int $id O ID do paciente.
     * @return Paciente|null Retorna o objeto Paciente ou null se não for encontrado. // ALTERADO
     */
    public function buscarPorId($id) {
        $endpoint = $this->apiUrl . '/pacientes/' . $id;
        $response = @file_get_contents($endpoint);

        if ($response === false) {
            return null;
        }

        // --- ALTERAÇÃO PRINCIPAL AQUI ---
        $pacienteData = json_decode($response, true);
        return $pacienteData ? $this->converterParaObjeto($pacienteData) : null;
    }

    /**
     * Cria um novo paciente fazendo uma chamada POST para a API.
     * @param Paciente $paciente O objeto Paciente com os dados. // ALTERADO
     * @return bool True se foi criado com sucesso, false caso contrário.
     */
    public function criar(Paciente $paciente) {
        $endpoint = $this->apiUrl . '/pacientes';

        // --- ALTERAÇÃO PRINCIPAL AQUI ---
        // Montamos o array para a API a partir do objeto
        $dadosPaciente = [
            'nome' => $paciente->getNome(),
            'cpf' => $paciente->getCpf(),
            'dataNascimento' => $paciente->getDataNascimento(), // A API espera 'dataNascimento'
            'email' => $paciente->getEmail()
        ];

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

        return $http_code == 201;
    }

    /**
     * Atualiza um paciente existente.
     * @param Paciente $paciente O objeto Paciente com os dados atualizados. // ALTERADO
     * @return bool True se foi atualizado com sucesso, false caso contrário.
     */
    public function atualizar(Paciente $paciente) {
        $endpoint = $this->apiUrl . '/pacientes/' . $paciente->getId();

        // --- ALTERAÇÃO PRINCIPAL AQUI ---
        $dadosPaciente = [
            'nome' => $paciente->getNome(),
            'cpf' => $paciente->getCpf(),
            'data_nascimento' => $paciente->getDataNascimento(), // A API espera 'data_nascimento' no PUT
            'email' => $paciente->getEmail()
        ];

        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT'); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dadosPaciente));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen(json_encode($dadosPaciente))
        ]);
        curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $http_code == 200;
    }

    /**
     * Exclui um paciente.
     * @param int $id O ID do paciente a ser excluído.
     * @return bool True se foi excluído com sucesso, false caso contrário.
     */
    public function excluir($id) {
        $endpoint = $this->apiUrl . '/pacientes/' . $id;

        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');

        curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $http_code == 200;
    }
}
?>