
const contenedorCarruselJornadas = document.getElementById('contenedorCarruselJornadas');
const carruselNextJornadas = document.getElementById('carruselNextJornadas');
const carruselPrevJornadas = document.getElementById('carruselBeforeJornadas');
const tituloJornada = document.getElementById('jornadaTitulo');
let carruselIndexJornadas = 0;
const carruselLengthJornadas = contenedorCarruselJornadas.children.length;

carruselNextJornadas.addEventListener('click', () => {

    var JornadaOcultar = contenedorCarruselJornadas.children[carruselIndexJornadas];
    JornadaOcultar.classList.add('hidden');
    carruselIndexJornadas++;
    
    
    if (carruselIndexJornadas >= carruselLengthJornadas) {
        carruselIndexJornadas = 0;
    }
    tituloJornada.innerHTML = "Jornada " + (carruselIndexJornadas + 1);
    var JornadaMostrar = contenedorCarruselJornadas.children[carruselIndexJornadas];
    JornadaMostrar.classList.remove('hidden');
    
}
);

carruselPrevJornadas.addEventListener('click', () => {
    var JornadaOcultar = contenedorCarruselJornadas.children[carruselIndexJornadas];
    JornadaOcultar.classList.add('hidden');

    carruselIndexJornadas--; // Disminuye el índice

    if (carruselIndexJornadas < 0) { // Si el índice es menor que cero, establece el índice al último elemento
        carruselIndexJornadas = carruselLengthJornadas - 1;
    }
    tituloJornada.innerHTML = "Jornada " + (carruselIndexJornadas + 1);
    var JornadaMostrar = contenedorCarruselJornadas.children[carruselIndexJornadas];
    JornadaMostrar.classList.remove('hidden');
});
