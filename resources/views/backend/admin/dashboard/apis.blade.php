@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Gestión de APIs</h1>
 <p>Ubicación del usuario:</p>
<div id="map" style="height: 500px;"></div>
<div id="coords"></div> 
    <hr>

    <h2>Dibujo Libre</h2>
    <div style="text-align: center;">
        <canvas id="drawCanvas" width="600" height="400" style="border:1px solid #000;"></canvas>
        <br>
        <button onclick="saveDrawing()">Guardar como PNG</button>
        <button onclick="clearCanvas()">Borrar Lienzo</button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Geolocalización
        try {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    try {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;

                        const coordsText = document.createElement('p');
                        coordsText.textContent = `Latitud: ${lat}, Longitud: ${lng}`;
                        document.getElementById('coords').appendChild(coordsText);
;

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

                        fetch('http://ip-api.com/json/')
                            .then(response => response.json())
                            .then(data => {
                                try {
                                    const lat = data.lat;
                                    const lng = data.lon;

                                    const coordsText = document.createElement('p');
                                    coordsText.textContent = `Latitud: ${lat}, Longitud: ${lng}`;
                                    document.getElementById('coords').appendChild(coordsText);


                                    const map = L.map('map').setView([lat, lng], 13);
                                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                        maxZoom: 19,
                                        attribution: '© OpenStreetMap'
                                    }).addTo(map);
                                    L.marker([lat, lng]).addTo(map).bindPopup('Ubicación aproximada basada en IP').openPopup();
                                } catch (error) {
                                    console.error('Error al inicializar el mapa con IP:', error);
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

        // Canvas Dibujo
        const canvas = document.getElementById('drawCanvas');
        const ctx = canvas.getContext('2d');
        let drawing = false;

        canvas.addEventListener('mousedown', () => drawing = true);
        canvas.addEventListener('mouseup', () => {
            drawing = false;
            ctx.beginPath();
        });
        canvas.addEventListener('mouseout', () => drawing = false);
        canvas.addEventListener('mousemove', draw);

        function draw(event) {
            if (!drawing) return;
            try {
                const rect = canvas.getBoundingClientRect();
                const x = event.clientX - rect.left;
                const y = event.clientY - rect.top;
                ctx.strokeStyle = 'black';
                ctx.lineWidth = 2;
                ctx.lineCap = 'round';
                ctx.lineTo(x, y);
                ctx.stroke();
                ctx.beginPath();
                ctx.moveTo(x, y);
            } catch (error) {
                console.error("Error al dibujar:", error);
            }
        }

        window.saveDrawing = function () {
            try {
                const image = canvas.toDataURL("image/png");
                const link = document.createElement('a');
                link.href = image;
                link.download = "dibujo.png";
                link.click();
            } catch (error) {
                console.error("Error al guardar la imagen:", error);
            }
        }

        window.clearCanvas = function () {
            try {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
            } catch (error) {
                console.error("Error al borrar el lienzo:", error);
            }
        }
    });
</script>
@endsection

<!-- Agregar en el <head> -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
