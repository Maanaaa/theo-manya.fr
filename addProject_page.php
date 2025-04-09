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
    <title>Ajouter un projet</title>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/dashboard.css">
    <!-- RTE stylesheets -->
    <link rel="stylesheet" href="richtexteditor/rte_theme_default.css" />
</head>
<body>
<?php include("components/dashboardHeader.php"); ?>
<form action="scripts/addProject.php" enctype="multipart/form-data" method="post">
    <fieldset>
        <legend>Ajouter un projet</legend>
        <div class="form-champs spaceTop">
            <label for="titre">Titre du projet</label>
            <input type="text" id="titre" name="titre" placeholder="Création d'une application de QrCode" required>
            <label for="description">Description</label>
            <textarea name="description" required></textarea>
            <label for="date">Année du projet</label>
            <input type="number" id="date" name="date">
            <label for="image">Image</label>
            <input type="file" id="image" name="image" required>
            <label for="competence">Compétence liée</label>
            <select name="id_competence" id="competence">
                <option value="none">Aucune compétence associée</option>
                <?php foreach ($tabCompetences as $competence) :?>
                    <option value="<?php echo($competence['id_competence']); ?>"><?php echo($competence['titre']);?></option>
                <?php endforeach;?>
            </select>
            <label for="lien">Lien vers le projet</label>
            <input type="text" name="lien" placeholder="www.github.com/Maanaa">
            <input type="submit" value="Ajouter le projet" class="btn warning">
        </div>
    </fieldset>
</form>
<!-- Include the RTE libraries -->
<script type="text/javascript" src="richtexteditor/rte.js"></script>
<script type="text/javascript" src='richtexteditor/plugins/all_plugins.js'></script>
<script>
    var editor1cfg = {}
    editor1cfg.toolbar = "basic";
    var editor1 = new RichTextEditor("#zoneediteur", editor1cfg);
</script>
</body>
</html>
