import './bootstrap';
import Alpine from 'alpinejs';

// ── Project Modal / Dialog Component (Alpine.js) ──────────────────────────
Alpine.data('projectModal', (projects = []) => ({
    projects: projects || [],
    isOpen: false,
    activeProject: null,
    activeGalleryIndex: null,
    triggerEl: null,
    touchStartX: 0,
    touchEndX: 0,

    init() {
        this.checkHash();
        window.addEventListener('popstate', () => this.checkHash());
        window.addEventListener('hashchange', () => this.checkHash());
    },

    checkHash() {
        const hash = window.location.hash;
        if (hash && (hash.startsWith('#projects-') || hash.startsWith('#proyek-'))) {
            const slug = hash.replace(/^#(projects|proyek)-/, '');
            const found = this.projects.find(p => p.slug === slug);
            if (found) {
                this.openProject(found.slug, null, false);
            }
        } else if (this.isOpen) {
            this.close(false);
        }
    },

    openProject(slug, triggerEl = null, updateHash = true) {
        const found = this.projects.find(p => p.slug === slug);
        if (!found) return;

        this.activeProject = found;
        this.activeGalleryIndex = null;
        this.triggerEl = triggerEl || document.getElementById('project-card-' + slug);
        this.isOpen = true;
        document.body.style.overflow = 'hidden';

        if (updateHash && window.location.hash !== '#projects-' + slug) {
            history.pushState({ modal: slug }, '', '#projects-' + slug);
        }

        this.$nextTick(() => {
            const modal = this.$refs.dialogContent;
            if (modal) {
                const focusable = modal.querySelectorAll('button:not([disabled]), [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
                if (focusable.length) {
                    focusable[0].focus();
                }
            }
        });
    },

    close(updateHash = true) {
        this.isOpen = false;
        this.activeGalleryIndex = null;
        document.body.style.overflow = '';

        if (updateHash && (window.location.hash.startsWith('#projects-') || window.location.hash.startsWith('#proyek-'))) {
            history.pushState(null, '', window.location.pathname + '#projects');
        }

        if (this.triggerEl) {
            this.triggerEl.focus();
        }
    },

    openGallery(index) {
        if (!this.activeProject || !this.activeProject.gallery || !this.activeProject.gallery[index]) return;
        this.activeGalleryIndex = index;
        this.$nextTick(() => {
            const backBtn = this.$refs.galleryBackBtn;
            if (backBtn) backBtn.focus();
        });
    },

    backToDetail() {
        this.activeGalleryIndex = null;
        this.$nextTick(() => {
            const closeBtn = this.$refs.modalCloseBtn;
            if (closeBtn) closeBtn.focus();
        });
    },

    prevGallery() {
        if (!this.activeProject || !this.activeProject.gallery.length) return;
        if (this.activeGalleryIndex > 0) {
            this.activeGalleryIndex--;
        } else {
            this.activeGalleryIndex = this.activeProject.gallery.length - 1;
        }
    },

    nextGallery() {
        if (!this.activeProject || !this.activeProject.gallery.length) return;
        if (this.activeGalleryIndex < this.activeProject.gallery.length - 1) {
            this.activeGalleryIndex++;
        } else {
            this.activeGalleryIndex = 0;
        }
    },

    handleKeyDown(e) {
        if (!this.isOpen) return;

        if (e.key === 'Escape') {
            e.preventDefault();
            if (this.activeGalleryIndex !== null) {
                this.backToDetail();
            } else {
                this.close();
            }
            return;
        }

        if (this.activeGalleryIndex !== null) {
            if (e.key === 'ArrowLeft') {
                e.preventDefault();
                this.prevGallery();
                return;
            } else if (e.key === 'ArrowRight') {
                e.preventDefault();
                this.nextGallery();
                return;
            }
        }

        // Focus trap di dalam modal dialog
        if (e.key === 'Tab') {
            const modal = this.$refs.dialogContent;
            if (!modal) return;
            const focusables = Array.from(modal.querySelectorAll('button:not([disabled]), [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'))
                .filter(el => el.offsetParent !== null);
            if (!focusables.length) return;

            const first = focusables[0];
            const last = focusables[focusables.length - 1];

            if (e.shiftKey) {
                if (document.activeElement === first || !modal.contains(document.activeElement)) {
                    e.preventDefault();
                    last.focus();
                }
            } else {
                if (document.activeElement === last || !modal.contains(document.activeElement)) {
                    e.preventDefault();
                    first.focus();
                }
            }
        }
    },

    handleTouchStart(e) {
        if (e.changedTouches && e.changedTouches[0]) {
            this.touchStartX = e.changedTouches[0].screenX;
        }
    },

    handleTouchEnd(e) {
        if (e.changedTouches && e.changedTouches[0]) {
            this.touchEndX = e.changedTouches[0].screenX;
            const diff = this.touchEndX - this.touchStartX;
            if (Math.abs(diff) > 45 && this.activeGalleryIndex !== null) {
                if (diff < 0) {
                    this.nextGallery(); // swipe kiri -> gambar berikutnya
                } else {
                    this.prevGallery(); // swipe kanan -> gambar sebelumnya
                }
            }
        }
    }
}));

window.Alpine = Alpine;
Alpine.start();

// ── Theme Toggle (Dark / Light) ───────────────────────────────────────────
function initThemeToggle() {
    const toggleBtn = document.getElementById('theme-toggle');
    if (!toggleBtn) return;

    function updateAria(isDark) {
        const label = isDark ? 'Switch to light mode' : 'Switch to dark mode';
        toggleBtn.setAttribute('aria-label', label);
        toggleBtn.setAttribute('title', label);
    }

    // Set initial aria state
    updateAria(document.documentElement.classList.contains('dark'));

    toggleBtn.addEventListener('click', () => {
        const isDark = document.documentElement.classList.toggle('dark');
        if (isDark) {
            document.documentElement.classList.remove('light');
            localStorage.setItem('theme', 'dark');
        } else {
            document.documentElement.classList.add('light');
            localStorage.setItem('theme', 'light');
        }
        updateAria(isDark);
    });

    // Sinkronisasi bila preferensi OS berubah dan user belum memilih manual
    if (window.matchMedia) {
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
            if (!localStorage.getItem('theme')) {
                const prefersDark = e.matches;
                if (prefersDark) {
                    document.documentElement.classList.add('dark');
                    document.documentElement.classList.remove('light');
                } else {
                    document.documentElement.classList.remove('dark');
                    document.documentElement.classList.add('light');
                }
                updateAria(prefersDark);
            }
        });
    }
}

