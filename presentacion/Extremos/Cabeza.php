<!doctype html>
<html lang="en">

<head>
    <title>Vive la vida loca</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>
    <nav class="nav justify-content-center mt-5 mb-3">
        <a class="nav-link active" href="?pid=<?php echo base64_encode("presentacion/inicio.php") ?>" aria-current="page">Inicio</a>
        <a class="nav-link" href="?pid=<?php echo base64_encode("presentacion/InicioPropietarios.php") ?>">Apartamentos Disponibles</a>
        <a class="nav-link" href="?pid=<?php echo base64_encode("presentacion/Autenticar.php") ?>">Iniciar sesion</a>
    </nav>