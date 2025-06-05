let toType = ['Creative', 'Developer', '<br><span>','&', 'Digital', 'Designer', '</span>'];
let delay = 100; // Délai en ms

function typeEffect(element, content, delay){
    let i = 0;
    let textContent = ""; // Stocker le texte en cours de frappe
    let interval = setInterval(() => { // Fonction intervale : https://developer.mozilla.org/en-US/docs/Web/API/Window/setInterval
        if(i < content.length){
            // https://developer.mozilla.org/fr/docs/Web/JavaScript/Reference/Global_Objects/String/charAt
            textContent = textContent+content.charAt(i); // Ajouter le caractère 
            element.innerHTML = textContent; // Mettre à jour le contenu
            i++;
        }else{
            clearInterval(interval); // Animation terminée, remettre à zéro l'intervale
        }
    }, delay);
    // https://developer.mozilla.org/en-US/docs/Web/API/Window/setInterval
}

function setupListeners(){
    let selector = document.querySelector(".typingEffect");
    let text = toType.join(" ");
    typeEffect(selector,text,delay);
}

window.addEventListener('load', setupListeners);