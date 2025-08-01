<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Locação Gerente</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      background: #fff8f0; /* Laranja claro suave */
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      animation: fadeIn 1s ease;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .container {
      background: #ffffff;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 0 20px rgba(255, 140, 0, 0.2);
      width: 380px;
      text-align: center;
    }

    .container h1 {
      color: #ff8c00;
      margin-bottom: 20px;
      font-size: 28px;
      font-weight: bold;
      letter-spacing: 1px;
    }

    .input-field {
      text-align: left;
      margin-bottom: 20px;
    }

    .input-field label {
      display: block;
      font-size: 14px;
      color: #333;
      margin-bottom: 5px;
    }

    .input-field input,
    .input-field select {
      width: 100%;
      padding: 10px 12px;
      border: 1px solid #ffcc99;
      border-radius: 8px;
      background-color: #fff7ee;
      font-size: 14px;
    }

    .radio-group {
      display: flex;
      justify-content: space-around;
      margin: 10px 0;
    }

    .radio-group input[type="radio"] {
      margin-right: 5px;
    }

    .radio-group label {
      font-size: 14px;
      color: #333;
      display: flex;
      align-items: center;
    }

    .button {
      background-color: #ff8c00;
      color: white;
      border: none;
      padding: 12px 20px;
      border-radius: 8px;
      cursor: pointer;
      width: 100%;
      font-size: 16px;
      transition: background-color 0.3s ease;
      margin-top: 10px;
    }

    .button:hover {
      background-color: #e67600;
    }

    /* Dark Mode opcional */
    .dark-mode {
      background: linear-gradient(135deg, #2c2c2c, #1a1a1a);
    }

    .dark-mode .container {
      background-color: #333;
      color: white;
      box-shadow: 0 8px 30px rgba(255, 255, 255, 0.15);
    }

    .dark-mode h1 {
      color: #ffa500;
    }

    .dark-mode .input-field label {
      color: #ccc;
    }

    .dark-mode .input-field input,
    .dark-mode .input-field select {
      background-color: #444;
      border: 1px solid #666;
      color: white;
    }

    .dark-mode .button {
      background-color: #ff8c00;
      color: white;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Alocar Gerente</h1>
    <form action="../processamento/processarAlocarGerente.php" method="POST" enctype="multipart/form-data">
      <div class="input-field">
        <label for="nome">Nome Gerente</label>
    <select name="nomegerente" id="nomegerente" required>
        <option></option>
        <?php
            session_start();
            include '../conect.php';
            $listarGerente = $conect->prepare('select nomegerente from gerente order by nomegerente');
            $listarGerente->execute();
            foreach($listarGerente as $valorGerente)
            {
                print_r('<option>'.$valorGerente[0].'</option>');
            }
        ?>
    </select>
    <label>Nome Empresa</label><br>
        <select name="nomeempresa" id="nomeempresa" required>
          <option></option>
        <?php
            include '../conect.php';
            $listarEmpresa = $conect->prepare('select nomeempresa from empresa order by nomeempresa');
            $listarEmpresa->execute();
            foreach($listarEmpresa as $valorEmpresa)
            {
                print_r('<option>'.$valorEmpresa[0].'</option>');
            }
        ?>
    </select>
      </div>

      <button type="submit" class="button">Alocar</button>
      <label for="retornarlogin"></label>
      <a href="menu.php">Menu</a>
    </form>
  </div>

  <!-- Script Dark Mode opcional -->
  <script>
    function toggleDarkMode() {
      document.body.classList.toggle('dark-mode');
    }
  </script>
</body>
</html>
