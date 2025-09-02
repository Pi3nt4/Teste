package model;


import java.time.LocalDate;
import java.time.format.DateTimeFormatter;

public class Paciente extends Pessoa {

    public Paciente(String nome, String cpf, LocalDate dataNascimento, String email) {
        super(nome, cpf, dataNascimento, email);
    }

    /**
     * Implementação obrigatória do método da classe Pessoa.
     * Formata os dados do paciente para um comando SQL.
     */
    // ...
@Override
public String toStringSql() {
    DateTimeFormatter sqlFormatter = DateTimeFormatter.ofPattern("yyyy-MM-dd");
    String dataNascimentoFormatada = this.dataNascimento.format(sqlFormatter);

    // ANTES: "INSERT INTO paciente..."
    // CORRIGIDO: "INSERT INTO pacientes..."
    return "INSERT INTO pacientes (nome, cpf, data_nascimento, email) VALUES ('" + //
            this.nome + "', '" +
            this.cpf + "', '" +
            dataNascimentoFormatada + "', '" +
            this.email + "');";
}
// ...

    @Override
    public String toString() {
        return "Paciente [" + super.toString() + "]";
    }
}