import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    const revealElements = document.querySelectorAll('.reveal-left, .reveal-right, .reveal-up');
    
    if ('IntersectionObserver' in window) {
        const revealObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.08,
            rootMargin: '0px 0px -25px 0px'
        });

        revealElements.forEach(el => revealObserver.observe(el));
    } else {
        revealElements.forEach(el => el.classList.add('is-visible'));
    }

    const categoryButtons = document.querySelectorAll('.category-nav-btn');
    const sections = document.querySelectorAll('.category-section');

    window.addEventListener('scroll', () => {
        let currentSectionId = '';
        const scrollPosition = window.scrollY + 160;

        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.offsetHeight;
            if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
                currentSectionId = section.getAttribute('id');
            }
        });

        if (currentSectionId) {
            categoryButtons.forEach(btn => {
                const target = btn.getAttribute('data-target');
                if (target === currentSectionId) {
                    btn.classList.add('bg-[#C5A880]', 'text-[#0D0C0A]', 'border-[#C5A880]', 'font-medium', 'shadow-md', 'shadow-[#C5A880]/20');
                    btn.classList.remove('bg-[#181614]', 'text-[#A89C8F]', 'border-[#C5A880]/20');
                    btn.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
                } else {
                    btn.classList.remove('bg-[#C5A880]', 'text-[#0D0C0A]', 'border-[#C5A880]', 'font-medium', 'shadow-md', 'shadow-[#C5A880]/20');
                    btn.classList.add('bg-[#181614]', 'text-[#A89C8F]', 'border-[#C5A880]/20');
                }
            });
        }
    }, { passive: true });

    const searchInput = document.getElementById('menu-search');
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            const query = e.target.value.toLowerCase().trim();
            const productCards = document.querySelectorAll('.product-card');

            productCards.forEach(card => {
                const title = card.getAttribute('data-name')?.toLowerCase() || '';
                const desc = card.getAttribute('data-desc')?.toLowerCase() || '';
                const notes = card.getAttribute('data-notes')?.toLowerCase() || '';

                if (title.includes(query) || desc.includes(query) || notes.includes(query)) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }

    const modal = document.getElementById('product-detail-modal');
    const modalBackdrop = document.getElementById('modal-backdrop');
    const modalCloseBtn = document.getElementById('modal-close-btn');

    const openModal = (data) => {
        if (!modal) return;
        document.getElementById('modal-title').textContent = data.name || '';
        document.getElementById('modal-subtitle').textContent = data.subtitle || '';
        document.getElementById('modal-price').textContent = data.price || '';
        
        const origPriceEl = document.getElementById('modal-orig-price');
        if (data.origPrice) {
            origPriceEl.textContent = data.origPrice;
            origPriceEl.style.display = 'block';
        } else {
            origPriceEl.style.display = 'none';
        }

        const badgeEl = document.getElementById('modal-badge');
        if (data.badge) {
            badgeEl.textContent = data.badge;
            badgeEl.style.display = 'inline-block';
        } else {
            badgeEl.style.display = 'none';
        }

        const abvEl = document.getElementById('modal-abv');
        if (data.abv && data.abv > 0) {
            abvEl.textContent = '%' + data.abv + ' ABV';
            abvEl.style.display = 'inline-block';
        } else {
            abvEl.style.display = 'none';
        }

        const volEl = document.getElementById('modal-vol');
        if (data.vol) {
            volEl.textContent = data.vol + ' ml';
            volEl.style.display = 'inline-block';
        } else {
            volEl.style.display = 'none';
        }

        document.getElementById('modal-desc').textContent = data.desc || '';
        
        const notesContainer = document.getElementById('modal-notes-container');
        const notesEl = document.getElementById('modal-notes');
        if (data.notes) {
            notesEl.textContent = data.notes;
            notesContainer.style.display = 'flex';
        } else {
            notesContainer.style.display = 'none';
        }

        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    };

    const closeModal = () => {
        if (!modal) return;
        modal.classList.add('hidden');
        if (!welcomeOverlay || welcomeOverlay.classList.contains('hidden')) {
            document.body.style.overflow = '';
        }
    };

    document.querySelectorAll('.open-product-modal').forEach(card => {
        card.addEventListener('click', () => {
            const data = {
                name: card.getAttribute('data-name'),
                subtitle: card.getAttribute('data-subtitle'),
                desc: card.getAttribute('data-desc'),
                notes: card.getAttribute('data-notes'),
                price: card.getAttribute('data-price'),
                origPrice: card.getAttribute('data-orig-price'),
                badge: card.getAttribute('data-badge'),
                abv: card.getAttribute('data-abv'),
                vol: card.getAttribute('data-vol'),
            };
            openModal(data);
        });
    });

    if (modalCloseBtn) modalCloseBtn.addEventListener('click', closeModal);
    if (modalBackdrop) modalBackdrop.addEventListener('click', closeModal);

    const welcomeOverlay = document.getElementById('specials-welcome-overlay');
    const welcomeCloseBtn = document.getElementById('welcome-close-btn');
    const welcomeDismissBtn = document.getElementById('welcome-dismiss-btn');
    const welcomeBackdrop = document.getElementById('welcome-backdrop');

    const closeWelcomeOverlay = () => {
        if (!welcomeOverlay) return;
        welcomeOverlay.classList.add('opacity-0', 'pointer-events-none', 'transition-all', 'duration-500');
        setTimeout(() => {
            welcomeOverlay.classList.add('hidden');
            document.body.style.overflow = '';
        }, 450);
    };

    if (welcomeOverlay) {
        document.body.style.overflow = 'hidden';
        if (welcomeCloseBtn) welcomeCloseBtn.addEventListener('click', closeWelcomeOverlay);
        if (welcomeDismissBtn) welcomeDismissBtn.addEventListener('click', closeWelcomeOverlay);
        if (welcomeBackdrop) welcomeBackdrop.addEventListener('click', closeWelcomeOverlay);
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            if (modal && !modal.classList.contains('hidden')) {
                closeModal();
            } else if (welcomeOverlay && !welcomeOverlay.classList.contains('hidden')) {
                closeWelcomeOverlay();
            }
        }
    });
});
