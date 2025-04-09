<?php
include("../config/configuration.php");
include("../scripts/connection.php");
include("../scripts/fonctions.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $titre = $_POST["titre"];
    $maitrise = $_POST["maitrise"];
    // Si les champs sont bien saisis
    if($titre != "" && $maitrise != ""){
        // Ajouter la compétence dans la base de donnée
        $requete = 'INSERT INTO Competences (titre, maitrise) VALUES (:titre, :maitrise)';
        $resultats = $connection->prepare($requete);
        $resultats->bindParam(':titre', $titre);
        $resultats->bindParam(':maitrise', $maitrise);
        $resultats->execute();
        header("Location: ../dashboard.php");
    }
}