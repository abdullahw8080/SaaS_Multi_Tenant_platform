// CV Script Engine - Advanced interactivity & animations

document.addEventListener('DOMContentLoaded', () => {
    // 1. Initialize AOS (Animate on Scroll)
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            offset: 100,
            once: true
        });
    }

    // 2. Mobile Menu Toggle
    const menuBtn = document.getElementById('menuBtn');
    const navLinks = document.getElementById('navLinks');

    if (menuBtn && navLinks) {
        menuBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            navLinks.classList.toggle('active');
            // Toggle hamburger icon between bars and X
            const icon = menuBtn.querySelector('i');
            if (navLinks.classList.contains('active')) {
                icon.className = 'fa-solid fa-xmark';
            } else {
                icon.className = 'fa-solid fa-bars';
            }
        });

        // Close menu when clicking outside
        document.addEventListener('click', () => {
            if (navLinks.classList.contains('active')) {
                navLinks.classList.remove('active');
                menuBtn.querySelector('i').className = 'fa-solid fa-bars';
            }
        });
    }

    // 3. Sticky Navbar & Scroll to Top effect on scroll
    const scrollToTopBtn = document.getElementById('scrollToTop');
    window.addEventListener('scroll', () => {
        const navbar = document.getElementById('navbar');
        if (navbar) {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        }
        
        if (scrollToTopBtn) {
            if (window.scrollY > 300) {
                scrollToTopBtn.classList.add('show');
            } else {
                scrollToTopBtn.classList.remove('show');
            }
        }
    });

    if (scrollToTopBtn) {
        scrollToTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    // 4. Smooth scroll for internal links & close mobile menu
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth'
                });
                if (navLinks) {
                    navLinks.classList.remove('active');
                    if (menuBtn) {
                        menuBtn.querySelector('i').className = 'fa-solid fa-bars';
                    }
                }
            }
        });
    });

    // 5. Job Title is static as requested (Typing animation disabled)

    // 6. Project Filtering System
    const filterBtns = document.querySelectorAll('.filter-btn');
    const projectCards = document.querySelectorAll('.project-card');

    if (filterBtns.length > 0 && projectCards.length > 0) {
        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                // Remove active classes
                filterBtns.forEach(b => {
                    b.style.background = 'transparent';
                    b.style.color = 'var(--text-primary)';
                    b.classList.remove('active');
                });
                
                // Set active class to clicked button
                btn.style.background = 'var(--accent-glow)';
                btn.style.color = 'var(--bg-dark-1)';
                btn.classList.add('active');

                const filterValue = btn.getAttribute('data-filter');

                projectCards.forEach(card => {
                    if (filterValue === 'all' || card.getAttribute('data-category') === filterValue) {
                        card.style.display = 'block';
                        setTimeout(() => {
                            card.style.opacity = '1';
                            card.style.transform = 'scale(1)';
                        }, 50);
                    } else {
                        card.style.opacity = '0';
                        card.style.transform = 'scale(0.8)';
                        setTimeout(() => {
                            card.style.display = 'none';
                        }, 300);
                    }
                });
            });
        });
    }

    // 7. Animate progress bars on scroll (IntersectionObserver)
    const progressObserverOptions = {
        threshold: 0.1
    };

    if ('IntersectionObserver' in window) {
        const progressObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Reset and fill skills progress
                    const skillBars = entry.target.querySelectorAll('.skill-progress-fill');
                    skillBars.forEach(bar => {
                        const width = bar.style.width || '100%';
                        bar.style.width = '0%';
                        setTimeout(() => {
                            bar.style.width = width;
                        }, 100);
                    });

                    // Reset and fill languages progress
                    const langBars = entry.target.querySelectorAll('.progress-fill');
                    langBars.forEach(bar => {
                        const width = bar.style.width || '100%';
                        bar.style.width = '0%';
                        setTimeout(() => {
                            bar.style.width = width;
                        }, 100);
                    });

                    // Unobserve after animating once
                    observer.unobserve(entry.target);
                }
            });
        }, progressObserverOptions);

        document.querySelectorAll('.skill-category, .language-card').forEach(category => {
            progressObserver.observe(category);
        });
    } else {
        // Fallback: trigger them immediately if not supported
        document.querySelectorAll('.skill-progress-fill, .progress-fill').forEach(bar => {
            bar.style.width = bar.style.width;
        });
    }

    // 8. Dark / Light Mode Switcher
    const themeToggleBtn = document.getElementById('themeToggleBtn');
    if (themeToggleBtn) {
        const savedTheme = localStorage.getItem('dev_cv_theme') || 'dark';
        if (savedTheme === 'light') {
            document.body.classList.add('light-theme');
            themeToggleBtn.querySelector('i').className = 'fa-solid fa-sun';
        } else {
            document.body.classList.remove('light-theme');
            themeToggleBtn.querySelector('i').className = 'fa-solid fa-moon';
        }

        themeToggleBtn.addEventListener('click', () => {
            document.body.classList.toggle('light-theme');
            const icon = themeToggleBtn.querySelector('i');
            if (document.body.classList.contains('light-theme')) {
                icon.className = 'fa-solid fa-sun';
                localStorage.setItem('dev_cv_theme', 'light');
            } else {
                icon.className = 'fa-solid fa-moon';
                localStorage.setItem('dev_cv_theme', 'dark');
            }
        });
    }
});
