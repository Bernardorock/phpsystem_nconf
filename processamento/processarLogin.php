<?php
session_start();
include '../conect.php';

$loginUsuario = $_POST['login'];
$loginSenha = $_POST['senha'];

//verificação login e senha

try
{
    $verificarLogin = $conect->prepare('select login from usuario where login = :usuariologin');
    $verificarLogin->bindParam(':usuariologin', $loginUsuario);
    $verificarLogin->execute();
    $capturarLogin = $verificarLogin->fetch();
    
    $verificarSenha = $conect->prepare('select senha from usuario where senha = :senha and login = :nome');
    $verificarSenha->bindParam(':senha', $loginSenha);
    $verificarSenha->bindParam(':nome', $loginUsuario);
    $verificarSenha->execute();
    $capturarSenha = $verificarSenha->fetch();

  if($loginUsuario == $capturarLogin['login'] && $loginSenha == $capturarSenha['senha']
  )
  { $_SESSION['usuario'] = $capturarLogin['login']; 
    header('Location: ../view/menu.php');
    exit;
  }else{
    echo 'Usuário ou Senha inválida';
  }
    

}catch(PDOException $e){
    die ('Algo de errado não está certo '). $e->getMessage();
}


?>