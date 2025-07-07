// Escuchar el evento 'DOMContentLoaded' para asegurarse de que el DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', function () {
    console.log("JS cargado correctamente"); // Mensaje de confirmación en la consola

    // Obtener el formulario de eliminación por su ID
    const formulario = document.querySelector('#formEliminar');

    // Si no se encuentra el formulario, mostrar un error en la consola y detener la ejecución
    if (!formulario) {
        console.error("No se encontró el formulario #formEliminar");
        return;
    }

    // Escuchar el evento 'submit' del formulario
    formulario.addEventListener('submit', function (e) {
        e.preventDefault(); // Evitar el envío del formulario si hay errores

        limpiarErrores(); // Limpiar errores previos

        // Validar el formulario antes de enviarlo
        if (validarEliminacion(this)) {
            console.log("Formulario válido. Enviando...");
            this.submit(); // Si el formulario es válido, enviarlo
        }
    });
});

// Función para validar el formulario de eliminación de perfil
function validarEliminacion(form) {
    // Obtener el valor del campo de confirmación (donde el usuario debe escribir "ELIMINAR")
    const confirmacion = form.querySelector('input[name="confirmar"]').value.trim();

    const errores = []; // Array para almacenar errores

    // Validar que el usuario haya escrito "ELIMINAR" en mayúsculas
    if (confirmacion !== 'ELIMINAR') {
        errores.push('Debes escribir "ELIMINAR" en mayúsculas para confirmar la eliminación.');
    }

    // Si hay errores, mostrarlos y evitar el envío del formulario
    if (errores.length > 0) {
        mostrarErrores(errores);
        return false; // Formulario no válido
    }

    return true; // Formulario válido
}

// Función para mostrar errores en un cuadro rojo arriba del formulario
function mostrarErrores(errores) {
    limpiarErrores(); // Limpiar errores previos

    // Obtener el contenedor de errores
    const errorContainer = document.querySelector('#errorContainer');

    // Si no se encuentra el contenedor de errores, mostrar un error en la consola y detener la ejecución
    if (!errorContainer) {
        console.error("No se encontró el contenedor de errores");
        return;
    }

    // Aplicar clases de estilo y mostrar los errores como párrafos
    errorContainer.className = 'alert alert-danger';
    errorContainer.innerHTML = errores.map(error => `<p>${error}</p>`).join('');
}

// Función para limpiar errores
function limpiarErrores() {
    // Obtener el contenedor de errores
    const errorContainer = document.querySelector('#errorContainer');

    // Si el contenedor existe, limpiar su contenido y remover clases de estilo
    if (errorContainer) {
        errorContainer.innerHTML = ''; // Limpiar el contenido
        errorContainer.className = ''; // Remover clases de estilo
    }
}