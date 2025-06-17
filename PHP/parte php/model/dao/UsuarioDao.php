<?php
// É necessário incluir o ConnectionFactory e o Model para que o DAO funcione
require_once 'ConnectionFactory.php';
require_once __DIR__ . '/../model/Usuario.php';

class UsuarioDao {

    public function inserir(Usuario $usuario) {
        try {
            $sql = "INSERT INTO usuarios (nome, email, senha, tipo) VALUES (:nome, :email, :senha, :tipo)";
            
            // Pega a conexão do ConnectionFactory
            $stmt = ConnectionFactory::getConnection()->prepare($sql);

            // Binda (liga) os valores do objeto Usuario com os parâmetros do SQL
            $stmt->bindValue(":nome", $usuario->getNome());
            $stmt->bindValue(":email", $usuario->getEmail());
            
            // --- IMPORTANTE: Criptografia da Senha ---
            // Nunca salvamos a senha em texto puro no banco de dados.
            // Usamos password_hash para criar uma versão segura (criptografada) da senha.
            $senhaHash = password_hash($usuario->getSenha(), PASSWORD_DEFAULT);
            $stmt->bindValue(":senha", $senhaHash);
            
            $stmt->bindValue(":tipo", $usuario->getTipo());

            // Executa a query
            return $stmt->execute();

        } catch(PDOException $ex) {
            // Em caso de erro, exibe a mensagem
            echo "<p>Erro ao inserir usuário: </p>" . $ex->getMessage();
            return false;
        }
    }

    // Método para ler todos os usuários do banco
    public function read() {
        try {
            $sql = "SELECT * FROM usuarios ORDER BY nome ASC";
            $result = ConnectionFactory::getConnection()->query($sql);
            
            $lista = $result->fetchAll(PDO::FETCH_ASSOC);
            $usuarioList = [];

            foreach($lista as $row) {
                $usuarioList[] = $this->listaUsuario($row);
            }

            return $usuarioList;

        } catch (PDOException $ex) {
            echo "<p>Erro ao listar usuários: </p>" . $ex->getMessage();
            return [];
        }
    }

    // Método auxiliar para transformar uma linha do banco em um objeto Usuario
    private function listaUsuario($row) {
        $usuario = new Usuario();
        $usuario->setId($row['id']);
        $usuario->setNome($row['nome']);
        $usuario->setEmail($row['email']);
        // Intencionalmente não retornamos a senha do banco para a aplicação
        $usuario->setTipo($row['tipo']);
        
        return $usuario;
    }
}
?>