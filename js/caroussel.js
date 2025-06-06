let currentIndex = 0;
let isAutoMode = true;
let interval;
let delayChange = 3500; // Délai en ms

// Déclarées ici et non dans setupListeners car sinon carousel est innaccessible pour les autres fonctions
let carousel;
let cards;

let cardNumber;
let cardNumberBullet;
let actualNumber;

function updateCarousel() {
    carousel.style.transform = `translateX(-${currentIndex * 100}%)`;
    updateBullet();
}

function updateBullet(){
    let actualCard = currentIndex;
    for(let i = 0;i < cardNumberBullet.length;i++){
        if(i==currentIndex){
            cardNumberBullet[i].style.backgroundColor = 'rgb(255, 46, 136)';
            cardNumberBullet[actualNumber].style.backgroundColor = '#ccc';
        }
        else{
            cardNumberBullet[i].style.backgroundColor = '#ccc;'
        }
    }
} 



function nextCard() {
    actualNumber = currentIndex; // Variable temporaire pour stocker la position de la carte avant changement, afin de changer la couleur du point
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

    cardNumber = cards.length;
    cardNumberBullet = document.getElementsByClassName("bullet");


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
            actualNumber = currentIndex; // Variable temporaire pour stocker la position de la carte avant changement, afin de changer la couleur du point
            currentIndex = (currentIndex - 1 + cards.length) % cards.length;
            updateCarousel();
        });

        nextButton.addEventListener('click', function() {
            nextCard();
        });
    } 
    startAutoMode();
    updateBullet();
}


window.addEventListener('load', setupListeners);