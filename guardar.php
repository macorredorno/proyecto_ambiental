<?php
include("conexion.php");

$descripcion = $_POST['descripcion'] ?? '';
$ubicacion = $_POST['ubicacion'] ?? '';
$tipo = $_POST['tipo'] ?? '';

if (empty($descripcion) || empty($ubicacion) || empty($tipo)) {
    echo "<h3>Todos los campos son obligatorios</h3>";
    exit();
}

/* ===== MANEJO DE IMAGEN ===== */
$imagen_nombre = null;

if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {

    $carpeta = "imagenes/";

    if (!file_exists($carpeta)) {
        mkdir($carpeta, 0777, true);
    }

    $nombre_archivo = time() . "_" . $_FILES['imagen']['name'];
    $ruta = $carpeta . $nombre_archivo;

    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta)) {
        $imagen_nombre = $nombre_archivo;
    }
}

/* ===== INSERT CON IMAGEN ===== */
$sql = "INSERT INTO reportes (descripcion, ubicacion, tipo, imagen) 
        VALUES ('$descripcion', '$ubicacion', '$tipo', '$imagen_nombre')";

$exito = $conexion->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Resultado</title>
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
    </style>
</head>

<body>

<div class="container mt-5">

    <?php if($exito){ ?>

        <div class="card shadow-lg p-4 text-center bg-light">
            <h2 class="text-success">✔ Reporte guardado correctamente</h2>
            <p class="text-muted">La información fue registrada en el sistema.</p>

            <div class="mt-4">
                <a href="index.php" class="btn btn-primary">Nuevo Reporte</a>
                <a href="ver.php" class="btn btn-success">Ver Reportes</a>
            </div>
        </div>

    <?php } else { ?>

        <div class="card shadow-lg p-4 text-center bg-light">
            <h2 class="text-danger">❌ Error al guardar</h2>
            <p class="text-muted">Intenta nuevamente.</p>

            <div class="mt-3">
                <a href="index.php" class="btn btn-secondary">Volver</a>
            </div>
        </div>

    <?php } ?>

</div>

</body>
</html>