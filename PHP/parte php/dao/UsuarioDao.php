<?php
// É necessário incluir o ConnectionFactory e o Model para que o DAO funcione
require_once 'ConnectionFactory.php';
require_once __DIR__ . '/../model/Usuario.php';

class UsuarioDao {

    public function inserir(Usuario $usuario) {
        try {
            // Query SQL ATUALIZADA para incluir cpf e data_nascimento
            $sql = "INSERT INTO usuarios (nome, cpf, data_nascimento, email, senha, tipo) 
                    VALUES (:nome, :cpf, :data_nascimento, :email, :senha, :tipo)";
            
            $stmt = ConnectionFactory::getConnection()->prepare($sql);

            // Binda os valores
            $stmt->bindValue(":nome", $usuario->getNome());
            $stmt->bindValue(":cpf", $usuario->getCpf());
            $stmt->bindValue(":data_nascimento", $usuario->getDataNascimento()); // Assumindo formato YYYY-MM-DD
            $stmt->bindValue(":email", $usuario->getEmail());
            
            $senhaHash = password_hash($usuario->getSenha(), PASSWORD_DEFAULT);
            $stmt->bindValue(":senha", $senhaHash);
            
            $stmt->bindValue(":tipo", $usuario->getTipo());

            return $stmt->execute();

        } catch(PDOException $ex) {
            echo "<p>Erro ao inserir usuário: </p>" . $ex->getMessage();
            return false;
        }
    }

    public function read() {
        try {
            $sql = "SELECT * FROM usuarios ORDER BY nome ASC";
            $result = ConnectionFactory::getConnection()->query($sql);
            
            $lista = $result->fetchAll(PDO::FETCH_ASSOC);
            $usuarioList = [];

            foreach($lista as $row) {
                // Usa o método auxiliar para converter a linha em objeto
                $usuarioList[] = $this->listaUsuario($row);
            }
            return $usuarioList;

        } catch (PDOException $ex) {
            echo "<p>Erro ao listar usuários: </p>" . $ex->getMessage();
            return [];
        }
    }

    public function buscarPorId($id) {
        try {
            $sql = "SELECT * FROM usuarios WHERE id = :id";
            $stmt = ConnectionFactory::getConnection()->prepare($sql);
            $stmt->bindValue(":id", $id);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                // Usa o método auxiliar para converter a linha em objeto
                return $this->listaUsuario($row);
            }
            return null; 

        } catch (PDOException $ex) {
            echo "<p>Erro ao buscar usuário por ID: </p>" . $ex->getMessage();
            return null;
        }
    }

    public function atualizar(Usuario $usuario) {
        try {
            $sql = "UPDATE usuarios SET 
                        nome = :nome, 
                        cpf = :cpf,                            -- Adicionado
                        data_nascimento = :data_nascimento,  -- Adicionado
                        email = :email, 
                        tipo = :tipo";

            $senhaNova = $usuario->getSenha();
            if (!empty($senhaNova)) {
                $sql .= ", senha = :senha"; // Adiciona a atualização da senha APENAS se uma nova foi fornecida
            }

            $sql .= " WHERE id = :id";

            $stmt = ConnectionFactory::getConnection()->prepare($sql);

            $stmt->bindValue(":nome", $usuario->getNome());
            $stmt->bindValue(":cpf", $usuario->getCpf());                         // Adicionado
            $stmt->bindValue(":data_nascimento", $usuario->getDataNascimento()); // Adicionado
            $stmt->bindValue(":email", $usuario->getEmail());
            $stmt->bindValue(":tipo", $usuario->getTipo());
            $stmt->bindValue(":id", $usuario->getId());

            if (!empty($senhaNova)) {
                $senhaHash = password_hash($senhaNova, PASSWORD_DEFAULT);
                $stmt->bindValue(":senha", $senhaHash);
            }

            return $stmt->execute();

        } catch (PDOException $ex) {
            echo "<p>Erro ao atualizar usuário: </p>" . $ex->getMessage();
            return false;
        }
    }

    public function excluir($id) {
        try {
            $sql = "DELETE FROM usuarios WHERE id = :id";
            $stmt = ConnectionFactory::getConnection()->prepare($sql);
            $stmt->bindValue(":id", $id);
            
            if ($stmt->execute()) {
                return $stmt->rowCount() > 0; 
            }
            return false;

        } catch (PDOException $ex) {
            echo "<p>Erro ao excluir usuário: </p>" . $ex->getMessage();
            return false;
        }
    }

    // Método auxiliar ATUALIZADO para transformar uma linha do banco em um objeto Usuario completo
    private function listaUsuario($row) {
        $usuario = new Usuario();
        $usuario->setId($row['id']);
        $usuario->setNome($row['nome']);
        $usuario->setCpf($row['cpf']);                         // Adicionado
        $usuario->setDataNascimento($row['data_nascimento']); // Adicionado
        $usuario->setEmail($row['email']);
        // A senha (hash) não é carregada para o objeto por segurança e porque geralmente não é necessária na listagem/edição.
        // Se precisar verificar a senha, seria no processo de login.
        $usuario->setTipo($row['tipo']);
        
        return $usuario;
    }
}
?>