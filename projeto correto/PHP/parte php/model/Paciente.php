<?php
// model/Paciente.php

class Paciente {
    private $id;
    private $nome;
    private $cpf;
    private $data_nascimento;
    private $email;

    // O construtor é um método especial chamado quando criamos um novo objeto
    public function __construct($nome = "", $cpf = "", $data_nascimento = "", $email = "", $id = null) {
        $this->nome = $nome;
        $this->cpf = $cpf;
        $this->data_nascimento = $data_nascimento;
        $this->email = $email;
        $this->id = $id;
    }

    // --- Getters (para obter os valores) ---
    public function getId() { return $this->id; }
    public function getNome() { return $this->nome; }
    public function getCpf() { return $this->cpf; }
    public function getDataNascimento() { return $this->data_nascimento; }
    public function getEmail() { return $this->email; }

    // --- Setters (para definir os valores) ---
    public function setId($id) { $this->id = $id; }
    public function setNome($nome) { $this->nome = $nome; }
    public function setCpf($cpf) { $this->cpf = $cpf; }
    public function setDataNascimento($data_nascimento) { $this->data_nascimento = $data_nascimento; }
    public function setEmail($email) { $this->email = $email; }
}
?>