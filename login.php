<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }

// Si déjà connecté -> direction dashboard
if (!empty($_SESSION['authenticated'])) {
    header('Location: ./dashboard.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Connexion Dashboard — Théo Manya</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5.3 (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Petite touche perso optionnelle -->
    <style>
      body{background:#121212;color:#e6e6e6;min-height:100vh;display:flex;align-items:center;justify-content:center;}
      .auth-card{background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.12);border-radius:16px;box-shadow:0 20px 60px rgba(0,0,0,.35);}
      .brand{font-family: "Clash Display", system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial, "Noto Sans", "Liberation Sans", sans-serif, "Apple Color Emoji","Segoe UI Emoji";}
      .brand span{color:#ff2e88;}
      .form-control{background:#1a1a1a;border-color:#2a2a2a;color:#fff;}
      .form-control:focus{background:#1a1a1a;border-color:#ff2e88;box-shadow:0 0 0 .2rem rgba(255,46,136,.15);}
      .btn-primary{background:linear-gradient(180deg,#ff4b9a,#d81c6e);border:none;}
      .btn-primary:hover{filter:brightness(1.05);}
      .small-muted{color:#9aa0a6;}
    </style>
</head>
<body>

  <main class="container" role="main" aria-labelledby="titre-page">
    <div class="row justify-content-center">
      <div class="col-12 col-md-6 col-lg-4">

        <div class="auth-card p-4 p-md-5">
          <h1 id="titre-page" class="h4 text-center brand mb-4">Théo <span>MANYA</span></h1>
          <h2 class="h5 text-center mb-3">Accès au dashboard</h2>
          <p class="small text-center small-muted mb-4">
            Entre le <strong>code à 4 caractères</strong> pour continuer.
          </p>


          <!-- Le formulaire poste vers scripts/auth.php (qui vérifie et redirige) -->
          <form action="scripts/auth.php" method="post" class="needs-validation" novalidate>
            <div class="mb-3">
              <label for="code" class="form-label">Code d'accès</label>
              <input
                type="text"
                id="code"
                name="code"
                class="form-control <?php echo $erreur ? 'is-invalid' : ''; ?>"
                placeholder="Ex : A7bC"
                inputmode="text"
                pattern="[A-Za-z0-9]{4}"
                maxlength="4"
                required
                aria-describedby="codeHelp">
              <div id="codeHelp" class="form-text small-muted">
                4 caractères (chiffres ou lettres, majuscules/minuscules).
              </div>
              <div class="invalid-feedback">
                Saisis 4 caractères valides (A–Z, a–z, 0–9).
              </div>
            </div>

            <button type="submit" class="btn btn-primary w-100">
              Se connecter
            </button>
          </form>
        </div>

      </div>
    </div>
  </main>

  <!-- Bootstrap JS (optionnel pour la validation visuelle custom) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Validation côté client (Bootstrap) -->
  <script>
  (function () {
    'use strict';
    const forms = document.querySelectorAll('.needs-validation');
    Array.from(forms).forEach(form => {
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });

    // Qualité de vie: auto-uppercase visuel sans modifier la valeur côté serveur
    const code = document.getElementById('code');
    if (code) {
      code.addEventListener('input', () => {
        code.value = code.value.replace(/[^A-Za-z0-9]/g,'').slice(0,4);
      });
    }
  })();
  </script>
</body>
</html>
