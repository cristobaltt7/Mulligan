$(document).ready(inicio);

// Funcion de validacion al crear un mazo
function inicio() {
    $("#btnCrearMazo").on("click", function (event) {
        $("#errores").text("");
        let nombre = $('#nombre');
        let comandante = $('#comandante');
        nombre.removeClass("input-error");
        comandante.removeClass("input-error");
        let errores = [];
        // Comprobamos si el nombre cumple los requisitos de longitud
        if (!nombre.val().match(/\w{2,30}/g)) {
            nombre.addClass("input-error");
            errores.push('Error: Nombre no valido');
        }
        // Compsobamos si el comandante cumple los requisitos de longitud
        if (!comandante.val().match(/\w{2,30}/g)) {
            comandante.addClass("input-error");
            errores.push('Error: Comandante no valido');
        }
        // En caso de errores añade una alerta
        if (errores.length != 0) {
            event.preventDefault();
            agregarAlerta(errores);
        }
    });
}

// Funcion para mostrar los errores
function agregarAlerta(mensaje) {
    const contenedorAlerta = $('#contenedorErrores');
    contenedorAlerta.empty();
    contenedorAlerta.append(`<div class="alert alert-danger alert-dismissible mensaje-alerta" role="alert">Se han encontrado los siguientes errores:`);
    contenedorAlerta.children().first().append(`<ul>`);
    for (const error of mensaje) {
        contenedorAlerta.children().first().children().first().append(`<li>${error}</li>`);
    }
    contenedorAlerta.children().first().append(`<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>`);
}
