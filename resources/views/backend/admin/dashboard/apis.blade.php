@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Gestión de APIs</h1>
    
    <!-- Sección de Geolocalización -->
    <p>Ubicación del usuario:</p>
    <div id="map" style="height: 500px;"></div>
    <div id="coords"></div> 
    <hr>

    <!-- Nueva Sección de Control de Video -->
    <h2>Control de Video</h2>
    <div class="video-container">
        <video id="customVideo" width="100%">
            <source src="{{ asset('videos/sample.mp4') }}" type="video/mp4">
            Tu navegador no soporta el elemento de video.
        </video>
        
        <div class="video-controls">
            <button id="playPauseBtn" class="btn btn-primary">Play</button>
            <button id="backwardBtn" class="btn btn-secondary">-10s</button>
            <button id="forwardBtn" class="btn btn-secondary">+10s</button>
            
            <div class="speed-control">
                <label for="speedSelect">Velocidad:</label>
                <select id="speedSelect" class="form-control">
                    <option value="0.5">0.5x</option>
                    <option value="0.75">0.75x</option>
                    <option value="1" selected>1x</option>
                    <option value="1.25">1.25x</option>
                    <option value="1.5">1.5x</option>
                    <option value="2">2x</option>
                </select>
            </div>
            
            <div class="volume-control">
                <label for="volumeSlider">Volumen:</label>
                <input type="range" id="volumeSlider" min="0" max="1" step="0.1" value="1" class="form-range">
            </div>
            
            <div class="time-display">
                <span id="currentTime">00:00</span> / <span id="duration">00:00</span>
            </div>
        </div>
        
        <div class="video-url mt-3">
            <div class="input-group">
                <input type="text" id="videoUrl" class="form-control" placeholder="Ingrese URL de video o seleccione local">
                <button class="btn btn-outline-secondary" type="button" id="loadVideoBtn">Cargar</button>
                <input type="file" id="videoFile" accept="video/*" style="display: none;">
                <button class="btn btn-outline-secondary" type="button" id="selectFileBtn">Local</button>
            </div>
        </div>
    </div>
    <hr>

    <!-- Sección de Dibujo Libre -->
    <h2>Dibujo Libre</h2>
    <div style="text-align: center;">
        <canvas id="drawCanvas" width="600" height="400" style="border:1px solid #000;"></canvas>
        <br>
        <button onclick="saveDrawing()">Guardar como PNG</button>
        <button onclick="clearCanvas()">Borrar Lienzo</button>
    </div>
</div>

