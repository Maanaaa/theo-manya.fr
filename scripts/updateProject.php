<?php
include("../config/configuration.php");
include("../scripts/connection.php");
include("../scripts/fonctions.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_projet = $_POST["id_projet"];
    $titre = $_POST["titre"];
    $description = $_POST["description"];
    $competence = $_POST["competence"];
    $lien = $_POST["lien"];
    $date = $_POST["date"];
    $file_max_size = 10000000;
    $allowed_extensions = ["jpg", "png"];

    $content_dir = "../img/projets/";

    $image_path = $_POST["current_image"]; // Chemin actuel de l'image, pour vérifier si l'image a été changée ou non
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == UPLOAD_ERR_OK) {
        if ($_FILES["image"]["size"] > 0) {
            $result = uploadFile($_FILES["image"], $content_dir, $allowed_extensions, $file_max_size, $connection);
            if ($result !== false) {
                $image_path = $result;
            }
        }
    }

    // Mettre à jour le projet dnas la bdd
    $requete = 'UPDATE Projets SET titre = :titre, description = :description, lien = :lien, competence = :competence, image = :image, date = :date WHERE id_projet = :id_projet';
    $stmt = $connection->prepare($requete);
    $stmt->bindParam(':titre', $titre);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':lien', $lien);
    $stmt->bindParam(':competence', $competence);
    $stmt->bindParam(':image', $image_path);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':id_projet', $id_projet);
    $stmt->execute();

    header("Location: ../dashboard.php");
}