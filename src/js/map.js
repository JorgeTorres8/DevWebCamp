if(document.querySelector('#map')) { //772

    const lat = 10.4948031;
    const lng = -66.847604;
    const zoom = 16;

    var map = L.map('map').setView([lat, lng], zoom);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    L.marker([lat, lng]).addTo(map)
        .bindPopup(`
            <h2 class="map__heading">DevWebCamp</h2>
            <p class="map__text">Altamira, La Estancia</p>
        `)
        .openPopup();
}