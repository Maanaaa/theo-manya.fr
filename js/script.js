// Popup au clique sur un projet 
function initPopup() {
  const modal = document.getElementById('projet-modal');
  if (!modal) return;

  const box   = modal.querySelector('.popup-box');
  const img   = document.getElementById('popup-img');
  const title = document.getElementById('popup-title');
  const date  = document.getElementById('popup-date');
  const desc  = document.getElementById('popup-desc');
  const cta   = document.getElementById('popup-cta');

  let lastFocus = null;

  function openPopup() {
    lastFocus = document.activeElement;
    modal.setAttribute('aria-hidden','false');
    document.body.classList.add('no-scroll');
    const closeBtn = modal.querySelector('.popup-close');
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
    const focusables = box.querySelectorAll(
      'a[href],button:not([disabled]),textarea,input,select,[tabindex]:not([tabindex="-1"])'
    );
    if (!focusables.length) return;
    const first = focusables[0];
    const last  = focusables[focusables.length - 1];
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

      const t  = card.querySelector('.bottom p:first-child')?.innerText?.trim() || '';
      const d  = card.querySelector('.bottom p:last-child')?.innerText?.trim() || '';
      const i  = card.querySelector('img')?.src || '';
      const ds = card.querySelector('.description p')?.innerText?.trim() || '';
      const l  = card.querySelector('.more-info')?.getAttribute('href');

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
