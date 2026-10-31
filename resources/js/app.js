import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// ── Scroll Reveal ─────────────────────────────────────────────────────────
const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry, i) => {
        if (entry.isIntersecting) {
            const delay = entry.target.style.animationDelay || '0s';
            entry.target.style.transitionDelay = delay;
            entry.target.classList.add('visible');
            revealObserver.unobserve(entry.target);
        }
    });
}, { threshold: 0.12 });

document.querySelectorAll('.scroll-reveal').forEach(el => revealObserver.observe(el));

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
    document.getElementById('lightbox-img').src = src;
    document.getElementById('lightbox-img').alt = title;
    document.getElementById('lightbox-title').textContent = title;
    document.getElementById('lightbox-cat').textContent = category;
    lb.classList.add('open');
    document.body.style.overflow = 'hidden';
};

window.closeLightbox = function(e) {
    if (e.target === document.getElementById('lightbox')) {
        closeLightboxBtn();
    }
};

window.closeLightboxBtn = function() {
    document.getElementById('lightbox').classList.remove('open');
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
