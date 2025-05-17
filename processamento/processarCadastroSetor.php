<?php
session_start();
include '../conect.php';

$setor = strtoupper($_POST['nomesetor']);

$verificarSetor = $conect->prepare('select nomesetor from setoravaliado where nomesetor = :nomesetor');
$verificarSetor->bindParam(':nomesetor', $setor);
$verificarSetor->execute();
$captarSetor = $verificarSetor->fetch();

if(!$captarSetor){
    $incluirSetor = $conect->prepare('insert into setoravaliado (nomesetor) values (:nomesetor) ');
    $incluirSetor->bindParam(':nomesetor', $setor);
    $incluirSetor->execute();
    echo 'Setor Cadastrado';
}else{
    echo 'Setor já Cadastrado';
}

?>