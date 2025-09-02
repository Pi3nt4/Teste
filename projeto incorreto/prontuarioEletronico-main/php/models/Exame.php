<?php
class Exame {
    private $nome;
    private $descricao;

    public static function listar($conn) {
        $result = $conn->query("SELECT * FROM exame ORDER BY id DESC");
        return $result;
    }

    public static function buscarPorId($conn, $id) {
        $stmt = $conn->prepare("SELECT * FROM exame WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public static function cadastrar($conn, $nome, $descricao) {
        $stmt = $conn->prepare("INSERT INTO exame (nome, descricao) VALUES (?, ?)");
        $stmt->bind_param("ss", $nome, $descricao);
        return $stmt->execute();
    }

    public static function editar($conn, $id, $nome, $descricao) {
        $stmt = $conn->prepare("UPDATE exame SET nome = ?, descricao = ? WHERE id = ?");
        $stmt->bind_param("ssi", $nome, $descricao, $id);
        return $stmt->execute();
    }

    public static function excluir($conn, $id) {
        $stmt = $conn->prepare("DELETE FROM exame WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}

?>