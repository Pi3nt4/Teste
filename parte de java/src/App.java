


import model.Paciente;
import model.Usuario;
import util.FileHandler; 

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
        Scanner sc = new Scanner(System.in);
        // Agora, esta linha usa a nossa classe 'FileHandler.java' corretamente.
        FileHandler arquivo = new FileHandler(); // Alterado de File para FileHandler
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
     * Pede os dados de um Usuário, cria o objeto e grava o SQL no ficheiro, com validações.
     */
    private static void cadastrarUsuario(Scanner sc, FileHandler arquivo, DateTimeFormatter formatador) { // Tipo alterado para FileHandler
        System.out.println("\n--- Cadastro de Usuário ---");
        // Campos de entrada com chamadas para os métodos de validação (a serem implementados)
        String nome = lerStringNaoVazia(sc, "Nome");
        String cpf = lerCpfValido(sc);
        String email = lerEmailValido(sc);
        LocalDate dataNascimento = lerData(sc, formatador); // Já existe e será aprimorado para data futura
        String senha = lerSenhaValida(sc);
        String tipo = lerTipoUsuarioValido(sc);

        // **DECLARAÇÃO DO OBJETO**
        Usuario novoUsuario = new Usuario(nome, cpf, dataNascimento, email, senha, tipo);

        arquivo.writeInsertStatement(novoUsuario.toStringSql());
        System.out.println("\n[SUCESSO] Usuário cadastrado e INSERT gerado!");
        System.out.println("Dados: " + novoUsuario.toString());
    }

    /**
     * Pede os dados de um Paciente, cria o objeto e grava o SQL no ficheiro, com validações.
     */
    private static void cadastrarPaciente(Scanner sc, FileHandler arquivo, DateTimeFormatter formatador) { // Tipo alterado para FileHandler
        System.out.println("\n--- Cadastro de Paciente ---");
        // Campos de entrada com chamadas para os métodos de validação (a serem implementados)
        String nome = lerStringNaoVazia(sc, "Nome");
        String cpf = lerCpfValido(sc);
        String email = lerEmailValido(sc);
        LocalDate dataNascimento = lerData(sc, formatador); // Já existe e será aprimorado para data futura

        // **DECLARAÇÃO DO OBJETO**
        Paciente novoPaciente = new Paciente(nome, cpf, dataNascimento, email);

        arquivo.writeInsertStatement(novoPaciente.toStringSql());
        System.out.println("\n[SUCESSO] Paciente cadastrado e INSERT gerado!");
        System.out.println("Dados: " + novoPaciente.toString());
    }

    /**
     * Um método auxiliar para ler e validar a data de nascimento.
     * Fica num loop até que o utilizador digite uma data no formato correto.
     * (Este método será aprimorado nos próximos passos para incluir validação de data futura)
     */
    private static LocalDate lerData(Scanner sc, DateTimeFormatter formatador) {
    while (true) { // Loop infinito que só é quebrado pelo 'return'.
        System.out.print("Data de Nascimento (dd/MM/yyyy): ");
        String dataStr = sc.nextLine();
        try {
            // Tenta converter o texto do utilizador para um objeto LocalDate.
            LocalDate data = LocalDate.parse(dataStr, formatador);

            // --- NOVA VALIDAÇÃO: Verificar se a data não é futura ---
            if (data.isAfter(LocalDate.now())) { // LocalDate.now() obtém a data atual do sistema
                System.out.println("[ERRO] Data de Nascimento não pode ser uma data futura! Por favor, tente novamente.");
            } else {
                return data; // Se a data é válida e não é futura, retorna e sai do loop
            }
        } catch (DateTimeParseException e) {
            // Se a conversão falhar, avisa o utilizador e o loop continua.
            System.out.println("[ERRO] Formato de data inválido! Use o formato dd/MM/yyyy. Por favor, tente novamente.");
        }
    }
}

    // --- Novos métodos de validação (serão implementados e detalhados nos próximos passos) ---

