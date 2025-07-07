import { Card } from "./models/Card.js";
import { Deck } from "./models/Deck.js";
import { pintarSimbolos } from "./manaSymbols.js";

// Establecemos la apiKey y la funcion cuando cargue el documento
$(document).ready(inicio);

// Funcion de asignacion de eventos a los botones
async function inicio() {
    $("#btnActualizar").on("click", actualizarPreview);
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

async function crearMazo(listaMazo) {
    let nombreMazo = $('#nombre').val();
    let comandanteMazo = $('#comandante').val();
    let mazo = new Deck(nombreMazo, comandanteMazo);

    let promesas = listaMazo.map(cartaActual => {
        let nombreCarta = cartaActual.split(" ");
        let numeroCarta = nombreCarta.shift();
        nombreCarta = nombreCarta.join(" ");
        return crearCarta(nombreCarta, numeroCarta, mazo);
    });

    await Promise.all(promesas);

    return mazo;
}

function crearCarta(nombreCarta, numeroCarta, mazo) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: "https://api.scryfall.com/cards/named",
            data: {
                exact: nombreCarta,
            },
            success: function (response) {
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


function dibujarMazo(mazo) {
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
    tierras = new Map([...tierras.entries()].sort((a, b) => String(a[0].name).localeCompare(b[0].name)));

    mostrarCategoria(comandantes, "Comandante");
    mostrarCategoria(criaturas, "Criaturas");
    mostrarCategoria(planeswalkers, "Planeswalkers");
    mostrarCategoria(instantaneos, "Instantaneos");
    mostrarCategoria(conjuros, "Conjuros");
    mostrarCategoria(encantamientos, "Encantamientos");
    mostrarCategoria(artefactos, "Artefactos");
    mostrarCategoria(tierras, "Tierras");
    mostrarCategoria(extra, "Extras");

    $("#contenedor-categorias").append(`<h3 class='total-cartas'>`);
    $("#contenedor-categorias").children().last().text(`Total de cartas: ${totalCartasMazo}`);
}

function mostrarCategoria(mapa, titulo) {
    if (mapa.size > 0) {
        mapa = new Map([...mapa.entries()].sort((a, b) => String(a[0].name).localeCompare(b[0].name)));
        let totalCartas = 0;
        $("#contenedor-categorias").append(`<div class='categoria-cartas'>`);
        let contenedor = $("#contenedor-categorias").children().last();
        contenedor.append(`<h5 class='titulo-categoria'>`);
        contenedor.append(`<ul class="lista-cartas">`);
        for (const cartaActual of mapa) {
            contenedor.children().last().append(`<li class='cartapreview'>`);
            contenedor.children().last().children().last().append(`${cartaActual[1]}x <a class="enlace-carta" href="/carta/${cartaActual[0].name}">${cartaActual[0].name}</a>`);
            contenedor.children().last().children().last().append(`<img class="imagen-carta hide" src="${cartaActual[0].image}">`);
            contenedor.children().last().children().last().append(pintarSimbolos(cartaActual[0].manaCost));
            totalCartas += parseInt(cartaActual[1]);
        }
        contenedor.children().first().text(`${titulo} (${totalCartas})`);
    }
}

async function actualizarPreview(event) {
    event.preventDefault();
    const listaActual = $("#listaMazo").val().split("\n");
    $("#contenedor-categorias").empty();
    crearMazo(listaActual).then(
        function (mazo) { dibujarMazo(mazo); }
    );
}