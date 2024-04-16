function mostrarNoticiaAmpliada(id) {
    // Aquí puedes agregar lógica para cargar la noticia ampliada del servidor si es necesario
    // Por simplicidad, solo mostramos el modal en este ejemplo
    $('#modalNoticiaAmpliada').removeClass('hidden');
}

// Función para cerrar el modal de la noticia ampliada
$('#closeNoticiaAmpliadaModal').on('click', function() {
    $('#modalNoticiaAmpliada').addClass('hidden');
});
 