<?php
include("config/configuration.php");
include("scripts/connection.php");

// Vérifiez que l'ID du projet est défini et est un nombre entier
if (isset($_GET['id_projet']) && is_numeric($_GET['id_projet'])) {
    $id_projet = $_GET['id_projet'];

    // Requête préparée pour récupérer les données du projet
    $requete = 'SELECT * FROM Projets WHERE id_projet = :id_projet';
    $stmt = $connection->prepare($requete);
    $stmt->bindParam(':id_projet', $id_projet, PDO::PARAM_INT);
    $stmt->execute();
    $projet = $stmt->fetch(PDO::FETCH_ASSOC);

    // Requête pour récupérer les compétences
    $requete = 'SELECT id_competence, titre FROM Competences';
    $resultats = $connection->query($requete);
    $tabCompetences = $resultats->fetchAll(PDO::FETCH_ASSOC);
    $resultats->closeCursor();
} else {
    echo "ID de projet invalide.";
    exit;
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
<form action="scripts/updateProjet.php" enctype="multipart/form-data" method="post" class="spaceTop">
    <fieldset>
        <legend>Mettre à jour un projet</legend>
        <div class="form-champs spaceTop">
            <label for="titre">Titre du projet</label>
            <input type="text" id="titre" name="titre" value="<?php echo isset($projet['titre']) ? $projet['titre'] : ''; ?>" required>
            <label for="description">Description</label>
            <textarea name="description" required><?php echo isset($projet['description']) ? $projet['description'] : ''; ?></textarea>
            <label for="date">Année du projet</label>
            <input type="number" id="date" name="date" value="<?php echo isset($projet['date']) ? $projet['date'] : ''; ?>">
            <label for="image">Image</label>
            <img src="<?php echo $projet['image'] ?>" width="35%" height="35%" alt="">
            <input type="file" id="image" name="image">
            <input type="hidden" name="current_image" value="<?php echo $projet['image']; ?>"> <!-- permet de récupérer l'image actuelle, pour pas l'update dans updateProjet -->
            <label for="competence">Compétence liée</label>
            <select name="competence" id="competence">
                <option value="none">Aucune compétence associée</option>
                <?php foreach ($tabCompetences as $competence) : ?>
                    <option value="<?php echo $competence['id_competence']; ?>"
                        <?php if (isset($projet['competence']) && $competence['id_competence'] == $projet['competence']) echo 'selected'; ?>>
                        <?php echo $competence['titre']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <label for="lien">Lien vers le projet</label>
            <input type="text" name="lien" value="<?php echo isset($projet['lien']) ? $projet['lien'] : ''; ?>" placeholder="www.github.com/Maanaa">
            <input type="hidden" name="id_projet" value="<?php echo $id_projet; ?>">
            <input type="submit" value="Mettre à jour le projet" class="btn warning">
        </div>
    </fieldset>
</form>
</body>
</html>
