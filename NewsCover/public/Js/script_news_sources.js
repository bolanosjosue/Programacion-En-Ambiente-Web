// JavaScript para mostrar/ocultar la ventana emergente al hacer clic en el botón "Agregar Noticia"
const toggleModalBtn = document.getElementById('toggleModalBtn');
const modal = document.getElementById('modal');
const modalEditar = document.getElementById('modalEditar');

const guardarModalBtn = document.getElementById('guardarModalBtn');
const userMenuBtn = document.getElementById('userMenuBtn');
const userMenu = document.getElementById('userMenu');

toggleModalBtn.addEventListener('click', () => {
    modal.classList.remove('hidden');
});

// JavaScript para ocultar la ventana emergente al hacer clic en el botón "Guardar" dentro de la ventana emergente
guardarModalBtn.addEventListener('click', () => {
    modal.classList.add('hidden');
});

// Agregar eventos para mostrar/ocultar el menú de usuario
userMenuBtn.addEventListener('click', () => {
    userMenu.classList.toggle('hidden');
});

// Ocultar el menú cuando se hace clic fuera de él
document.addEventListener('click', (event) => {
    if (!userMenu.contains(event.target) && !userMenuBtn.contains(event.target)) {
        userMenu.classList.add('hidden');
    }
});

function openEditModal(button) {
    const idNoticia = button.getAttribute('data-id');
    const nombreNoticia = button.getAttribute('data-name');
    const urlNoticia = button.getAttribute('data-url');
    const categoriaNoticia = button.getAttribute('data-categoria');

    // Prellenar el modal de editar con la información actual
    document.getElementById('idNoticia').value = idNoticia; // Agrega esta línea

    document.getElementById('fuenteE').value = nombreNoticia;
    document.getElementById('rssUrlE').value = urlNoticia;
    const categoriaSelect = document.getElementById('categoriaSelectE');
    for (let i = 0; i < categoriaSelect.options.length; i++) {
        if (categoriaSelect.options[i].text === categoriaNoticia) {
            categoriaSelect.selectedIndex = i;
            break;
        }
    }

    // Mostrar el modal de editar
    modalEditar.classList.remove('hidden');
}