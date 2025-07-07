// Escuchar el evento 'DOMContentLoaded' para asegurarse de que el DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', function () {
    console.log("JS para editar perfil cargado correctamente");

    // Obtener el formulario de edición de perfil por su ID
    const formulario = document.querySelector('#formulario-editar-perfil');

    // Si no se encuentra el formulario, mostrar un error en la consola y detener la ejecución
    if (!formulario) {
        console.error("No se encontró el formulario #formulario-editar-perfil");
        return;
    }

    // Guardar los valores originales del formulario al cargar la página
    const valoresOriginales = {
        username: formulario.querySelector('#username').value.trim(), // Nombre de usuario original
        email: formulario.querySelector('#email').value.trim() // Correo electrónico original
    };

    // Escuchar el evento 'submit' del formulario
    formulario.addEventListener('submit', function (e) {
        e.preventDefault(); // Evitar el envío del formulario si hay errores
        limpiarErrores(); // Limpiar errores previos

        // Obtener los valores de los campos de nueva contraseña y confirmación
        const nuevaContrasena = formulario.querySelector('#password_nueva').value.trim();
        const confirmacionContrasena = formulario.querySelector('#password_confirmacion').value.trim();

        // Verificar si no hay cambios en el formulario
        if (!hayCambios(formulario, valoresOriginales, nuevaContrasena)) {
            mostrarErrores(["No has realizado ningún cambio."]); // Mostrar mensaje de error
            return; // Detener la ejecución
        }

        // Validar el formulario antes de enviarlo
        if (validarFormulario(this)) {
            console.log("Formulario válido. Enviando...");
            this.submit(); // Si el formulario es válido, enviarlo
        }
    });

    // Habilitar/deshabilitar el campo de confirmación de contraseña según el campo de nueva contraseña
    document.getElementById('password_nueva').addEventListener('input', function () {
        const confirmacion = document.getElementById('password_confirmacion');
        confirmacion.disabled = this.value.trim() === ''; // Deshabilitar si no hay nueva contraseña
    });
});

// Función para comprobar si hay cambios en el formulario
function hayCambios(form, valoresOriginales, nuevaContrasena) {
    return (
        form.querySelector('#username').value.trim() !== valoresOriginales.username || // Cambio en el nombre de usuario
        form.querySelector('#email').value.trim() !== valoresOriginales.email || // Cambio en el correo electrónico
        nuevaContrasena !== '' // Cambio en la contraseña
    );
}

// Función para validar el formulario
function validarFormulario(form) {
    // Obtener los valores de los campos del formulario
    const username = form.querySelector('#username').value.trim();
    const email = form.querySelector('#email').value.trim();
    const nuevaContrasena = form.querySelector('#password_nueva').value.trim();
    const confirmacionContrasena = form.querySelector('#password_confirmacion').value.trim();

    const errores = []; // Array para almacenar errores

    // Validación del nombre de usuario
    if (username.length < 3 || username.length > 20) {
        errores.push('El nombre de usuario debe tener entre 3 y 20 caracteres.');
    }

    // Validación del correo electrónico
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        errores.push('Por favor, introduce un correo electrónico válido.');
    }

    // Validación de la nueva contraseña (si se proporciona)
    if (nuevaContrasena || confirmacionContrasena) {
        if (nuevaContrasena.length < 6) {
            errores.push('La nueva contraseña debe tener al menos 6 caracteres.');
        }
        if (nuevaContrasena !== confirmacionContrasena) {
            errores.push('Las contraseñas no coinciden.');
        }
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
    errorContainer.className = 'alert alert-danger'; // Aplicar clases de estilo
    errorContainer.innerHTML = errores.map(error => `<p>${error}</p>`).join(''); // Mostrar errores como párrafos
}

// Función para limpiar errores
function limpiarErrores() {
    const errorContainer = document.querySelector('#errorContainer');
    if (errorContainer) {
        errorContainer.innerHTML = ''; // Limpiar el contenido
        errorContainer.className = ''; // Remover clases de estilo
    }
}
