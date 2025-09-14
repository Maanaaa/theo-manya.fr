<?php
include("config/configuration.php");
include("scripts/connection.php");

if (isset($_GET['id_projet'])) {
    $id_projet = $_GET['id_projet'];
    $requete = 'SELECT * FROM Projets WHERE id_projet = :id_projet';
    $resultats = $connection->prepare($requete);
    $resultats->bindParam(':id_projet', $id_projet, PDO::PARAM_INT);
    $resultats->execute();
    $projet = $resultats->fetch(PDO::FETCH_ASSOC);
    $requete = 'SELECT id_competence, titre FROM Competences';
    $resultats = $connection->query($requete);
    $tabCompetences = $resultats->fetchAll(PDO::FETCH_ASSOC);
    $resultats->closeCursor();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Mettre à jour un projet</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body class="bg-light">
<?php include("components/dashboardHeader.php"); ?>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card shadow-sm">
                <div class="card-header"><h1 class="h5 mb-0">Mettre à jour un projet</h1></div>
                <div class="card-body">
                    <form action="scripts/updateProject.php" enctype="multipart/form-data" method="post" class="row g-3">
                        <input type="hidden" name="id_projet" value="<?php echo $projet['id_projet']; ?>">
                        <div class="col-12">
                            <label for="titre" class="form-label">Titre du projet</label>
                            <input type="text" id="titre" name="titre" class="form-control" value="<?php echo $projet['titre']; ?>" required>
                        </div>
                        <div class="col-12">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="6" required><?php echo $projet['description']; ?></textarea>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="date" class="form-label">Année du projet</label>
                            <input type="number" id="date" name="date" class="form-control" value="<?php echo $projet['date']; ?>">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" id="image" name="image" class="form-control">
                            <input type="hidden" name="current_image" value="<?php echo $projet['image']; ?>">
                        </div>
                        <div class="col-12">
                            <img src="<?php echo $projet['image']; ?>" alt="Image du projet" class="img-fluid rounded border mt-2">
                        </div>
                        <div class="col-12">
                            <label for="competence" class="form-label">Compétence liée</label>
                            <select name="id_competence" id="competence" class="form-select">
                                <option value="none">Aucune compétence associée</option>
                                <?php foreach ($tabCompetences as $competence) : ?>
                                    <option value="<?php echo $competence['id_competence']; ?>" <?php if ($projet['id_competence'] == $competence['id_competence']) echo 'selected'; ?>>
                                        <?php echo $competence['titre']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="lien" class="form-label">Lien vers le projet</label>
                            <input type="text" name="lien" class="form-control" value="<?php echo $projet['lien']; ?>" placeholder="www.github.com/Maanaa">
                        </div>
                        <div class="col-12 text-end">
                            <input type="submit" value="Mettre à jour le projet" class="btn btn-primary">
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
