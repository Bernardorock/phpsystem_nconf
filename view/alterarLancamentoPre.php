<?php
    session_start();
    include '../conect.php';
    echo '<strong>'.' <i class="bi bi-person-circle"></i> Usuário: ' . $_SESSION['usuario'].'</strong>';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alteração Auditoria</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: white;
            color: #333;
            margin: 20px;
        }

        h3 {
            color:black;
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
            margin-top: 10px;
            margin-bottom: 5px;
        }

        input[type="number"], select, textarea {
            padding: 8px;
            width: 100%;
            max-width: 400px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        textarea {
            height: 80px;
        }

        .form-check {
            margin: 5px 0;
        }

        .form-check-input {
            margin-right: 5px;
        }

        button, a {
    padding: 10px 15px;
    background-color: #ffa500; /* mesma cor usada nas bordas e cabeçalho da tabela */
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
            margin-top: 20px;
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
        .form-check {
    display: flex;
    align-items: center;
    margin-top: 10px;
    }

    .form-check-input[type="checkbox"] {
    width: 18px;
    height: 18px;
    margin-right: 8px;
    accent-color: #FFA500;
    }

    </style>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

</head>
<body>
    <h3>Área de alteração</h3>
    <a href="menu.php">⮌ Voltar ao Menu</a>

    <form method="GET">
        <label for="idpre">Favor, inserir o número da auditoria:</label>
        <input type="number" name="idpre" id="idpre" placeholder="Número da Auditoria" required>
        <button type="submit">Buscar</button>
    </form>

    <h3>Lista de auditorias ativas:</h3>
    <table>
        <thead>
            <tr>
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
                $idPre = $_GET['idpre'] ?? '';
                $listaPendenteNc = $conect->prepare("
                    SELECT 
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
                    WHERE audativa = 's' AND pre.idpre = :idpre
                ");
                $listaPendenteNc->bindParam(':idpre', $idPre);
                $listaPendenteNc->execute();

                foreach ($listaPendenteNc as $row) {
                    echo "<tr>
                            <td>{$row[0]}</td>
                            <td>{$row[1]}</td>
                            <td>{$row[2]}</td>
                            <td>{$row[3]}</td>
                            <td>{$row[4]}</td>
                            <td>{$row[5]}</td>
                            <td>{$row[6]}</td>
                            <td>{$row[7]}</td>
                        </tr>";
                }
            ?>
        </tbody>
    </table>

    <h3>Listagem Não Conformidades</h3>
    <form method="POST" action="../processamento/alterarPos.php">
        <label for="ocorrencia">Ocorrência:</label>
        <input type="number" name="ocorrencia" id="ocorrencia" required>

        <label for="inconformidades">Não Conformes:</label>
        <select name="inconformidades" id="inconformidades">
            <option value="">Selecione</option>
            <?php
                $listaInconf = $conect->query('SELECT conc AS descricao FROM inconf');
                foreach($listaInconf as $item) {
                    echo "<option>" . htmlspecialchars($item['descricao']) . "</option>";
                }
1            ?>
        </select>

        <label>Depende do Gerente?</label>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="cobrarnota" id="cobrarnotaSim" value="s">
            <label for="cobrarnotaSim">Sim</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="cobrarnota" id="cobrarnotaNao" value="n">
            <label for="cobrarnotaNao">Não</label>
        </div>

        <label for="observacao">Observação:</label>
        <textarea name="observacao" id="observacao"></textarea>
        <?= $_SESSION['idpre'] = $_GET['idpre'] ?? '' ?>
        
        <div class="form-check">
             <input class="form-check-input" type="checkbox" id="desativarOcorrencia" name="desativar" value="1">
             <label for="desativarOcorrencia">Desativar Ocorrência</label>
        </div>


        <button type="submit">Alterar</button>
        <a href="incluirPos.php">Inserir</a>
        <a href="excluirAuditoria.php">Excluir</a>
    </form>

    <h3>Não Conformidades Cadastradas</h3>
    <table>
        <thead>
            <tr>
                <th>Ocorrência</th>
                <th>Descrição</th>
                <th>Depende do Gerente</th>
                <th>Observação</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $listarPosConformidades = $conect->prepare("
                    SELECT 
                        idpos,
                        nomeconf,
                        vlrcobrado,
                        observacao
                    FROM pos_cadastroconf 
                    WHERE idplano = :idpre AND ncativo = 's'
                ");
                $listarPosConformidades->bindParam(':idpre', $idPre);
                $listarPosConformidades->execute();

                foreach ($listarPosConformidades as $valor) {
                    echo "<tr>
                            <td>{$valor[0]}</td>
                            <td>{$valor[1]}</td>
                            <td>{$valor[2]}</td>
                            <td>{$valor[3]}</td>
                        </tr>";
                }
            ?>
        </tbody>
    </table>
</body>
</html>
