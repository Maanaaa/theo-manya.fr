<?php
include("../config/configuration.php");
include("../scripts/connection.php");
include("../scripts/fonctions.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_competence = $_POST['id_competence'];
    $titre  = $_POST['titre'];
    $maitrise = $_POST['maitrise'];

    $requete = 'UPDATE Competences SET titre = :titre, maitrise = :maitrise WHERE id_competence = :id_competence';
    $resultats = $connection->prepare($requete);
    $resultats->bindParam(':titre', $titre);
    $resultats->bindParam(':maitrise', $maitrise);
    $resultats->bindParam(':id_competence', $id_competence);
    $resultats->execute();

    header("Location: ../dashboard.php");
}