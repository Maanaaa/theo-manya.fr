<?php
include("config/configuration.php");
include("scripts/connection.php");


// Projets
$requete = 'SELECT id_projet, titre, description, date, image, lien FROM Projets';
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
?>
<!DOCTYPE html>
<html>
<head>
    <title>Théo Manya - Portfolio</title>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <header class="flex horizontal-center vertical-center">
        <nav>
            <h2>MANYA Théo</h2>
            <ul class="flex">
                <li><a href="#projets">Projets</a></li>
                <li><a href="#skills">Compétences</a></li>
                <li><a href="#experiences">Expériences</a></li>
            </ul>
        </nav>
    </header>
    <main class="spaceTop">
    <div class="intro">
        <img src="img/header.png" alt="Portfolio de Manya Théo, SAE203. Image principale du header.">
        <h1>Mon Portfolio</h1>
    </div>
    <section id="projets"  class="spaceTop">
        <h2>Mes projets</h2>
        <?php foreach ($tabProjets as $projet): ?>
            <?php
            // Récupérer les compétences pour ce projet
            $requete_competences = 'SELECT c.titre FROM ProjetCompetences pc JOIN Competences c ON pc.id_competence = c.id_competence WHERE pc.id_projet = :id_projet';
            $resultats_competences = $connection->prepare($requete_competences);
            $resultats_competences->bindParam(':id_projet', $projet['id_projet']);
            $resultats_competences->execute();
            $tabProjetsCompetences = $resultats_competences->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <div class="card spaceTop">
                <p class="skill">
                    <?php foreach ($tabProjetsCompetences as $competence): ?>
                        <?php echo $competence['titre'] . ' '; ?>
                    <?php endforeach; ?>
                </p>
                <img src="<?php echo $projet['image']; ?>" alt="Portfolio de Manya Théo, SAE203.">
                <div class="bottom">
                    <p><?php echo $projet['titre']; ?></p>
                    <p><?php echo $projet['date']; ?></p>
                </div>
                <a href="<?php echo $projet["lien"] ?>" target="_blank">En savoir plus</a>
            </div>
        <?php endforeach; ?>
    </section>
    <section id="skills" class="spaceTop">
        <h2>Mes compétences</h2>
        <div class="skills spaceTop">
            <?php foreach ($tabSkills as $skill): ?>
            <div class="skill flex">
                <p><?php echo $skill["titre"]?></p>
                <progress max="100" value="<?php echo $skill["maitrise"]?>"><?php echo $skill["maitrise"]?></progress>
                <label for=""><?php echo " ".$skill["maitrise"]?>%</label>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section id="experiences" class="spaceTop flex">
        <div class="left">
            <?php foreach($tabXp as $xp): ?>
                <?php
                // Compétence pour cet expérience
                $requete_xp_competences = 'SELECT c.titre FROM ExperiencesCompetences ec JOIN Competences c ON ec.id_competence = c.id_competence WHERE ec.id_experience = :id_experience';
                $resultats_xp_competences = $connection->prepare($requete_xp_competences);
                $resultats_xp_competences->bindParam(':id_experience', $xp['id_experience']);
                $resultats_xp_competences->execute();
                $tabXpCompetences = $resultats_xp_competences->fetchAll(PDO::FETCH_ASSOC);
                ?>
            <li>
                <p><?php echo $xp["poste"] ?> - <?php echo $xp["entreprise"] ?>
                    <?php ?><?php
                    if(isset($xp["fin"])){
                        echo "(". $xp["debut"] . " - ". $xp["fin"] . ")";
                    }
                    else{
                        echo "(". $xp["debut"] .")";
                    }
                    ?>
                <p class="skill"><?php echo $competence["titre"] ?></p>
            </li>
            <?php endforeach ?>
        </div>
        <div class="right">
            <img src="img/xp_illustr.png" alt="Portfolio de Manya Théo, SAE203. Image d'illustration de la section expériences.">
        </div>
    </section>
    </main>
</body>
</html>