<!DOCTYPE html>
<html>
<head>
    <title>Reportes Ambientales</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
    body {
        background: linear-gradient(135deg, #74ebd5, #ACB6E5);
        min-height: 100vh;
    }

    .card {
        border-radius: 15px;
    }

    .container {
        max-width: 900px;
    }

    h2 {
        font-weight: bold;
    }

    #preview {
        max-height: 150px;
        margin-top: 10px;
        display: none;
    }

    #drop-zone {
        cursor: pointer;
        transition: 0.3s;
    }

    #drop-zone:hover {
        background-color: #f8f9fa;
    }

    #drop-zone.dragover {
        background-color: #d1ecf1;
        border-color: #0dcaf0;
    }
    </style>
</head>

<body>

<div class="container mt-5">
    <h2 class="text-center">Sistema de Reportes Ambientales</h2>
    <p class="text-center text-muted">Registra y consulta problemáticas ambientales</p>

    <form action="guardar.php" method="POST" enctype="multipart/form-data" class="card p-4 mt-4 shadow-lg border-0 bg-light">

        <!-- DESCRIPCIÓN -->
        <div class="mb-3">
            <label class="form-label">Descripción:</label>
            <textarea name="descripcion" class="form-control" rows="3" placeholder="Describe el problema ambiental" required></textarea>
        </div>

        <!-- UBICACIÓN -->
        <div class="mb-3">
            <label class="form-label">Ubicación:</label>
            <input type="text" name="ubicacion" class="form-control" placeholder="Ej: Barrio Centro, Bogotá" required>
        </div>
        <button type="button" class="btn btn-info mt-2" onclick="obtenerUbicacion()">
            📍 Usar mi ubicación actual
        </button>

        <!-- TIPO -->
        <div class="mb-3">
            <label class="form-label">Tipo de problema:</label>
            <select name="tipo" class="form-control" required>
                <option value="">Seleccione una opción</option>
                <option>Basura</option>
                <option>Contaminación</option>
                <option>Quema</option>
            </select>
        </div>

        <!-- Arrastrar o dar clic IMAGEN -->
        <div class="mb-3">
            <label class="form-label">Adjuntar imagen (opcional):</label>

            <div id="drop-zone" class="border border-2 border-dashed p-4 text-center rounded bg-white">
                <p class="text-muted">Arrastra una imagen aquí o haz clic</p>
                <input type="file" name="imagen" id="imagen" class="d-none" accept="image/*">
                <img id="preview" class="img-thumbnail rounded shadow">
            </div>
        </div>

        <!-- BOTÓN -->
        <button class="btn btn-success w-100">Guardar Reporte</button>

    </form>

    <!-- BOTONES -->
    <div class="text-center mt-3">
        <a href="ver.php" class="btn btn-primary">Ver Reportes</a>
        <a href="dashboard.php" class="btn btn-dark">Dashboard</a>
    </div>
</div>

<!-- SCRIPT DRAG & DROP + PREVIEW -->
<script>
const dropZone = document.getElementById("drop-zone");
const input = document.getElementById("imagen");
const preview = document.getElementById("preview");

dropZone.addEventListener("click", () => input.click());

input.addEventListener("change", function() {
    mostrarPreview(this.files[0]);
});

dropZone.addEventListener("dragover", (e) => {
    e.preventDefault();
    dropZone.classList.add("dragover");
});

dropZone.addEventListener("dragleave", () => {
    dropZone.classList.remove("dragover");
});

dropZone.addEventListener("drop", (e) => {
    e.preventDefault();
    dropZone.classList.remove("dragover");

    const file = e.dataTransfer.files[0];
    input.files = e.dataTransfer.files;
    mostrarPreview(file);
});

function mostrarPreview(file){
    if(file){
        preview.src = URL.createObjectURL(file);
        preview.style.display = "block";
    }
}
</script>
<script>
function obtenerUbicacion() {
    if (navigator.geolocation) {

        navigator.geolocation.getCurrentPosition(
            function(position) {

                let lat = position.coords.latitude;
                let lon = position.coords.longitude;

                // Mostrar coordenadas en el campo
                document.querySelector("[name='ubicacion']").value = lat + ", " + lon;

            },
            function(error) {
                alert("No se pudo obtener la ubicación");
            }
        );

    } else {
        alert("Tu navegador no soporta geolocalización");
    }
}
</script>
</body>
</html>