
<?php
class Paciente {
    private $nome;
    private $nascimento;
    private $cpf;
    private $sexo;
    private $telefone;
    private $email;
    private $endereco;
    private $convenio;
    private $observacoes;

    public function __construct($nome, $nascimento, $cpf, $sexo, $telefone, $email, $endereco, $convenio, $observacoes) {
        $this->nome = $nome;
        $this->nascimento = $nascimento;
        $this->cpf = $cpf;
        $this->sexo = $sexo;
        $this->telefone = $telefone;
        $this->email = $email;
        $this->endereco = $endereco;
        $this->convenio = $convenio;
        $this->observacoes = $observacoes;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getCpf() {
        return $this->cpf;
    }

    public function toArray() {
        return [
            'nome' => $this->nome,
            'nascimento' => $this->nascimento,
            'cpf' => $this->cpf,
            'sexo' => $this->sexo,
            'telefone' => $this->telefone,
            'email' => $this->email,
            'endereco' => $this->endereco,
            'convenio' => $this->convenio,
            'observacoes' => $this->observacoes
        ];
    }
}
?>