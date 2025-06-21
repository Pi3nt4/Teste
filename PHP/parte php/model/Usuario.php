<?php
class Usuario {
    private $id;
    private $nome;
    private $email;
    private $senha;
    private $tipo; // 'admin' ou 'aluno'
    
    private $cpf;
    private $data_nascimento;

    // --- Getters e Setters ---

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function setSenha($senha) {
        // A criptografia da senha é feita no DAO antes de inserir/atualizar
        $this->senha = $senha; // CORRIGIDO: $this->senha
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo; // CORRIGIDO: $this->tipo
    }

    // --- Novos Getters e Setters ---
    public function getCpf() {
        return $this->cpf;
    }

    public function setCpf($cpf) {
        $this->cpf = $cpf; // CORRIGIDO: $this->cpf
    }

    public function getDataNascimento() {
        return $this->data_nascimento;
    }

    public function setDataNascimento($data_nascimento) {
        // Idealmente, aqui você poderia validar ou formatar a data
        $this->data_nascimento = $data_nascimento; // CORRIGIDO: $this->data_nascimento
    }
}
?>