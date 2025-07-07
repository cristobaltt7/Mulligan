// Esperar a que el documento esté completamente cargado antes de ejecutar la función 'inicio'
$(document).ready(inicio);

// Función que se ejecuta al cargar la página
function inicio() {
    // Asignar eventos a los botones de filtro y reinicio
    $("#btnFiltroUsuarios").on("click", filtrarUsuarios); // Al hacer clic en "Filtrar", ejecutar 'filtrarUsuarios'
    $("#btnReiniciarFiltro").on("click", reiniciarFiltros); // Al hacer clic en "Reiniciar", ejecutar 'reiniciarFiltros'
}

// Función para filtrar usuarios según el valor ingresado en el campo de filtro
function filtrarUsuarios() {
    // Obtener el valor del campo de filtro
    let valorFiltro = $("#filtro-usuarios").val();

    // Reemplazar espacios en blanco con guiones
    valorFiltro = valorFiltro.replaceAll(" ", "-");

    // Recorrer todas las filas de usuarios
    $(".fila-usuario").each(function () {
        $(this).show(); // Mostrar la fila por defecto

        // Si el valor del filtro no está vacío y la fila no tiene la clase correspondiente, ocultarla
        if (valorFiltro !== "" && !$(this).hasClass(valorFiltro)) {
            $(this).hide();
        }
    });
}

// Función para reiniciar los filtros y mostrar todas las filas de usuarios
function reiniciarFiltros() {
    // Limpiar el campo de filtro
    $("#filtro-usuarios").val("");

    // Recorrer todas las filas de usuarios y mostrarlas
    $(".fila-usuario").each(function () {
        $(this).show();
    });
}