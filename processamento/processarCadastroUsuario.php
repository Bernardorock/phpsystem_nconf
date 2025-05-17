<?php
    session_start();
    include '../conect.php';

    $nomeUsuario = $_POST['nome'];
    $loginUsuario = $_POST['login'];
    $senhaUser = $_POST['senha'];
    //$senhaUsuario = password_hash($senhaUser, PASSWORD_DEFAULT);
    $pedidoAdm = $_POST['pedido_adm'];
    $setorUsuario = $_POST['setor'];
    $verificarAdm = 'n';

    // verificar se o login do usuário já existe
    $checkLogin = $conect->prepare("select login from usuario where login = :loginUser");
    $checkLogin->bindParam(':loginUser', $loginUsuario);
    $checkLogin->execute();
    $loginExistente = $checkLogin->fetch();
    if($loginExistente)
    {
        die ('Login já cadastrado');
    }
    // buscando a forieng key do setor
  
        $buscandoSetor = $conect->prepare('select idsetor from setor where nomesetor = :setor');
        $buscandoSetor->bindParam(':setor', $setorUsuario);
        $buscandoSetor->execute();
        $foriengKeySetor = $buscandoSetor->fetch();

        if(empty($foriengKeySetor)){
            die('Setor Incorreto!');
        }

        // inserindo o usuário com as informações obtidas
        $inserirUsuario = $conect->prepare('insert into usuario (nome, login, senha, pedidoadm, veradm, id_setor) 
        values (:nome, :login, :senha, :pedidoadm, :veradm, :id_setor)');

        $inserirUsuario->bindParam(':nome', $nomeUsuario);
        $inserirUsuario->bindParam(':login', $loginUsuario);
        $inserirUsuario->bindParam(':senha', $senhaUser);
        $inserirUsuario->bindParam(':id_setor', $foriengKeySetor[0]);
        $inserirUsuario->bindParam(':pedidoadm', $pedidoAdm);
        $inserirUsuario->bindParam(':veradm', $verificarAdm);
        $inserirUsuario->execute();
        echo 'USUÁRIO CADASTRADO!';

        


?>  