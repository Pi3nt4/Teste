package model;

import java.time.LocalDate;
import java.time.format.DateTimeFormatter;

public class Usuario extends Pessoa {

    private String senha;
    private String tipo;

    public Usuario(String nome, String cpf, LocalDate dataNascimento, String email, String senha, String tipo) {
        super(nome, cpf, dataNascimento, email);
        this.senha = senha;
        this.tipo = tipo;
    }
    
    // --- Getters e Setters (sem alterações) ---
    public String getSenha() { return senha; }
    public void setSenha(String senha) { this.senha = senha; }
    public String getTipo() { return tipo; }
    public void setTipo(String tipo) { this.tipo = tipo; }

    /**
     * Implementação obrigatória do método da classe Pessoa.
     * Formata os dados do usuário para um comando SQL.
     */
    @Override
    public String toStringSql() {
        DateTimeFormatter sqlFormatter = DateTimeFormatter.ofPattern("yyyy-MM-dd");
        String dataNascimentoFormatada = this.dataNascimento.format(sqlFormatter);

        // Assumindo uma tabela 'usuario' com estas colunas.
        return "INSERT INTO usuario (nome, cpf, data_nascimento, email, senha, tipo) VALUES ('" +
                this.nome + "', '" +
                this.cpf + "', '" +
                dataNascimentoFormatada + "', '" +
                this.email + "', '" +
                this.senha + "', '" + // ATENÇÃO: Nunca guarde senhas em texto plano em projetos reais!
                this.tipo + "');";
    }

    @Override
    public String toString() {
        return "Usuario [" + super.toString() + ", Tipo: '" + tipo + '\'' + ']';
    }
}