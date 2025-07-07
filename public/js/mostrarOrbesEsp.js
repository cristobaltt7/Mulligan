import { pintarSimbolos } from "./manaSymbols.js";
$(window).ready(mostrarOrbes);

function mostrarOrbes(){ // Aplicamos la funcion pintar simbolos en el coste de mana y texto de reglas
    $('#costeMana').html(`<strong>Coste de Maná:</strong>${pintarSimbolos($('#costeMana').text())}`);
    $('#textoReglas').html(`<strong>Texto de reglas:</strong>${pintarSimbolos($('#textoReglas').text())}`);
}

