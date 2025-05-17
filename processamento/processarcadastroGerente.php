<?php
session_start();
include '../conect.php';
$nomeGerente = strtoupper($_POST['nome']);
$sexo = $_POST['sexo'];

switch($sexo){
    case 'masculino':
        $sex = 'm';
        break;
    case 'feminino':
        $sex = 'f';
        break;
}

$verificarNome = $conect->prepare('select nomegerente from gerente where nomegerente = :nome');
$verificarNome->bindParam(':nome', $nomeGerente);
$verificarNome->execute();
$captarNome = $verificarNome->fetch();

$verificandoUsuario = $conect->prepare('select idusuario from usuario where nome = :nome');
$verificandoUsuario->bindParam(':nome', $_SESSION['usuario']);
$verificandoUsuario->execute();
$captarIdUsuario = $verificandoUsuario->fetch();

if(!$captarNome){
    $inserirGernte = $conect->prepare('insert into gerente (nomegerente, idusuario, sexo ) value(:nomegerente,:idusuario, :sex)');
    $inserirGernte->bindParam(':nomegerente', $nomeGerente);
    $inserirGernte->bindParam(':idusuario', $captarIdUsuario[0]);
    $inserirGernte->bindParam(':sex', $sex);
    $inserirGernte->execute();
    echo 'Gerente Cadastrado';
    
}else{
    echo 'Gerente já cadastrado';
}

