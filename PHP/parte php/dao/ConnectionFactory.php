<?php
class ConnectionFactory { // padrão singleton
    
    // A variável estática guardará a única instância da conexão
    private static $connection;

    public static function getConnection() {
        // Se a conexão ainda não foi criada, cria uma nova
        if (!isset(self::$connection)) {
            // --- ATENÇÃO: Altere os dados abaixo para os do seu banco ---
            $host = "localhost";
            $dbName = "teste"; // Coloque o nome do seu banco de dados aqui
            $user = "root";
            $pass = ""; // Coloque a sua senha aqui (geralmente vazia no XAMPP)
            
            try {
                // Cria a conexão usando PDO (PHP Data Objects)
                self::$connection = new PDO("mysql:host=$host;dbname=$dbName", $user, $pass);
                
                // Configura o PDO para lançar exceções em caso de erro
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                return self::$connection;

            } catch(PDOException $ex) {
                // Em caso de erro, exibe a mensagem
                echo("ERRO ao conectar no banco de dados! <p>$ex</p>");
            }
        }
        
        // Se a conexão já existe, apenas a retorna
        return self::$connection;
    }
}
?>