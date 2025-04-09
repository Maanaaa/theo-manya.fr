<?php
include("config/configuration.php");
include("scripts/connection.php");

?>

<!DOCTYPE html>
<html>
<head>
    <title>Ajouter une compétence</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
</head>
<body>
    <?php include("components/dashboardHeader.php") ?>
    <form action="scripts/addSkill.php" method="post">
        <fieldset>
            <legend>Ajouter une compétence</legend>
            <label for="titre">Titre de la compétence</label>
            <input type="text" name="titre" placeholder="HTML / CSS / Javascript" required>
            <label for="maitrise">Niveau de maîtrise (%)</label>
            <input type="number" name="maitrise" min="0" max="100">
            <button type="submit">Ajouter</button>
        </fieldset>
    </form>
</body>
</html>
