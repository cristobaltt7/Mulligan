// Función para validar el formulario de creación de perfil
function validarFormulario(form) {
    // Obtener los valores de los campos del formulario y eliminar espacios en blanco al inicio y final
    const username = form.querySelector('#username').value.trim(); // Nombre de usuario
    const email = form.querySelector('#email').value.trim(); // Correo electrónico
    const password = form.querySelector('#password').value.trim(); // Contraseña
    const passwordConfirmation = form.querySelector('#password_confirmation').value.trim(); // Confirmación de contraseña

    const errores = []; // Array para almacenar los errores de validación

    // Validación del nombre de usuario
    if (username.length < 3 || username.length > 20) {
        errores.push('El nombre de usuario debe tener entre 3 y 20 caracteres.');
    }

    // Validación del correo electrónico
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Expresión regular para validar correos
    if (!emailRegex.test(email)) {
        errores.push('Por favor, introduce un correo electrónico válido.');
    }

    // Validación de la contraseña
    if (password.length < 6) {
        errores.push('La contraseña debe tener al menos 6 caracteres.');
    }

    // Validación de la confirmación de contraseña
    if (password !== passwordConfirmation) {
        errores.push('Las contraseñas no coinciden.');
    }

    // Si hay errores, mostrarlos y evitar el envío del formulario
    if (errores.length > 0) {
        mostrarErrores(errores); // Mostrar los errores en la interfaz
        return false; // Detener el envío del formulario
    }

    return true; // Permitir el envío del formulario si no hay errores
}

// Función para mostrar errores en un cuadro rojo arriba del formulario
function mostrarErrores(errores) {
    // Limpiar errores anteriores para evitar duplicados
    limpiarErrores();

    // Crear un contenedor para los errores
    const errorContainer = document.createElement('div');
    errorContainer.className = 'alert alert-danger'; // Aplicar clases de estilo (Bootstrap)
    errorContainer.innerHTML = errores.map(error => `<p>${error}</p>`).join(''); // Convertir errores en párrafos

    // Insertar el contenedor de errores antes del formulario
    const formulario = document.querySelector('form');
    formulario.insertBefore(errorContainer, formulario.firstChild);
}

// Función para limpiar errores anteriores
function limpiarErrores() {
    // Buscar el contenedor de errores anterior
    const erroresAnteriores = document.querySelector('.alert.alert-danger');
    if (erroresAnteriores) {
        erroresAnteriores.remove(); // Eliminar el contenedor de errores si existe
    }
}

// Manejar el envío del formulario
document.querySelector('form').addEventListener('submit', function (e) {
    e.preventDefault(); // Evitar el envío automático del formulario

    limpiarErrores(); // Limpiar errores anteriores antes de validar

    // Validar el formulario antes de enviarlo
    if (validarFormulario(this)) {
        this.submit(); // Si la validación es exitosa, enviar el formulario
    }
});