// ── Liquid Glass Navbar: Sliding Bubble Indicator & Interaction ───────────
function initNavbarObserver() {
    const track = document.querySelector('.nav-links-track');
    const bubble = document.getElementById('nav-bubble');
    if (!track || !bubble) return;

    const navLinks = Array.from(track.querySelectorAll('.glass-nav-link[data-section]'));
    if (!navLinks.length) return;

    let activeLink = navLinks.find(l => l.classList.contains('active')) || navLinks[0];
    let isClickScrolling = false;
    let clickScrollTimeout = null;
    let isHovering = false;

    const hasHoverSupport = window.matchMedia && window.matchMedia('(hover: hover) and (pointer: fine)').matches;

    // Geser gelembung kaca secara mulus ke item target
    function moveNavBubble(targetLink) {
        if (!bubble || !targetLink) return;
        const trackRect = track.getBoundingClientRect();
        const linkRect = targetLink.getBoundingClientRect();

        const left = linkRect.left - trackRect.left;
        const width = linkRect.width;

        bubble.style.width = `${width}px`;
        bubble.style.transform = `translate3d(${left}px, 0, 0)`;
        bubble.style.opacity = '1';
    }

    // Tetapkan item aktif, update aria-current="true", dan perbarui gelembung
    function setActive(link, moveBubble = true) {
        if (!link) return;
        activeLink = link;
        navLinks.forEach(l => {
            if (l === link) {
                l.classList.add('active');
                l.setAttribute('aria-current', 'true');
            } else {
                l.classList.remove('active');
                l.removeAttribute('aria-current');
            }
        });

        if (moveBubble && !isHovering) {
            moveNavBubble(link);
        }
    }

    // Inisialisasi awal posisi gelembung
    setActive(activeLink, true);

    // 1. Hover: gelembung bergeser mengikuti item yang di-hover; kembali ke active saat kursor keluar
    if (hasHoverSupport) {
        navLinks.forEach(link => {
            link.addEventListener('mouseenter', () => {
                isHovering = true;
                moveNavBubble(link);
            });
        });

        track.addEventListener('mouseleave', () => {
            isHovering = false;
            if (activeLink) {
                moveNavBubble(activeLink);
            }
        });
    }

    // 2. Klik: berpindah ke item aktif, biarkan browser scroll normal ke anchor, kunci scroll-spy sementara
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            setActive(link, true);
            isClickScrolling = true;
            if (clickScrollTimeout) clearTimeout(clickScrollTimeout);
            clickScrollTimeout = setTimeout(() => {
                isClickScrolling = false;
            }, 850);
        });
    });

    // 3. Keyboard: Tab/Shift+Tab fokus, gelembung mengikuti fokus, kembali ke active saat blur
    navLinks.forEach(link => {
        link.addEventListener('focus', () => {
            moveNavBubble(link);
        });
        link.addEventListener('blur', () => {
            setTimeout(() => {
                if (!track.contains(document.activeElement) && !isHovering) {
                    if (activeLink) moveNavBubble(activeLink);
                }
            }, 30);
        });
    });

    // 4. Scroll-spy (IntersectionObserver)
    const sections = [];
    navLinks.forEach(link => {
        const id = link.dataset.section;
        const sec = document.getElementById(id);
        if (sec && !sections.includes(sec)) sections.push(sec);
    });

    if (sections.length && 'IntersectionObserver' in window) {
        // rootMargin diperhitungkan dari tinggi navbar (~90px) + margin atas.
        // Zone aktif: antara 40% dari atas dan 55% dari bawah viewport,
        // sehingga section tinggi seperti Projects tidak "mencuri" item sebelumnya.
        const observer = new IntersectionObserver((entries) => {
            if (isClickScrolling) return;

            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const currentId = entry.target.id;
                    const targetLink = navLinks.find(l => l.dataset.section === currentId);
                    if (targetLink && targetLink !== activeLink) {
                        setActive(targetLink, !isHovering);
                    }
                }
            });
        }, {
            root: null,
            rootMargin: '-40% 0px -55% 0px',
            threshold: 0
        });

        sections.forEach(sec => observer.observe(sec));

        // Penanganan saat pengguna scroll mendekati atas (home) atau dasar halaman (kontak)
        window.addEventListener('scroll', () => {
            if (isClickScrolling) return;
            if (window.scrollY < 80) {
                const homeLink = navLinks.find(l => l.dataset.section === 'home');
                if (homeLink && homeLink !== activeLink) {
                    setActive(homeLink, !isHovering);
                }
                return;
            }
            const scrollPos = window.innerHeight + window.scrollY;
            const totalHeight = document.documentElement.scrollHeight;
            if (scrollPos >= totalHeight - 40) {
                const contactLink = navLinks.find(l => l.dataset.section === 'contact');
                if (contactLink && contactLink !== activeLink) {
                    setActive(contactLink, !isHovering);
                }
            }
        }, { passive: true });
    }

    // Penyesuaian saat resize
    window.addEventListener('resize', () => {
        if (activeLink) moveNavBubble(activeLink);
    });

    // Timeout untuk memastikan font dan layout selesai dirender
    setTimeout(() => {
        if (activeLink) moveNavBubble(activeLink);
    }, 150);
}

