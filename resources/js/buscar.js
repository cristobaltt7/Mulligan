document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("searchForm").addEventListener("submit", function (e) {
        e.preventDefault();
        
        let query = document.getElementById("searchQuery").value.trim();
        if (!query) {
            alert("Debes ingresar un término de búsqueda.");
            return;
        }

        fetch(`/buscar?q=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                let resultsContainer = document.getElementById("results");
                resultsContainer.innerHTML = ""; // Limpiar resultados previos

                if (data.error) {
                    resultsContainer.innerHTML = `<div class="alert alert-danger">${data.error}</div>`;
                    return;
                }

                if (data.data && data.data.length > 0) {
                    data.data.forEach(card => {
                        let cardHtml = `
                            <div class="col-md-4 mb-3">
                                <div class="card">
                                    <img src="${card.image_uris?.normal || card.card_faces?.[0]?.image_uris?.normal || ''}" class="card-img-top" alt="${card.name}">
                                    <div class="card-body">
                                        <h5 class="card-title">${card.name}</h5>
                                        <p class="card-text">${card.type_line}</p>
                                        <p class="card-text"><strong>Precio:</strong> $${card.prices?.usd || "N/A"}</p>
                                    </div>
                                </div>
                            </div>
                        `;
                        resultsContainer.innerHTML += cardHtml;
                    });
                } else {
                    resultsContainer.innerHTML = `<div class="alert alert-warning">No se encontraron cartas.</div>`;
                }
            })
            .catch(error => {
                console.error("Error:", error);
                document.getElementById("results").innerHTML = `<div class="alert alert-danger">Hubo un problema con la búsqueda.</div>`;
            });
    });
});
