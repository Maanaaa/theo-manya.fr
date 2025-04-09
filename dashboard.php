<?php
include("config/configuration.php");
include("scripts/connection.php");
include("scripts/fonctions.php");

// Projets
$requete = 'SELECT id_projet, titre, description FROM Projets';
$resultats = $connection->query($requete);
$tabProjets = $resultats->fetchAll(PDO::FETCH_ASSOC);
$resultats->closeCursor();

// Compétences
$requete = 'SELECT id_competence, titre, maitrise FROM Competences';
$resultats = $connection->query($requete);
$tabSkills = $resultats->fetchAll(PDO::FETCH_ASSOC);
$resultats->closeCursor();

// Expériences
$requete = 'SELECT id_experience, poste, debut, fin, entreprise FROM Experience';
$resultats = $connection->query($requete);
$tabXp = $resultats->fetchAll(PDO::FETCH_ASSOC);
$resultats->closeCursor();

// Projet - Compétences
$requete = 'SELECT c.titre FROM ProjetCompetences pc JOIN Competences c ON pc.id_competence = c.id_competence WHERE pc.id_projet = :id_projet';
$resultats = $connection->prepare($requete);
$resultats->bindParam(':id_projet', $projet['id_projet']);
$resultats->execute();
$tabProjetsCompetences = $resultats->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <?php include "components/dashboardHeader.php"; ?>
    <section id="projets" class="spaceTop">
        <div class="top flex">
            <h2><u>Projets</u></h2>
            <a href="addProject_page.php" class="btn">Ajouter un projet</a>
        </div>
        <div class="main">
            <?php foreach($tabProjets as $projet): ?>
            <div class="projet flex">
                <div class="left">
                    <h3><?php echo($projet["titre"]);?></h3>
                    <p><?php
                        echo substr($projet["description"], 0, 32) . "...";
                        ?></p>
                </div>
                <div class="right">
                    <a href="scripts/deleteData.php?table=Projets&id=<?php echo $projet["id_projet"]?>&column=id_projet" class="btn warning">Supprimer</a>
                    <a href="updateProject_page.php?id_projet=<?php echo $projet["id_projet"]?>" class="btn warning">Modifier</a>
                </div>
            </div>
        </div>
        <?php endforeach;?>
    </section>
    <section id="skills" class="spaceTop">
        <div class="top flex">
            <h2><u>Compétences</u></h2>
            <a href="addSkill_page.php" class="btn">Ajouter une compétence</a>
        </div>
        <div class="main">
            <?php foreach($tabSkills as $skill): ?>
            <div class="projet flex">
                <div class="left">
                    <h3><?php echo $skill["titre"] ?></h3>
                    <p><strong>Niveau de maîtrise :</strong> <?php echo $skill["maitrise"]?>%</p>
                </div>
                <div class="right">
                    <a href="scripts/deleteData.php?table=Competences&id=<?php echo $skill["id_competence"]?>&column=id_competence" class="btn warning">Supprimer</a>
                    <a href="updateSkill_page.php?id_competence=<?php echo $skill["id_competence"]?>"  class="btn warning">Modifier</a>
                </div>
            </div>
        </div>
        <?php endforeach;?>
    </section>
    <section id="experiences" class="spaceTop">
        <div class="top flex">
            <h2><u>Expériences</u></h2>
            <a href="addXp_page.php" class="btn">Ajouter une expérience</a>
        </div>
        <div class="main">
            <?php foreach($tabXp as $experience): ?>
            <div class="projet flex">
                <div class="left">
                    <h3><?php echo $experience["poste"]?> - <?php echo $experience["entreprise"]?></h3>
                    <p><?php echo $experience["debut"]?><?php
                        if(isset($experience["fin"])){echo " - ". $experience["fin"];}?></p>
                </div>
                <div class="right">
                    <a href="scripts/deleteData.php?table=Experience&id=<?php echo $experience["id_experience"]?>&column=id_experience" class="btn warning">Supprimer</a>
                    <a href="updateXp_page.php?id_experience=<?php echo $experience["id_experience"]?>" class="btn warning">Modifier</a>
                </div>
            </div>
        </div>
        <?php endforeach;?>
    </section>
</body>
</html>