<?php
    include '../conect.php';

    $sqlLista = 
    "
        select refsankhya, nomeproduto from produto
        order by refsankhya
    ";

    $lista = $conect->prepare($sqlLista);
    $lista->execute();
    $captarLista = $lista->fetchAll();

    foreach($captarLista as $valorLista)
    {
        echo '<ul>';
        echo '<li>'.$valorLista[0]. ' . '.$valorLista[1].'</li>';
        echo '</ul>';
        
    }
?>