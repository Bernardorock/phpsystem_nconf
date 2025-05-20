<?php
//conectar com o banco SYSTEM_NCONF mysql

$nomebanco = 'SYSTEM_NCONF';
$usuario = 'bernardo';
$host = '152.67.44.205';
$senha = '';
$porta = '3306';

try
{
    $conect = new PDO('mysql:dbname='.$nomebanco.';port='.$porta.';host='.$host,$usuario, $senha);
    //echo 'STATUS OK';
}catch(PDOException $e){
    die('Erro na conexão ' . $e->getMessage());
}

?>