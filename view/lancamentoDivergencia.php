<?php
    include '../conect.php';
    session_start();
    require __DIR__ . '/../vendor/autoload.php';
    use App\controller\Pdf;
    $cabecario = new Pdf();
    include '../conect.php';
    echo 'Usuário: ' . $_SESSION['usuario'];
    $_SESSION['idpre'] = $_GET['numerodaauditoria'] ?? '';
    
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lançamento de Divergências</title>
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

    a {
        display: inline-block;
        margin-bottom: 15px;
        text-decoration: none;
        color: #ffffff;
        font-weight: bold;
        padding: 10px 15px;
        background-color: #ffa500;
        border-radius: 5px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    a:hover {
        background-color: #FFCC80;
    }

    form {
        margin-bottom: 30px;
        background-color: #fff3e0;
        padding: 20px;
        border: 1px solid #ffa500;
        border-radius: 8px;
        max-width: 600px;
    }

    label {
        display: block;
        margin-top: 10px;
        margin-bottom: 5px;
        font-weight: bold;
    }

    input[type="number"], input[type="text"], textarea {
        padding: 10px;
        width: 100%;
        max-width: 100%;
        border: 1px solid #ccc;
        border-radius: 4px;
        background-color: #fffaf3;
        box-sizing: border-box;
        margin-bottom: 15px;
    }

    textarea {
        height: 100px;
    }

    button {
        padding: 10px 20px;
        background-color: #FFA500;
        border: none;
        border-radius: 5px;
        color: white;
        font-weight: bold;
        cursor: pointer;
        margin-top: 10px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    button:hover {
        background-color: #e69500;
    }

    p {
        font-size: 1rem;
        color: #555;
        margin-top: 20px;
    }
  </style>
</head>
<body>
  <h2>Área de Divergências</h2>
  <a href="menuEventos.php">⮌ Voltar ao Menu</a>

  <form method="get">
    <label for="numerodaauditoria">Número da Auditoria:</label>
    <input type="number" name="numerodaauditoria" value="<?=htmlspecialchars($_SESSION['idpre']);?>" id="numerodaauditoria" placeholder="Digite o número da auditoria">
    <button type="submit">Buscar</button>
  </form>

  <p><strong>Dados da Auditoria:</strong></p>
  <hr>
  <?=$cabecario->listarCabecario($_GET['numerodaauditoria'] ?? '');?>
  <hr>

  <h3>Inserir Divergências:</h3>
  <form action="#" method="post">
    <label for="codigoproduto">Código do Produto:</label>
    <input type="number" name="codigoproduto" id="codigoproduto" placeholder="Insira o número do produto" required>

    <label for="produto">Produto:</label>
    <input type="text" name="produto" id="produto" placeholder="Nome do Produto" required>

    <label for="valor">Valor:</label>
    <input type="number" name="valor" id="valor" placeholder="Valor do Item" required>

    <label for="observacao">Observação:</label>
    <textarea name="observacao" id="observacao" placeholder="Observações"></textarea>

    <button type="submit">Salvar</button>
  </form>
</body>
</html>
