//Ordenar la Tabla
document.addEventListener("DOMContentLoaded", function() {
    // Encuentra la tabla por su ID
    var table = document.getElementById("miTabla");

    // Encuentra todas las filas de la tabla
    var rows = table.getElementsByTagName("tr");

    // Convierte las filas en un array para poder ordenarlas
    var rowsArray = Array.prototype.slice.call(rows, 1); // Empezamos desde 1 para omitir la fila de encabezados

    // Ordena las filas según los puntos y luego por round difference
    rowsArray.sort(function(rowA, rowB) {
        var puntosA = parseInt(rowA.cells[7].textContent); // El índice 7 corresponde a la columna de puntos
        var puntosB = parseInt(rowB.cells[7].textContent);
        var roundDiffA = parseInt(rowA.cells[6].textContent); // El índice 6 corresponde a la columna de round difference
        var roundDiffB = parseInt(rowB.cells[6].textContent);
        
        // Ordena por puntos de forma descendente
        if (puntosB !== puntosA) {
            return puntosB - puntosA;
        } else {
            // Si los puntos son iguales, ordena por round difference de forma descendente
            return roundDiffB - roundDiffA;
        }
    });

    // Vuelve a insertar las filas en la tabla en el orden ordenado
    for (var i = 0; i < rowsArray.length; i++) {
        table.appendChild(rowsArray[i]);
        // Actualiza el número de posición
        rowsArray[i].cells[0].textContent = i + 1;
    }
});
//Para la combobox
document.addEventListener('DOMContentLoaded', function () {
    // Obtener la combobox de temporada
    const combobox = document.getElementById('temporada');

    // Agregar un event listener para detectar cambios en la combobox
    combobox.addEventListener('change', function () {
        // Obtener el formulario
        const form = document.getElementById('temporadaForm');
        // Enviar el formulario automáticamente al seleccionar una temporada
        form.submit();
    });
});

//para las jornadas
function mostrarOcultarPartidos(jornadaId) {
    var jornada = document.getElementById(jornadaId);
    // Si está visible, ocultarlo; si está oculto, mostrarlo
    if (jornada.style.display === 'none') {
        jornada.style.display = 'block';
    } else {
        jornada.style.display = 'none';
    }
}