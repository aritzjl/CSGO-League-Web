const modal = document.getElementById('modal');
    const openModalButton = document.getElementById('openModal');
    const closeModalButton = document.getElementById('closeModal');

    // Función para abrir el modal
    function openModal() {
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    // Función para cerrar el modal
    function closeModal() {
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    // Event listeners para abrir y cerrar el modal
    openModalButton.addEventListener('click', openModal);
    closeModalButton.addEventListener('click', closeModal);

function openRegistroModal() {
    document.getElementById('modal').classList.add('hidden');
    document.getElementById('registroModal').classList.remove('hidden');
}

document.getElementById('closeRegistroModal').addEventListener('click', function() {
    document.getElementById('registroModal').classList.add('hidden');
    document.getElementById('modal').classList.remove('hidden');
});

function submitForm(event) {
    event.preventDefault(); // Evita que se envíe el formulario de manera tradicional

    // Obtener los datos del formulario
    var formData = {
        nombre: $('#nombre').val(),
        apellido: $('#apellido').val(),
        email: $('#email').val(),
        password: $('#password').val(),
        confirmPassword: $('#confirmPassword').val()
    };

    // Enviar los datos del formulario al servidor
    $.ajax({
        type: 'POST',
        url: '../csl/register.php', // Ruta al archivo PHP que procesa el formulario
        data: formData,
        success: function(response) {
            // Manejar la respuesta del servidor
            $('#mensaje').html(response); // Mostrar el mensaje del servidor en el elemento con id "mensaje"
        }
    });
}


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
