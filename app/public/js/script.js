/**
 * Portfolio Développeur Web - JavaScript
 * Fonctionnalités interactives et animations
 */

// Attendre que le DOM soit chargé
document.addEventListener('DOMContentLoaded', function() {
    
    // ==================== LOADING SCREEN ====================
    initLoadingScreen();
    
    // ==================== SMOOTH SCROLLING ====================
    initSmoothScrolling();
    
    // ==================== NAVBAR EFFECTS ====================
    initNavbarEffects();
    
    // ==================== AOS ANIMATIONS ====================
    initAOSAnimations();
    
    // ==================== SCROLL ANIMATIONS ====================
    initScrollAnimations();
    
    // ==================== SKILL BARS ANIMATION ====================
    initSkillBars();
    
    // ==================== PROJECT FILTERS ====================
    initProjectFilters();
    
    // ==================== CONTACT FORM ====================
    initContactForm();
    
    // ==================== TYPING ANIMATION ====================
    initTypingAnimation();
    
    // ==================== PARTICLE EFFECTS ====================
    initParticleEffects();
});

/**
 * Initialise l'écran de chargement
 */
function initLoadingScreen() {
    const loading = document.getElementById('loading');
    if (loading) {
        window.addEventListener('load', function() {
            setTimeout(function() {
                loading.classList.add('hidden');
            }, 1000);
        });
    }
}

/**
 * Initialise le défilement fluide
 */
function initSmoothScrolling() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                const offsetTop = target.offsetTop - 80; // Ajustement pour la navbar fixe
                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
            }
        });
    });
}

/**
 * Initialise les effets de la navbar
 */
function initNavbarEffects() {
    const navbar = document.querySelector('.navbar');
    if (!navbar) return;

    // Appliquer le style dès le chargement
    if (window.scrollY > 50) {
        navbar.style.background = 'rgba(255, 255, 255, 0.98)';
        navbar.style.boxShadow = '0 2px 20px rgba(0, 0, 0, 0.1)';
    } else {
        navbar.style.background = 'rgba(255, 255, 255, 0.95)';
        navbar.style.boxShadow = 'none';
    }

    // Ensuite, écouter le scroll
    window.addEventListener('scroll', function () {
        if (window.scrollY > 50) {
            navbar.style.background = 'rgba(255, 255, 255, 0.98)';
            navbar.style.boxShadow = '0 2px 20px rgba(0, 0, 0, 0.1)';
        } else {
            navbar.style.background = 'rgba(255, 255, 255, 0.95)';
            navbar.style.boxShadow = 'none';
        }
    });
}


/**
 * Initialise les animations AOS
 */
function initAOSAnimations() {
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100,
            easing: 'ease-in-out'
        });
    }
}

/**
 * Initialise les animations au scroll
 */
function initScrollAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, observerOptions);

    document.querySelectorAll('.fade-in').forEach(el => {
        observer.observe(el);
    });
}

/**
 * Initialise l'animation des barres de compétences
 */
function initSkillBars() {
    const progressObserver = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const progressBar = entry.target;
                const level = progressBar.dataset.level;
                if (level) {
                    progressBar.style.setProperty('--target-width', level + '%');
                    progressBar.classList.add('animate');
                    progressObserver.unobserve(progressBar);
                }
            }
        });
    }, {
        threshold: 0.5,
        rootMargin: '0px 0px -100px 0px'
    });

    document.querySelectorAll('.skill-progress').forEach(bar => {
        progressObserver.observe(bar);
    });
}

/**
 * Initialise les filtres de projets
 */
function initProjectFilters() {
    const filterButtons = document.querySelectorAll('.btn-filter');
    const projectItems = document.querySelectorAll('.project-item');

    if (filterButtons.length === 0 || projectItems.length === 0) return;

    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            filterButtons.forEach(btn => btn.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');

            const filter = this.dataset.filter;

            projectItems.forEach(item => {
                if (filter === 'all') {
                    item.classList.remove('hidden');
                    item.classList.add('visible');
                } else {
                    const categories = item.dataset.category.split(' ');
                    if (categories.includes(filter)) {
                        item.classList.remove('hidden');
                        item.classList.add('visible');
                    } else {
                        item.classList.add('hidden');
                        item.classList.remove('visible');
                    }
                }
            });
        });
    });

    // Initialize visible state
    projectItems.forEach(item => {
        item.classList.add('visible');
    });
}

/**
 * Initialise le formulaire de contact
 */
function initContactForm() {
    const form = document.getElementById('contactForm');
    if (!form) return;

    const submitButton = form.querySelector('button[type="submit"]');
    
    form.addEventListener('submit', function(e) {
        // Add loading state to button
        if (submitButton) {
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Envoi en cours...';
            submitButton.disabled = true;
        }
    });

    // Real-time validation
    const inputs = form.querySelectorAll('input, textarea, select');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateField(this);
        });
        
        input.addEventListener('input', function() {
            if (this.classList.contains('is-invalid')) {
                validateField(this);
            }
        });
    });
}

/**
 * Valide un champ de formulaire
 */
function validateField(field) {
    const value = field.value.trim();
    let isValid = true;
    
    // Remove previous validation classes
    field.classList.remove('is-valid', 'is-invalid');
    
    // Check if required field is empty
    if (field.hasAttribute('required') && !value) {
        isValid = false;
    }
    
    // Email validation
    if (field.type === 'email' && value) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) {
            isValid = false;
        }
    }
    
    // Message length validation
    if (field.name === 'message' && value && value.length < 10) {
        isValid = false;
    }
    
    // Add validation class
    if (value) {
        field.classList.add(isValid ? 'is-valid' : 'is-invalid');
    }
}

