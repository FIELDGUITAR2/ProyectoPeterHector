<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verificar que la sesión esté iniciada
if (!isset($_SESSION["rol"]) || !isset($_SESSION["id"])) {
    header("Location: index.php");
    exit();
}

$rol = $_SESSION["rol"];
$id = $_SESSION["id"];

// Verificar que solo los administradores puedan agregar usuarios
if ($rol != "admin") {
    header("Location: index.php");
    exit();
}

// Asegurar que las clases estén incluidas
require_once("logica/Admin.php");
require_once("logica/Propietario.php");

if (isset($_POST['agregarUsuario'])) {
    $nombre = trim($_POST['nombreUsuario'] ?? '');
    $apellido = trim($_POST['apellidoUsuario'] ?? '');
    $telefono = trim($_POST['telefonoUsuario'] ?? '');
    $clave = trim($_POST['claveUsuario'] ?? '');
    $correo = trim($_POST['correoUsuario'] ?? '');
    $tipoUsuario = trim($_POST['tipoUsuario'] ?? '');

    // Validar que todos los campos estén llenos
    if (empty($nombre) || empty($apellido) || empty($telefono) || empty($clave) || empty($correo) || empty($tipoUsuario)) {
        $mensajeError = "Todos los campos son obligatorios.";
    } else {
        $resultado = false;
        
        try {
            if ($tipoUsuario == "admin") {
                $nuevoAdmin = new Admin();
                $nuevoAdmin->setNombre($nombre);
                $nuevoAdmin->setApellido($apellido);
                $nuevoAdmin->setTelefono($telefono);
                $nuevoAdmin->setClave($clave);
                $nuevoAdmin->setCorreo($correo);
                $resultado = $nuevoAdmin->insertar();
            } elseif ($tipoUsuario == "propietario") {
                $nuevoPropietario = new Propietario();
                $nuevoPropietario->setNombre($nombre);
                $nuevoPropietario->setApellido($apellido);
                $nuevoPropietario->setTelefono($telefono);
                $nuevoPropietario->setClave($clave);
                $nuevoPropietario->setCorreo($correo);
                // La fecha de ingreso se establecerá automáticamente en la base de datos
                $resultado = $nuevoPropietario->insertar();
            }

            if ($resultado) {
                $mensaje = "Usuario agregado correctamente.";
                // Limpiar campos después de agregar exitosamente
                $nombre = $apellido = $telefono = $clave = $correo = $tipoUsuario = '';
            } else {
                $mensajeError = "Error al agregar el usuario. Verifique que el correo no esté ya registrado.";
            }
        } catch (Exception $e) {
            $mensajeError = "Error al agregar el usuario: " . $e->getMessage();
        }
    }
}

include("presentacion/Extremos/Cabeza.php");
include("presentacion/menu" . ucfirst($_SESSION["rol"]) . ".php");
?>

<body>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h4>Agregar Nuevo Usuario</h4>
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
                        <!-- Tipo de Usuario -->
                        <div class="col-md-6 mb-3">
                            <label for="tipoUsuario" class="form-label">Tipo de Usuario:</label>
                            <select name="tipoUsuario" id="tipoUsuario" class="form-control" required>
                                <option value="">Seleccione un tipo</option>
                                <option value="admin" <?php echo (isset($tipoUsuario) && $tipoUsuario == 'admin') ? 'selected' : ''; ?>>Administrador</option>
                                <option value="propietario" <?php echo (isset($tipoUsuario) && $tipoUsuario == 'propietario') ? 'selected' : ''; ?>>Propietario</option>
                            </select>
                        </div>

                        <!-- Nombre -->
                        <div class="col-md-6 mb-3">
                            <label for="nombreUsuario" class="form-label">Nombre:</label>
                            <input type="text" name="nombreUsuario" id="nombreUsuario" class="form-control"
                                value="<?php echo isset($nombre) ? htmlspecialchars($nombre) : ''; ?>" required>
                        </div>

                        <!-- Apellido -->
                        <div class="col-md-6 mb-3">
                            <label for="apellidoUsuario" class="form-label">Apellido:</label>
                            <input type="text" name="apellidoUsuario" id="apellidoUsuario" class="form-control"
                                value="<?php echo isset($apellido) ? htmlspecialchars($apellido) : ''; ?>" required>
                        </div>

                        <!-- Correo -->
                        <div class="col-md-6 mb-3">
                            <label for="correoUsuario" class="form-label">Correo:</label>
                            <input type="email" name="correoUsuario" id="correoUsuario" class="form-control"
                                value="<?php echo isset($correo) ? htmlspecialchars($correo) : ''; ?>" required>
                        </div>

                        <!-- Teléfono -->
                        <div class="col-md-6 mb-3">
                            <label for="telefonoUsuario" class="form-label">Teléfono:</label>
                            <input type="text" name="telefonoUsuario" id="telefonoUsuario" class="form-control"
                                value="<?php echo isset($telefono) ? htmlspecialchars($telefono) : ''; ?>" required>
                        </div>

                        <!-- Clave -->
                        <div class="col-md-6 mb-3">
                            <label for="claveUsuario" class="form-label">Clave:</label>
                            <input type="password" name="claveUsuario" id="claveUsuario" class="form-control"
                                value="<?php echo isset($clave) ? htmlspecialchars($clave) : ''; ?>" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        <button type="submit" name="agregarUsuario" class="btn btn-success me-2">Agregar Usuario</button>
                        <button type="button" class="btn btn-secondary" onclick="history.back()">Atrás</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

<?php include("presentacion/Extremos/Pie.php"); ?>