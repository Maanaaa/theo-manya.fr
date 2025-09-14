<?php
include("config/configuration.php");
include("scripts/connection.php");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Ajouter une compétence</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body class="bg-light">
<?php include("components/dashboardHeader.php") ?>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header"><h1 class="h5 mb-0">Ajouter une compétence</h1></div>
                <div class="card-body">
                    <form action="scripts/addSkill.php" method="post" class="row g-3">
                        <div class="col-12">
                            <label for="titre" class="form-label">Titre de la compétence</label>
                            <input type="text" id="titre" name="titre" class="form-control" placeholder="HTML / CSS / Javascript" required>
                        </div>
                        <div class="col-12">
                            <label for="maitrise" class="form-label">Niveau de maîtrise (%)</label>
                            <input type="number" id="maitrise" name="maitrise" class="form-control" min="0" max="100">
                        </div>
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-primary">Ajouter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
