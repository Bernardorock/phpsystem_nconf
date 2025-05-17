<?php
session_start();
include '../conect.php';

$pendente = 'n';
$captarSessaoIdPre = $_SESSION['idpre'] ?? '';

if (empty($captarSessaoIdPre)) {
    die('ID de pré-não conformidade não informado.');
}

$deleteOnconformidade = $conect->prepare('
    DELETE FROM an_cadastrarinconf
    WHERE idpre = :idpre
');
$deleteOnconformidade->bindParam(':idpre', $captarSessaoIdPre);
$deleteOnconformidade->execute();

$idPendentePre = $conect->prepare('
    UPDATE pre_nconformidade
    SET pendente = :pendente
    WHERE idpre = :idpre 
');
$idPendentePre->bindParam(':idpre', $captarSessaoIdPre);
$idPendentePre->bindParam(':pendente', $pendente);
$idPendentePre->execute();

// Limpa a sessão após salvar
unset($_SESSION['idpre']);

// Redireciona corretamente
header('Location: ../view/lancarNaoConformidades.php');
exit;
?>
    
   
   