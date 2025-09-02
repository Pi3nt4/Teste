// É preciso importar todas as classes que usamos de outros pacotes/ficheiros.
import model.Paciente;
import model.Usuario;

// A LINHA "import java.io.File;" FOI REMOVIDA DAQUI.

import java.time.LocalDate;
import java.time.format.DateTimeFormatter;
import java.time.format.DateTimeParseException;
import java.util.Scanner;

/**
 * Classe principal que executa a aplicação.
 * Permite ao utilizador cadastrar novos Usuários ou Pacientes.
 */
public class App {
    public static void main(String[] args) {
        // Inicializamos os objetos que vamos usar em todo o programa.
        Scanner sc = new Scanner(System.in);
        // Agora, esta linha usa a nossa classe 'File.java' corretamente.
        File arquivo = new File();
        // Define o formato de data que o utilizador deve digitar (dia/mês/ano).
        DateTimeFormatter formatadorData = DateTimeFormatter.ofPattern("dd/MM/yyyy");

        String opcao = "";
        // O loop continua enquanto o utilizador não digitar "sair".
        while (!opcao.equalsIgnoreCase("sair")) {
            System.out.println("\n========= MENU PRINCIPAL =========");
            System.out.println("1. Cadastrar Novo Usuário");
            System.out.println("2. Cadastrar Novo Paciente");
            System.out.println("Digite 'sair' para encerrar.");
            System.out.print("--> Escolha uma opção: ");
            opcao = sc.nextLine();

            // O switch direciona para o método correto com base na escolha do utilizador.
            switch (opcao) {
                case "1":
                    cadastrarUsuario(sc, arquivo, formatadorData);
                    break;
                case "2":
                    cadastrarPaciente(sc, arquivo, formatadorData);
                    break;
                case "sair":
                    System.out.println("\nObrigado por usar o programa. Até logo!");
                    break;
                default:
                    System.out.println("\n[ERRO] Opção inválida! Por favor, tente novamente.");
                    break;
            }
        }
        // É uma boa prática fechar o Scanner no final.
        sc.close();
    }

    /**
     * Pede os dados de um Usuário, cria o objeto e grava o SQL no ficheiro.
     */
    private static void cadastrarUsuario(Scanner sc, File arquivo, DateTimeFormatter formatador) {
        System.out.println("\n--- Cadastro de Usuário ---");
        System.out.print("Nome: ");
        String nome = sc.nextLine();
        System.out.print("CPF: ");
        String cpf = sc.nextLine();
        System.out.print("Email: ");
        String email = sc.nextLine();
        LocalDate dataNascimento = lerData(sc, formatador); // Usa o método auxiliar para ler a data
        System.out.print("Senha: ");
        String senha = sc.nextLine();
        System.out.print("Tipo (ex: admin, medico): ");
        String tipo = sc.nextLine();
        
        // **DECLARAÇÃO DO OBJETO**
        // Aqui criamos a instância de Usuario com os dados recolhidos.
        Usuario novoUsuario = new Usuario(nome, cpf, dataNascimento, email, senha, tipo);
        
        // Usamos o objeto para gerar o SQL e depois gravá-lo.
        arquivo.writeInsertStatement(novoUsuario.toStringSql());
        System.out.println("\n[SUCESSO] Usuário cadastrado e INSERT gerado!");
        System.out.println("Dados: " + novoUsuario.toString());
    }
    
    /**
     * Pede os dados de um Paciente, cria o objeto e grava o SQL no ficheiro.
     */
    private static void cadastrarPaciente(Scanner sc, File arquivo, DateTimeFormatter formatador) {
        System.out.println("\n--- Cadastro de Paciente ---");
        System.out.print("Nome: ");
        String nome = sc.nextLine();
        System.out.print("CPF: ");
        String cpf = sc.nextLine();
        System.out.print("Email: ");
        String email = sc.nextLine();
        LocalDate dataNascimento = lerData(sc, formatador);

        // **DECLARAÇÃO DO OBJETO**
        // Aqui criamos a instância de Paciente.
        Paciente novoPaciente = new Paciente(nome, cpf, dataNascimento, email);
        
        // Usamos o objeto para gerar o SQL e depois gravá-lo.
        arquivo.writeInsertStatement(novoPaciente.toStringSql());
        System.out.println("\n[SUCESSO] Paciente cadastrado e INSERT gerado!");
        System.out.println("Dados: " + novoPaciente.toString());
    }

    /**
     * Um método auxiliar para ler e validar a data de nascimento.
     * Fica num loop até que o utilizador digite uma data no formato correto.
     */
    private static LocalDate lerData(Scanner sc, DateTimeFormatter formatador) {
        while (true) { // Loop infinito que só é quebrado pelo 'return'.
            System.out.print("Data de Nascimento (dd/MM/yyyy): ");
            String dataStr = sc.nextLine();
            try {
                // Tenta converter o texto do utilizador para um objeto LocalDate.
                return LocalDate.parse(dataStr, formatador);
            } catch (DateTimeParseException e) {
                // Se a conversão falhar, avisa o utilizador e o loop continua.
                System.out.println("[ERRO] Formato de data inválido! Use o formato dd/MM/yyyy.");
            }
        }
    }
}