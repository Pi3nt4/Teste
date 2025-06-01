<?php
class FabricanteDao{

    public function inserir(Fabricante $fab){
        try{
            $sql = "INSERT INTO fabricante (nome, endereco, documento)
                VALUES (:nome, :endereco, :documento)";
            $conn = ConnectionFactory::getConnection()->prepare($sql);
            $conn->bindValue(":nome", $fab->getNome());
            $conn->bindValue(":endereco", $fab->getEndereco());
            $conn->bindValue(":documento", $fab->getDocumento());
            return $conn->execute(); # executa o insert
        }catch(PDOException $ex){
            echo "<p> Erro </p> <p> $ex </p>";
        }
    }

    // Executa SELECT * FROM no banco
    public function read(){
        try{
            $sql = "SELECT * FROM fabricante";
            $conn = ConnectionFactory::getConnection()->query($sql);
            $lista = $conn->fetchAll(PDO::FETCH_ASSOC);
            $fabList = array();
            foreach($lista as $fab){
                $fabList[] = $this->listaFabricante($fab); // Adiciona fabricante
            }
            echo "Temos ". count($fabList) . " cadastros no banco";
            return $fabList;
        }catch (PDOException $ex){
            echo "<p>Ocorreu um erro ao executar a consulta </p> {$ex}";
        }
    }

    // Converter uma linha em obj
    public function listaFabricante($row){
        $fabricante = new Fabricante();
        $fabricante->setId($row['id']);
        $fabricante->setNome($row['nome']);
        $fabricante->setEndereco($row['endereco']);
        $fabricante->setDocumento($row['documento']);
        return $fabricante;
    }
}
?>