<?php
include("config/configuration.php");
include("scripts/connection.php");


// Projets
$requete = 'SELECT id_projet, titre, description, date, image, lien FROM Projets ORDER BY date DESC';
$resultats = $connection->query($requete);
$tabProjets = $resultats->fetchAll(PDO::FETCH_ASSOC);
$resultats->closeCursor();

// Compétences
$requete = 'SELECT id_competence, titre, maitrise FROM Competences';
$resultats = $connection->query($requete);
$tabSkills = $resultats->fetchAll(PDO::FETCH_ASSOC);
$resultats->closeCursor();

// Expériences
$requete = 'SELECT id_experience, poste, debut, fin, entreprise FROM Experience ORDER BY fin DESC';
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap">
    <link rel="stylesheet" href="https://api.fontshare.com/v2/css?f[]=clash-display@200,400,300,500,600,700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@100;200;300;400;500;600;700;800&display=swap">
    <script src="js/typeEffect.js"></script>
    <script src="js/caroussel.js"></script>
    <script src="js/filter.js"></script>
</head>

<body>
    <header class="flex horizontal-center vertical-center">
        <nav>
            <div class="titre">
                <p>Théo <span>MANYA</span></p>
            </div>
            <ul class="flex">
                <li><a href="#projets">Projets</a></li>
                <li><a href="#skills">Compétences</a></li>
                <li><a href="#experiences">Expériences</a></li>
            </ul>
        </nav>
    </header>
    <div class="intro">
        <!---<img src="img/header.png" alt="Portfolio de Manya Théo, SAE203. Image principale du header."> !-->
        <h1 class="typingEffect"></h1>
        <div class="description spaceTop">
            <p>Passionné par le développement, le design et les interfaces modernes. Je crée des expériences digitales uniques qui allient technique et créativité.</p>
            <a href="#projets" class="spaceTop">Voir mes projets</a>
        </div>

    </div>
    <section id="projets" class="spaceTopPadding">
        <div class="description showCase">
            <p><span>Portfolio</span></p>
            <h2 class="smallSpaceTop">Mes <span>Projets</span></h2>
            <p class="smallSpaceTop">Découvrez une sélection de mes réalisations, alliant technique et créativité pour offrir des expériences digitales uniques.</p>
        </div>
        <div class="carousel-container">
            <div class="carousel spaceTop">
                <div class="decoration-haut"></div>
                <?php foreach ($tabProjets as $index => $projet): ?>
                    <?php
                    // Récupérer les compétences pour ce projet
                    $requete_competences = 'SELECT c.titre FROM ProjetCompetences pc JOIN Competences c ON pc.id_competence = c.id_competence WHERE pc.id_projet = :id_projet';
                    $resultats_competences = $connection->prepare($requete_competences);
                    $resultats_competences->bindParam(':id_projet', $projet['id_projet']);
                    $resultats_competences->execute();
                    $tabProjetsCompetences = $resultats_competences->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <div class="card">
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
                        <div class="description">
                            <p><?php echo $projet['description']; ?></p>
                        </div>
                        <?php if ($projet['lien'] != NULL): ?>
                            <a href="<?php echo $projet["lien"] ?>" target="_blank" class="more-info">En savoir plus</a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="cardNumber">
                <?php foreach ($tabProjets as $i => $projet): ?>
                    <div class="bullet"></div>
                <?php endforeach ?>
            </div>
            <div class="controlButtons">
                <button id="toggleMode">Mode Manuel</button>
                <button id="prevBtn"><</button>
                <button id="nextBtn">></button>
            </div>

        </div>
    </section>
    <section id="skills" class="spaceTop">
        <div class="description showCase">
            <p><span>Expertise</span></p>
            <h2 class="smallSpaceTop">Mes <span>Compétences</span></h2>
            <p class="smallSpaceTop">Découvrez une sélection de mes réalisations, alliant technique et créativité pour offrir des expériences digitales uniques.</p>
        </div>
        <div class="skills spaceTop">
            <?php
            $svgs = [
                '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>',
                '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5-3 3-2-2"/></svg>',
                '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-8a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2zM8 8v4M12 8v4M16 8v4"/></svg>',
                '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 3H1v20h22V3zM12 17a5 5 0 1 0 0-10 5 5 0 0 0 0 10z"/></svg>',
                '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
                '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2M3 10h18M3 6h18"/></svg>',
                '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10zM12 6v6l4 2"/></svg>',
                '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 18l6-6-6-6M8 6l-6 6 6 6"/></svg>'
            ];

            $index = 0;
            foreach ($tabSkills as $skill): ?>
                <div class="skill flex">
                    <?php echo $svgs[$index % count($svgs)]; ?>
                    <p><?php echo $skill["titre"]; ?></p>
                    <progress max="100" value="<?php echo $skill["maitrise"]; ?>"><?php echo $skill["maitrise"]; ?></progress>
                </div>
            <?php
                $index++;
            endforeach; ?>
        </div>
    </section>
    <section id="experiences" class="spaceTop flex">
        <div class="showCase">
            <h2 class="smallSpaceTop">Mes <span>Expériences</span></h2>
            <p class="smallSpaceTop">Découvrez une sélection de mes réalisations, alliant technique et créativité pour offrir des expériences digitales uniques.</p>
        </div>
        <div class="left spaceTop">
            <div class="filtre">
                <label for="ordre">Ordre d'affichage</label>
                <select name="ordre" id="order">
                    <option value="croissant">Du plus ancien au plus récent</option>
                    <option value="decroissant">Du plus récent au plus ancien</option>
                </select>
            </div>
            <div>
                <ul>
                    <?php foreach ($tabXp as $xp): ?>
                        <li>
                            <?php
                            // Compétence pour cet expérience
                            $requete_xp_competences = 'SELECT c.titre FROM ExperiencesCompetences ec JOIN Competences c ON ec.id_competence = c.id_competence WHERE ec.id_experience = :id_experience';
                            $resultats_xp_competences = $connection->prepare($requete_xp_competences);
                            $resultats_xp_competences->bindParam(':id_experience', $xp['id_experience']);
                            $resultats_xp_competences->execute();
                            $tabXpCompetences = $resultats_xp_competences->fetchAll(PDO::FETCH_ASSOC);
                            ?>

                            <p><?php echo $xp["poste"] ?> - <?php echo $xp["entreprise"] ?>
                                <?php ?><?php
                                        if (isset($xp["fin"])) {
                                            echo "<p class='date'>(" . $xp["debut"] . " - " . $xp["fin"] . ")</p>";
                                        } else {
                                            echo "(" . $xp["debut"] . " à aujourd'hui)";
                                        }
                                        ?>
                            <p></p>
                        </li>
                    <?php endforeach ?>
                </ul>
            </div>
        </div>
        <div class="right">
            <!---<img src="img/xp_illustr.png" alt="Portfolio de Manya Théo, SAE203. Image d'illustration de la section expériences."> !-->
        </div>
    </section>
    </main>
    <footer style="margin-top: 4rem; padding: 2rem 1rem; text-align: center; background-color: #111; color: #fff;">
        <p style="font-family: 'Inter', sans-serif; font-weight: 300;">© <?php echo date("Y"); ?> Théo Manya. Tous droits réservés.</p>
        <p style="margin-top: 0.5rem; font-family: 'JetBrains Mono', monospace; font-size: 0.9rem;">
            Développé avec ❤️ et un soupçon de café.
        </p>
    </footer>
</body>
</html>