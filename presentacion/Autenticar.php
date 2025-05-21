
<?php

if (isset($_GET["sesion"]) && $_GET["sesion"] == "false") {
    session_destroy();
    header("Location: index.php");
    exit();
}

$error = false;

if (isset($_POST["autenticar"])) {
    $nombre = $_POST["nombre"];
    $clave = $_POST["clave"];

    $admin = new Admin("", $nombre, "", $clave);
    if ($admin->autenticar()) {
        $_SESSION["id"] = $admin->getId();
        $_SESSION["rol"] = "admin";
        header("Location: index.php?pid=" . base64_encode("presentacion/sesionAdmin.php"));
        exit();
    }

    $propietario = new Propietario("", $nombre, "", $clave);
    if ($propietario->autenticar()) {
        $_SESSION["id"] = $propietario->getId();
        $_SESSION["rol"] = "propietario";
        header("Location: index.php?pid=" . base64_encode("presentacion/sesionPropietario.php"));
        exit();
    }

    $error = true;
}

if (isset($_GET["pid"])) {
    $ruta = base64_decode($_GET["pid"]);
    if (file_exists($ruta)) {
        include($ruta);
        exit();
    } else {
        echo "<div class='alert alert-danger'>Error: archivo no encontrado: $ruta</div>";
        exit();
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



                        <form method="post" action="?pid=<?php echo base64_encode('presentacion/Autenticar.php'); ?>">
                            <div class="mb-3">
                                <input type="text" class="form-control" name="nombre" placeholder="nombre" required>
                            </div>
                            <div class="mb-3">
                                <input type="password" class="form-control" name="clave" placeholder="clave" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" name="autenticar" class="btn btn-info">Entrar</button>
                            </div>
                        </form>

                        <?php if ($error): ?>
                            <div class="alert alert-danger text-center mt-3">Usuario o contraseña incorrectos</div>
                        <?php endif; ?>

                        <div class="card-header mt-4">
                            <h4>Admins</h4>
                        </div>
                        <div class="card-body">
                            <?php
                            $admin = new Admin();
                            $admins = $admin->consultar();
                            echo "<table class='table table-striped table-hover'>";
                            echo "<tr><td>Id</td><td>Nombre</td><td>Apellido</td></tr>";
                            foreach ($admins as $ad) {
                                echo "<tr>";
                                echo "<td>" . $ad->getId() . "</td>";
                                echo "<td>" . $ad->getNombre() . "</td>";
                                echo "<td>" . $ad->getApellido() . "</td>";
                                echo "</tr>";
                            }
                            echo "</table>";
                            ?>
                        </div>

                        <div class="card-header mt-4">
                            <h4>Propietarios</h4>
                        </div>
                        <div class="card-body">
                            <?php
                            $propietario = new Propietario();
                            $propietarios = $propietario->consultar();
                            echo "<table class='table table-striped table-hover'>";
                            echo "<tr><td>Id</td><td>Nombre</td><td>Apellido</td><td>Fecha</td></tr>";
                            foreach ($propietarios as $pro) {
                                echo "<tr>";
                                echo "<td>" . $pro->getId() . "</td>";
                                echo "<td>" . $pro->getNombre() . "</td>";
                                echo "<td>" . $pro->getApellido() . "</td>";
                                echo "<td>" . $pro->getFecha() . "</td>";
                                echo "</tr>";
                            }
                            echo "</table>";
                            ?>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</body>

</html>
