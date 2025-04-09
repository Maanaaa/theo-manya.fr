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
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mettre à jour une compétence</title>
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
<?php include("components/dashboardHeader.php")?>
<form action="scripts/updateSkill.php" method="post">
    <fieldset>
        <input type="hidden" id="id_competence" name="id_competence" value="<?php echo $competence["id_competence"]; ?>">
        <legend>Ajouter une compétence</legend>
        <label for="titre">Titre de la compétence</label>
        <input type="text" name="titre" placeholder="HTML / CSS / Javascript" required value="<?php echo $competence['titre'] ?>">
        <label for="maitrise">Niveau de maîtrise (%)</label>
        <input type="number" name="maitrise" min="0" max="100" value="<?php echo $competence['maitrise'] ?>">
        <button type="submit">Mettre à jour</button>
    </fieldset>
</form>
</body>
</html>
