/**
 * Doctor Prestige Template - Interactive Script
 * Vanilla JS implementation for animations, Canvas particles, and UX features.
 */

document.addEventListener('DOMContentLoaded', () => {

  // 1. نظام الجزيئات الطبية بـ Canvas (Particles)
  const canvas = document.getElementById('particles-canvas');
  if (canvas) {
    class Particle {
      constructor(width, height) {
        this.width = width;
        this.height = height;
        this.reset();
      }

      reset() {
        this.x = Math.random() * this.width;
        this.y = Math.random() * this.height;
        this.vx = (Math.random() - 0.5) * 0.4;
        this.vy = (Math.random() - 0.5) * 0.4;
        this.radius = Math.random() * 2 + 1.5; // 1.5px to 3.5px
        this.alpha = Math.random() * 0.3 + 0.1; // 0.1 to 0.4 opacity
      }

      update() {
        this.x += this.vx;
        this.y += this.vy;

        // الارتداد عن الحواف
        if (this.x < 0 || this.x > this.width) this.vx *= -1;
        if (this.y < 0 || this.y > this.height) this.vy *= -1;
      }
    }

    class ParticleSystem {
      constructor(canvasElement) {
        this.canvas = canvasElement;
        this.ctx = this.canvas.getContext('2d');
        this.particles = [];
        this.maxParticles = 60;
        this.connectionDistance = 120;
        
        this.resize();
        this.init();
      }

      resize() {
        this.width = this.canvas.parentElement.offsetWidth;
        this.height = this.canvas.parentElement.offsetHeight;
        this.canvas.width = this.width;
        this.canvas.height = this.height;
      }

      init() {
        this.particles = [];
        for (let i = 0; i < this.maxParticles; i++) {
          this.particles.push(new Particle(this.width, this.height));
        }
      }

      draw() {
        this.ctx.clearRect(0, 0, this.width, this.height);

        // رسم الخطوط بين الجسيمات القريبة
        for (let i = 0; i < this.particles.length; i++) {
          const p1 = this.particles[i];
          for (let j = i + 1; j < this.particles.length; j++) {
            const p2 = this.particles[j];
            const dist = Math.hypot(p1.x - p2.x, p1.y - p2.y);

            if (dist < this.connectionDistance) {
              const alpha = (1 - dist / this.connectionDistance) * 0.12;
              this.ctx.strokeStyle = `rgba(0, 212, 255, ${alpha})`;
              this.ctx.lineWidth = 0.8;
              this.ctx.beginPath();
              this.ctx.moveTo(p1.x, p1.y);
              this.ctx.lineTo(p2.x, p2.y);
              this.ctx.stroke();
            }
          }
        }

        // رسم النقاط
        this.particles.forEach(p => {
          this.ctx.fillStyle = `rgba(0, 212, 255, ${p.alpha})`;
          this.ctx.beginPath();
          this.ctx.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
          this.ctx.fill();
          p.update();
        });
      }
    }

    const system = new ParticleSystem(canvas);
    
    function animateParticles() {
      system.draw();
      requestAnimationFrame(animateParticles);
    }
    
    // تشغيل الأنيميشن فقط إذا كان الـ Canvas ظاهراً ومسموح بالحركة
    if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
      animateParticles();
      window.addEventListener('resize', () => {
        system.resize();
        system.init();
      });
    }
  }

  // 2. تاثير Scroll للـ Navbar
  const navbar = document.getElementById('navbar');
  if (navbar) {
    const handleScroll = () => {
      navbar.classList.toggle('scrolled', window.scrollY > 50);
    };
    window.addEventListener('scroll', handleScroll, { passive: true });
    handleScroll(); // تشغيل فوري للتحقق من الحالة الابتدائية
  }

  // 3. Hamburger Menu للموبايل
  const hamburgerBtn = document.getElementById('hamburgerBtn');
  const navbarLinks = document.getElementById('navbarLinks');
  if (hamburgerBtn && navbarLinks) {
    const links = navbarLinks.querySelectorAll('a');
    
    const toggleMenu = (forceClose = false) => {
      const isOpen = hamburgerBtn.getAttribute('aria-expanded') === 'true';
      const shouldOpen = !isOpen && !forceClose;
      
      hamburgerBtn.setAttribute('aria-expanded', shouldOpen ? 'true' : 'false');
      navbarLinks.classList.toggle('active', shouldOpen);
    };

    hamburgerBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      toggleMenu();
    });

    // إغلاق عند النقر على الروابط
    links.forEach(link => {
      link.addEventListener('click', () => toggleMenu(true));
    });

    // إغلاق عند النقر بالخارج
    document.addEventListener('click', (e) => {
      if (!navbarLinks.contains(e.target) && !hamburgerBtn.contains(e.target)) {
        toggleMenu(true);
      }
    });
  }

  // 4. العدادات التلقائية (Counter Animation)
  const stats = document.querySelectorAll('.hero__stat-number');
  if (stats.length > 0) {
    const runCounter = (el) => {
      const target = parseInt(el.getAttribute('data-target'), 10);
      if (isNaN(target)) return;

      const duration = 2000; // 2 seconds
      const startTime = performance.now();

      const animate = (currentTime) => {
        const elapsed = currentTime - startTime;
        const progress = Math.min(elapsed / duration, 1);
        
        // easeOutQuad animation logic
        const easeProgress = progress * (2 - progress);
        const currentVal = Math.floor(easeProgress * target);
        
        el.textContent = currentVal;

        if (progress < 1) {
          requestAnimationFrame(animate);
        } else {
          el.textContent = target;
        }
      };

      requestAnimationFrame(animate);
    };

    // تشغيل العداد عند تداخل الصفحة
    const statsObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          runCounter(entry.target);
          statsObserver.unobserve(entry.target);
        }
      });
    }, { threshold: 0.5 });

    stats.forEach(s => statsObserver.observe(s));
  }

  // 5. Intersection Observer للحركات والظهور
  const animObserver = new IntersectionObserver(
    (entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          
          // تمديد أشرطة التقدم للمهارات عند الظهور
          const skillBar = entry.target.querySelector('.skill-bar-fill');
          if (skillBar) {
            skillBar.style.width = skillBar.getAttribute('data-width');
          }
          
          animObserver.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.15 }
  );

  document.querySelectorAll('.fade-in-up, .timeline__item, .skill-card').forEach(el => {
    animObserver.observe(el);
  });

  // 6. نظام الـ Lightbox التفاعلي الكامل
  const lightbox = document.getElementById('lightbox');
  const lightboxImg = document.getElementById('lightbox-img');
  
  if (lightbox && lightboxImg && typeof lightboxImages !== 'undefined' && lightboxImages.length > 0) {
    let currentIndex = 0;

    window.openLightbox = (index) => {
      currentIndex = index;
      lightboxImg.src = lightboxImages[currentIndex];
      lightbox.style.display = 'flex';
      document.body.style.overflow = 'hidden'; // إيقاف تمرير الصفحة الرئيسية
      lightbox.focus();
    };

    window.closeLightbox = () => {
      lightbox.style.display = 'none';
      document.body.style.overflow = 'auto'; // إعادة التمرير
    };

    window.nextLightbox = (e) => {
      if (e) e.stopPropagation();
      currentIndex = (currentIndex + 1) % lightboxImages.length;
      lightboxImg.src = lightboxImages[currentIndex];
    };

    window.prevLightbox = (e) => {
      if (e) e.stopPropagation();
      currentIndex = (currentIndex - 1 + lightboxImages.length) % lightboxImages.length;
      lightboxImg.src = lightboxImages[currentIndex];
    };

    // التصفح بالكيبورد
    document.addEventListener('keydown', (e) => {
      if (lightbox.style.display === 'flex') {
        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowRight') nextLightbox();
        if (e.key === 'ArrowLeft') prevLightbox();
      }
    });

    // إغلاق بالنقر على الخلفية
    lightbox.addEventListener('click', (e) => {
      if (e.target === lightbox) closeLightbox();
    });

    // دعم السحب باللمس على الجوال (Swipe Support)
    let touchStartX = 0;
    let touchEndX = 0;

    lightbox.addEventListener('touchstart', (e) => {
      touchStartX = e.changedTouches[0].screenX;
    }, { passive: true });

    lightbox.addEventListener('touchend', (e) => {
      touchEndX = e.changedTouches[0].screenX;
      handleSwipe();
    }, { passive: true });

    function handleSwipe() {
      const threshold = 50;
      if (touchEndX < touchStartX - threshold) {
        // سحب لليمين -> التالي
        nextLightbox();
      }
      if (touchEndX > touchStartX + threshold) {
        // سحب لليسار -> السابق
        prevLightbox();
      }
    }
  }

  // 7. تمرير ناعم للروابط الداخلية (Smooth Scroll)
  document.querySelectorAll('a[href^="#"]').forEach(link => {
    link.addEventListener('click', function(e) {
      const targetId = this.getAttribute('href');
      if (targetId === '#') return;
      
      const targetElement = document.querySelector(targetId);
      if (targetElement) {
        e.preventDefault();
        targetElement.scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });
      }
    });
  });

  // 8. تشغيل مكتبة الأنيميشن AOS
  if (typeof AOS !== 'undefined') {
    AOS.init({
      duration: 800,
      once: true,
      disable: window.matchMedia('(prefers-reduced-motion: reduce)').matches
    });
  }

});