// ── Liquid Glass: Hover Sheen (Radial Gradient Following Cursor) ───────────
function initGlassHoverSheen() {
    // Nonaktif di layar sentuh
    if (window.matchMedia && !window.matchMedia('(hover: hover) and (pointer: fine)').matches) {
        return;
    }

    // Hormati prefers-reduced-motion
    if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
    }

    const pills = document.querySelectorAll('.liquid-glass-pill');
    pills.forEach(pill => {
        pill.addEventListener('pointerenter', () => {
            pill.style.setProperty('--glow-opacity', '1');
        });
        pill.addEventListener('pointerleave', () => {
            pill.style.setProperty('--glow-opacity', '0');
        });
        pill.addEventListener('pointermove', (e) => {
            const rect = pill.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            pill.style.setProperty('--mouse-x', `${x}px`);
            pill.style.setProperty('--mouse-y', `${y}px`);
        });
    });
}

// ── Progressive Enhancement: Filter SVG Check ─────────────────────────────
function checkSvgBackdropSupport() {
    try {
        if (window.CSS && CSS.supports && (
            CSS.supports('backdrop-filter', 'url(#liquid-glass)') ||
            CSS.supports('-webkit-backdrop-filter', 'url(#liquid-glass)')
        )) {
            document.querySelectorAll('.liquid-glass-pill').forEach(el => {
                el.classList.add('has-svg-filter');
            });
        }
    } catch (e) {
        // Fallback Tingkat 1
    }
}

// ── Scroll Progress & Navbar Scrolled Shrinkage ────────────────────────────
function initScrollProgressAndNavbar() {
    const progressFill = document.getElementById('scroll-progress-fill');
    const floatingNav = document.getElementById('floating-navbar');

    function onScroll() {
        const scrollTop = window.scrollY || document.documentElement.scrollTop;
        const docHeight = document.documentElement.scrollHeight - window.innerHeight;

        if (progressFill && docHeight > 0) {
            const progress = Math.min(100, Math.max(0, (scrollTop / docHeight) * 100));
            progressFill.style.width = `${progress}%`;
        }

        if (floatingNav) {
            if (scrollTop > 40) {
                floatingNav.classList.add('is-scrolled');
            } else {
                floatingNav.classList.remove('is-scrolled');
            }
        }
    }

    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
}

