$(window).ready(inicio);

function inicio(){
    let ruta = window.location.href.replace("http://127.0.0.1:8000/","");
    switch (ruta){
        case "":
        $("#link-inicio").addClass("active");
        break;
        case "decks":
        $("#link-mazos").addClass("active");
        break;
        case "carta-aleatoria":
        $("#link-aleatorio").addClass("active");
        break;
        case "ver-perfil":
        $("#link-perfil").addClass("active");
        break;
    }
}