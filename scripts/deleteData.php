<?php
include("../config/configuration.php");
include("../scripts/connection.php");

// Vérifiez que les paramètres nécessaires sont définis et que l'ID est numérique
if (isset($_GET['table'], $_GET['id'], $_GET['column']) && is_numeric($_GET['id'])) {
    $table = $_GET['table'];  // Table
    $id = $_GET['id'];        // ID
    $column = $_GET['column'];  // Colonne

    // Supprimer les enregistrements liés dans les tables de liaison
    if ($table === 'Projets') {
        $requete_liaison = 'DELETE FROM ProjetCompetences WHERE id_projet = :id';
        $resultats_liaison = $connection->prepare($requete_liaison);
        $resultats_liaison->bindParam(':id', $id, PDO::PARAM_INT);
        $resultats_liaison->execute();
    } elseif ($table === 'Experience') {
        $requete_liaison = 'DELETE FROM ExperiencesCompetences WHERE id_experience = :id';
        $resultats_liaison = $connection->prepare($requete_liaison);
        $resultats_liaison->bindParam(':id', $id, PDO::PARAM_INT);
        $resultats_liaison->execute();
    }

    // Supprimer l'enregistrement principal
    $requete = 'DELETE FROM ' . $table . ' WHERE ' . $column . ' = :id';
    $resultats = $connection->prepare($requete);
    $resultats->bindParam(':id', $id, PDO::PARAM_INT);
    $resultats->execute();

    header("Location: ../dashboard.php");
    exit();
} else {
    echo "Paramètres manquants ou ID non valide.";
}
?>
