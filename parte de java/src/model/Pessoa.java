package model;

import java.time.LocalDate;
import java.time.format.DateTimeFormatter;

public abstract class Pessoa {

    protected String nome;
    protected String cpf;
    protected LocalDate dataNascimento;
    protected String email;

    public Pessoa(String nome, String cpf, LocalDate dataNascimento, String email) {
        this.nome = nome;
        this.cpf = cpf;
        this.dataNascimento = dataNascimento;
        this.email = email;
    }

    // --- Getters e Setters (sem alterações) ---
    public String getNome() { return nome; }
    public void setNome(String nome) { this.nome = nome; }
    public String getCpf() { return cpf; }
    public void setCpf(String cpf) { this.cpf = cpf; }
    public LocalDate getDataNascimento() { return dataNascimento; }
    public void setDataNascimento(LocalDate dataNascimento) { this.dataNascimento = dataNascimento; }
    public String getEmail() { return email; }
    public void setEmail(String email) { this.email = email; }

    /**
     * Método abstrato para gerar o comando SQL.
     * Classes filhas (Usuario, Paciente) SÃO OBRIGADAS a implementar este método.
     * @return Uma string com o comando INSERT.
     */
    public abstract String toStringSql();

    @Override
    public String toString() {
        DateTimeFormatter formatter = DateTimeFormatter.ofPattern("dd/MM/yyyy");
        return  "Nome: '" + nome + '\'' +
                ", CPF: '" + cpf + '\'' +
                ", Email: '" + email + '\'' +
                ", Data de Nascimento: " + (dataNascimento != null ? dataNascimento.format(formatter) : "N/A");
    }
}