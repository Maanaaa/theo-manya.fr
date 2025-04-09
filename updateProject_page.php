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
<html>
<head>
    <meta charset="utf-8">
    <title>Mettre à jour un projet</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<?php include("components/dashboardHeader.php"); ?>
<form action="scripts/updateProject.php" enctype="multipart/form-data" method="post">
    <fieldset>
        <legend>Mettre à jour un projet</legend>
        <input type="hidden" name="id_projet" value="<?php echo $projet['id_projet']; ?>">
        <label for="titre">Titre du projet</label>
        <input type="text" id="titre" name="titre" value="<?php echo $projet['titre']; ?>" required>
        <label for="description">Description</label>
        <textarea name="description" required><?php echo $projet['description']; ?></textarea>
        <label for="date">Année du projet</label>
        <input type="number" id="date" name="date" value="<?php echo $projet['date']; ?>">
        <label for="image">Image</label>
        <input type="file" id="image" name="image">
        <input type="hidden" name="current_image" value="<?php echo $projet['image']; ?>">
        <label for="competence">Compétence liée</label>
        <select name="id_competence" id="competence">
            <option value="none">Aucune compétence associée</option>
            <?php foreach ($tabCompetences as $competence) : ?>
                <option value="<?php echo $competence['id_competence']; ?>">
                    <?php if ($projet['id_competence'] == $competence['id_competence']) echo 'selected'; ?>>
                    <?php echo $competence['titre']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <label for="lien">Lien vers le projet</label>
        <input type="text" name="lien" value="<?php echo $projet['lien']; ?>" placeholder="www.github.com/Maanaa">
        <input type="submit" value="Mettre à jour le projet" class="btn warning">
    </fieldset>
</form>

</body>
</html>
