function toggleMenu() {
    const hamburger = document.getElementById('hamburger');
    const nav = document.getElementById('nav');
    var isSelected = false;

    if (hamburger.classList.contains('selected')) {
        isSelected = true;
    } else {
        isSelected = false;
    }

    if (isSelected) {
        hamburger.classList.remove('selected');
        nav.classList.remove('hidden');
    } else {
        hamburger.classList.add('selected');
        nav.classList.add('hidden');
    }
}

// Ejecutar la función toggleMenu cada vez que se hace clic en algún elemento
document.addEventListener('click', function(event) {
    toggleMenu();
});