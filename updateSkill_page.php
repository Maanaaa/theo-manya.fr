<?php
include("config/configuration.php");
include("scripts/connection.php");

if(isset($_GET['id_competence'])){
    $id_competence = $_GET["id_competence"];
    $requete = 'SELECT * FROM Competences WHERE id_competence = :id_competence';
    $resultats = $connection->prepare($requete);
    $resultats->bindParam(':id_competence', $id_competence, PDO::PARAM_INT);
    $resultats->execute();
    $competence = $resultats->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mettre à jour une compétence</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body class="bg-light">
<?php include("components/dashboardHeader.php")?>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header"><h1 class="h5 mb-0">Mettre à jour une compétence</h1></div>
                <div class="card-body">
                    <form action="scripts/updateSkill.php" method="post" class="row g-3">
                        <input type="hidden" id="id_competence" name="id_competence" value="<?php echo $competence["id_competence"]; ?>">
                        <div class="col-12">
                            <label for="titre" class="form-label">Titre de la compétence</label>
                            <input type="text" name="titre" id="titre" class="form-control" placeholder="HTML / CSS / Javascript" required value="<?php echo $competence['titre'] ?>">
                        </div>
                        <div class="col-12">
                            <label for="maitrise" class="form-label">Niveau de maîtrise (%)</label>
                            <input type="number" name="maitrise" id="maitrise" class="form-control" min="0" max="100" value="<?php echo $competence['maitrise'] ?>">
                        </div>
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-primary">Mettre à jour</button>
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
