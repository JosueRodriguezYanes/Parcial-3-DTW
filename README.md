<div align="center">
  <h1>🚀 Parcial3-DTW135</h1>
</div>

<p align="center">
  <img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
</p>

## 📋 Tabla de Contenidos
- [Configuración Inicial](#-configuración-inicial)
- [Requisitos Previos](#-requisitos-previos)
- [Instalación](#-instalación)
- [APIS´s usadas](#-API´s-usadas)
- [Web Workers](#-Web-Workers)

## 🛠 Configuración Inicial

Para ejecutar este proyecto localmente, sigue estos pasos cuidadosamente.

### ⚡ Requisitos Previos

- PHP >= 8.0
- Composer
- MySQL
- Una base de datos MySQL creada para el proyecto

### 📥 Instalación

1. **Clonar el repositorio**
   ```bash
   git clone [url-del-repositorio]
   cd Parcial-3-DTW
   ```

2. **Configurar el archivo .env**
   - Localiza el archivo `.env` en la raíz del proyecto
   - Busca la siguiente línea:
     ```env
     DB_PASSWORD=
     ```
   - Reemplaza el valor con tu contraseña de MySQL:
     ```env
     DB_PASSWORD=tu_contraseña
     ```

   > ⚠️ **Importante**: Asegúrate de que la base de datos esté creada y coincida con las especificaciones del proyecto.

3. **Instalar dependencias**
   ```bash
   composer install
   ```

4. **Generar clave de aplicación**
   ```bash
   php artisan key:generate
   ```

5. **Ejecutar migraciones**
   ```bash
   php artisan migrate
   ```

## 🔴 API´s usadas

### API de Geolocalización

Con la implementación de esta API, el usuario podra ver la altitud y latitud en un mapa interactivo, capaz de acercar y alejar.

### API de Video

Con la implementación de esta API, el usuario puede visualizar videos, ya sea cargados por medio de una URL o por medio de la carga de un archivo de video local, de igual manera, el usuario puede reproducir/pausae el video, puede adelantar el video 10 segundos y retroceder el video 10 segundos, además se puede modificar la velocidad en que se reproduce el video, al igual que su volumen.

### API Canva

Con la implementación de esta API, el usuario posee un lienzo en blanco en el cual puede dibujar, en este caso puede dibujar lineas negras simples, el usuario puede descarga la imagen creada en el lienzo y de igual manera se puede borrar el dibujo en el lienzo

## 🛠 Web Workers

### Calcular los números primos hasta X número límite

En este apartado el usuario debe ingresar un número limite, posteriormente la aplicación mostrara los númmeros pares hasta ese límite que el usuario escribio.

## 👥 Integrantes

| Nombre | Carnet |
|--------|---------|
| Alejandra Michelle Mejía Rivas | MR22035 |
| Josué Daniel Rodriguez Yanes | RY22001 |
| Ivan Eduardo Lopez Tobar | LT22009 |
| Christopher Alexis Velasquez Aguilar | VA22020 |
| Kelvin Antonio Velásquez Vásquez | VV22015 |
