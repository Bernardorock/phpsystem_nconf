<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Relatório</title>
  <style>
    * {
      box-sizing: border-box;
    }
    body {
      font-family: Arial, sans-serif;
      background: #f4f6f9;
      margin: 0;
      padding: 20px;
    }
    h2 {
      text-align: center;
      color: #2c3e50;
      margin-bottom: 30px;
    }
    .container {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 20px;
    }
    .form-busca, .form-pdf, .resultado {
      background: #ffffff;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .form-busca {
      flex: 1;
      max-width: 250px;
    }
    .resultado {
      flex: 2;
      min-height: 200px;
    }
    .form-pdf {
      flex: 1;
      max-width: 200px;
      text-align: center;
    }
    label {
      display: block;
      margin-bottom: 10px;
      font-weight: bold;
    }
    input[type="number"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border-radius: 6px;
      border: 1px solid #ccc;
    }
    button {
      background: #3498db;
      color: white;
      padding: 10px 15px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 16px;
      width: 100%;
    }
    button:hover {
      background: #2980b9;
    }
    .subtitulo {
      font-size: 18px;
      margin-top: 20px;
      font-weight: bold;
      color: #34495e;
    }
    .resultado p {
      margin: 10px 0;
      font-size: 16px;
    }
  </style>
</head>
<body>
  <h1>Relatório</h1>
  
  <div class="container">
    
    <!-- Formulário de busca (esquerda) -->
    <form class="form-busca" method="GET">
      <label for="numerodaauditoria">Nº da Auditoria</label>
      <input type="number" id="numerodaauditoria" name="numerodaauditoria" required placeholder="Digite o número">
      <button type="submit">Buscar</button>
      <a href="menu.php">Menu</a>
    </form>

    <!-- Resultado (centro) -->
    <div class="resultado">
      <?php
        require __DIR__ .'/../vendor/autoload.php';
        use App\controller\Pdf;
        include '../conect.php';

        define('notamaxima', 10.00);
        $idPre = $_GET['numerodaauditoria'] ?? '';
        $prePDF = new Pdf();

        echo '<h2>'.'Resumo'. '</h2>';
        if (!empty($idPre)) {
          $prePDF->listarCabecario($idPre);

          echo '<p><strong>Nota Inicial:</strong> ' . notamaxima . '</p>';
          echo '<p><strong>Nota da Auditoria:</strong> ' . $prePDF->nota($idPre) . '</p>';
          echo '<p><strong>Resultado Final:</strong> ' . (notamaxima - $prePDF->nota($idPre)) . '</p>';

          echo '<p class="subtitulo">Não conformidades com Observações:</p>';
          $prePDF->listarComDesconto($idPre);

          echo '<p class="subtitulo">Não conformidades sem Observações:</p>';
          $prePDF->listarSemDesconto($idPre);
        } else {
          echo '<p>Digite o número da auditoria para ver o resultado.</p>';
        }
      ?>
    </div>

    <!-- Botão PDF (direita) -->
    <form class="form-pdf" method="POST" action="gerarPdf.php">
      <input type="hidden" name="numerodaauditoria" value="<?= htmlspecialchars($idPre) ?>">
      <button type="submit">Gerar PDF</button>
    </form>

  </div>
</body>
</html>
