let currentIndexTM = 0;
let isAutoModeTM = true;
let intervalTM;
let delayChangeTM = 3500; // Délai en ms

// Déclarées ici et non dans setupListeners car sinon carousel est inaccessible pour les autres fonctions
let carouselTM;
let cardsTM;
let cardNumberBulletTM;

/* updateCarousel : met à jour le décalage du carousel selon l’index courant.
 * @return {}
 */
function updateCarousel() {
    carouselTM.style.transform = `translateX(-${currentIndexTM * 100}%)`;
    updateBullet();
}

/* updateBullet : met à jour l’état des bullets en fonction la carte actuellement affichée.
*@return {}
*/
function updateBullet() {
    for (let iTM = 0; iTM < cardNumberBulletTM.length; iTM++) {
        if (iTM === currentIndexTM) {
            cardNumberBulletTM[iTM].style.backgroundColor = 'rgb(255, 46, 136)'; // Rose
        } else {
            cardNumberBulletTM[iTM].style.backgroundColor = '#ccc'; // Gris
        }
    }
}

/* nextCard : passe à la carte suivante du carousel.
*@return {}
*/
function nextCard() {
    currentIndexTM = (currentIndexTM + 1) % cardsTM.length;
    updateCarousel();
}

/* startAutoMode : démarre le défilement automatique du caroussel
*@return {}
*/
function startAutoMode() {
    intervalTM = setInterval(nextCard, delayChangeTM); // Change de carte toutes les 3 secondes
}

/* stopAutoMode : arrête le défilement automatique.
*@return {}
*/
function stopAutoMode() {
    clearInterval(intervalTM);
}

/* setupListeners : initialise les écouteurs d’évènements et les éléments du DOM nécessaires pour que le carousel marche.
*@return {}
*/
function setupListeners() {
    carouselTM = document.querySelector('.carousel');
    cardsTM = document.querySelectorAll('.card');
    cardNumberBulletTM = document.querySelectorAll('.bullet'); // Utilisation de querySelectorAll

    let toggleButtonTM = document.getElementById('toggleMode');
    let prevButtonTM = document.getElementById('prevBtn');
    let nextButtonTM = document.getElementById('nextBtn');

    if (toggleButtonTM && prevButtonTM && nextButtonTM) {
        toggleButtonTM.addEventListener('click', function() {
            isAutoModeTM = !isAutoModeTM; // Égal à l'inverse de l'état actuel de isAutoModeTM
            if (isAutoModeTM == true) {
                toggleButtonTM.textContent = 'Mode Manuel';
                startAutoMode();
            } else {
                toggleButtonTM.textContent = 'Mode Auto';
                stopAutoMode();
            }
        });

        prevButtonTM.addEventListener('click', function() {
            currentIndexTM = (currentIndexTM - 1 + cardsTM.length) % cardsTM.length;
            updateCarousel();
        });

        nextButtonTM.addEventListener('click', function() {
            nextCard();
        });
    }

    // Points de navigation
    for (let iTM = 0; iTM < cardNumberBulletTM.length; iTM++) {
        cardNumberBulletTM[iTM].addEventListener('click', function() {
            currentIndexTM = iTM;
            updateCarousel(); // Correction de l'appel de la fonction
        });
    }

    startAutoMode();
    updateBullet();
}

window.addEventListener('load', setupListeners);