private static String lerStringNaoVazia(Scanner sc, String nomeCampo) {
    String input;
    while (true) { // Loop infinito que continua até uma entrada válida
        System.out.print(nomeCampo + ": "); // Exibe a pergunta (ex: "Nome: ")
        input = sc.nextLine().trim(); // Lê a linha e remove espaços em branco no início/fim
        if (!input.isEmpty()) { // Verifica se a string não está vazia
            return input; // Se não estiver vazia, retorna o input e sai do loop
        } else {
            System.out.println("[ERRO] O campo '" + nomeCampo + "' não pode ser vazio. Por favor, tente novamente."); // Mensagem de erro
        }
    }
}
private static String lerCpfValido(Scanner sc) {
    String cpf;
    while (true) { // Loop infinito que continua até uma entrada válida
        System.out.print("CPF (apenas números, 11 dígitos): "); // Solicita o CPF
        cpf = sc.nextLine().trim(); // Lê a entrada e remove espaços em branco

        // Valida se o CPF contém APENAS dígitos e tem um comprimento de 11
        if (cpf.matches("\\d{11}")) { // A expressão regular "\\d{11}" verifica 11 dígitos numéricos
            return cpf; // Se válido, retorna o CPF e sai do loop
        } else {
            System.out.println("[ERRO] CPF inválido! Deve conter exatamente 11 dígitos numéricos. Por favor, tente novamente."); // Mensagem de erro
        }
    }
}
  private static String lerEmailValido(Scanner sc) {
    String email;
    // Expressão regular para uma validação de e-mail básica
    // Permite letras, números, . % + - _ no nome de usuário, e letras, números, - no domínio, com 2 a 6 letras no TLD
    String emailRegex = "^[\\w!#$%&’*+/=?`{|}~^-]+(?:\\.[\\w!#$%&’*+/=?`{|}~^-]+)*@(?:[a-zA-Z0-9-]+\\.)+[a-zA-Z]{2,6}$";

    while (true) { // Loop infinito que continua até uma entrada válida
        System.out.print("Email: "); // Solicita o e-mail
        email = sc.nextLine().trim(); // Lê a entrada e remove espaços em branco

        if (email.matches(emailRegex)) { // Valida o formato do e-mail usando a expressão regular
            return email; // Se válido, retorna o e-mail e sai do loop
        } else {
            System.out.println("[ERRO] Formato de email inválido! Por favor, tente novamente."); // Mensagem de erro
        }
    }
}
    private static String lerSenhaValida(Scanner sc) {
    String senha;
    int MIN_CARACTERES_SENHA = 6; // Define o requisito mínimo de caracteres

    while (true) { // Loop infinito que continua até uma entrada válida
        System.out.print("Senha (mínimo " + MIN_CARACTERES_SENHA + " caracteres): "); // Solicita a senha
        senha = sc.nextLine(); // Lê a entrada (não usamos trim aqui, pois espaços podem ser parte da senha se permitido)

        if (senha.length() >= MIN_CARACTERES_SENHA) { // Verifica o comprimento da senha
            return senha; // Se válida, retorna a senha e sai do loop
        } else {
            System.out.println("[ERRO] A senha deve ter no mínimo " + MIN_CARACTERES_SENHA + " caracteres. Por favor, tente novamente."); // Mensagem de erro
        }
    }
}

private static String lerTipoUsuarioValido(Scanner sc) {
    String tipo;
    while (true) { // Loop infinito que continua até uma entrada válida
        System.out.print("Tipo (admin ou aluno): "); // Solicita o tipo de usuário
        tipo = sc.nextLine().trim().toLowerCase(); // Lê a entrada, remove espaços e converte para minúsculas

        if (tipo.equals("admin") || tipo.equals("aluno")) { // Verifica se é 'admin' ou 'aluno'
            return tipo; // Se válido, retorna o tipo e sai do loop
        } else {
            System.out.println("[ERRO] Tipo de usuário inválido! Digite 'admin' ou 'aluno'. Por favor, tente novamente."); // Mensagem de erro
        }
    }
}
}
