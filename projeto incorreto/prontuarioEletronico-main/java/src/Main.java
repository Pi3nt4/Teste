import java.io.FileWriter;
import java.io.IOException;
import java.util.ArrayList;

public class Main {
    public static void main(String[] args) {
        ArrayList<Paciente> pacientes = new ArrayList<>();
        pacientes.add(new Paciente("Alexandre Moresca", "12345678900", "11999999999", "Rua da Rua, 34", "2005-05-28"));
        pacientes.add(new Paciente("Luís Pinho", "98765432100", "21988888888", "Rua da Calçada, 65", "2005-06-13"));
        pacientes.add(new Paciente("Abel Ferreira", "45678912300", "31977777777", "Rua Palestra Itália, 1914", "2000-10-20"));

        ArrayList<Exame> exames = new ArrayList<>();
        exames.add(new Exame("Glicose", "Exame para medir o nível de glicose no sangue"));
        exames.add(new Exame("Colesterol Total", "Exame para medir o nível de colesterol no sangue"));
        exames.add(new Exame("Triglicerídeos", "Exame para medir o nível de triglicerídeos no sangue"));
        exames.add(new Exame("Ureia", "Exame para avaliar a função renal"));
        exames.add(new Exame("Creatinina", "Exame para avaliar a função renal e muscular"));

        // Gerar arquivo paciente.sql
        try (FileWriter writer = new FileWriter("paciente.sql")) {
            for (Paciente p : pacientes) {
                writer.write(String.format(
                    "INSERT INTO paciente (nome, cpf, telefone, endereco, nascimento) VALUES ('%s', '%s', '%s', '%s', '%s');\n",
                    p.getNome(), p.getCpf(), p.getTelefone(), p.getEndereco(), p.getNascimento()));
            }
            System.out.println("Arquivo paciente.sql gerado com sucesso!");
        } catch (IOException e) {
            System.out.println("Erro ao gerar o arquivo paciente.sql: " + e.getMessage());
        }

        // Gerar arquivo exame.sql
        try (FileWriter writer = new FileWriter("exame.sql")) {
            for (Exame e : exames) {
                writer.write(String.format(
                    "INSERT INTO exame (nome, descricao) VALUES ('%s', '%s');\n",
                    e.getNome(), e.getDescricao()));
            }
            System.out.println("Arquivo exame.sql gerado com sucesso!");
        } catch (IOException e) {
            System.out.println("Erro ao gerar o arquivo exame.sql: " + e.getMessage());
        }
    }
}