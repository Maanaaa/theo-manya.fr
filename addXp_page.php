<?php
include("config/configuration.php");
include("scripts/connection.php");

$requete = 'SELECT id_competence, titre FROM Competences';
$resultats = $connection->query($requete);
$tabCompetences = $resultats->fetchAll(PDO::FETCH_ASSOC);
$resultats->closeCursor();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Ajouter une expérience</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboard.min.css">
</head>
<body class="bg-light">
<?php include("components/dashboardHeader.php") ?>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card shadow-sm">
                <div class="card-header"><h1 class="h5 mb-0">Ajouter une expérience</h1></div>
                <div class="card-body">
                    <form action="scripts/addXp.php" method="post" class="row g-3">
                        <div class="col-12">
                            <label for="poste" class="form-label">Poste occupé*</label>
                            <input type="text" name="poste" id="poste" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label for="entreprise" class="form-label">Entreprise*</label>
                            <input type="text" name="entreprise" class="form-control" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="debut" class="form-label">Année de début*</label>
                            <input type="number" min="0" max="2025" name="debut" class="form-control" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="fin" class="form-label">Année de fin</label>
                            <input type="number" name="fin" class="form-control">
                        </div>
                        <div class="col-12">
                            <label for="competence" class="form-label">Compétence associée</label>
                            <select name="id_competence" id="competence" class="form-select">
                                <option value="none">Aucune compétence associée</option>
                                <?php foreach ($tabCompetences as $competence) :?>
                                    <option value="<?php echo($competence['id_competence']); ?>"><?php echo($competence['titre']);?></option>
                                <?php endforeach;?>
                            </select>
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
