function applyFilters() {
    // recogemos los valores del filtro
    let query = document.getElementById('searchQuery').value;
    let rarity = document.getElementById('rarity').value;
    let type = document.getElementById('type').value;
    let colors = [];

    document.querySelectorAll("input[name='color[]']:checked").forEach(checkbox => {
        colors.push(checkbox.value);
    });

    //Los incluimos en la url de busqueda
    let url = document.getElementById("filterForm").dataset.searchUrl + "?q=" + encodeURIComponent(query);
    if (rarity) url += `+rarity:${rarity}`;
    if (type) url += `+type:${type}`;
    if (colors.length > 0) url += `+color:${colors.join('')}`;

    window.location.href = url;
}
