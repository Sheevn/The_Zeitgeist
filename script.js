// This function runs once the entire page is loaded
document.addEventListener('DOMContentLoaded', function() {

    // --- Theme Toggle Logic ---
    const themeToggle = document.getElementById('theme-toggle');
    // We check if the button exists before adding a listener
    if (themeToggle) {
        themeToggle.addEventListener('click', function() {
            let currentTheme = document.documentElement.getAttribute('data-theme');
            if (currentTheme === 'dark') {
                document.documentElement.removeAttribute('data-theme');
                localStorage.removeItem('theme');
            } else {
                document.documentElement.setAttribute('data-theme', 'dark');
                localStorage.setItem('theme', 'dark');
            }
        });
    }

    // --- Modal Logic ---
    const aboutModal = document.getElementById('about-modal');
    const aboutLink = document.getElementById('about-link');
    
    // We check if the modal and link exist before adding listeners
    if (aboutModal && aboutLink) {
        const closeButton = aboutModal.querySelector('.close-button');

        aboutLink.addEventListener('click', function(event) {
            event.preventDefault();
            aboutModal.style.display = 'flex';
        });

        if (closeButton) {
            closeButton.addEventListener('click', function() {
                aboutModal.style.display = 'none';
            });
        }

        window.addEventListener('click', function(event) {
            if (event.target === aboutModal) {
                aboutModal.style.display = 'none';
            }
        });
    }
});
