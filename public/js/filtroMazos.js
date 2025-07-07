$(document).ready(inicio);

// Añadimos los eventos para los botones del filtro
function inicio() {
    $("#btnFiltroMazos").on("click", filtrarMazos);
    $("#btnReiniciarFiltro").on("click", reiniciarFiltros);
}

// Filtramos los mazos mostrados en el buscador
function filtrarMazos() {
    // Preparamos el campo del valor de busqueda del mazo
    let valorFiltro = $("#filtro-mazos").val();
    valorFiltro = valorFiltro.replaceAll(",", "");
    valorFiltro = valorFiltro.replaceAll(" ", "-");
    // Recorremos la lista y escondemos los mazos que coincidan con el filtro
    $(".carta-mazo").each(function () {
        $(this).show();
        if (!$(this).hasClass(valorFiltro)) {
            $(this).hide();
        }
    });
}

// Reiniciamos el filtro de mazos mostrando todos de nuevo
function reiniciarFiltros(){
    $(".carta-mazo").each(function () {
        $(this).show();
    });
}