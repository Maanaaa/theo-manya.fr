let experiencesContainerTM;
let orderSelectedTM;

/* setupListeners : initialise les écouteurs d'événements pour le tri des expériences.
 * Récupère les éléments du DOM nécessaires pour que le filtre fonctionne.
 */
function setupListeners() {
    orderSelectedTM = document.getElementById("order");
    experiencesContainerTM = document.querySelector('#experiences .left ul'); // Cibler uniquement la liste <ul>

    // Mettre à jour dès qu'il y a un changement de choix
    if (orderSelectedTM) {
        orderSelectedTM.addEventListener('change', ordonner);
    }
}

/* ordonner : détermine l'ordre de tri sélectionné par l'utilisateur et appelle la fonction de tri.
 * Si l'option sélectionnée est "croissant", la fonction trie les expériences par ordre croissant.
 * Sinon, elle trie les expériences par ordre décroissant.
 */
function ordonner() {
    let selectedOptionTM = orderSelectedTM.options[orderSelectedTM.selectedIndex]; // Option sélectionnée
    let contentTM = selectedOptionTM.value;

    if(contentTM == "croissant"){
        console.log("Croissant");
        trier("croi");
    }
    else{
        console.log("Décroissant");
        trier("dec");
    }
}

/* getEndYear : récupère l'année de fin d'une expérience à partir de son élément DOM.
 * @param {HTMLElement} listeTM - L'élément DOM qui représente une expérience.
 * @return {number} année de fin de l'expérience.
 */
function getEndYear(listeTM) {
    const dateElemTM = listeTM.querySelector('.date');
    // Vérifier si dateElemTM est null et retourner une valeur par défaut si c'est le cas
    if (!dateElemTM) {
        console.warn("Aucun élément de date trouvé, utilisation de l'année actuelle par défaut.");
        return new Date().getFullYear(); // Retourner l'année actuelle par défaut
    }

    let textTM = dateElemTM.textContent;
    if (!textTM) textTM = ""; // Si le if fait a qu'une instruction, pas besoin d'ouvrir les {} on peux le faire sur la même ligne

    textTM = textTM.replace(/[()@]/g, '').trim(); // enlever parenthèses
    // https://developer.mozilla.org/fr/docs/Web/JavaScript/Guide/Regular_expressions#classes_de_caractères
    // https://www.w3schools.com/jsref/jsref_replace.asp

    let partsTM = textTM.split(' - '); // Séparer le contenu avec les - pour avoir la date de début et de fin et en faire un tableau
    if (partsTM.length === 1) { // Pour quand la date de fin est "date début - à aujourd'hui)
        partsTM = textTM.split(' à ');
    }

    // Variables pour convertir les date de fin & de début
    let debutTM = "";
    let finTM = "";
    if (partsTM.length > 0) { // Si y'a au moins 1 élément dans le tableau partsTM
        debutTM = partsTM[0].trim(); // si oui on prends le premier et on l'assigne à la date de début
        // Trim retire les espaces au début et à la fin de la chaine
    }
    if (partsTM.length > 1) { // Si la deuxième partie existe bien après le -
        finTM = partsTM[1].trim(); // On défini la date de fin
    }
    // Si la date de fin obtenu est "aujourd'hui" ce qui veut dire que c'est en cours
    if (finTM === "aujourd'hui") {
        finTM = new Date().getFullYear().toString(); // on remplace par l'année actuelle pour pouvoir trier
    }

    return parseInt(finTM);
}

/* trier : trie les expériences en fonction de l'ordre choisie par l'utilisateur
 * @param {string} orderTM - L'ordre de tri ("croi" -> croissant, "dec" -> décroissant).
 */
function trier(orderTM){
    const experiencesTM = Array.from(experiencesContainerTM.querySelectorAll('li')); // Transformation de la liste des experiences en une array liste (=récupérer tous les <li>)

    let tableauTM = []; // Tableau vide pour stocker chaque experience + son année de fin
    let tableauTrieTM = []; // Version du tableau trié (initialisé ici hors boucle)

    for(let iTM = 0; iTM < experiencesTM.length; iTM++){
        let finTM = getEndYear(experiencesTM[iTM]); // Récupérer l'année de fin

        // Rentrer l'experience et son année de fin dans le tableau
        tableauTM.push({
            annee: finTM,
            experience: experiencesTM[iTM]
        });
    }

    // On parcours les éléments du tableau qui restent, pour trouver le prochain à afficher
    while (tableauTM.length > 0) {
        let iChoisiTM = 0;
        for(let iTM = 1; iTM < tableauTM.length; iTM++){
            // Si l'utilisateur a choisi l'ordre croissant
            // et que l'année de l'élément actuel est plus petite que celle de l'élément choisi,
            // alors on met à jour l'indice de l'élément choisi (en gros le plus ancien trouvé pour l’instant)

            if(orderTM === "croi" && tableauTM[iTM].annee < tableauTM[iChoisiTM].annee){ // trouver la plus petite année
                iChoisiTM = iTM;
            }
            // Si l'utilisateur a choisi l'ordre décroissant ("dec")
            // et que l'année de l'élément actuel est plus grande que celle de l'élément choisi,
            // alors on met à jour l'indice de l'élément choisi (toujours le plus récent trouvé pour l’instant)

            if (orderTM === "dec" && tableauTM[iTM].annee > tableauTM[iChoisiTM].annee) { // trouver la plus grande année
                iChoisiTM = iTM;
            }
        }

        // Ajouter cet élément trié dans le tableau final
        tableauTrieTM.push(tableauTM[iChoisiTM]);

        // L’enlever du tableau de base
        tableauTM.splice(iChoisiTM, 1);
    }

    // Une fois les expériences triées, on peux supprimer les expériences du DOM
    experiencesContainerTM.innerHTML = ""; // Vider le contenu de experiences

    // Remettre les expériences une par une triées dans le bon ordre dans le DOM
    for (let iTM = 0; iTM < tableauTrieTM.length; iTM++) {
        experiencesContainerTM.appendChild(tableauTrieTM[iTM].experience);
    }
}

window.addEventListener('load', setupListeners);