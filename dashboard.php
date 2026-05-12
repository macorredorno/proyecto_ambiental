<?php
include("conexion.php");

// CONSULTAS
$total = $conexion->query("SELECT COUNT(*) as total FROM reportes")->fetch_assoc()['total'];
$basura = $conexion->query("SELECT COUNT(*) as total FROM reportes WHERE tipo='Basura'")->fetch_assoc()['total'];
$contaminacion = $conexion->query("SELECT COUNT(*) as total FROM reportes WHERE tipo='Contaminación'")->fetch_assoc()['total'];
$quema = $conexion->query("SELECT COUNT(*) as total FROM reportes WHERE tipo='Quema'")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Ambiental</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
    body {
        background: linear-gradient(135deg, #74ebd5, #ACB6E5);
        min-height: 100vh;
    }

    .card {
        border-radius: 15px;
    }

    h2 {
        font-weight: bold;
    }
    </style>
</head>

<body>

<div class="container mt-5">

    <h2 class="text-center mb-4">📊 Dashboard Ambiental</h2>

    <div class="row text-center">

        <!-- TOTAL -->
        <div class="col-md-3">
            <div class="card p-3 shadow bg-light">
                <h5>Total Reportes</h5>
                <h2><?php echo $total; ?></h2>
            </div>
        </div>

        <!-- BASURA -->
        <div class="col-md-3">
            <div class="card p-3 shadow bg-success text-white">
                <h5>Basura</h5>
                <h2><?php echo $basura; ?></h2>
            </div>
        </div>

        <!-- CONTAMINACIÓN -->
        <div class="col-md-3">
            <div class="card p-3 shadow bg-warning">
                <h5>Contaminación</h5>
                <h2><?php echo $contaminacion; ?></h2>
            </div>
        </div>

        <!-- QUEMA -->
        <div class="col-md-3">
            <div class="card p-3 shadow bg-danger text-white">
                <h5>Quemas</h5>
                <h2><?php echo $quema; ?></h2>
            </div>
        </div>

    </div>

    <!-- BOTONES -->
    <div class="text-center mt-4">
        <a href="ver.php" class="btn btn-primary">Ver Reportes</a>
        <a href="index.php" class="btn btn-success">Nuevo Reporte</a>
    </div>

</div>

</body>
</html>