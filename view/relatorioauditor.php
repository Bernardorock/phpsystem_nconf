<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Auditores</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff8f0;
            color: #333;
            padding: 30px;
        }

        h3 {
            color: #d96f32;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        form {
            background-color: #fff3e0;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
            max-width: 500px;
        }

        label {
            display: block;
            margin-top: 10px;
            color: #d96f32;
            font-weight: bold;
        }

        input, select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        button {
            background-color: #ffa64d;
            border: none;
            padding: 10px 15px;
            margin-top: 15px;
            color: white;
            font-weight: bold;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #e68a00;
        }

        .resultado {
            margin-top: 30px;
            background-color: #fff3e0;
            padding: 20px;
            border-radius: 8px;
        }

        .resultado p {
            margin: 5px 0;
        }
    </style>
</head>
<body>

    <h3>Relatório de Auditores</h3>
    <a href="menu.php">Menu</a>

    <form method="GET">
        <label for="datainicial">Data Inicial</label>
        <input type="date" name="datainicial" required>

        <label for="datafinal">Data Final</label>
        <input type="date" name="datafinal" required>

        <label for="auditor">Auditor</label>
        <select name="auditor" required>
            <option value="">-- Selecione --</option>
            <?php
                include '../conect.php';
                $ListarAuditor = $conect->prepare('SELECT nomeauditor FROM auditor');
                $ListarAuditor->execute();
                foreach($ListarAuditor as $listarAudi) {
                    echo '<option value="' . htmlspecialchars($listarAudi[0]) . '">' . htmlspecialchars($listarAudi[0]) . '</option>';
                }
            ?>
        </select>

        <button type="submit">Buscar</button>
    </form>

    <?php
        include '../conect.php';
        require __DIR__ . '/../vendor/autoload.php';
        use App\controller\Relatorioauditor;

        $contarAud = new Relatorioauditor();

        $auditor = $_GET['auditor'] ?? '';
        $dataInicial = $_GET['datainicial'] ?? '';
        $dataFinal = $_GET['datafinal'] ?? '';

        if ($auditor && $dataInicial && $dataFinal) {
            echo '<div class="resultado">';
            echo '<p><strong>Quantidades de Auditorias:</strong> ' . $contarAud->quantidadeAuditdas($dataInicial, $dataFinal, $auditor) . '</p>';
            echo '<p><strong>Dias em lojas:</strong> ' . $contarAud->diasLojas($dataInicial, $dataFinal, $auditor) . '</p>';
            echo '<p><strong>Média dias por auditoria:</strong> ' . $contarAud->mediaDias($dataInicial, $dataFinal, $auditor) . '</p>';
            echo '<p><strong>Lista de auditorias do período selecionado:</strong></p>';
            $contarAud->listarAuditoriaPeriodo($dataInicial, $dataFinal, $auditor);
            echo '</div>';
        } else {
            echo '<p style="margin-top: 20px; color: #999;">Aguardando preenchimento dos filtros...</p>';
        }
    ?>

</body>
</html>
