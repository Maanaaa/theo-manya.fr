let currentIndex = 0;
let isAutoMode = true;
let interval;
let delayChange = 3500; // Délai en ms

// Déclarées ici et non dans setupListeners car sinon carousel est inaccessible pour les autres fonctions
let carousel;
let cards;
let cardNumberBullet;

function updateCarousel() {
    carousel.style.transform = `translateX(-${currentIndex * 100}%)`;
    updateBullet();
}

function updateBullet() {
    for (let i = 0; i < cardNumberBullet.length; i++) {
        if (i === currentIndex) {
            cardNumberBullet[i].style.backgroundColor = 'rgb(255, 46, 136)'; // Rose
        } else {
            cardNumberBullet[i].style.backgroundColor = '#ccc'; // Gris
        }
    }
}

function nextCard() {
    currentIndex = (currentIndex + 1) % cards.length;
    updateCarousel();
}

function startAutoMode() {
    interval = setInterval(nextCard, delayChange); // Change de carte toutes les 3 secondes
}

function stopAutoMode() {
    clearInterval(interval);
}

function setupListeners() {
    carousel = document.querySelector('.carousel');
    cards = document.querySelectorAll('.card');
    cardNumberBullet = document.querySelectorAll('.bullet'); // Utilisation de querySelectorAll

    let toggleButton = document.getElementById('toggleMode');
    let prevButton = document.getElementById('prevBtn');
    let nextButton = document.getElementById('nextBtn');

    if (toggleButton && prevButton && nextButton) {
        toggleButton.addEventListener('click', function() {
            isAutoMode = !isAutoMode; // Égal à l'inverse de l'état actuel de isAutoMode
            if (isAutoMode == true) {
                toggleButton.textContent = 'Mode Manuel';
                startAutoMode();
            } else {
                toggleButton.textContent = 'Mode Auto';
                stopAutoMode();
            }
        });

        prevButton.addEventListener('click', function() {
            currentIndex = (currentIndex - 1 + cards.length) % cards.length;
            updateCarousel();
        });

        nextButton.addEventListener('click', function() {
            nextCard();
        });
    }

    // Points de navigation
    for (let i = 0; i < cardNumberBullet.length; i++) {
        cardNumberBullet[i].addEventListener('click', function() {
            currentIndex = i;
            updateCarousel(); // Correction de l'appel de la fonction
        });
    }

    startAutoMode();
    updateBullet();
}

window.addEventListener('load', setupListeners);
