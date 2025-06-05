<?php
session_start();
require_once dirname(__DIR__, 1) . '/conect.php';
require __DIR__ . '/../vendor/autoload.php';
use App\controller\Produto;
$produto = new Produto();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $produto->InserirProduto
    (
        $_POST['referp'],
        $_POST['descricaoproduto'],
        $_POST['ean'],
        $_POST['tipovolume']
    
    );
}