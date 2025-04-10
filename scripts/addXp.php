<?php
include("../config/configuration.php");
include("../scripts/connection.php");
include("../scripts/fonctions.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $poste = $_POST["poste"];
    $entreprise = $_POST["entreprise"];
    $debut = $_POST["debut"];
    $fin = $_POST["fin"];
    $competence = $_POST["id_competence"];


    if($poste == "" OR $entreprise == "" OR $debut == "" OR $competence == ""){header("Location: ../dashboard.php"); exit;}
    if (empty($fin)) {
        $fin = NULL;
    }

    $requete = 'INSERT INTO Experience (poste, entreprise, debut, fin, id_competence) VALUES (:poste, :entreprise, :debut, :fin, :id_competence)';
    $stmt = $connection->prepare($requete);
    $stmt->bindParam(':poste', $poste, PDO::PARAM_STR);
    $stmt->bindParam(':entreprise', $entreprise, PDO::PARAM_STR);
    $stmt->bindParam(':debut', $debut, PDO::PARAM_INT);
    $stmt->bindParam(':fin', $fin, PDO::PARAM_INT);
    $stmt->bindParam(':id_competence', $competence, PDO::PARAM_INT);
    $stmt->execute();

    // Récupérer l'ID de l'expériecne qui vient d'être insérée
    $dernier_id = $connection->lastInsertId(); // https://www.php.net/manual/fr/pdo.lastinsertid.php

    // Liaison compétence experience
    $requete_liaison = 'INSERT INTO ExperiencesCompetences (id_experience, id_competence) VALUES (:id_experience, :id_competence)';
    $stmt_liaison = $connection->prepare($requete_liaison);
    $stmt_liaison->bindParam(':id_experience', $dernier_id, PDO::PARAM_INT);
    $stmt_liaison->bindParam(':id_competence', $competence, PDO::PARAM_INT);
    $stmt_liaison->execute();

    header("Location: ../dashboard.php");
}
?>
