<?php
require_once(__DIR__ . '/../models/Exame.php');
require_once(__DIR__ . '/../config/db.php');

class ExameController {
    public static function listar() {
        global $conn;
        return Exame::listar($conn);
    }

    public static function buscarPorId($id) {
        global $conn;
        return Exame::buscarPorId($conn, $id);
    }

    public static function cadastrar($nome, $descricao) {
        global $conn;
        return Exame::cadastrar($conn, $nome, $descricao);
    }

    public static function editar($id, $nome, $descricao) {
        global $conn;
        return Exame::editar($conn, $id, $nome, $descricao);
    }

    public static function excluir($id) {
        global $conn;
        return Exame::excluir($conn, $id);
    }
}
?>