<!-- Leaflet para el mapa -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<!-- Estilos para el control de video -->
<style>
    .video-container {
        max-width: 800px;
        margin: 20px auto;
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .video-controls {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: center;
        margin-top: 10px;
        padding: 10px;
        background: #e9ecef;
        border-radius: 4px;
    }

    .speed-control, .volume-control {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .time-display {
        margin-left: auto;
        font-family: monospace;
    }

    #customVideo {
        border-radius: 4px;
        background: #000;
        width: 100%;
    }

    .video-url {
        margin-top: 15px;
    }

    @media (max-width: 768px) {
        .video-controls {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .time-display {
            margin-left: 0;
            margin-top: 10px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // 1. Código de Geolocalización (existente)
        try {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    try {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;

                        const coordsText = document.createElement('p');
                        coordsText.textContent = `Latitud: ${lat}, Longitud: ${lng}`;
                        document.getElementById('coords').appendChild(coordsText);

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

        // 2. Control de Video (nuevo)
        try {
            const video = document.getElementById('customVideo');
            const playPauseBtn = document.getElementById('playPauseBtn');
            const backwardBtn = document.getElementById('backwardBtn');
            const forwardBtn = document.getElementById('forwardBtn');
            const speedSelect = document.getElementById('speedSelect');
            const volumeSlider = document.getElementById('volumeSlider');
            const currentTimeDisplay = document.getElementById('currentTime');
            const durationDisplay = document.getElementById('duration');
            const videoUrlInput = document.getElementById('videoUrl');
            const loadVideoBtn = document.getElementById('loadVideoBtn');
            const selectFileBtn = document.getElementById('selectFileBtn');
            const videoFileInput = document.getElementById('videoFile');

            // Play/Pause toggle
            playPauseBtn.addEventListener('click', function() {
                try {
                    if (video.paused) {
                        video.play();
                        playPauseBtn.textContent = 'Pause';
                    } else {
                        video.pause();
                        playPauseBtn.textContent = 'Play';
                    }
                } catch (error) {
                    console.error('Error al reproducir/pausar:', error);
                    alert('Error al controlar la reproducción del video');
                }
            });

            // Skip backward 10 seconds
            backwardBtn.addEventListener('click', function() {
                try {
                    video.currentTime = Math.max(0, video.currentTime - 10);
                } catch (error) {
                    console.error('Error al retroceder:', error);
                    alert('Error al retroceder el video');
                }
            });

            // Skip forward 10 seconds
            forwardBtn.addEventListener('click', function() {
                try {
                    video.currentTime = Math.min(video.duration, video.currentTime + 10);
                } catch (error) {
                    console.error('Error al adelantar:', error);
                    alert('Error al adelantar el video');
                }
            });

            // Change playback speed
            speedSelect.addEventListener('change', function() {
                try {
                    video.playbackRate = parseFloat(this.value);
                } catch (error) {
                    console.error('Error al cambiar velocidad:', error);
                    alert('Error al cambiar la velocidad de reproducción');
                }
            });

            // Change volume
            volumeSlider.addEventListener('input', function() {
                try {
                    video.volume = this.value;
                } catch (error) {
                    console.error('Error al cambiar volumen:', error);
                    alert('Error al ajustar el volumen');
                }
            });

            // Update time display
            video.addEventListener('timeupdate', function() {
                try {
                    currentTimeDisplay.textContent = formatTime(video.currentTime);
                } catch (error) {
                    console.error('Error al actualizar tiempo:', error);
                }
            });

            // Update duration when metadata is loaded
            video.addEventListener('loadedmetadata', function() {
                try {
                    durationDisplay.textContent = formatTime(video.duration);
                } catch (error) {
                    console.error('Error al cargar metadatos:', error);
                    alert('Error al cargar información del video');
                }
            });

            // Load video from URL
            loadVideoBtn.addEventListener('click', function() {
                try {
                    const url = videoUrlInput.value.trim();
                    if (url) {
                        video.src = url;
                        video.load();
                        playPauseBtn.textContent = 'Play';
                    }
                } catch (error) {
                    console.error('Error al cargar video desde URL:', error);
                    alert('Error al cargar el video desde la URL proporcionada');
                }
            });

            // Select local file
            selectFileBtn.addEventListener('click', function() {
                try {
                    videoFileInput.click();
                } catch (error) {
                    console.error('Error al seleccionar archivo:', error);
                    alert('Error al seleccionar archivo local');
                }
            });

            // Handle local file selection
            videoFileInput.addEventListener('change', function() {
                try {
                    if (this.files && this.files[0]) {
                        const file = this.files[0];
                        const fileURL = URL.createObjectURL(file);
                        video.src = fileURL;
                        videoUrlInput.value = file.name;
                        video.load();
                        playPauseBtn.textContent = 'Play';
                    }
                } catch (error) {
                    console.error('Error al cargar archivo local:', error);
                    alert('Error al cargar el archivo de video local');
                }
            });

            // Format time (seconds to MM:SS)
            function formatTime(seconds) {
                try {
                    const minutes = Math.floor(seconds / 60);
                    const secs = Math.floor(seconds % 60);
                    return `${minutes.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
                } catch (error) {
                    console.error('Error al formatear tiempo:', error);
                    return '00:00';
                }
            }

            // Handle video errors
            video.addEventListener('error', function() {
                try {
                    console.error('Error de video:', video.error);
                    alert('Error al cargar el video. Por favor verifica la fuente.');
                } catch (error) {
                    console.error('Error al manejar error de video:', error);
                }
            });

        } catch (error) {
            console.error('Error inicializando controles de video:', error);
            alert('Error al inicializar los controles de video');
        }

        // 3. Canvas Dibujo (existente)
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