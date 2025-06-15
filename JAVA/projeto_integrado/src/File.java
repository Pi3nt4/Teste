
import java.io.FileWriter;
import java.io.IOException;
import java.io.PrintWriter;

public class File {
    private static String fileName = "arquivo.sql";

    /**
     * Escreve uma linha (o comando INSERT) no final do ficheiro.
     * @param insert A string SQL a ser escrita.
     */
    public void writeInsertStatement(String insert) {
        // O 'true' no FileWriter indica que queremos adicionar ao final do ficheiro (append).
        try (FileWriter fw = new FileWriter(fileName, true);
             PrintWriter pw = new PrintWriter(fw)) {
            
            pw.println(insert); // Usamos println para adicionar uma nova linha automaticamente

        } catch (IOException e) {
            System.err.println("Erro ao escrever no arquivo.sql: " + e.getMessage());
        }
    }
}