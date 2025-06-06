<?php
    session_start();
    include '../conect.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Auditoria</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fffaf0;
            color: #333;
            margin: 20px;
        }

        h2, h3 {
            color: #FFA500;
        }

        a, button {
            display: inline-block;
            padding: 10px 15px;
            background-color: #FFA500;
            border: none;
            border-radius: 5px;
            color: white;
            font-weight: bold;
            text-decoration: none;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover, a:hover {
            background-color: #e69500;
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

        input[type="number"] {
            padding: 8px;
            width: 100%;
            max-width: 400px;
            border: 1px solid #ccc;
            border-radius: 4px;
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
    </style>
</head>
<body>
    <h2>Área de exclusão de Auditoria</h2>
    <a href='menu.php'>⮌ Voltar ao Menu</a>

    <h3>Favor, insira o número da auditoria</h3>
    <form method="POST" action="/../processamento/processarInativarPre.php">
        <label for="numeroauditoria">Número da auditoria:</label>
        <input type="number" name="numerodaauditoria" id="numeroauditoria" required value="<?= htmlspecialchars($_SESSION['idpre'] ?? '') ?>" disabled>
        <button type="submit">Excluir</button>
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
                if (!empty($_SESSION['idpre'])) {
                    $listarPosConformidades = $conect->prepare("
                        SELECT 
                            idpos,
                            nomeconf,
                            vlrcobrado,
                            observacao
                        FROM pos_cadastroconf 
                        WHERE idplano = :idpre AND ncativo = 's'
                    ");
                    $listarPosConformidades->bindParam(':idpre', $_SESSION['idpre']);
                    $listarPosConformidades->execute();

                    foreach ($listarPosConformidades as $valor) {
                        echo "<tr>
                                <td>{$valor['idpos']}</td>
                                <td>{$valor['nomeconf']}</td>
                                <td>{$valor['vlrcobrado']}</td>
                                <td>{$valor['observacao']}</td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Nenhuma auditoria selecionada.</td></tr>";
                }
            ?>
        </tbody>
    </table>
</body>
</html>
