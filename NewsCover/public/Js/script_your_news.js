const userMenuBtn = document.getElementById('userMenuBtn');
const userMenu = document.getElementById('userMenu');

userMenuBtn.addEventListener('click', () => {
    userMenu.classList.toggle('hidden');
});

// Ocultar el menú cuando se hace clic fuera de él
document.addEventListener('click', (event) => {
    if (!userMenu.contains(event.target) && !userMenuBtn.contains(event.target)) {
        userMenu.classList.add('hidden');
    }
});

