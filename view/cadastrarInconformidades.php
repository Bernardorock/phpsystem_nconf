

  <!DOCTYPE html>
  <html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Cadastro de Auditor</title>
    <style>
      * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      }

      body {
        background: #fff8f0;
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
        width: 350px;
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
      }

      .button:hover {
        background-color: #e67600;
      }

      /* Dark Mode (opcional para futuro) */
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
      <h1>Cadastro Setor Avaliado</h1>
      <form action="../processamento/processarCadastroInconf.php" method="POST" enctype="multipart/form-data">
        <div class="input-field">
          <div class="input-field">
              <div class="input-field">
                  <label for="nome">Setor Avaliado</label>
                  <select name='set'>
                    <?php
                    include '../conect.php';
                    $primeiraLista = $conect->query('select nomesetor from setoravaliado');
                    foreach($primeiraLista as $valor)
                    { 
                      print_r ('<option>'.$valor[0].'</option>');
                  }
                    ?>
                  </select>
                </div>
              <label for="nome">Referência</label>
              <input type="number" id="nome" name="ref" required step="0.01" placeholder="Ex: 0.0 ou 0.00">
            </div>
          <label for="nome">Nome da inconformidade</label>
          <input type="text" id="nome" name="nomeincof" required>
        </div>
      
        <div class="input-field">
          <label for="nome">Valor da Nota</label>
          <input type="number" id="nome" name="valor" required step="0.01" placeholder="Ex: 0.0 ou 0.00" lang="pt-br">
        </div>
        
        <button type="submit" class="button">Cadastrar</button>
        <a href="menu.php">Menu</a>
      </form>
    </div>

    <!-- Script de Modo Escuro (opcional, para ativar no futuro) -->
    <script>
      function toggleDarkMode() {
        document.body.classList.toggle('dark-mode');
      }
    </script>
  </body>
  </html>