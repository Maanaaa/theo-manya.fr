let experiencesContainer;
let orderSelected;

function setupListeners() {
    orderSelected = document.getElementById("order");
    experiencesContainer = document.querySelector('#experiences .left ul'); // Cibler uniquement la liste <ul>

    // Mettre à jour dès qu'il y a un changement de choix
    if (orderSelected) {
        orderSelected.addEventListener('change', ordonner);
    }
}

function ordonner() {
    let selectedOption = orderSelected.options[orderSelected.selectedIndex]; // Option sélectionnée
    let content = selectedOption.value; 

    if(content == "croissant"){
        console.log("Croissant");
        trier("croi");
    }
    else{
        console.log("Décroissant");
        trier("dec");
    }
}

function getEndYear(liste) {
    const dateElem = liste.querySelector('.date');
    // Vérifier si dateElem est null et retourner une valeur par défaut si c'est le cas
    if (!dateElem) {
        console.warn("Aucun élément de date trouvé, utilisation de l'année actuelle par défaut.");
        return new Date().getFullYear(); // Retourner l'année actuelle par défaut
    }

    let text = dateElem.textContent;
    if (!text) text = ""; // Si le if fait a qu'une instruction, pas besoin d'ouvrir les {} on peux le faire sur la même ligne

    text = text.replace(/[()]/g, '').trim(); // enlever parenthèses
    // https://developer.mozilla.org/fr/docs/Web/JavaScript/Guide/Regular_expressions#classes_de_caractères
    // https://www.w3schools.com/jsref/jsref_replace.asp

    let parts = text.split(' - '); // Séparer le contenu avec les - pour avoir la date de début et de fin et en faire un tableau
    if (parts.length === 1) { // Pour quand la date de fin est "date début - à aujourd'hui)
        parts = text.split(' à ');
    }

    // Variables pour convertir les date de fin & de début
    let debut = "";
    let fin = "";
    if (parts.length > 0) { // Si y'a au moins 1 élément dans le tableau parts
        debut = parts[0].trim(); // si oui on prends le premier et on l'assigne à la date de début
        // Trim retire les espaces au début et à la fin de la chaine
    }
    if (parts.length > 1) { // Si la deuxième partie existe bien après le -
        fin = parts[1].trim(); // On défini la date de fin
    }
    // Si la date de fin obtenu est "aujourd'hui" ce qui veut dire que c'est en cours
    if (fin === "aujourd'hui") {
        fin = new Date().getFullYear().toString(); // on remplace par l'année actuelle pour pouvoir trier
    }

    return parseInt(fin);
}



function trier(order){
    const experiences = Array.from(experiencesContainer.querySelectorAll('li')); // Transformation de la liste des experiences en une array liste (=récupérer tous les <li>)

    let tableau = []; // Tableau vide pour stocker chaque experience + son année de fin 
    let tableauTrie = []; // Version du tableau trié (initialisé ici hors boucle)

    for(let i = 0; i < experiences.length; i++){
        let fin = getEndYear(experiences[i]); // Récupérer l'année de fin

        // Rentrer l'experience et son année de fin dans le tableau 
        tableau.push({
            annee: fin,
            experience: experiences[i]
        });
    }

    // On parcours les éléments du tableau qui restent, pour trouver le prochain à afficher
    while (tableau.length > 0) {
        let iChoisi = 0;
        for(let i = 1; i < tableau.length; i++){
            // Si l'utilisateur a choisi l'ordre croissant 
            // et que l'année de l'élément actuel est plus petite que celle de l'élément choisi,
            // alors on met à jour l'indice de l'élément choisi (en gros le plus ancien trouvé pour l’instant)

            if(order === "croi" && tableau[i].annee < tableau[iChoisi].annee){ // trouver la plus petite année
                iChoisi = i;
            }
            // Si l'utilisateur a choisi l'ordre décroissant ("dec") 
            // et que l'année de l'élément actuel est plus grande que celle de l'élément choisi,
            // alors on met à jour l'indice de l'élément choisi (toujours le plus récent trouvé pour l’instant)

            if (order === "dec" && tableau[i].annee > tableau[iChoisi].annee) { // trouver la plus grande année 
                iChoisi = i;
            }
        }

        // Ajouter cet élément trié dans le tableau final
        tableauTrie.push(tableau[iChoisi]);

        // L’enlever du tableau de base
        tableau.splice(iChoisi, 1);
    }

    // Une fois les expériences triées, on peux supprimer les expériences du DOM 
    experiencesContainer.innerHTML = ""; // Vider le contenu de experiences

    // Remettre les expériences une par une triées dans le bon ordre dans le DOM
    for (let i = 0; i < tableauTrie.length; i++) {
        experiencesContainer.appendChild(tableauTrie[i].experience);
    }
}

window.addEventListener('load', setupListeners);