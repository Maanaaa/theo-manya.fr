<?php
include("config/configuration.php");
include("scripts/connection.php");
include("scripts/fonctions.php");
require("scripts/auth.php");

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
  <meta charset="utf-8" />
  <title>Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="theme-color" content="#ff4ecb" />
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- <link rel="stylesheet" href="css/dashboard.css"> DÉSACTIVÉ POUR LE MOMENT -> BOOTSTRAP SUFFIT -->
</head>


<body>
  <?php include "components/dashboardHeader.php"; ?>

  <div class="container py-4">

    <!-- Projets -->
    <section id="projets" class="mb-5">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Projets</h2>
        <a href="addProject_page.php" class="btn btn-primary">Ajouter un projet</a>
      </div>

      <div class="row g-3">
        <?php foreach($tabProjets as $projet): ?>
          <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100">
              <div class="card-body d-flex flex-column">
                <h5 class="card-title"><?= htmlspecialchars($projet["titre"]) ?></h5>
                <p class="card-text">
                  <?= htmlspecialchars(mb_strimwidth($projet["description"], 0, 120, "…", "UTF-8")) ?>
                </p>
                <div class="mt-auto d-flex gap-2 flex-wrap">
                  <a href="updateProject_page.php?id_projet=<?= $projet['id_projet'] ?>" class="btn btn-outline-secondary btn-sm">Modifier</a>
                  <a href="scripts/deleteData.php?table=Projets&id=<?= $projet['id_projet'] ?>&column=id_projet" class="btn btn-danger btn-sm">Supprimer</a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </section>

    <!-- Compétences -->
    <section id="skills" class="mb-5">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Compétences</h2>
        <a href="addSkill_page.php" class="btn btn-primary">Ajouter une compétence</a>
      </div>

      <div class="row g-3">
        <?php foreach($tabSkills as $skill): ?>
          <?php $lvl = max(0, min(100, (int)$skill["maitrise"])); ?>
          <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100">
              <div class="card-body d-flex flex-column">
                <h5 class="card-title"><?= htmlspecialchars($skill["titre"]) ?></h5>
                <p class="card-text">Maîtrise : <?= $lvl ?>%</p>
                <div class="progress mb-3">
                  <div class="progress-bar" role="progressbar" style="width: <?= $lvl ?>%" aria-valuenow="<?= $lvl ?>" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="mt-auto d-flex gap-2 flex-wrap">
                  <a href="updateSkill_page.php?id_competence=<?= $skill['id_competence'] ?>" class="btn btn-outline-secondary btn-sm">Modifier</a>
                  <a href="scripts/deleteData.php?table=Competences&id=<?= $skill['id_competence'] ?>&column=id_competence" class="btn btn-danger btn-sm">Supprimer</a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </section>

    <!-- Expériences -->
    <section id="experiences" class="mb-5">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Expériences</h2>
        <a href="addXp_page.php" class="btn btn-primary">Ajouter une expérience</a>
      </div>

      <div class="row g-3">
        <?php foreach($tabXp as $experience): ?>
          <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100">
              <div class="card-body d-flex flex-column">
                <h5 class="card-title"><?= htmlspecialchars($experience["poste"]) ?> — <?= htmlspecialchars($experience["entreprise"]) ?></h5>
                <p class="card-text">
                  <?= htmlspecialchars($experience["debut"]) ?>
                  <?php if (!empty($experience["fin"])): ?> – <?= htmlspecialchars($experience["fin"]) ?><?php endif; ?>
                </p>
                <div class="mt-auto d-flex gap-2 flex-wrap">
                  <a href="updateXp_page.php?id_experience=<?= $experience['id_experience'] ?>" class="btn btn-outline-secondary btn-sm">Modifier</a>
                  <a href="scripts/deleteData.php?table=Experience&id=<?= $experience['id_experience'] ?>&column=id_experience" class="btn btn-danger btn-sm">Supprimer</a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </section>

  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
