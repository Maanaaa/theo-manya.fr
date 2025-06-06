let currentIndex = 0;
let isAutoMode = true;
let interval;
let delayChange = 3500; // Délai en ms

// Déclarées ici et non dans setupListeners car sinon carousel est innaccessible pour les autres fonctions
let carousel;
let cards;

function updateCarousel() {
    carousel.style.transform = `translateX(-${currentIndex * 100}%)`;
}

function nextCard() {
    currentIndex = (currentIndex + 1) % cards.length;
    updateCarousel();
}

function startAutoMode() {
    interval = setInterval(nextCard, delayChange); // Change de card toutes les 3 secondes
}

function stopAutoMode() {
    clearInterval(interval);
}

function setupListeners() {
    carousel =  document.querySelector('.carousel'); 
    cards = document.querySelectorAll('.card');
    let toggleButton = document.getElementById('toggleMode');
    let prevButton = document.getElementById('prevBtn');
    let nextButton = document.getElementById('nextBtn');

    if (toggleButton && prevButton && nextButton) {
        toggleButton.addEventListener('click', function() {
            isAutoMode = !isAutoMode // Égal à l'inverse de l'état actuelle de isAutoMode
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
    startAutoMode();
}


window.addEventListener('load', setupListeners);