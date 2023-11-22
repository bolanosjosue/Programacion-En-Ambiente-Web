const toggleModalBtn = document.getElementById('toggleModalBtn');
const modalAgregar = document.getElementById('modalAgregar');
const modalEditar = document.getElementById('modalEditar');
const userMenuBtn = document.getElementById('userMenuBtn');
const userMenu = document.getElementById('userMenu');
const categoryFormAgregar = document.getElementById('categoryFormAgregar');
const categoryFormEditar = document.getElementById('categoryFormEditar');

toggleModalBtn.addEventListener('click', () => {
    // Limpiar el campo de nombre en el modal de agregar
    document.getElementById('categoriaModalAgregar').value = '';
    modalAgregar.classList.remove('hidden');
});

function openEditModal(button) {
    const idCategoria = button.getAttribute('data-id');
    const nombreCategoria = button.getAttribute('data-name');

    // Prellenar el modal de editar con la información actual
    document.getElementById('categoriaModalEditar').value = nombreCategoria;
    // Establecer el valor del campo de ID para la edición
    document.getElementById('editCategoryId').value = idCategoria;

    // Mostrar el modal de editar
    modalEditar.classList.remove('hidden');
}

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