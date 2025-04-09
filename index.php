<?php
include("config/configuration.php");
include("scripts/connection.php");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Théo Manya - Portfolio</title>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <header class="flex horizontal-center vertical-center">
        <nav>
            <h2>MANYA Théo</h2>
            <ul class="flex">
                <li>Projets</li>
                <li>Compétences</li>
                <li>Expériences</li>
            </ul>
        </nav>
    </header>
    <main class="spaceTop">
    <div class="intro">
        <img src="img/header.png" alt="Portfolio de Manya Théo, SAE203. Image principale du header.">
        <h1>Mon Portfolio</h1>
    </div>
    <section id="projets"  class="spaceTop">
        <h2>Mes projets</h2>
        <div class="card spaceTop">
            <p class="skill">$compétence</p>
            <img src="img/projets/card1.png" alt="Portfolio de Manya Théo, SAE203.">
            <div class="bottom">
                <p>titre</p>
                <p>date</p>
            </div>
            <a href="#">En savoir plus</a>
        </div>
    </section>
    <section id="skills" class="spaceTop">
        <h2>Mes compétences</h2>
        <div class="skills spaceTop">
            <div class="skill flex">
                <p>HTML</p>
                <progress id="html" max="100" value="70">70%</progress>
            </div>

        </div>
    </section>

    <section id="experiences" class="spaceTop flex">
        <div class="left">
            <li>
                <p>Assistant Pizzaïolo - Le Golden (2021-2022)</p>
                <p>Travail en équipe, nom de la compétence</p>
            </li>

        </div>
        <div class="right">
            <img src="img/xp_illustr.png" alt="Portfolio de Manya Théo, SAE203. Image d'illustration de la section expériences.">
        </div>
    </section>
    </main>
</body>
</html>