/**
 * Initialise l'animation de frappe
 */
function initTypingAnimation() {
    const typingElements = document.querySelectorAll('[data-typing]');
    
    typingElements.forEach(element => {
        const text = element.textContent;
        const speed = element.dataset.speed || 100;
        element.textContent = '';
        
        let i = 0;
        function typeWriter() {
            if (i < text.length) {
                element.textContent += text.charAt(i);
                i++;
                setTimeout(typeWriter, speed);
            }
        }
        
        // Start typing when element is visible
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    setTimeout(typeWriter, 500);
                    observer.unobserve(entry.target);
                }
            });
        });
        
        observer.observe(element);
    });
}

/**
 * Initialise les effets de particules
 */
function initParticleEffects() {
    const particleContainer = document.querySelector('.floating-elements');
    if (!particleContainer) return;

    // Create floating particles
    for (let i = 0; i < 5; i++) {
        createParticle(particleContainer);
    }
}

/**
 * Crée une particule flottante
 */
function createParticle(container) {
    const particle = document.createElement('div');
    particle.className = 'floating-particle';
    particle.style.cssText = `
        position: absolute;
        width: 4px;
        height: 4px;
        background: rgba(255, 255, 255, 0.5);
        border-radius: 50%;
        pointer-events: none;
        animation: floatParticle 8s infinite linear;
        left: ${Math.random() * 100}%;
        animation-delay: ${Math.random() * 8}s;
    `;
    
    container.appendChild(particle);
    
    // Remove particle after animation
    setTimeout(() => {
        if (particle.parentNode) {
            particle.parentNode.removeChild(particle);
        }
    }, 8000);
}

/**
 * Utilitaires pour les animations
 */
const AnimationUtils = {
    /**
     * Anime un élément vers une position
     */
    animateTo: function(element, target, duration = 300) {
        return new Promise(resolve => {
            element.style.transition = `all ${duration}ms ease`;
            element.style.transform = target;
            setTimeout(resolve, duration);
        });
    },
    
    /**
     * Fait apparaître un élément
     */
    fadeIn: function(element, duration = 300) {
        element.style.opacity = '0';
        element.style.display = 'block';
        
        let opacity = 0;
        const increment = 16 / duration; // 60fps
        
        const timer = setInterval(() => {
            opacity += increment;
            element.style.opacity = opacity;
            
            if (opacity >= 1) {
                clearInterval(timer);
                element.style.opacity = '1';
            }
        }, 16);
    },
    
    /**
     * Fait disparaître un élément
     */
    fadeOut: function(element, duration = 300) {
        let opacity = 1;
        const decrement = 16 / duration;
        
        const timer = setInterval(() => {
            opacity -= decrement;
            element.style.opacity = opacity;
            
            if (opacity <= 0) {
                clearInterval(timer);
                element.style.display = 'none';
            }
        }, 16);
    }
};

/**
 * Gestionnaire d'erreurs global
 */
window.addEventListener('error', function(e) {
    console.error('Erreur JavaScript:', e.error);
});

/**
 * Gestionnaire pour les performances
 */
if ('performance' in window) {
    window.addEventListener('load', function() {
        const perfData = performance.getEntriesByType('navigation')[0];
        console.log('Temps de chargement:', perfData.loadEventEnd - perfData.loadEventStart + 'ms');
    });
}

/**
 * Service Worker pour le cache (PWA)
 */
if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
        navigator.serviceWorker.register('/sw.js')
            .then(function(registration) {
                console.log('Service Worker enregistré:', registration);
            })
            .catch(function(error) {
                console.log('Erreur Service Worker:', error);
            });
    });
}

/**
 * Ajoute les styles CSS pour les animations personnalisées
 */
function addCustomStyles() {
    const style = document.createElement('style');
    style.textContent = `
        @keyframes floatParticle {
            0% {
                transform: translateY(0px) rotate(0deg);
                opacity: 1;
            }
            100% {
                transform: translateY(-100vh) rotate(360deg);
                opacity: 0;
            }
        }
        
        .floating-particle {
            animation: floatParticle 8s infinite linear;
        }
        
        .is-valid {
            border-color: #10b981 !important;
            box-shadow: 0 0 0 0.2rem rgba(16, 185, 129, 0.25) !important;
        }
        
        .is-invalid {
            border-color: #ef4444 !important;
            box-shadow: 0 0 0 0.2rem rgba(239, 68, 68, 0.25) !important;
        }
    `;
    document.head.appendChild(style);
}

// Ajouter les styles personnalisés
addCustomStyles();

/**
 * Fonctions utilitaires
 */
const Utils = {
    /**
     * Débounce une fonction
     */
    debounce: function(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    },
    
    /**
     * Throttle une fonction
     */
    throttle: function(func, limit) {
        let inThrottle;
        return function() {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    },
    
    /**
     * Vérifie si un élément est visible
     */
    isElementVisible: function(element) {
        const rect = element.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    }
};
/**
 * Ferme automatiquement la navbar Bootstrap après un clic sur un lien
 */
function autoCloseNavbar() {
    const navbarCollapseEl = document.getElementById('navbarNav');
    if (!navbarCollapseEl) return;

    const navLinks = navbarCollapseEl.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            if (navbarCollapseEl.classList.contains('show')) {
                const bsCollapse = bootstrap.Collapse.getInstance(navbarCollapseEl)
                    || new bootstrap.Collapse(navbarCollapseEl, { toggle: false });
                bsCollapse.hide();
            }
        });
    });
}

// Appel de la fonction
autoCloseNavbar();

// ajout du style background


// Exposer les utilitaires globalement
window.AnimationUtils = AnimationUtils;
window.Utils = Utils;