// ── Card Spotlight Effect (Radial Glow Following Cursor) ───────────────────
function initCardSpotlight() {
    if (window.matchMedia && !window.matchMedia('(hover: hover) and (pointer: fine)').matches) {
        return;
    }
    if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
    }

    const cards = document.querySelectorAll('.depth-card');
    cards.forEach(card => {
        card.addEventListener('pointerenter', () => {
            card.style.setProperty('--card-spotlight-opacity', '1');
        });
        card.addEventListener('pointerleave', () => {
            card.style.setProperty('--card-spotlight-opacity', '0');
        });
        card.addEventListener('pointermove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            card.style.setProperty('--card-spotlight-x', `${x}px`);
            card.style.setProperty('--card-spotlight-y', `${y}px`);
        });
    });
}

// ── 3D Card Tilt (Max 4-5 degrees on Hero Profile Card) ────────────────────
function initCardTilt() {
    if (window.matchMedia && !window.matchMedia('(hover: hover) and (pointer: fine)').matches) {
        return;
    }
    if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
    }

    const tiltContainers = document.querySelectorAll('.tilt-card-container');
    tiltContainers.forEach(container => {
        const card = container.querySelector('.tilt-card') || container;

        container.addEventListener('pointermove', (e) => {
            const rect = container.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;

            // Maksimal 4-5 derajat tilt halus
            const rotateX = ((y - centerY) / centerY) * -4.5;
            const rotateY = ((x - centerX) / centerX) * 4.5;

            card.style.transform = `rotateX(${rotateX.toFixed(2)}deg) rotateY(${rotateY.toFixed(2)}deg)`;
        });

        container.addEventListener('pointerleave', () => {
            card.style.transform = 'rotateX(0deg) rotateY(0deg)';
        });
    });
}

// ── Scroll Reveal Stagger ─────────────────────────────────────────────────
function initStaggeredReveal() {
    const reveals = document.querySelectorAll('.scroll-reveal');
    if (!reveals.length) return;

    if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        reveals.forEach(el => el.classList.add('visible'));
        return;
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    reveals.forEach(el => observer.observe(el));
}

// Inisialisasi Seluruh Fitur Interaksi saat DOM Ready
function initApp() {
    initThemeToggle();
    initNavbarObserver();
    initGlassHoverSheen();
    checkSvgBackdropSupport();
    initScrollProgressAndNavbar();
    initCardSpotlight();
    initCardTilt();
    initStaggeredReveal();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initApp);
} else {
    initApp();
}

// ── Skill Bar Animation ───────────────────────────────────────────────────
const skillObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.querySelectorAll('.skill-bar').forEach(bar => {
                const width = bar.dataset.width;
                setTimeout(() => { bar.style.width = width + '%'; }, 200);
            });
            skillObserver.unobserve(entry.target);
        }
    });
}, { threshold: 0.2 });

document.querySelectorAll('#skills').forEach(el => skillObserver.observe(el));

// ── Design Gallery Filter ─────────────────────────────────────────────────
const filterBtns = document.querySelectorAll('.filter-btn');
const designItems = document.querySelectorAll('.design-item');

filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        filterBtns.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        const filter = btn.dataset.filter;
        designItems.forEach(item => {
            if (filter === 'all' || item.dataset.category === filter) {
                item.style.display = '';
                item.style.opacity = '1';
            } else {
                item.style.display = 'none';
            }
        });
    });
});

// ── Lightbox ──────────────────────────────────────────────────────────────
window.openLightbox = function(src, title, category) {
    const lb = document.getElementById('lightbox');
    if (!lb) return;
    const img = document.getElementById('lightbox-img');
    if (img) {
        img.src = src;
        img.alt = title;
    }
    const tEl = document.getElementById('lightbox-title');
    if (tEl) tEl.textContent = title;
    const cEl = document.getElementById('lightbox-cat');
    if (cEl) cEl.textContent = category;
    lb.classList.add('open');
    document.body.style.overflow = 'hidden';
};

window.closeLightbox = function(e) {
    if (e.target === document.getElementById('lightbox')) {
        closeLightboxBtn();
    }
};

window.closeLightboxBtn = function() {
    const lb = document.getElementById('lightbox');
    if (lb) lb.classList.remove('open');
    document.body.style.overflow = '';
};

// Close lightbox with Escape key
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeLightboxBtn();
});

// ── Admin: Image Preview ──────────────────────────────────────────────────
document.querySelectorAll('input[type="file"][data-preview]').forEach(input => {
    input.addEventListener('change', function () {
        const previewId = this.dataset.preview;
        const preview = document.getElementById(previewId);
        if (!preview) return;
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    });
});

// ── Admin: Confirm Delete ─────────────────────────────────────────────────
document.querySelectorAll('[data-confirm]').forEach(el => {
    el.addEventListener('click', function(e) {
        if (!confirm(this.dataset.confirm || 'Yakin ingin menghapus?')) {
            e.preventDefault();
        }
    });
});
