let toTypeTM = ['Creative', 'Developer', '<br><span>', '&', 'Digital', 'Designer', '</span>'];
let delayTM = 100; // Délai en ms

/* typeEffect : produit un effet de "frappe" lettre par lettre sur un élément donné avec du contenu et un délai choisi.
 * @param {HTMLElement} elementTM - L'élément DOM où l'effet de "frappe" sera appliqué.
 * @param {string} contentTM - Le texte à écrire.
 * @param {number} delayTM - Le délai en millisecondes entre chaque caractère écrit.
 */
function typeEffect(elementTM, contentTM, delayTM) {
    let iTM = 0;
    let textContentTM = ""; // Stocker le texte en cours de frappe
    let intervalTM = setInterval(() => { // Fonction intervale : https://developer.mozilla.org/en-US/docs/Web/API/Window/setInterval
        if (iTM < contentTM.length) {
            // https://developer.mozilla.org/fr/docs/Web/JavaScript/Reference/Global_Objects/String/charAt
            textContentTM = textContentTM + contentTM.charAt(iTM); // Ajouter le caractère
            elementTM.innerHTML = textContentTM; // Mettre à jour le contenu
            iTM++;
        } else {
            clearInterval(intervalTM); // Animation terminée, remettre à zéro l'intervale
        }
    }, delayTM);
    // https://developer.mozilla.org/en-US/docs/Web/API/Window/setInterval
}

/* setupListeners : initialise les écouteurs d'événements pour l'effet de frappe.
 * Sélectionne la classe "typingEffect" et applique l'effet de "frappe" au chargement de la page.
 */
function setupListeners() {
    let selectorTM = document.querySelector(".typingEffect");
    let textTM = toTypeTM.join(" ");
    typeEffect(selectorTM, textTM, delayTM);
}

window.addEventListener('load', setupListeners);
