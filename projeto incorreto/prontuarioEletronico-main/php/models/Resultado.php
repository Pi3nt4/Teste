<?php
class Resultado {
    private $paciente_id;
    private $exame_id;
    private $data;
    private $resultado;

    public function __construct($paciente_id, $exame_id, $data, $resultado) {
        $this->paciente_id = $paciente_id;
        $this->exame_id = $exame_id;
        $this->data = $data;
        $this->resultado = $resultado;
    }

    public function toArray() {
        return [
            'paciente_id' => $this->paciente_id,
            'exame_id' => $this->exame_id,
            'data' => $this->data,
            'resultado' => $this->resultado
        ];
    }
}
?>