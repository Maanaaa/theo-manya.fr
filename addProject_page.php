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
    <title>Ajouter un projet</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="richtexteditor/rte_theme_default.css">
</head>
<body class="bg-light">
<?php include("components/dashboardHeader.php"); ?>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header"><h1 class="h5 mb-0">Ajouter un projet</h1></div>
                <div class="card-body">
                    <form action="scripts/addProject.php" enctype="multipart/form-data" method="post" class="row g-3">
                        <div class="col-12">
                            <label for="titre" class="form-label">Titre du projet</label>
                            <input type="text" id="titre" name="titre" class="form-control" placeholder="Création d'une application de QrCode" required>
                        </div>
                        <div class="col-12">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="6" required></textarea>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="date" class="form-label">Année du projet</label>
                            <input type="number" id="date" name="date" class="form-control">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" id="image" name="image" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label for="competence" class="form-label">Compétence liée</label>
                            <select name="id_competence" id="competence" class="form-select">
                                <option value="none">Aucune compétence associée</option>
                                <?php foreach ($tabCompetences as $competence) :?>
                                    <option value="<?php echo($competence['id_competence']); ?>"><?php echo($competence['titre']);?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="lien" class="form-label">Lien vers le projet</label>
                            <input type="text" id="lien" name="lien" class="form-control" placeholder="www.github.com/Maanaa">
                        </div>
                        <div class="col-12 text-end">
                            <input type="submit" value="Ajouter le projet" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="richtexteditor/rte.js"></script>
<script src="richtexteditor/plugins/all_plugins.js"></script>
<script>
    var editor1cfg = {}
    editor1cfg.toolbar = "basic";
    var editor1 = new RichTextEditor("#zoneediteur", editor1cfg);
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
