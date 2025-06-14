<?php
session_start();
echo '<strong>'.'Usuário: ' . $_SESSION['usuario'].'</strong>';
include '../conect.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inclusão de Não Conformidades</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fffaf0;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        h2 {
            color: #FFA500;
        }

        form {
            background-color: #fff3e0;
            padding: 20px;
            border: 1px solid #FFD580;
            border-radius: 10px;
            max-width: 600px;
            margin-top: 20px;
        }

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="number"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }

        textarea {
            height: 100px;
            resize: vertical;
        }

        .form-check {
            margin-top: 10px;
        }

        .form-check-input {
            margin-right: 5px;
        }

        button {
            margin-top: 20px;
            padding: 12px 20px;
            background-color: #FFD580;
            color: #333;
            font-weight: bold;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #ffc04d;
        }
        .botao-link {
    display: inline-block;
    margin-top: 20px;
    padding: 12px 20px;
    background-color: #FFD580;
    color: #333;
    font-weight: bold;
    text-decoration: none;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.botao-link:hover {
    background-color: #ffc04d;
}

    </style>
</head>
<body>
    <h2>Inclusão de Não Conformidades</h2>

    <a href="menuEventos.php" class="botao-link">⮌ Voltar ao Menu</a>


    <form method="POST" action="/../processamento/incluirPosConf.php">
        <label for="numerodaauditoria">Número da Auditoria</label>
        <input type="number" name="numerodaauditoria" id="numerodaauditoria" value="<?=  $_SESSION['idpre'] ?>" disabled>

        <label for="inconformidades">Não Conformes:</label>
        <select name="inconformidades" id="inconformidades" required>
            <option value="">Selecione</option>
            <?php
                $listaInconf = $conect->query('SELECT conc AS descricao FROM inconf');
                foreach ($listaInconf as $item) {
                    echo "<option>" . htmlspecialchars($item['descricao']) . "</option>";
                }
            ?>
        </select>

        <label>Depende do Gerente?</label>
        <div class="form-check">
            <label for="cobrarnotaSim">Sim</label>
            <input class="form-check-input" type="radio" name="cobrarnota" id="cobrarnotaSim" value="s">
            
        </div>
        <div class="form-check">
            <label for="cobrarnotaNao">Não</label>
            <input class="form-check-input" type="radio" name="cobrarnota" id="cobrarnotaNao" value="n">
            
        </div>

        <label for="observacao">Observação:</label>
        <textarea name="observacao" id="observacao"></textarea>

        <button type="submit">Incluir</button>
    </form>
</body>
</html>
