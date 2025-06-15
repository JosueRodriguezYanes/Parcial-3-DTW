@extends('layouts.app')
<!-- Agregar en el <head> -->
@section('content')
<div class="container">
    <h1>Gestión de APIs</h1>
    <p>Ubicación del usuario:</p>
    <div id="map" style="height: 500px;"></div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        try {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    try {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;

                        // Mostrar coordenadas
                        const coordsText = document.createElement('p');
                        coordsText.textContent = `Latitud: ${lat}, Longitud: ${lng}`;
                        document.querySelector('.container').appendChild(coordsText);

                        // Inicializar mapa con LeafletJS
                        const map = L.map('map').setView([lat, lng], 13);
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            maxZoom: 19,
                            attribution: '© OpenStreetMap'
                        }).addTo(map);
                        L.marker([lat, lng]).addTo(map).bindPopup('Estás aquí').openPopup();
                    } catch (error) {
                        console.error('Error al inicializar el mapa:', error);
                        alert('Ocurrió un error al mostrar el mapa.');
                    }
                }, function (error) {
                    if (error.code === error.PERMISSION_DENIED) {
                        alert('Permiso denegado para acceder a la ubicación. Mostrando una ubicación aproximada basada en IP.');

                        // Respaldo: Obtener ubicación basada en IP
                        fetch('http://ip-api.com/json/')
                            .then(response => response.json())
                            .then(data => {
                                try {
                                    const lat = data.lat;
                                    const lng = data.lon;

                                    // Mostrar coordenadas
                                    const coordsText = document.createElement('p');
                                    coordsText.textContent = `Latitud: ${lat}, Longitud: ${lng}`;
                                    document.querySelector('.container').appendChild(coordsText);

                                    // Inicializar mapa con LeafletJS
                                    const map = L.map('map').setView([lat, lng], 13);
                                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                        maxZoom: 19,
                                        attribution: '© OpenStreetMap'
                                    }).addTo(map);
                                    L.marker([lat, lng]).addTo(map).bindPopup('Ubicación aproximada basada en IP').openPopup();
                                } catch (error) {
                                    console.error('Error al inicializar el mapa con ubicación basada en IP:', error);
                                    alert('Ocurrió un error al mostrar el mapa con la ubicación aproximada.');
                                }
                            })
                            .catch(error => {
                                console.error('Error al obtener la ubicación basada en IP:', error);
                                alert('No se pudo obtener la ubicación aproximada.');
                            });
                    } else {
                        alert('No se pudo obtener la ubicación: ' + error.message);
                    }
                });
            } else {
                alert('Geolocalización no soportada por el navegador.');
            }
        } catch (error) {
            console.error('Error inesperado:', error);
            alert('Ocurrió un error inesperado.');
        }
    });
</script>
@endsection

<!-- Agregar en el <head> -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script> d 