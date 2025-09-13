// Popup au clique sur un projet 
function initPopup() {
  let modal = document.getElementById('projet-modal');
  if (!modal) return;

  let box   = modal.querySelector('.popup-box');
  let img   = document.getElementById('popup-img');
  let title = document.getElementById('popup-title');
  let date  = document.getElementById('popup-date');
  let desc  = document.getElementById('popup-desc');
  let cta   = document.getElementById('popup-cta');

  let lastFocus = null;

  function openPopup() {
    lastFocus = document.activeElement;
    modal.setAttribute('aria-hidden','false');
    document.body.classList.add('no-scroll');
    let closeBtn = modal.querySelector('.popup-close');
    if (closeBtn) closeBtn.focus();
    document.addEventListener('keydown', onKeydown);
  }

  function closePopup() {
    modal.setAttribute('aria-hidden','true');
    document.body.classList.remove('no-scroll');
    document.removeEventListener('keydown', onKeydown);
    if (lastFocus && typeof lastFocus.focus === 'function') {
      lastFocus.focus();
    }
  }

  function onKeydown(e) {
    if (e.key === 'Escape') closePopup();
    if (e.key === 'Tab') trapFocus(e);
  }

  function trapFocus(e){
    let focusables = box.querySelectorAll(
      'a[href],button:not([disabled]),textarea,input,select,[tabindex]:not([tabindex="-1"])'
    );
    if (!focusables.length) return;
    let first = focusables[0];
    let last  = focusables[focusables.length - 1];
    if (e.shiftKey && document.activeElement === first) {
      last.focus();
      e.preventDefault();
    } else if (!e.shiftKey && document.activeElement === last) {
      first.focus();
      e.preventDefault();
    }
  }

  // Fermer popup
  modal.addEventListener('click', (e) => {
    if (e.target.closest('[data-close="popup"]')) {
      closePopup();
    }
  });

  // Ouvrir depuis les cartes
  document.querySelectorAll('#projets .card').forEach(card => {
    card.style.cursor = 'pointer';
    card.addEventListener('click', (e) => {
      if (e.target.closest('.more-info')) return;

      let t  = card.querySelector('.bottom p:first-child')?.innerText?.trim() || '';
      let d  = card.querySelector('.bottom p:last-child')?.innerText?.trim() || '';
      let i  = card.querySelector('img')?.src || '';
      let ds = card.querySelector('.description p')?.innerText?.trim() || '';
      let l  = card.querySelector('.more-info')?.getAttribute('href');

      title.textContent = t;
      date.textContent  = d;
      img.src = i;
      img.alt = t ? `Image du projet ${t}` : 'Image du projet';
      desc.textContent  = ds;

      if (l) {
        cta.href = l;
        cta.hidden = false;
      } else {
        cta.hidden = true;
      }

      openPopup();
    });
  });
}


window.addEventListener("load", initPopup);
