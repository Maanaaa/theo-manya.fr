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
    <!-- CSS -->
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap">
    <link rel="stylesheet" href="https://api.fontshare.com/v2/css?f[]=clash-display@200,400,300,500,600,700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@100;200;300;400;500;600;700;800&display=swap">
    <link rel="stylesheet" href="css/reset.css">
    <!-- JS -->
    <script src="js/typeEffect.js" defer></script>
    <script src="js/caroussel.js" defer></script>
    <script src="js/filter.js" defer></script>
    <script src="js/popup.js" defer></script>
    <script src="js/script.js" defer></script>
    <script src="https://unpkg.com/lucide@latest" defer></script>
</head>

<body>
    <header class="flex horizontal-center vertical-center">
        <nav>
            <div class="titre">
                <p>Théo <span>MANYA</span></p>
            </div>

            <!-- bouton burger mobile -->
            <button
                id="menuBtn"
                class="menu-btn"
                type="button"
                aria-label="Ouvrir le menu"
                aria-controls="menu"
                aria-expanded="false"
                data-collapse-toggle="menu">
                <span class="menu-icon"></span>
            </button>

            <!-- menu -->
            <ul class="flex " id="menu" aria-label="Menu de navigation">
                <li><a href="#projets">Projets</a></li>
                <li><a href="#skills">Compétences</a></li>
                <li><a href="#experiences">Expériences</a></li>
            </ul>
        </nav>
    </header>

    <div class="intro">
        <!---<img src="img/header.png" alt="Portfolio de Manya Théo, SAE203. Image principale du header."> !-->
        <div class="portrait-container">
            <img src="https://i.ibb.co/60ywMdqS/portrait-manya-theo.webp" alt="Portrait de Théo Manya, étudiant en BUT MMI à l'IUT du Puy-en-Velay. Développement web." class="portrait">
        </div>
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

        <div class="carousel-container" aria-label="Mes projets">
            <div class="carousel spaceTop">
                <div class="decoration-haut"></div>
                <?php foreach ($tabProjets as $index => $projet): ?>
                    <?php
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

            <div class="cardNumber" aria-label="Navigation des projets">
                <?php foreach ($tabProjets as $i => $projet): ?>
                    <div class="bullet" tabindex="0"></div>
                <?php endforeach ?>
            </div>

            <div class="controlButtons">
                <button id="toggleMode">Mode Manuel</button>
                <button id="prevBtn">
                    <
                        <button id="nextBtn">>
                </button>
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
            $skills = [
                ["icon" => "code", "title" => "Front-end", "meta" => "HTML • CSS • JavaScript"],
                ["icon" => "server", "title" => "Back-end", "meta" => "PHP • Java"],
                ["icon" => "database", "title" => "Bases de données", "meta" => "MySQL • SQL • Modélisation"],
                ["icon" => "package", "title" => "Outils / DevOps", "meta" => "Git • Docker"],
                ["icon" => "pen-tool", "title" => "UI / UX Design", "meta" => "Figma • Accessibilité • Prototypage"],
                ["icon" => "kanban", "title" => "Gestion de projet", "meta" => "Trello • Documentation"]
            ];
            foreach ($skills as $s): ?>
                <div data-tilt class="skill flex">
                    <i data-lucide="<?php echo $s['icon']; ?>"></i>
                    <p><strong><?php echo $s['title']; ?><br></strong><span><?php echo str_replace(' • ', '<br>', $s['meta']); ?></span></p>
                </div>
            <?php endforeach; ?>
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
                            $requete_xp_competences = 'SELECT c.titre FROM ExperiencesCompetences ec JOIN Competences c ON ec.id_competence = c.id_competence WHERE ec.id_experience = :id_experience';
                            $resultats_xp_competences = $connection->prepare($requete_xp_competences);
                            $resultats_xp_competences->bindParam(':id_experience', $xp['id_experience']);
                            $resultats_xp_competences->execute();
                            $tabXpCompetences = $resultats_xp_competences->fetchAll(PDO::FETCH_ASSOC);
                            ?>

                            <p><?php echo $xp["poste"] ?> - <?php echo $xp["entreprise"] ?>
                                <?php
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
        </div>
    </section>

    <!-- Popup Projet -->
    <div id="projet-modal" class="popup" aria-hidden="true" role="dialog" aria-modal="true">
        <div class="popup-overlay" data-close="popup"></div>
        <div class="popup-box" role="document">
            <button type="button" class="popup-close" aria-label="Fermer" data-close="popup">✕</button>

            <div class="popup-media">
                <img id="popup-img" src="" alt="">
            </div>

            <div class="popup-body">
                <div class="popup-head">
                    <h3 id="popup-title" class="popup-title"></h3>
                    <time id="popup-date" class="popup-date"></time>
                </div>

                <p id="popup-desc" class="popup-desc"></p>
            </div>

            <a id="popup-cta" class="popup-cta" href="#" target="_blank" rel="noopener" hidden>
                En savoir plus
            </a>
        </div>

    </div>


    <footer style="margin-top: 4rem; padding: 2rem 1rem; text-align: center; background-color: #111; color: #fff;">
        <p style="font-family: 'Inter', sans-serif; font-weight: 300;">© <?php echo date("Y"); ?> Théo Manya. Tous droits réservés.</p>
        <p style="margin-top: 0.5rem; font-family: 'JetBrains Mono', monospace; font-size: 0.9rem;">
            Développé avec ❤️ et un soupçon de café
        </p>
    </footer>
    <script src="js/vanilla-tilt.min.js"></script>
    <script src="https://unpkg.com/flowbite/dist/flowbite.min.js"></script>
    <div id="menuOverlay" class="menu-overlay" hidden></div> <!-- Overlay pour le menu en version mobile -->
    <script src="https://unpkg.com/lucide@latest" defer></script>
</body>

</html>