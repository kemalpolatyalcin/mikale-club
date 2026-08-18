import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('product-detail-modal');
    const modalBackdrop = document.getElementById('modal-backdrop');
    const modalCloseBtn = document.getElementById('modal-close-btn');
    const welcomeOverlay = document.getElementById('specials-welcome-overlay');
    const welcomeCloseBtn = document.getElementById('welcome-close-btn');
    const welcomeDismissBtn = document.getElementById('welcome-dismiss-btn');
    const welcomeBackdrop = document.getElementById('welcome-backdrop');
    const cartDrawer = document.getElementById('cart-drawer');
    const openCartBtns = document.querySelectorAll('#open-cart-btn, .open-cart-btn-trigger');
    const closeCartBtn = document.getElementById('close-cart-btn');
    const cartBackdrop = document.getElementById('cart-backdrop');
    const joinTableModal = document.getElementById('join-table-modal');
    const openJoinModalBtns = document.querySelectorAll('.open-join-table-btn, .open-companion-modal-btn');
    const closeJoinModalBtn = document.getElementById('close-join-modal-btn');
    const joinModalBackdrop = document.getElementById('join-modal-backdrop');
    const searchInput = document.getElementById('menu-search');
    const toolbarSearchBtn = document.getElementById('toolbar-tab-search');
    const toolbarMenuBtn = document.getElementById('toolbar-tab-menu');

    let currentModalProduct = null;
    let cart = [];
    try {
        const savedCart = localStorage.getItem('mikale_cart');
        if (savedCart) cart = JSON.parse(savedCart);
    } catch (e) {
        cart = [];
    }

    const setActiveToolbarTab = (targetId) => {
        document.querySelectorAll('.toolbar-item').forEach(item => {
            if (item.id === targetId) {
                item.classList.add('bg-[#C5A880]/20', 'border-[#C5A880]/40', 'text-[#F5EFE6]', 'shadow-inner', 'font-semibold');
                item.classList.remove('text-[#A89C8F]', 'border-transparent');
                const svg = item.querySelector('svg');
                if (svg) svg.classList.add('text-[#C5A880]');
            } else {
                item.classList.remove('bg-[#C5A880]/20', 'border-[#C5A880]/40', 'text-[#F5EFE6]', 'shadow-inner', 'font-semibold');
                item.classList.add('text-[#A89C8F]', 'border-transparent');
                const svg = item.querySelector('svg');
                if (svg) svg.classList.remove('text-[#C5A880]');
            }
        });
    };

    const closeAllModals = () => {
        if (welcomeOverlay && !welcomeOverlay.classList.contains('hidden')) {
            welcomeOverlay.classList.add('hidden');
        }
        if (modal && !modal.classList.contains('hidden')) {
            modal.classList.add('hidden');
        }
        if (cartDrawer && !cartDrawer.classList.contains('hidden')) {
            cartDrawer.classList.add('hidden');
        }
        if (joinTableModal && !joinTableModal.classList.contains('hidden')) {
            joinTableModal.classList.add('hidden');
        }
        document.body.style.overflow = '';
    };

    const closeModal = () => {
        if (modal) modal.classList.add('hidden');
        if (!welcomeOverlay || welcomeOverlay.classList.contains('hidden')) {
            document.body.style.overflow = '';
        }
        if (window.location.pathname.includes('/reception') || window.location.pathname.includes('/portal')) {
            setActiveToolbarTab('toolbar-tab-reception');
        } else {
            setActiveToolbarTab('toolbar-tab-menu');
        }
    };

    const closeCart = () => {
        if (cartDrawer) cartDrawer.classList.add('hidden');
        document.body.style.overflow = '';
        if (window.location.pathname.includes('/reception') || window.location.pathname.includes('/portal')) {
            setActiveToolbarTab('toolbar-tab-reception');
        } else {
            setActiveToolbarTab('toolbar-tab-menu');
        }
    };

    const openCart = () => {
        closeAllModals();
        setActiveToolbarTab('toolbar-tab-cart');
        if (cartDrawer) {
            cartDrawer.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
    };

    const openJoinModal = () => {
        closeAllModals();
        setActiveToolbarTab('toolbar-tab-join');
        if (joinTableModal) {
            joinTableModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
    };

    const closeWelcomeOverlay = () => {
        if (!welcomeOverlay) return;
        welcomeOverlay.classList.add('opacity-0', 'pointer-events-none', 'transition-all', 'duration-500');
        setTimeout(() => {
            welcomeOverlay.classList.add('hidden');
            document.body.style.overflow = '';
        }, 350);
    };

    if (welcomeOverlay) {
        document.body.style.overflow = 'hidden';
        if (welcomeCloseBtn) welcomeCloseBtn.addEventListener('click', closeWelcomeOverlay);
        if (welcomeDismissBtn) welcomeDismissBtn.addEventListener('click', closeWelcomeOverlay);
        if (welcomeBackdrop) welcomeBackdrop.addEventListener('click', closeWelcomeOverlay);
    }

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

        searchInput.addEventListener('focus', () => {
            setActiveToolbarTab('toolbar-tab-search');
        });

        searchInput.addEventListener('blur', () => {
            if (document.getElementById('cart-drawer')?.classList.contains('hidden') && document.getElementById('join-table-modal')?.classList.contains('hidden')) {
                setActiveToolbarTab('toolbar-tab-menu');
            }
        });
    }

    if (toolbarSearchBtn) {
        toolbarSearchBtn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            closeAllModals();
            setActiveToolbarTab('toolbar-tab-search');
            
            const targetSearch = document.getElementById('menu-search');
            if (targetSearch) {
                targetSearch.scrollIntoView({ behavior: 'smooth', block: 'center' });
                setTimeout(() => {
                    targetSearch.focus();
                }, 200);
            } else {
                window.location.href = '/#menu-search';
            }
        });
    }

    if (toolbarMenuBtn) {
        toolbarMenuBtn.addEventListener('click', (e) => {
            closeAllModals();
            setActiveToolbarTab('toolbar-tab-menu');
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    const updateCartUI = () => {
        try {
            localStorage.setItem('mikale_cart', JSON.stringify(cart));
        } catch (e) {}

        const totalCount = cart.reduce((acc, item) => acc + item.quantity, 0);
        const totalPrice = cart.reduce((acc, item) => acc + (item.price * item.quantity), 0);

        const toolbarBadge = document.getElementById('toolbar-cart-badge');
        if (toolbarBadge) {
            toolbarBadge.textContent = totalCount;
            if (totalCount > 0) {
                toolbarBadge.classList.remove('scale-0');
                toolbarBadge.classList.add('scale-100');
            } else {
                toolbarBadge.classList.add('scale-0');
                toolbarBadge.classList.remove('scale-100');
            }
        }

        const cartItemsList = document.getElementById('cart-items-container');
        const cartDrawerTotal = document.getElementById('cart-drawer-total');
        if (cartItemsList) {
            if (cart.length === 0) {
                cartItemsList.innerHTML = '<div class="text-center py-10 text-[#8C8276] text-xs">Sepetinizde ürün bulunmuyor.</div>';
            } else {
                cartItemsList.innerHTML = cart.map((item, index) => `
                    <div class="lux-card rounded-xl p-3.5 flex items-center justify-between gap-3">
                        <div class="flex-1 min-w-0">
                            <h5 class="font-lux-title text-xs md:text-sm text-[#F5EFE6] truncate">${item.name}</h5>
                            <span class="text-[10px] text-[#C5A880] block">${(item.price * item.quantity).toLocaleString('tr-TR')} ₺</span>
                            ${item.notes ? `<span class="text-[9px] text-[#8C8276] italic block truncate">Not: ${item.notes}</span>` : ''}
                        </div>
                        <div class="flex items-center gap-2 flex-shrink-0">
                            <button data-idx="${index}" class="cart-qty-minus w-6 h-6 rounded-full bg-[#1F1B16] border border-[#C5A880]/30 text-[#C5A880] flex items-center justify-center text-xs hover:text-white">-</button>
                            <span class="text-xs font-mono text-[#F5EFE6] w-4 text-center">${item.quantity}</span>
                            <button data-idx="${index}" class="cart-qty-plus w-6 h-6 rounded-full bg-[#1F1B16] border border-[#C5A880]/30 text-[#C5A880] flex items-center justify-center text-xs hover:text-white">+</button>
                        </div>
                    </div>
                `).join('');

                cartItemsList.querySelectorAll('.cart-qty-minus').forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        const idx = parseInt(btn.getAttribute('data-idx'));
                        if (cart[idx].quantity > 1) {
                            cart[idx].quantity--;
                        } else {
                            cart.splice(idx, 1);
                        }
                        updateCartUI();
                    });
                });

                cartItemsList.querySelectorAll('.cart-qty-plus').forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        const idx = parseInt(btn.getAttribute('data-idx'));
                        cart[idx].quantity++;
                        updateCartUI();
                    });
                });
            }
        }

        if (cartDrawerTotal) {
            cartDrawerTotal.textContent = totalPrice.toLocaleString('tr-TR') + ' ₺';
        }
    };

    window.addToCart = (product, quantity = 1, notes = '') => {
        const existing = cart.find(i => i.product_id === product.id && i.notes === notes);
        if (existing) {
            existing.quantity += quantity;
        } else {
            cart.push({
                product_id: product.id,
                name: product.name,
                price: parseFloat(product.price),
                quantity: quantity,
                notes: notes
            });
        }
        updateCartUI();

        const toast = document.getElementById('order-toast');
        if (toast) {
            document.getElementById('toast-msg').textContent = `${product.name} sepete eklendi.`;
            toast.classList.remove('translate-y-32', 'opacity-0', 'pointer-events-none');
            toast.classList.add('translate-y-0', 'opacity-100');
            setTimeout(() => {
                toast.classList.add('translate-y-32', 'opacity-0', 'pointer-events-none');
                toast.classList.remove('translate-y-0', 'opacity-100');
            }, 2500);
        }
    };

    updateCartUI();

    openCartBtns.forEach(btn => btn.addEventListener('click', openCart));
    if (closeCartBtn) closeCartBtn.addEventListener('click', closeCart);
    if (cartBackdrop) cartBackdrop.addEventListener('click', closeCart);

    const submitOrderBtn = document.getElementById('submit-order-btn');
    if (submitOrderBtn) {
        submitOrderBtn.addEventListener('click', async () => {
            const tableNumber = submitOrderBtn.getAttribute('data-table');
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            if (cart.length === 0) return;

            submitOrderBtn.disabled = true;
            submitOrderBtn.textContent = 'İletiliyor...';

            try {
                const response = await fetch('/orders/submit', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken || ''
                    },
                    body: JSON.stringify({
                        table_number: tableNumber,
                        items: cart,
                        note: document.getElementById('order-general-note')?.value || ''
                    })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    cart = [];
                    updateCartUI();
                    closeCart();
                    alert(`✅ ${data.message}\nSipariş No: ${data.order_number}\nTutar: ${data.total}`);
                    window.location.reload();
                } else {
                    alert(`Uyarı: ${data.message || 'Sipariş iletilemedi.'}`);
                    if (response.status === 401) {
                        closeCart();
                        openJoinModal();
                    }
                }
            } catch (err) {
                alert('Bir bağlantı hatası oluştu.');
            } finally {
                submitOrderBtn.disabled = false;
                submitOrderBtn.textContent = 'Siparişi Masaya İlet';
            }
        });
    }

    const openModal = (data) => {
        if (!modal) return;
        closeAllModals();
        currentModalProduct = data;
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

    document.querySelectorAll('.open-product-modal').forEach(card => {
        card.addEventListener('click', (e) => {
            if (e.target.closest('.quick-add-btn')) return;
            const data = {
                id: card.getAttribute('data-id'),
                name: card.getAttribute('data-name'),
                subtitle: card.getAttribute('data-subtitle'),
                desc: card.getAttribute('data-desc'),
                notes: card.getAttribute('data-notes'),
                price: card.getAttribute('data-price'),
                rawPrice: card.getAttribute('data-raw-price'),
                origPrice: card.getAttribute('data-orig-price'),
                badge: card.getAttribute('data-badge'),
                abv: card.getAttribute('data-abv'),
                vol: card.getAttribute('data-vol'),
            };
            openModal(data);
        });
    });

    document.querySelectorAll('.quick-add-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            const id = btn.getAttribute('data-id');
            const name = btn.getAttribute('data-name');
            const price = parseFloat(btn.getAttribute('data-price'));
            window.addToCart({ id: id, name: name, price: price }, 1, '');
        });
    });

    const modalAddBtn = document.getElementById('modal-add-to-cart-btn');
    if (modalAddBtn) {
        modalAddBtn.addEventListener('click', () => {
            if (currentModalProduct) {
                const notes = document.getElementById('modal-order-note')?.value || '';
                window.addToCart({
                    id: currentModalProduct.id,
                    name: currentModalProduct.name,
                    price: parseFloat(currentModalProduct.rawPrice || 0)
                }, 1, notes);
                closeModal();
            }
        });
    }

    if (modalCloseBtn) modalCloseBtn.addEventListener('click', closeModal);
    if (modalBackdrop) modalBackdrop.addEventListener('click', closeModal);

    openJoinModalBtns.forEach(btn => btn.addEventListener('click', openJoinModal));
    if (closeJoinModalBtn) closeJoinModalBtn.addEventListener('click', () => {
        if (joinTableModal) joinTableModal.classList.add('hidden');
        document.body.style.overflow = '';
        if (window.location.pathname.includes('/reception') || window.location.pathname.includes('/portal')) {
            setActiveToolbarTab('toolbar-tab-reception');
        } else {
            setActiveToolbarTab('toolbar-tab-menu');
        }
    });

    if (joinModalBackdrop) joinModalBackdrop.addEventListener('click', () => {
        if (joinTableModal) joinTableModal.classList.add('hidden');
        document.body.style.overflow = '';
        if (window.location.pathname.includes('/reception') || window.location.pathname.includes('/portal')) {
            setActiveToolbarTab('toolbar-tab-reception');
        } else {
            setActiveToolbarTab('toolbar-tab-menu');
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeAllModals();
            if (window.location.pathname.includes('/reception') || window.location.pathname.includes('/portal')) {
                setActiveToolbarTab('toolbar-tab-reception');
            } else {
                setActiveToolbarTab('toolbar-tab-menu');
            }
        }
    });
});
