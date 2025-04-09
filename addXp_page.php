<?php
include("config/configuration.php");
include("scripts/connection.php");

$requete = 'SELECT id_competence, titre FROM Competences';
$resultats = $connection->query($requete);
$tabCompetences = $resultats->fetchAll(PDO::FETCH_ASSOC);
$resultats->closeCursor();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ajouter une expérience</title>
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
<?php include("components/dashboardHeader.php") ?>
<form action="scripts/addXp.php" method="post">
    <fieldset>
        <legend>Ajouter une expérience</legend>
        <label for="poste">Poste occupé*</label>
        <input type="text" name="poste" id="poste" required>
        <label for="entreprise">Entreprise*</label>
        <input type="text" name="entreprise" required>
        <label for="debut">Année de début*</label>
        <input type="number" min="0" max="2025" name="debut" required>
        <label for="fin">Année de fin</label>
        <input type="number" name="fin">
        <label for="competence">Compétence associée</label>
        <select name="id_competence" id="competence">
            <option value="none">Aucune compétence associée</option>
            <?php foreach ($tabCompetences as $competence) :?>
                <option value="<?php echo($competence['id_competence']); ?>"><?php echo($competence['titre']);?></option>
            <?php endforeach;?>
        </select>
        <button type="submit">Ajouter</button>
    </fieldset>
</form>
</body>
</html>