window.onload = function() {
    // Obtener el div de carga
    var loadingDiv = document.getElementById('loading');

    // Esperar 1000 milisegundos (1 segundo)
    setTimeout(function() {
        // Agregar la clase 'hidden' con transición al div de carga
        loadingDiv.classList.add('fade-out');
        // Esperar la duración de la transición antes de ocultar realmente el div
        setTimeout(function() {
            loadingDiv.classList.add('hidden');
        }, 500); // Duración de la transición (en milisegundos)
    }, 1000); // Tiempo de espera (en milisegundos)
};