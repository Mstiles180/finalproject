// Work Connect - Enhanced Interactive Features

document.addEventListener('DOMContentLoaded', function() {
    // Initialize enhanced animations
    initializeAnimations();
    
    // Initialize enhanced form interactions
    initializeFormEnhancements();
    
    // Initialize enhanced navigation
    initializeNavigation();
    
    // Initialize enhanced cards
    initializeCardEnhancements();
});

// Enhanced Animations
function initializeAnimations() {
    // Intersection Observer for scroll animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in-up');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observe elements for animation
    document.querySelectorAll('.card, .feature-card, .stats-card').forEach(el => {
        observer.observe(el);
    });
}

// Enhanced Form Interactions
function initializeFormEnhancements() {
    // Enhanced form focus effects
    document.querySelectorAll('.form-control, .form-select').forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            if (!this.value) {
                this.parentElement.classList.remove('focused');
            }
        });
    });

    // Enhanced button interactions
    document.querySelectorAll('.btn').forEach(btn => {
        btn.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        btn.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
}

// Enhanced Navigation
function initializeNavigation() {
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Enhanced navbar scroll effect
    let lastScrollTop = 0;
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('.navbar');
        const currentScrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        if (currentScrollTop > lastScrollTop && currentScrollTop > 100) {
            // Scrolling down
            navbar.style.transform = 'translateY(-100%)';
        } else {
            // Scrolling up
            navbar.style.transform = 'translateY(0)';
        }
        
        lastScrollTop = currentScrollTop;
    });
}

// Enhanced Card Interactions
function initializeCardEnhancements() {
    // Enhanced card hover effects
    document.querySelectorAll('.card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Enhanced stats card interactions
    document.querySelectorAll('.stats-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.05)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
}

// Enhanced Loading States
function showLoading(element) {
    element.classList.add('loading');
    element.disabled = true;
}

function hideLoading(element) {
    element.classList.remove('loading');
    element.disabled = false;
}

// Enhanced Toast Notifications
function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    toast.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(toast);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (toast.parentNode) {
            toast.remove();
        }
    }, 5000);
}

// Enhanced Form Validation
function enhanceFormValidation(form) {
    const inputs = form.querySelectorAll('input, select, textarea');
    
    inputs.forEach(input => {
        input.addEventListener('invalid', function(e) {
            e.preventDefault();
            this.classList.add('is-invalid');
            
            // Show custom error message
            const errorDiv = this.parentElement.querySelector('.invalid-feedback');
            if (errorDiv) {
                errorDiv.style.display = 'block';
            }
        });
        
        input.addEventListener('input', function() {
            if (this.classList.contains('is-invalid')) {
                this.classList.remove('is-invalid');
                const errorDiv = this.parentElement.querySelector('.invalid-feedback');
                if (errorDiv) {
                    errorDiv.style.display = 'none';
                }
            }
        });
    });
}

// Enhanced Table Interactions
function initializeTableEnhancements() {
    document.querySelectorAll('.table tbody tr').forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.backgroundColor = 'var(--primary-50)';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
        });
    });
}

// Enhanced Modal Interactions
function initializeModalEnhancements() {
    // Enhanced modal animations
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('show.bs.modal', function() {
            this.querySelector('.modal-dialog').style.transform = 'scale(0.8)';
            this.querySelector('.modal-dialog').style.opacity = '0';
        });
        
        modal.addEventListener('shown.bs.modal', function() {
            this.querySelector('.modal-dialog').style.transform = 'scale(1)';
            this.querySelector('.modal-dialog').style.opacity = '1';
        });
    });
}

// Enhanced Dropdown Interactions
function initializeDropdownEnhancements() {
    document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
        toggle.addEventListener('click', function() {
            const menu = this.nextElementSibling;
            if (menu.classList.contains('show')) {
                menu.style.transform = 'translateY(-10px)';
                menu.style.opacity = '0';
            } else {
                menu.style.transform = 'translateY(0)';
                menu.style.opacity = '1';
            }
        });
    });
}

// Enhanced Search Functionality
function initializeSearchEnhancements() {
    const searchInputs = document.querySelectorAll('input[type="search"], .search-input');
    
    searchInputs.forEach(input => {
        input.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const searchableElements = document.querySelectorAll('.searchable');
            
            searchableElements.forEach(element => {
                const text = element.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    element.style.display = '';
                    element.style.opacity = '1';
                } else {
                    element.style.opacity = '0.5';
                }
            });
        });
    });
}

// Enhanced Responsive Behavior
function initializeResponsiveEnhancements() {
    // Handle mobile-specific interactions
    if (window.innerWidth <= 768) {
        // Enhanced mobile navigation
        const navbarToggler = document.querySelector('.navbar-toggler');
        if (navbarToggler) {
            navbarToggler.addEventListener('click', function() {
                const navbarCollapse = document.querySelector('.navbar-collapse');
                navbarCollapse.classList.toggle('show');
            });
        }
        
        // Enhanced mobile cards
        document.querySelectorAll('.card').forEach(card => {
            card.addEventListener('touchstart', function() {
                this.style.transform = 'scale(0.98)';
            });
            
            card.addEventListener('touchend', function() {
                this.style.transform = 'scale(1)';
            });
        });
    }
}

// Enhanced Performance Monitoring
function initializePerformanceMonitoring() {
    // Monitor page load performance
    window.addEventListener('load', function() {
        const loadTime = performance.now();
        console.log(`Page loaded in ${loadTime.toFixed(2)}ms`);
        
        // Show performance indicator if load time is high
        if (loadTime > 3000) {
            showToast('Page is loading slowly. Please wait...', 'warning');
        }
    });
}

// Enhanced Accessibility
function initializeAccessibilityEnhancements() {
    // Enhanced keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Tab') {
            document.body.classList.add('keyboard-navigation');
        }
    });
    
    document.addEventListener('mousedown', function() {
        document.body.classList.remove('keyboard-navigation');
    });
    
    // Enhanced focus indicators
    document.addEventListener('focusin', function(e) {
        if (e.target.classList.contains('btn') || e.target.classList.contains('form-control')) {
            e.target.style.outline = '2px solid var(--primary-500)';
            e.target.style.outlineOffset = '2px';
        }
    });
    
    document.addEventListener('focusout', function(e) {
        if (e.target.classList.contains('btn') || e.target.classList.contains('form-control')) {
            e.target.style.outline = '';
            e.target.style.outlineOffset = '';
        }
    });
}

// Initialize all enhancements
document.addEventListener('DOMContentLoaded', function() {
    initializeAnimations();
    initializeFormEnhancements();
    initializeNavigation();
    initializeCardEnhancements();
    initializeTableEnhancements();
    initializeModalEnhancements();
    initializeDropdownEnhancements();
    initializeSearchEnhancements();
    initializeResponsiveEnhancements();
    initializePerformanceMonitoring();
    initializeAccessibilityEnhancements();
});

// Export functions for global use
window.WorkConnect = {
    showToast,
    showLoading,
    hideLoading,
    enhanceFormValidation
};
