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
            $svgs = [
                '<svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 8-4 4 4 4m8 0 4-4-4-4m-2-3-4 14"/></svg>',
                '<svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0 0 50 50">
    <path d="M47,5v40L30.619,5H47z M17.762,36.579H25L28.429,45h7.238L25,18.801L17.762,36.579z M3,5v40L19.381,5H3z"></path>
</svg>',
                '<svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7h-1M8 7h-.688M13 5v4m-2-2h4"/>
</svg>
',
                '<svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
  <path fill-rule="evenodd" d="M9 7V2.221a2 2 0 0 0-.5.365L4.586 6.5a2 2 0 0 0-.365.5H9Zm2 0V2h7a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V9h5a2 2 0 0 0 2-2Zm-2 4a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2v-2a2 2 0 0 0-2-2H9Zm0 2h2v2H9v-2Zm7.965-.557a1 1 0 0 0-1.692-.72l-1.268 1.218a1 1 0 0 0-.308.721v.733a1 1 0 0 0 .37.776l1.267 1.032a1 1 0 0 0 1.631-.776v-2.984Z" clip-rule="evenodd"/>
</svg>
',
                '<svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
  <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M4.5 17H4a1 1 0 0 1-1-1 3 3 0 0 1 3-3h1m0-3.05A2.5 2.5 0 1 1 9 5.5M19.5 17h.5a1 1 0 0 0 1-1 3 3 0 0 0-3-3h-1m0-3.05a2.5 2.5 0 1 0-2-4.45m.5 13.5h-7a1 1 0 0 1-1-1 3 3 0 0 1 3-3h3a3 3 0 0 1 3 3 1 1 0 0 1-1 1Zm-1-9.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z"/>
</svg>
',
                '<svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1M5 12h14M5 12a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v4a1 1 0 0 1-1 1m-2 3h.01M14 15h.01M17 9h.01M14 9h.01"/>
</svg>

',
                '<svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 6c0 1.657-3.134 3-7 3S5 7.657 5 6m14 0c0-1.657-3.134-3-7-3S5 4.343 5 6m14 0v6M5 6v6m0 0c0 1.657 3.134 3 7 3s7-1.343 7-3M5 12v6c0 1.657 3.134 3 7 3s7-1.343 7-3v-6"/>
</svg>
',
                '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 18l6-6-6-6M8 6l-6 6 6 6"/></svg>'
            ];

            $index = 0;
            foreach ($tabSkills as $skill): ?>
                <div data-tilt class="skill flex">
                    <?php echo $svgs[$index % count($svgs)]; ?>
                    <p><?php echo $skill["titre"]; ?></p>
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

                <a id="popup-cta" class="popup-cta" href="#" target="_blank" rel="noopener" hidden>En savoir plus</a>
            </div>
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
</body>

</html>