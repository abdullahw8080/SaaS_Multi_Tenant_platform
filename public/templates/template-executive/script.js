/**
 * Executive Prestige Template — script.js
 * Premium Vanilla JS — No dependencies
 */
document.addEventListener('DOMContentLoaded', () => {

  /* ─────────────────────────────────────────
     1. NAVBAR SCROLL EFFECT
  ───────────────────────────────────────── */
  const navbar = document.querySelector('.navbar');
  if (navbar && !navbar.classList.contains('exec-navbar--static')) {
    const onScroll = () => navbar.classList.toggle('scrolled', window.scrollY > 80);
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll(); // run once on load
  }

  /* ─────────────────────────────────────────
     2. HAMBURGER MENU
  ───────────────────────────────────────── */
  const hamburger = document.querySelector('.hamburger');
  const mobileMenu = document.querySelector('.navbar__links');

  hamburger?.addEventListener('click', () => {
    const isOpen = hamburger.getAttribute('aria-expanded') === 'true';
    hamburger.setAttribute('aria-expanded', String(!isOpen));
    mobileMenu?.classList.toggle('is-open', !isOpen);
    document.body.style.overflow = !isOpen ? 'hidden' : '';
  });

  mobileMenu?.querySelectorAll('a').forEach(link =>
    link.addEventListener('click', () => {
      hamburger?.setAttribute('aria-expanded', 'false');
      mobileMenu.classList.remove('is-open');
      document.body.style.overflow = '';
    })
  );

  // Close on Escape
  document.addEventListener('keydown', e => {
    if (e.key === 'Escape' && mobileMenu?.classList.contains('is-open')) {
      hamburger?.setAttribute('aria-expanded', 'false');
      mobileMenu.classList.remove('is-open');
      document.body.style.overflow = '';
    }
  });

  /* ─────────────────────────────────────────
     3. INTERSECTION OBSERVER — Animation Trigger
  ───────────────────────────────────────── */
  const animObserver = new IntersectionObserver(
    (entries) => entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('is-visible');
        animObserver.unobserve(entry.target); // one-shot
      }
    }),
    { threshold: 0.1, rootMargin: '0px 0px -40px 0px' }
  );

  document.querySelectorAll('.fade-in-up, .timeline__item').forEach(el =>
    animObserver.observe(el)
  );

  /* ─────────────────────────────────────────
     4. COUNTER ANIMATION (Hero Stats)
  ───────────────────────────────────────── */
  function easeOutQuart(t) { return 1 - Math.pow(1 - t, 4); }

  function animateCounter(el, target, duration = 2000) {
    const start = performance.now();
    const suffix = el.dataset.suffix || '';

    const update = (now) => {
      const elapsed  = now - start;
      const progress = Math.min(elapsed / duration, 1);
      const current  = Math.round(easeOutQuart(progress) * target);
      el.textContent = current.toLocaleString() + suffix;
      if (progress < 1) requestAnimationFrame(update);
    };
    requestAnimationFrame(update);
  }

  const statsSection = document.querySelector('.hero__stats');
  if (statsSection) {
    const counterObserver = new IntersectionObserver(
      (entries) => entries.forEach(entry => {
        if (entry.isIntersecting) {
          document.querySelectorAll('.hero__stat').forEach(stat => {
            const numberEl = stat.querySelector('.hero__stat-number');
            const target   = parseInt(stat.dataset.count || '0', 10);
            if (numberEl && target > 0) animateCounter(numberEl, target);
          });
          counterObserver.disconnect();
        }
      }),
      { threshold: 0.4 }
    );
    counterObserver.observe(statsSection);
  }

  /* ─────────────────────────────────────────
     5. TEXT ROTATOR (Hero Tagline Badge)
  ───────────────────────────────────────── */
  class TextRotator {
    constructor(el, texts, interval = 3200) {
      this.el       = el;
      this.texts    = texts;
      this.index    = 0;
      this.interval = interval;
      this.el.style.transition = 'opacity 0.4s ease';
      this.start();
    }

    start() {
      setInterval(() => {
        this.el.style.opacity = '0';
        setTimeout(() => {
          this.index = (this.index + 1) % this.texts.length;
          this.el.textContent = this.texts[this.index];
          this.el.style.opacity = '1';
        }, 420);
      }, this.interval);
    }
  }

  const taglineEl = document.querySelector('.hero__tagline-rotate');
  if (taglineEl) {
    try {
      const raw = taglineEl.getAttribute('data-texts');
      const texts = raw ? JSON.parse(raw) : ['CEO', 'LEADER', 'VISIONARY', 'FOUNDER'];
      if (texts.length > 1) new TextRotator(taglineEl, texts);
    } catch (e) {
      // Fail silently — text stays as initial
    }
  }

  /* ─────────────────────────────────────────
     6. SMOOTH SCROLL
  ───────────────────────────────────────── */
  document.querySelectorAll('a[href^="#"]').forEach(link => {
    link.addEventListener('click', e => {
      const id = link.getAttribute('href');
      if (id === '#') return;
      const target = document.querySelector(id);
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        // Update URL without jumping
        history.pushState(null, '', id);
      }
    });
  });

  /* ─────────────────────────────────────────
     7. ACTIVE NAV LINK — Highlight on scroll
  ───────────────────────────────────────── */
  const navLinks = document.querySelectorAll('.navbar__links a[href^="#"]');
  const sections = [];

  navLinks.forEach(link => {
    const id = link.getAttribute('href');
    const section = id ? document.querySelector(id) : null;
    if (section) sections.push({ link, section });
  });

  if (sections.length > 0) {
    const sectionObserver = new IntersectionObserver(
      (entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            const active = sections.find(s => s.section === entry.target);
            if (active) {
              navLinks.forEach(l => l.style.color = '');
              active.link.style.color = 'var(--color-gold-light)';
            }
          }
        });
      },
      { rootMargin: '-30% 0px -60% 0px', threshold: 0 }
    );

    sections.forEach(({ section }) => sectionObserver.observe(section));
  }

  /* ─────────────────────────────────────────
     8. SCROLL INDICATOR — Hide after scroll
  ───────────────────────────────────────── */
  const scrollIndicator = document.querySelector('.scroll-indicator');
  if (scrollIndicator) {
    scrollIndicator.addEventListener('click', () => {
      const firstSection = document.querySelector('.section');
      firstSection?.scrollIntoView({ behavior: 'smooth' });
    });

    window.addEventListener('scroll', () => {
      if (window.scrollY > 100) {
        scrollIndicator.style.opacity = '0';
        scrollIndicator.style.pointerEvents = 'none';
      } else {
        scrollIndicator.style.opacity = '1';
        scrollIndicator.style.pointerEvents = 'auto';
      }
    }, { passive: true });
  }

  /* ─────────────────────────────────────────
     9. LIGHTBOX (Project Detail Page)
  ───────────────────────────────────────── */
  class Lightbox {
    constructor() {
      this.modal   = document.getElementById('lightbox');
      if (!this.modal) return;

      this.img     = document.getElementById('lightbox-img');
      this.images  = [...document.querySelectorAll('.gallery-item[data-src]')];
      this.current = 0;

      this.bindGallery();
      this.bindEvents();
    }

    open(index) {
      if (!this.images[index]) return;
      this.current = index;
      const src = this.images[index].dataset.src;
      this.img.src = src;
      this.modal.style.display = 'flex';
      requestAnimationFrame(() => this.modal.classList.add('is-open'));
      this.modal.focus();
      document.body.style.overflow = 'hidden';
    }

    close() {
      this.modal.classList.remove('is-open');
      setTimeout(() => {
        this.modal.style.display = 'none';
        this.img.src = '';
      }, 300);
      document.body.style.overflow = '';
    }

    next() { this.open((this.current + 1) % this.images.length); }
    prev() { this.open((this.current - 1 + this.images.length) % this.images.length); }

    bindGallery() {
      this.images.forEach((item, i) => {
        item.style.cursor = 'pointer';
        item.addEventListener('click', () => this.open(i));

        // Keyboard accessibility
        item.setAttribute('tabindex', '0');
        item.setAttribute('role', 'button');
        item.addEventListener('keydown', e => {
          if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            this.open(i);
          }
        });
      });
    }

    bindEvents() {
      const closeBtn = this.modal.querySelector('.lightbox-close');
      closeBtn?.addEventListener('click', () => this.close());

      this.modal.addEventListener('click', e => {
        if (e.target === this.modal) this.close();
      });

      document.addEventListener('keydown', e => {
        if (!this.modal.classList.contains('is-open')) return;
        if (e.key === 'Escape') this.close();
        if (e.key === 'ArrowRight' || e.key === 'ArrowDown') this.next();
        if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') this.prev();
      });
    }
  }

  new Lightbox();

  /* ─────────────────────────────────────────
     10. HERO INITIAL ANIMATIONS — Sequence
  ───────────────────────────────────────── */
  const heroEls = document.querySelectorAll('.hero .fade-in-up');
  heroEls.forEach((el, i) => {
    // Force them visible with a small delay to create sequence feel
    setTimeout(() => {
      el.classList.add('is-visible');
    }, 150 + i * 100);
  });

}); // end DOMContentLoaded
