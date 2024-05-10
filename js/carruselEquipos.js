// Obtener elementos del DOM
const contenedorCarrusel = document.getElementById('contenedorCarrusel');
const carruselNext = document.getElementById('carruselNext');
const carruselPrev = document.getElementById('carruselBefore');

// Inicializar variables de índice y longitud del carrusel
let carruselIndex = 0;
const carruselLength = contenedorCarrusel.children[0].children.length;

// Agregar evento 'click' al botón de siguiente en el carrusel
carruselNext.addEventListener('click', () => {
    // Ocultar la imagen actual en el carrusel
    contenedorCarrusel.children[0].children[carruselIndex].children[0].classList.add('hidden');
    // Incrementar el índice del carrusel
    carruselIndex++;
    // Reiniciar el índice si es mayor o igual a la longitud del carrusel
    if (carruselIndex >= carruselLength) {
        carruselIndex = 0;
    }
    // Mostrar la siguiente imagen en el carrusel
    var carruselSeleccionado = contenedorCarrusel.children[0].children[carruselIndex].children[0];
    carruselSeleccionado.classList.remove('hidden');
    console.log(carruselSeleccionado);
});

// Agregar evento 'click' al botón de anterior en el carrusel
carruselPrev.addEventListener('click', () => {
    // Ocultar la imagen actual en el carrusel
    contenedorCarrusel.children[0].children[carruselIndex].children[0].classList.add('hidden');
    // Decrementar el índice del carrusel
    carruselIndex--;
    // Reiniciar el índice al final del carrusel si es menor que cero
    if (carruselIndex < 0) {
        carruselIndex = carruselLength - 1;
    }
    // Mostrar la imagen anterior en el carrusel
    var carruselSeleccionado = contenedorCarrusel.children[0].children[carruselIndex].children[0];
    carruselSeleccionado.classList.remove('hidden');
    console.log(carruselSeleccionado);
});
