import { Card } from "./models/Card.js";
import { Deck } from "./models/Deck.js";

// Establecemos la apiKey y la funcion cuando cargue el documento
$(document).ready(inicio);

// Funcion obtener la lista del mazo
async function inicio() {
    let urlActual = window.location.href.split("/");
    let idMazo = urlActual[4];
    $.ajax({
        url: `http://127.0.0.1:8000/api/decks/${idMazo}`,
        success: function (response) {
            crearMazo(response.decklist).then(
                function (mazo) { dibujarMazo(mazo); }
            );
        },
        error: function (e) {
            console.log(`Error: ${e}`);
        }
    });
}

// Creacion del objeto mazo a partir de la lista obtenida a traves de la API local
async function crearMazo(listaMazo) {
    let nombreMazo = $('#nombre').val();
    let comandanteMazo = $('#comandante').val();
    let mazo = new Deck(nombreMazo, comandanteMazo);

    // Creamos los objetos cartas obteniendo la informacion de la API externa
    let promesas = listaMazo.map(cartaActual => {
        let nombreCarta = cartaActual.split(" ");
        let numeroCarta = nombreCarta.shift();
        nombreCarta = nombreCarta.join(" ");
        return crearCarta(nombreCarta, numeroCarta, mazo);
    });

    // Esperamos a que se completen todas las peticiones antes de devolver el mazo
    await Promise.all(promesas);

    return mazo;
}

// Creacion del objeto carta
function crearCarta(nombreCarta, numeroCarta, mazo) {
    return new Promise((resolve, reject) => {
        // Peticion a la API de la informacion de la carta
        $.ajax({
            url: "https://api.scryfall.com/cards/named",
            data: {
                exact: nombreCarta,
            },
            success: function (response) {
                // Agregamos un delay por peticion de la API externa para evitar sobrecargas
                setTimeout(function () {
                    let rutaImagen ="";
                    let costeCarta ="";
                    // Aseguramos de coger bien la ruta a la imagen de la carta
                    if(response.hasOwnProperty('card_faces')){
                        rutaImagen = response.card_faces[0].image_uris.normal;
                        costeCarta = response.card_faces[0].mana_cost;
                    } else {
                        rutaImagen = response.image_uris.normal;
                        costeCarta = response.mana_cost;
                    }
                    // Creamos la carta con los datos devueltos
                    let cartaNueva = new Card(response.name, response.type_line, rutaImagen, costeCarta);
                    mazo.decklist.set(cartaNueva, numeroCarta);
                    resolve();
                }, 100);
            },
            error: function (e) {
                console.log(`Error: ${e}`);
                reject(e);
            }
        });
    });
}

// Dibujamos el mazo en su contenedor correspondiente
function dibujarMazo(mazo) {
    // Establecemos una serie de mapas con las distintas categorias de las cartas
    let totalCartasMazo = 0;
    let comandantes = new Map();
    let criaturas = new Map();
    let planeswalkers = new Map();
    let instantaneos = new Map();
    let conjuros = new Map();
    let encantamientos = new Map();
    let artefactos = new Map();
    let tierras = new Map();
    let extra = new Map();

    // Separamos las cartas del mazo en categorias de manera apropiada
    for (const data of mazo.decklist) {
        const carta = data[0];
        const numeroCopias = data[1];
        totalCartasMazo += parseInt(numeroCopias);
        const tipos = carta.type.split(" ");
        if (carta.name == mazo.commander) {
            comandantes.set(carta, numeroCopias);
        } else {
            if (tipos.includes("Creature")) {
                criaturas.set(carta, numeroCopias);
            } else if (tipos.includes("Planeswalker")) {
                planeswalkers.set(carta, numeroCopias);
            } else if (tipos.includes("Instant")) {
                instantaneos.set(carta, numeroCopias);
            } else if (tipos.includes("Sorcery")) {
                conjuros.set(carta, numeroCopias);
            } else if (tipos.includes("Enchantment")) {
                encantamientos.set(carta, numeroCopias);
            } else if (tipos.includes("Artifact")) {
                artefactos.set(carta, numeroCopias);
            } else if (tipos.includes("Land")) {
                tierras.set(carta, numeroCopias);
            } else {
                extra.set(carta, numeroCopias);
            }
        }
    }

    // Mostramos las categorias de cartas de manera adecuada en el orden apropiado
    mostrarCategoria(comandantes, "Comandante", "bi-flag-fill");
    mostrarCategoria(criaturas, "Criaturas", "bi-gitlab");
    mostrarCategoria(planeswalkers, "Planeswalkers", "bi-person-standing");
    mostrarCategoria(instantaneos, "Instantaneos", "bi-lightning-fill");
    mostrarCategoria(conjuros, "Conjuros", "bi-fire");
    mostrarCategoria(encantamientos, "Encantamientos", "bi-stars");
    mostrarCategoria(artefactos, "Artefactos", "bi-gear-wide-connected");
    mostrarCategoria(tierras, "Tierras", "bi-tree-fill");
    mostrarCategoria(extra, "Extras","bi-question-circle-fill");

    // Mostramos el total de las cartas
    $("#contenedor-categorias").append(`<h3 class='total-cartas'>`);
    $("#contenedor-categorias").children().last().text(`Total de cartas: ${totalCartasMazo}`);
}

// Funcion para mostrar las cartas de una categoria concreta
function mostrarCategoria(mapa, titulo, icono) {
    if (mapa.size > 0) {
        // Ordenamos el mapa alfabeticamente
        mapa = new Map([...mapa.entries()].sort((a, b) => String(a[0].name).localeCompare(b[0].name)));
        let totalCartas = 0;
        $("#contenedor-categorias").append(`<div class='categoria-cartas'>`);
        let contenedor = $("#contenedor-categorias").children().last();
        contenedor.append(`<h3 class='titulo-categoria'>`);
        contenedor.append(`<div class="lista-cartas d-flex flex-wrap flex-row">`);
        // Por cada carta creamos el contenedor que la mostrara con los datos adecuados
        for (const cartaActual of mapa) {
            contenedor.children().last().append(`<div class='carta m-1'>`);
            contenedor.children().last().children().last().append(`<a class="enlace-carta" href="/carta/${cartaActual[0].name.replaceAll("//"," ")}">`);
            contenedor.children().last().children().last().children().last().append(`<img class='card-item' src='${cartaActual[0].image}'>`);
            contenedor.children().last().children().last().children().last().append(`<div class='overlay'>`);
            contenedor.children().last().children().last().children().last().children().last().append(`<span class="badge rounded-pill text-bg-primary">x${cartaActual[1]}</span>`);
            totalCartas += parseInt(cartaActual[1]);
        }
        contenedor.children().first().html(`<i class="bi ${icono}"></i> ${titulo} (${totalCartas})`);
    }
}