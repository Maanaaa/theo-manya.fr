<?php
include("../config/configuration.php");
include("../scripts/connection.php");
include("../scripts/fonctions.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_projet = $_POST["id_projet"];
    $titre = $_POST["titre"];
    $description = $_POST["description"];
    $id_competence = isset($_POST["id_competence"]) ? $_POST["id_competence"] : null;
    $lien = $_POST["lien"];
    $date = $_POST["date"];
    $file_max_size = 10000000;
    $allowed_extensions = ["jpg", "png"];

    $content_dir = "../img/projets/";

    $image_path = $_POST["current_image"];

    if ($image_path && file_exists($image_path)) {
        unlink($image_path);
    }

    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == UPLOAD_ERR_OK) {
        if ($_FILES["image"]["size"] > 0) {
            $result = uploadFile($_FILES["image"], $content_dir, $allowed_extensions, $file_max_size, $connection);
            if ($result !== false) {
                $image_path = $result;
            }
        }
    } else {
        $image_path = $_POST["current_image"];
    }

    $requete = 'UPDATE Projets SET titre = :titre, description = :description, lien = :lien, id_competence = :id_competence, image = :image, date = :date WHERE id_projet = :id_projet';
    $resultats = $connection->prepare($requete);
    $resultats->bindParam(':titre', $titre);
    $resultats->bindParam(':description', $description);
    $resultats->bindParam(':lien', $lien);
    $resultats->bindParam(':id_competence', $id_competence, PDO::PARAM_INT);
    $resultats->bindParam(':image', $image_path);
    $resultats->bindParam(':date', $date);
    $resultats->bindParam(':id_projet', $id_projet);
    $resultats->execute();

    if ($id_competence !== null) {
        $requete_liaison = 'UPDATE ProjetCompetences SET id_competence = :id_competence WHERE id_projet = :id_projet';
        $resultats_liaison = $connection->prepare($requete_liaison);
        $resultats_liaison->bindParam(':id_competence', $id_competence, PDO::PARAM_INT);
        $resultats_liaison->bindParam(':id_projet', $id_projet);
        $resultats_liaison->execute();
    }

    header("Location: ../dashboard.php");
}
?>
