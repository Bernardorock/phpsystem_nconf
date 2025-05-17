<?php
session_start();
include '../conect.php';

$numeroFilial = $_POST['numerofilial'];
$nomeFilial = strtoupper($_POST['nome']);
$emailFilial =$_POST['email'];

$verificarNumeroEmpresa = $conect->prepare('select numeroempresa from empresa where numeroempresa = :numero');
$verificarNumeroEmpresa->bindParam(':numero', $numeroFilial);
$verificarNumeroEmpresa->execute();
$capturarNumeroFilial = $verificarNumeroEmpresa->fetch();

$verificarNomeEmpresa = $conect->prepare('select nomeempresa from empresa where nomeempresa = :nome');
$verificarNomeEmpresa->bindParam(':nome', $nomeFilial);
$verificarNomeEmpresa->execute();
$captutarNomeEmpresa = $verificarNomeEmpresa->fetch();

if(!$capturarNumeroFilial){
    $valorChave = $conect->prepare('select idusuario from usuario where nome = :nome');
    $valorChave->bindParam(':nome', $_SESSION['usuario']);
    $valorChave->execute();
    $capturarChave = $valorChave->fetch();

    $insertEmpresa = $conect->prepare('insert into empresa (numeroempresa, nomeempresa, id_usuario, email) values (:numero, :nome, :idusuario, :email)');
    $insertEmpresa->bindParam(':numero', $numeroFilial);
    $insertEmpresa->bindParam(':nome', $nomeFilial);
    $insertEmpresa->bindParam(':email', $emailFilial);
    $insertEmpresa->bindParam(':idusuario', $capturarChave[0]);
    $insertEmpresa->execute();
    echo 'Empresa Cadastrada';
}else{
    echo 'Empresa Já cadastrada';
}

?>