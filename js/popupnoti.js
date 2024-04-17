// Función para abrir el popup con la noticia ampliada
function abrirPopup(imagen, titulo, descripcion) {
    // Crear un nuevo div para el popup
    var popupDiv = document.createElement("div");
    popupDiv.classList.add("popup");

    // Agregar contenido al popup
    popupDiv.innerHTML = `
        <div class="popup-content">
            <span class="popup-close" onclick="cerrarPopup()">×</span>
            <img src="${imagen}" alt="${titulo}" class="popup-image"/>
            <h1>${titulo}</h1>
            <p>${descripcion}</p>
            <!-- Aquí puedes agregar el formulario de comentarios -->
        </div>
    `;

    // Agregar el popup al body
    document.body.appendChild(popupDiv);
}

// Función para cerrar el popup
function cerrarPopup() {
    var popup = document.querySelector(".popup");
    if (popup) {
        popup.remove();
    }
}
