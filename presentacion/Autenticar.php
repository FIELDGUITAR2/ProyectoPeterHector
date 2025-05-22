<?php


if (isset($_GET["sesion"])){
    if ($_GET["sesion"] == "false") {
        session_destroy();
    }
}
$error = false;
if (isset($_POST["autenticar"])) {
    $nombre = $_POST["nombre"];
    $clave = $_POST["clave"];

    $admin = new Admin("", $nombre, "", $clave);
    if ($admin->autenticar()) {
        $_SESSION["id"] = $admin->getId();
        $_SESSION["rol"] = "admin";
        header("Location: ?pid=" . base64_encode("presentacion/sesionAdmin.php"));
    } else {
        $propietario = new Propietario("", $nombre, "", $clave);
        if ($propietario->autenticar()) {
            $_SESSION["id"] = $propietario->getId();
            $_SESSION["rol"] = "propietario";
            header("Location: ?pid=" . base64_encode("presentacion/sesionPropietario.php"));
            $error = true;
        } 
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>ViveLaVidaLoca</title>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body style="background-image: url('img/fondo.png'); background-size: cover; background-position: center;">
    <div class="container min-vh-100 d-flex justify-content-center align-items-center">
        <div class="row w-100 justify-content-center">
            <div class="col-12 col-md-4 col-lg-4 mb-4 mb-md-0 mt-4 mt-md-0">
                <div class="card bg-light bg-opacity-50 shadow h-100 text-center p-4">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                        <img src="img/logoConjuntos.png" alt="Logo Conjuntos" class="img-fluid mb-3 rounded-circle">
                        <h4 class="card-title">Conjunto Vive La Vida Loca</h4>
                        <p class="card-text">Bienvenido al sistema de acceso seguro de pagos de cuentas.</p>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-6">
                <div class="card bg-light bg-opacity-50 shadow p-4 h-100">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <h3 class="mb-4 text-center">Iniciar Sesión</h3>
                            <form action="?pid=<?php echo base64_encode("presentacion/Autenticar.php") ?>" method="post">
                                <div class="mb-3">
                                    <input type="text" class="form-control" name="nombre" placeholder="nombre" required>
                                </div>
                                <div class="mb-3">
                                    <input type="password" class="form-control" name="clave" placeholder="Clave" required>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" name="autenticar" class="btn btn-info">Entrar</button>
                                </div>
                            </form>
                            <?php
                            if ($error) {
                                echo "<div class='alert alert-danger mt-3' role='alert'>Credenciales incorrectas</div>";
                            }
                            ?>
                        </div>
                    
                </div>
            </div>

        </div>
    </div>
</body>

</html>