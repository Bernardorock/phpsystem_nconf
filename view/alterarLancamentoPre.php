<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alteração Auditoria</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fffaf0;
            color: #333;
            margin: 20px;
        }

        h3 {
            color: #FFA500;
        }

        a {
            display: inline-block;
            margin-bottom: 15px;
            text-decoration: none;
            color: #FFA500;
            font-weight: bold;
        }

        form {
            margin-bottom: 30px;
            background-color: #fff3e0;
            padding: 15px;
            border: 1px solid #ffa500;
            border-radius: 8px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input[type="number"] {
            padding: 8px;
            width: 250px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 10px 15px;
            background-color: #FFA500;
            border: none;
            border-radius: 5px;
            color: white;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background-color: #e69500;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #ffa500;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #ffe0b3;
        }
    </style>
</head>
<body>
    <h3>Área de alteração</h3>
    <a href="menu.php">⮌ Voltar ao Menu</a>
    <form method="GET" action="/../processamento/processarInativarPre.php">
        <label for="idpre">Favor, inserir o número da auditoria:</label>
        <input type="number" name="idpre" id="idpre" placeholder="Número da Auditoria" required>
        <button type="submit">Inativar</button>
    </form>

    <h3>Lista de auditorias ativas:</h3>
    <table>
        <thead>
            <tr>
                <th>Nº PL</th>
                <th>Nº AUDITORIA</th>
                <th>Dt Inicial</th>
                <th>Dt Final</th>
                <th>Auditor 1</th>
                <th>Auditor 2</th>
                <th>Auditor 3</th>
                <th>Empresa</th>
                <th>Gerente</th>
            </tr>
        </thead>
        <tbody>
            <?php
                include '../conect.php';
                $listaPendenteNc = $conect->query("
                    SELECT 
                        pl.idplano,
                        pre.idpre,
                        pre.dtinicial,
                        pre.dtfinal,
                        aud.nomeauditor,
                        auds.nomeauditor,
                        audt.nomeauditor,
                        emp.nomeempresa,
                        ger.nomegerente
                    FROM pre_nconformidade pre
                    LEFT JOIN auditor aud ON aud.idauditor = pre.id_auditorpri
                    LEFT JOIN auditor auds ON auds.idauditor = pre.id_auditorsec
                    LEFT JOIN auditor audt ON audt.idauditor = pre.id_auditorter
                    INNER JOIN empresagerente empg ON empg.idempger = pre.idempgr
                    INNER JOIN empresa emp ON emp.idempresa = empg.id_empresa
                    INNER JOIN gerente ger ON ger.idgerente = empg.id_gerente
                    INNER JOIN planodeacao pl ON pl.idplano = pre.idplano
                    WHERE audativa = 's'
                ");

                foreach($listaPendenteNc as $row) {
                    echo "<tr>
                            <td>{$row[0]}</td>
                            <td>{$row[1]}</td>
                            <td>{$row[2]}</td>
                            <td>{$row[3]}</td>
                            <td>{$row[4]}</td>
                            <td>{$row[5]}</td>
                            <td>{$row[6]}</td>
                            <td>{$row[7]}</td>
                            <td>{$row[8]}</td>
                        </tr>";
                }
            ?>
        </tbody>
    </table>
</body>
</html>
