<?php
include("../config/configuration.php");
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id_experience = $_POST["id_experience"];
    $poste = $_POST["poste"];
    $entreprise = $_POST["entreprise"];
    $debut = $_POST["debut"];
    $fin = $_POST["fin"];
    $id_competence = $_POST["id_competence"];

    // Mettre à jour l'expérience dans la base de données
    $requete = 'UPDATE Experience SET poste = :poste, entreprise = :entreprise, debut = :debut, fin = :fin, id_competence = :id_competence WHERE id_experience = :id_experience';
    $resultats = $connection->prepare($requete);
    $resultats->bindParam(':poste', $poste);
    $resultats->bindParam(':entreprise', $entreprise);
    $resultats->bindParam(':debut', $debut);
    $resultats->bindParam(':fin', $fin);
    $resultats->bindParam(':id_competence', $id_competence, PDO::PARAM_INT);
    $resultats->bindParam(':id_experience', $id_experience, PDO::PARAM_INT);
    $resultats->execute();

    // Mettre à jour la table ExperiencesCompetences
    if ($id_competence !== null && $id_competence != 'none') {
        $requete_liaison = 'UPDATE ExperiencesCompetences SET id_competence = :id_competence WHERE id_experience = :id_experience';
        $resultats_liaison = $connection->prepare($requete_liaison);
        $resultats_liaison->bindParam(':id_competence', $id_competence, PDO::PARAM_INT);
        $resultats_liaison->bindParam(':id_experience', $id_experience, PDO::PARAM_INT);
        $resultats_liaison->execute();
    }

    header("Location: ../dashboard.php");
    exit();
}