<?php
include("conexion.php");

$sql = "SELECT * FROM reportes ORDER BY id DESC";
$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reportes Registrados</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <style>
    body {
        background: linear-gradient(135deg, #74ebd5, #ACB6E5);
        min-height: 100vh;
    }

    .card {
        border-radius: 15px;
    }

    .container {
        max-width: 1100px;
    }

    h2 {
        font-weight: bold;
    }

    img {
        max-height: 80px;
        cursor: pointer;
    }
    </style>
</head>

<body>

<div class="container mt-5">

    <h2 class="text-center mb-4">📊 Reportes Ambientales Registrados</h2>

    <div class="text-end mb-3">
        <a href="dashboard.php" class="btn btn-success">📊 Dashboard</a>
        <a href="index.php" class="btn btn-primary">+ Nuevo Reporte</a>
    </div>

    <div class="card shadow-lg border-0 bg-light">
        <div class="card-body">

            <table class="table table-hover table-bordered align-middle text-center">

                <thead class="table-dark">
                    <tr>
                        
                        <th>Fecha</th>
                        <th>Descripción</th>
                        <th>Ubicación</th>
                        <th>Mapa</th>
                        <th>Tipo</th>
                        <th>Imagen</th>
                    </tr>
                </thead>

                <tbody>

                <?php while($fila = $resultado->fetch_assoc()) { ?>

                    <tr>
                        
                        <td><?php echo $fila['fecha']; ?></td>
                        <td><?php echo $fila['descripcion']; ?></td>
                        <td><?php echo $fila['ubicacion']; ?></td>

                        <!-- BOTÓN MAPA -->
                        <td>
                            <button class="btn btn-sm btn-info"
                                onclick="mostrarMapa('<?php echo $fila['ubicacion']; ?>')">
                                Ver mapa
                            </button>
                        </td>

                        <!-- TIPO -->
                        <td>
                            <?php 
                                if($fila['tipo'] == "Basura"){
                                    echo "<span class='badge bg-success'>Basura</span>";
                                } elseif($fila['tipo'] == "Contaminación"){
                                    echo "<span class='badge bg-warning text-dark'>Contaminación</span>";
                                } else {
                                    echo "<span class='badge bg-danger'>Quema</span>";
                                }
                            ?>
                        </td>

                        <!-- IMAGEN -->
                        <td>
                         <?php 
                            if (!empty($fila['imagen'])) {
                                echo "<img src='imagenes/".$fila['imagen']."' onclick='verImagen(this.src)' class='img-thumbnail rounded shadow'>";
                            } else {
                                echo "<span class='badge bg-secondary'>Sin imagen</span>";
                            }
                            ?>
                        </td>

                    </tr>

                <?php } ?>

                </tbody>
            </table>

        </div>
    </div>

</div>

<!-- MODAL MAPA -->
<div class="modal fade" id="mapModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-body">
        <div id="map" style="height:400px;"></div>
      </div>
    </div>
  </div>
</div>

<!-- SCRIPTS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
let map;

// MOSTRAR MAPA
function mostrarMapa(lugar) {

    let modal = new bootstrap.Modal(document.getElementById('mapModal'));
    modal.show();

    setTimeout(() => {

        if(map){
            map.remove();
        }

        map = L.map('map').setView([4.7110, -74.0721], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${lugar}`)
        .then(res => res.json())
        .then(data => {
            if(data.length > 0){
                let lat = data[0].lat;
                let lon = data[0].lon;

                map.setView([lat, lon], 15);

                L.marker([lat, lon]).addTo(map)
                 .bindPopup(lugar)
                 .openPopup();
            }
        });

    }, 500);
}

</script>

</body>
</html>