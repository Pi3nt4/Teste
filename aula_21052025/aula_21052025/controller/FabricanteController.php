<?php
require __DIR__. '/../dao/ConnectionFactory.php';
require __DIR__. '/../model/Fabricante.php';
require __DIR__. '/../dao/FabricanteDao.php';


$fabricanteDao = new FabricanteDao();

if(isset($_POST['cadastrar'])){
    $fabricante = new Fabricante();
    $fabricante->setNome($_POST['nome']);
    $fabricante->setEndereco($_POST['endereco']);
    $fabricante->setDocumento($_POST['documento']);
    $fabricanteDao->inserir($fabricante);
    header("Location: ../index.php");
}


function listar(){
    $fabricanteDao = new FabricanteDao();
    $lista = $fabricanteDao->read();
    foreach($lista as $fab){
        echo "<tr>
        <td> {$fab->getId()} </td>
        <td> {$fab->getNome()}</td>
        <td> {$fab->getEndereco()}</td>
        <td> {$fab->getDocumento()}</td>
        <td> <a href='index.php?editar={$fab->getId()}'> <i class='bi bi-pencil-square'></i> Editar</a> <a href='#'> Exluir</a> </td>
    </tr>";
    }
}
?>