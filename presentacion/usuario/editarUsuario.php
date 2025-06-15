<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$rol = $_SESSION["rol"];
$id = $_SESSION["id"];


$datosUsuario = null;


if ($rol == "admin") {
    $admin = new Admin($id);
    $admin->consultar();
    $datosUsuario = $admin;
} elseif ($rol == "propietario") {
    $propietario = new Propietario($id);
    $propietario->consultar();
    $datosUsuario = $propietario;
}


if (isset($_POST['actualizarUsuario'])) {
    $nombre = trim($_POST['nombreUsuario'] ?? '');
    $apellido = trim($_POST['apellidoUsuario'] ?? '');
    $telefono = trim($_POST['telefonoUsuario'] ?? '');
    $clave = trim($_POST['claveUsuario'] ?? '');
    $correo = trim($_POST['correoUsuario'] ?? '');

    if ($rol == "admin") {
        $admin->setNombre($nombre);
        $admin->setApellido($apellido);
        $admin->setTelefono($telefono);
        $admin->setClave($clave);
        $admin->setCorreo($correo);
        $resultado = $admin->actualizar();

        if ($resultado) {
            $mensaje = "Datos actualizados correctamente.";
        } else {
            $mensajeError = "Error al actualizar los datos.";
        }
        $datosUsuario = $admin;
    } elseif ($rol == "propietario") {
        $propietario->setNombre($nombre);
        $propietario->setApellido($apellido);
        $propietario->setTelefono($telefono);
        $propietario->setClave($clave);
        $propietario->setCorreo($correo);
        $resultado = $propietario->actualizar();

        if ($resultado) {
            $mensaje = "Datos actualizados correctamente.";
        } else {
            $mensajeError = "Error al actualizar los datos.";
        }
        $datosUsuario = $propietario;
    }
}

include("presentacion/Extremos/Cabeza.php");
include("presentacion/menu" . ucfirst($_SESSION["rol"]) . ".php");
?>

<body>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h4>Información de Usuario</h4>
            </div>
            <div class="card-body">

              
                <?php if (isset($mensaje)) { ?>
                    <div class="alert alert-success text-center">
                        <?php echo $mensaje; ?>
                    </div>
                <?php } elseif (isset($mensajeError)) { ?>
                    <div class="alert alert-danger text-center">
                        <?php echo $mensajeError; ?>
                    </div>
                <?php } ?>

                <form method="post" action="">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nombreUsuario" class="form-label">Nombre:</label>
                            <input type="text" name="nombreUsuario" id="nombreUsuario" class="form-control"
                                value="<?php echo isset($datosUsuario) ? htmlspecialchars($datosUsuario->getNombre()) : ''; ?>" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="apellidoUsuario" class="form-label">Apellido:</label>
                            <input type="text" name="apellidoUsuario" id="apellidoUsuario" class="form-control"
                                value="<?php echo isset($datosUsuario) ? htmlspecialchars($datosUsuario->getApellido()) : ''; ?>" required>
                        </div>
                        <!-- Correo -->
                        <div class="col-md-6 mb-3">
                            <label for="correoUsuario" class="form-label">Correo:</label>
                            <input type="text" name="correoUsuario" id="correoUsuario" class="form-control"
                                value="<?php echo isset($datosUsuario) ? htmlspecialchars($datosUsuario->getApellido()) : ''; ?>" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="telefonoUsuario" class="form-label">Teléfono:</label>
                            <input type="text" name="telefonoUsuario" id="telefonoUsuario" class="form-control"
                                value="<?php echo isset($datosUsuario) ? htmlspecialchars($datosUsuario->getTelefono()) : ''; ?>" required>
                        </div>

                        <?php if ($rol == "propietario") { ?>
                            <div class="col-md-6 mb-3">
                                <label for="fechaIngreso" class="form-label">Fecha de Ingreso:</label>
                                <input type="text" name="fechaIngreso" id="fechaIngreso" class="form-control"
                                    value="<?php echo isset($datosUsuario) ? htmlspecialchars($datosUsuario->getFecha()) : ''; ?>" readonly>
                            </div>
                        <?php } ?>

                        <div class="col-md-6 mb-3">
                            <label for="claveUsuario" class="form-label">Clave:</label>
                            <input type="text" name="claveUsuario" id="claveUsuario" class="form-control"
                                value="<?php echo isset($datosUsuario) ? htmlspecialchars($datosUsuario->getClave()) : ''; ?>" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        <button type="submit" name="actualizarUsuario" class="btn btn-primary me-2">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
