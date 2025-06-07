<?php
require __DIR__ . '/../vendor/autoload.php';
include '../conect.php';
use Dompdf\Dompdf;
define('notamaxima', 10.00);
$pdf = new Dompdf();
ob_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório CheckList</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
        }

        h2, h3 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #444;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .info-block {
            background-color: #f9f9f9;
            padding: 10px;
            border: 1px solid #ddd;
            margin-bottom: 10px;
        }

        .resumo {
            margin-top: 10px;
            font-weight: bold;
        }

        hr {
            border: 0;
            border-top: 1px solid #ccc;
        }
    </style>
</head>
<body>

    <h2>Relatório CheckList</h2>
    <h3>Dados da Auditoria:</h3>

    <div class="info-block">
        <?php
            $sqlNumeroAuditoria = "
                SELECT 
                    pre.idpre,
                    aud.nomeauditor,
                    aud2.nomeauditor,
                    aud3.nomeauditor,
                    ger.nomegerente,
                    emp.nomeempresa,
                    pre.dtinicial
                FROM pre_nconformidade pre
                INNER JOIN auditor aud ON aud.idauditor = pre.id_auditorpri
                LEFT JOIN auditor aud2 ON aud2.idauditor = pre.id_auditorsec
                LEFT JOIN auditor aud3 ON aud3.idauditor = pre.id_auditorter
                INNER JOIN empresagerente empger ON empger.idempger = pre.idempgr
                INNER JOIN empresa emp ON emp.idempresa = empger.id_empresa
                INNER JOIN gerente ger ON ger.idgerente = empger.id_gerente
                WHERE pre.pendente = 'n' AND pre.audativa = 's' AND pre.idpre = :idpre
            ";

            $listarCabecalho = $conect->prepare($sqlNumeroAuditoria);
            $listarCabecalho->bindParam(':idpre', $_POST['numerodaauditoria']);
            $listarCabecalho->execute();
            $captarAuditoria = $listarCabecalho->fetch();

            echo 'Número da Auditoria: ' . $captarAuditoria[0] . '<br>';
            echo 'Auditor 1: ' . $captarAuditoria[1] . ' | ';
            echo 'Auditor 2: ' . $captarAuditoria[2] . ' | ';
            echo 'Auditor 3: ' . $captarAuditoria[3] . '<br>';
            echo 'Gerente: ' . $captarAuditoria[4] . ' | ';
            echo 'Filial: ' . $captarAuditoria[5];
        ?>
    </div>

    <?php
        $sqlNotaAuditoria = "
            SELECT SUM(inc.valor) 
            FROM inconf inc
            INNER JOIN pos_cadastroconf pos ON pos.nomeconf = inc.conc
            INNER JOIN pre_nconformidade pre ON pre.idplano = pos.idplano
            WHERE pos.vlrcobrado = 's' AND pos.ncativo = 's'
            AND pre.idpre = :idpre
        ";
        $notaAuditoria = $conect->prepare($sqlNotaAuditoria);
        $notaAuditoria->bindParam(':idpre', $_POST['numerodaauditoria']);
        $notaAuditoria->execute();
        $captiarNota = $notaAuditoria->fetch();

        $notaFinal = notamaxima - floatval($captiarNota[0]);

        echo '<div class="resumo">';
        echo 'Nota Inicial: ' . number_format(notamaxima, 2, ',', '.') . ' | ';
        echo 'Nota Auditoria: ' . number_format($captiarNota[0], 2, ',', '.') . ' | ';
        echo 'Resultado Final: ' . number_format($notaFinal, 2, ',', '.');
        echo '</div>';
    ?>

    <h3>Não conformidades com observações</h3>
    <hr>

    <table>
        <thead>
            <tr>
                <th>Ref</th>
                <th>Descrição</th>
                <th>Valor</th>
                <th>Observação</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $sqlDescontos = "
                    SELECT 
                        inc.ref,
                        inc.nomeincof,
                        inc.valor,
                        pos.observacao
                    FROM inconf inc
                    LEFT JOIN pos_cadastroconf pos ON pos.nomeconf = inc.conc
                    INNER JOIN pre_nconformidade pre ON pre.idpre = pos.idplano
                    WHERE pos.ncativo = 's' AND pos.vlrcobrado = 's' AND pre.idpre = :idpre
                ";
                $sqlDes = $conect->prepare($sqlDescontos);
                $sqlDes->bindParam(':idpre', $_POST['numerodaauditoria']);
                $sqlDes->execute();
                $captarDescontos = $sqlDes->fetchAll();

                foreach ($captarDescontos as $row) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row[0]) . '</td>';
                    echo '<td>' . htmlspecialchars($row[1]) . '</td>';
                    echo '<td>' . number_format($row[2], 2, ',', '.') . '</td>';
                    echo '<td>' . htmlspecialchars($row[3]) . '</td>';
                    echo '</tr>';
                }
            ?>
        </tbody>
    </table>
    <br><br>
    <h3>Não conformidades (Sem Observações)</h3>
    <hr>

    <table>
        <thead>
            <tr>
                <th>Ref</th>
                <th>Descrição</th>
                <th>Valor</th>
                <th>Observação</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $sqlDescontos = "
                    SELECT 
                        inc.ref,
                        inc.nomeincof,
                        inc.valor,
                        pos.observacao
                    FROM inconf inc
                    LEFT JOIN pos_cadastroconf pos ON pos.nomeconf = inc.conc
                    INNER JOIN pre_nconformidade pre ON pre.idpre = pos.idplano
                    WHERE pos.ncativo = 's' AND pos.vlrcobrado = 'n' AND pre.idpre = :idpre
                ";
                $sqlDes = $conect->prepare($sqlDescontos);
                $sqlDes->bindParam(':idpre', $_POST['numerodaauditoria']);
                $sqlDes->execute();
                $captarDescontos = $sqlDes->fetchAll();

                foreach ($captarDescontos as $row) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row[0]) . '</td>';
                    echo '<td>' . htmlspecialchars($row[1]) . '</td>';
                    echo '<td>' . number_format($row[2], 2, ',', '.') . '</td>';
                    echo '<td>' . htmlspecialchars($row[3]) . '</td>';
                    echo '</tr>';
                }
            ?>
        </tbody>
    </table>

    <br><br><hr>
    <p><strong>Orientação:</strong> Favor, senhor(a) gerente, leia atentamente o conteúdo deste relatório antes de assinar. A sua assinatura indica ciência e concordância com as informações aqui apresentadas.</p>

    <br><br><br>
    <table style="width:100%; margin-top:40px; text-align:center; border: none;">
        <tr>
            <td style="width: 50%;">
                _________________________________________<br>
                <?php echo htmlspecialchars($captarAuditoria[4]); ?><br>
                <strong>Gerente Responsável</strong>
            </td>
            <td style="width: 50%;">
                _________________________________________<br>
                <?php echo htmlspecialchars($captarAuditoria[1]); ?><br>
                <strong>Auditor 1</strong>
            </td>
        </tr>
    </table>

</body>
</html>
<?php
$html = ob_get_clean();
$pdf->loadHtml($html);
$pdf->setPaper('A4');
$pdf->render();
$pdf->stream($captarAuditoria[6].$captarAuditoria[5].'.pdf',['Attachment'=>false]);

?>
