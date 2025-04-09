<?php
include("config/configuration.php");
include("scripts/connection.php");

if (isset($_GET['id_experience'])) {
    $id_experience = $_GET['id_experience'];

    $requete = 'SELECT * FROM Experience WHERE id_experience = :id_experience';
    $resultats = $connection->prepare($requete);
    $resultats->bindParam(':id_experience', $id_experience, PDO::PARAM_INT);
    $resultats->execute();

    $experience = $resultats->fetch(PDO::FETCH_ASSOC);

    if ($experience) {
        $requete = 'SELECT id_competence, titre FROM Competences';
        $resultats = $connection->query($requete);
        $tabCompetences = $resultats->fetchAll(PDO::FETCH_ASSOC);
        $resultats->closeCursor();
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Mettre à jour une expérience</title>
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
<?php include("components/dashboardHeader.php") ?>
<form action="scripts/updateXp.php" method="post">
    <fieldset>
        <input type="hidden" name="id_experience" value="<?php echo $experience['id_experience']; ?>">
        <legend>Mettre à jour une expérience</legend>
        <label for="poste">Poste occupé*</label>
        <input type="text" name="poste" id="poste" required value="<?php echo htmlspecialchars($experience['poste']); ?>">
        <label for="entreprise">Entreprise*</label>
        <input type="text" name="entreprise" required value="<?php echo htmlspecialchars($experience['entreprise']); ?>">
        <label for="debut">Année de début*</label>
        <input type="number" min="0" max="2025" name="debut" required value="<?php echo htmlspecialchars($experience['debut']); ?>">
        <label for="fin">Année de fin</label>
        <input type="number" name="fin" value="<?php echo htmlspecialchars($experience['fin']); ?>">
        <label for="id_competence">Compétence associée</label>
        <select name="id_competence" id="competence">
            <option value="none">Aucune compétence associée</option>
            <?php foreach ($tabCompetences as $competence) : ?>
                <option value="<?php echo $competence['id_competence']; ?>"
                    <?php if ($experience['id_competence'] == $competence['id_competence']) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($competence['titre']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Mettre à jour</button>
    </fieldset>
</form>
</body>
</html>
