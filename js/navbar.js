// Función para alternar el menú desplegable
function toggleMenu() {
    // Obtener elementos del DOM
    const hamburger = document.getElementById('hamburger');
    const nav = document.getElementById('nav');
    var isSelected = false;

    // Verificar si el botón hamburguesa está seleccionado
    if (hamburger.classList.contains('selected')) {
        isSelected = true;
    } else {
        isSelected = false;
    }

    // Alternar clases según el estado seleccionado
    if (isSelected) {
        hamburger.classList.remove('selected');
        nav.classList.remove('hidden');
    } else {
        hamburger.classList.add('selected');
        nav.classList.add('hidden');
    }
}

// Obtener el elemento del botón hamburguesa
const hamburger = document.getElementById('hamburger');
// Agregar un evento 'click' al botón hamburguesa para llamar a la función toggleMenu
hamburger.addEventListener('click', toggleMenu);
