public class Paciente {
    private String nome;
    private String cpf;
    private String telefone;
    private String endereco;
    private String nascimento;

    public Paciente(String nome, String cpf, String telefone, String endereco, String nascimento) {
        this.nome = nome;
        this.cpf = cpf;
        this.telefone = telefone;
        this.endereco = endereco;
        this.nascimento = nascimento;
    }

    public String getNome() { return nome; }
    public String getCpf() { return cpf; }
    public String getTelefone() { return telefone; }
    public String getEndereco() { return endereco; }
    public String getNascimento() { return nascimento; }

    public void setNome(String nome) { this.nome = nome; }
    public void setTelefone(String telefone) { this.telefone = telefone; }
    public void setEndereco(String endereco) { this.endereco = endereco; }
    public void setNascimento(String nascimento) { this.nascimento = nascimento; }

    @Override
    public String toString() {
        return "Nome: " + nome + " | CPF: " + cpf + " | Telefone: " + telefone +
               " | Endereço: " + endereco + " | Nascimento: " + nascimento;
    }
}