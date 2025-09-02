<?php
require_once(__DIR__ . '/../models/Paciente.php');
require_once(__DIR__ . '/../config/db.php');

class PacienteController {
    public static function cadastrar() {
        global $conn;
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cadastrar'])) {
            $stmt = $conn->prepare("INSERT INTO paciente (nome, nascimento, cpf, sexo, telefone, email, endereco, convenio, observacoes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param(
                "sssssssss",
                $_POST['nome'],
                $_POST['nascimento'],
                $_POST['cpf'],
                $_POST['sexo'],
                $_POST['telefone'],
                $_POST['email'],
                $_POST['endereco'],
                $_POST['convenio'],
                $_POST['observacoes']
            );
            $stmt->execute();
            $stmt->close();
        }
    }

    public static function editar() {
        global $conn;
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar'])) {
            $stmt = $conn->prepare("UPDATE paciente SET nome = ?, nascimento = ?, cpf = ?, sexo = ?, telefone = ?, email = ?, endereco = ?, convenio = ?, observacoes = ? WHERE id = ?");
            $stmt->bind_param(
                "sssssssssi",
                $_POST['nome'],
                $_POST['nascimento'],
                $_POST['cpf'],
                $_POST['sexo'],
                $_POST['telefone'],
                $_POST['email'],
                $_POST['endereco'],
                $_POST['convenio'],
                $_POST['observacoes'],
                $_POST['id']
            );
            $stmt->execute();
            $stmt->close();
        }
    }

    public static function excluir() {
        global $conn;
        if (isset($_GET['excluir'])) {
            $stmt = $conn->prepare("DELETE FROM paciente WHERE id = ?");
            $stmt->bind_param("i", $_GET['excluir']);
            $stmt->execute();
            $stmt->close();
        }
    }

    public static function listar() {
        global $conn;
        return $conn->query("SELECT * FROM paciente");
    }

    public static function buscarPorId($id) {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM paciente WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}