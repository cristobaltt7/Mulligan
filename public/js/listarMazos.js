document.addEventListener("DOMContentLoaded", function () {
    const userId = document.getElementById("selectDeck").dataset.userId; // Obtener ID desde atributo data
    fetch(`/api/user/${userId}/decks`)
        .then(response => response.json())
        //le agregamos el nombre del deck y su id para que nos salga en el desplegable
        .then(data => {
            let selectDeck = document.getElementById("selectDeck");
            data.forEach(deck => {
                let option = document.createElement("option");
                option.value = deck.id;
                option.textContent = deck.name;
                selectDeck.appendChild(option);
            });
        })
        .catch(error => console.error("Error al cargar los mazos:", error));
});
