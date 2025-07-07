// Establecemos la funcion cuando cargue el documento
$(document).ready(inicio);
// Funcion de asignacion de eventos a los botones y campos de busqueda
function inicio() {
    $("#comandante").on("keypress", resultadosComandante);
    $("#nuevaCarta").on("keypress", resultadosCarta);
    $("#btnEditarMazo").on("click", agregarCarta);
}

// Funcion para mostrar los resultados de busqueda de comandante
async function resultadosComandante() {

    commanderName = `${$("#comandante").val()} (type:creature type:legendary)`;

    // Peticion mediante AJAX
    $.ajax({
        url: "https://api.scryfall.com/cards/search",
        data: {
            q: commanderName,
        },
        success: function (response) {
            // Mostramos los resultados en el datalist correspondiente
            if (typeof response.data !== 'undefined') {
                $("#commanderResults").html("");

                for (let i = 0; i < 10; i++) {
                    if (typeof response.data[i] !== 'undefined') {
                        $("#commanderResults").append(`<option value='${response.data[i].name}'>`);
                    }
                }
                // Añadimos el evento seleccionar comandante
                $(".result-commander").on("click", seleccionarComandante);
            }

        },
        error: function (e) {
            console.log(`Error: ${e}`);
        }
    });
}

// Funcion similar pero para los resultados de busqueda
async function resultadosCarta() {

    cardName = `${$("#nuevaCarta").val()}`;

    if (cardName != '') {
        $.ajax({
            url: "https://api.scryfall.com/cards/search",
            data: {
                q: cardName,
            },
            success: function (response) {

                $("#cardResults").html("");

                for (let i = 0; i < 10; i++) {
                    if (typeof response.data[i] !== 'undefined') {
                        $("#cardResults").append(`<option value='${response.data[i].name}'>`);
                    }
                }

                $(".result-item").on("click", seleccionarCarta);


            },
            error: function (e) {
                console.log(`Error: ${e}`);
            }
        });
    }
}

// Funcion para elegir comandante, limpia el datalist y coloca el valor en el campo input
function seleccionarComandante() {
    $("#comandante").val($(this).text());
    $("#commanderResults").html("");
}

// Funcion para seleccionar una carta y añadirla al campo de busqueda
function seleccionarCarta() {
    let listaActual = $("#listaMazo").val();
    if (listaActual.includes($(this).text())) {
        // Si la carta ya existe en el mazo la busca y modifica la cantidad para sumarle 1
        let array = $("#listaMazo").val().split("\n");
        for (let i = 0; i < array.length; i++) {
            if (array[i].includes($(this).text())) {
                let frase = array[i].split(" ");
                frase[0] = (parseInt(frase[0]) + 1).toString();
                array[i] = frase.join(" ");
            }
        }
        $("#listaMazo").val(array.join("\n"));
    } else {
        // Si no existe se añade sin mas
        $("#listaMazo").val($("#listaMazo").val() + '\n1 ' + $(this).text());
    }
    // Limpiamos los datos de busqueda
    $("#cardResults").html("");
    $("#nuevaCarta").val("");
}

function agregarCarta(event) {
    event.preventDefault();
    let listaActual = $("#listaMazo").val();
    if (listaActual.includes($("#nuevaCarta").val())) {
        let array = $("#listaMazo").val().split("\n");
        for (let i = 0; i < array.length; i++) {
            if (array[i].includes($("#nuevaCarta").val())) {
                let frase = array[i].split(" ");
                frase[0] = (parseInt(frase[0]) + 1).toString();
                array[i] = frase.join(" ");
            }
        }
        $("#listaMazo").val(array.join("\n"));
    } else {
        $("#listaMazo").val($("#listaMazo").val() + '\n1 ' + $("#nuevaCarta").val());
    }
    $("#cardResults").html("");
    $("#nuevaCarta").val("");
}



