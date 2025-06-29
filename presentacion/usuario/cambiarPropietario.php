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

// Verificar que solo los administradores puedan cambiar propietarios
if ($rol != "admin") {
    header("Location: index.php");
    exit();
}

// Incluir las clases necesarias
require_once("logica/Apartamento.php");
require_once("logica/Propietario.php");

// Verificar que se recibió el ID del propietario a eliminar
if (!isset($_GET['idPropietario']) || empty($_GET['idPropietario'])) {
    header("Location: consultarPropietarios.php");
    exit();
}

$idPropietarioEliminar = $_GET['idPropietario'];

// Obtener información del propietario a eliminar
$propietarioEliminar = new Propietario($idPropietarioEliminar);
$propietarioEliminar->consultar();

// Obtener apartamentos del propietario a eliminar
$apartamento = new Apartamento();
$apartamentosAfectados = $apartamento->consultarConPropietario($idPropietarioEliminar);

// Obtener todos los propietarios activos (excepto el que se va a eliminar)
$propietario = new Propietario();
$propietariosDisponibles = $propietario->consultarActivos($idPropietarioEliminar);

// Procesar el formulario
if (isset($_POST['procesarCambio'])) {
    $cambiosRealizados = true;
    $errores = [];
    
    try {
        foreach ($apartamentosAfectados as $apt) {
            $idApartamento = $apt['idApartamento'];
            $accion = $_POST['accion_' . $idApartamento] ?? '';
            
            if ($accion == 'asignar_existente') {
                $nuevoPropietarioId = $_POST['propietario_' . $idApartamento] ?? '';
                if (!empty($nuevoPropietarioId)) {
                    $apartamentoObj = new Apartamento($idApartamento);
                    $apartamentoObj->cambiarPropietario($nuevoPropietarioId);
                }
            } elseif ($accion == 'crear_nuevo') {
                // Crear nuevo propietario
                $nombre = trim($_POST['nombre_' . $idApartamento] ?? '');
                $apellido = trim($_POST['apellido_' . $idApartamento] ?? '');
                $telefono = trim($_POST['telefono_' . $idApartamento] ?? '');
                $correo = trim($_POST['correo_' . $idApartamento] ?? '');
                $clave = trim($_POST['clave_' . $idApartamento] ?? '');
                
                if (!empty($nombre) && !empty($apellido) && !empty($telefono) && !empty($correo) && !empty($clave)) {
                    $nuevoPropietario = new Propietario();
                    $nuevoPropietario->setNombre($nombre);
                    $nuevoPropietario->setApellido($apellido);
                    $nuevoPropietario->setTelefono($telefono);
                    $nuevoPropietario->setCorreo($correo);
                    $nuevoPropietario->setClave($clave);
                    $nuevoPropietario->setFechaIngreso(date('Y-m-d'));
                    
                    $nuevoPropietarioId = $nuevoPropietario->insertar();
                    
                    if ($nuevoPropietarioId) {
                        $apartamentoObj = new Apartamento($idApartamento);
                        $apartamentoObj->cambiarPropietario($nuevoPropietarioId);
                    } else {
                        $errores[] = "Error al crear propietario para apartamento " . $apt['nombre'];
                        $cambiosRealizados = false;
                    }
                } else {
                    $errores[] = "Datos incompletos para el nuevo propietario del apartamento " . $apt['nombre'];
                    $cambiosRealizados = false;
                }
            } elseif ($accion == 'sin_propietario') {
                // Dejar sin propietario
                $apartamentoObj = new Apartamento($idApartamento);
                $apartamentoObj->cambiarPropietario(null);
            }
        }
        
        if ($cambiosRealizados && empty($errores)) {
            // Eliminar el propietario original
            $propietarioEliminar->eliminar();
            $mensaje = "Propietario eliminado y cambios realizados correctamente.";
            
            // Redireccionar después de 3 segundos
            echo "<script>
                setTimeout(function() {
                    window.location.href = 'consultarPropietarios.php';
                }, 3000);
            </script>";
        } else {
            $mensajeError = "Algunos cambios no se pudieron realizar: " . implode(", ", $errores);
        }
        
    } catch (Exception $e) {
        $mensajeError = "Error al procesar los cambios: " . $e->getMessage();
    }
}

include("presentacion/Extremos/Cabeza.php");
include("presentacion/menu" . ucfirst($_SESSION["rol"]) . ".php");
?>

<body>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-warning">
                <h4>Cambio de Propietario</h4>
                <p class="mb-0">Propietario a eliminar: <strong><?php echo htmlspecialchars($propietarioEliminar->getNombre() . " " . $propietarioEliminar->getApellido()); ?></strong></p>
            </div>
            <div class="card-body">

                <?php if (isset($mensaje)) { ?>
                    <div class="alert alert-success text-center">
                        <?php echo $mensaje; ?>
                        <br><small>Redirigiendo en 3 segundos...</small>
                    </div>
                <?php } elseif (isset($mensajeError)) { ?>
                    <div class="alert alert-danger text-center">
                        <?php echo $mensajeError; ?>
                    </div>
                <?php } ?>

                <?php if (empty($apartamentosAfectados)) { ?>
                    <div class="alert alert-info text-center">
                        <p>Este propietario no tiene apartamentos asignados.</p>
                        <a href="eliminarPropietario.php?idPropietario=<?php echo $idPropietarioEliminar; ?>&confirmar=true" class="btn btn-danger">Eliminar Propietario</a>
                        <a href="consultarPropietarios.php" class="btn btn-secondary">Cancelar</a>
                    </div>
                <?php } else { ?>
                    <div class="alert alert-warning">
                        <strong>Atención:</strong> Este propietario tiene <?php echo count($apartamentosAfectados); ?> apartamento(s) asignado(s). 
                        Debe decidir qué hacer con cada uno antes de eliminarlo.
                    </div>

                    <form method="post" action="">
                        <?php foreach ($apartamentosAfectados as $apt) { ?>
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h5>Apartamento: <?php echo htmlspecialchars($apt['nombre']); ?> 
                                        <small class="text-muted">(<?php echo $apt['metrosCuadrados']; ?> m²)</small>
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Seleccione una opción:</label>
                                            <select name="accion_<?php echo $apt['idApartamento']; ?>" class="form-control accion-select" data-apartamento="<?php echo $apt['idApartamento']; ?>" required>
                                                <option value="">Seleccione una acción</option>
                                                <option value="asignar_existente">Asignar a propietario existente</option>
                                                <option value="crear_nuevo">Crear nuevo propietario</option>
                                                <option value="sin_propietario">Dejar sin propietario</option>
                                            </select>
                                        </div>
                                        <div class="col-md-8">
                                            <!-- Sección para asignar a propietario existente -->
                                            <div id="existente_<?php echo $apt['idApartamento']; ?>" class="opcion-detalle" style="display: none;">
                                                <label>Seleccionar propietario:</label>
                                                <select name="propietario_<?php echo $apt['idApartamento']; ?>" class="form-control">
                                                    <option value="">Seleccione un propietario</option>
                                                    <?php foreach ($propietariosDisponibles as $prop) { ?>
                                                        <option value="<?php echo $prop['idPropietario']; ?>">
                                                            <?php echo htmlspecialchars($prop['nombre'] . " " . $prop['apellido'] . " - " . $prop['telefono']); ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <!-- Sección para crear nuevo propietario -->
                                            <div id="nuevo_<?php echo $apt['idApartamento']; ?>" class="opcion-detalle" style="display: none;">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>Nombre:</label>
                                                        <input type="text" name="nombre_<?php echo $apt['idApartamento']; ?>" class="form-control">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Apellido:</label>
                                                        <input type="text" name="apellido_<?php echo $apt['idApartamento']; ?>" class="form-control">
                                                    </div>
                                                    <div class="col-md-6 mt-2">
                                                        <label>Teléfono:</label>
                                                        <input type="text" name="telefono_<?php echo $apt['idApartamento']; ?>" class="form-control">
                                                    </div>
                                                    <div class="col-md-6 mt-2">
                                                        <label>Correo:</label>
                                                        <input type="email" name="correo_<?php echo $apt['idApartamento']; ?>" class="form-control">
                                                    </div>
                                                    <div class="col-md-6 mt-2">
                                                        <label>Clave:</label>
                                                        <input type="password" name="clave_<?php echo $apt['idApartamento']; ?>" class="form-control">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Sección para sin propietario -->
                                            <div id="sin_<?php echo $apt['idApartamento']; ?>" class="opcion-detalle" style="display: none;">
                                                <div class="alert alert-info">
                                                    <small>El apartamento quedará disponible sin propietario asignado.</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="d-flex justify-content-center mt-4">
                            <button type="submit" name="procesarCambio" class="btn btn-warning me-2">
                                <i class="fas fa-exchange-alt"></i> Procesar Cambios y Eliminar Propietario
                            </button>
                            <a href="consultarPropietarios.php" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                        </div>
                    </form>
                <?php } ?>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Manejar cambios en los selects de acción
            document.querySelectorAll('.accion-select').forEach(function(select) {
                select.addEventListener('change', function() {
                    const apartamento = this.dataset.apartamento;
                    const valor = this.value;
                    
                    // Ocultar todas las opciones de detalle para este apartamento
                    document.querySelectorAll(`[id^="existente_${apartamento}"], [id^="nuevo_${apartamento}"], [id^="sin_${apartamento}"]`).forEach(function(div) {
                        div.style.display = 'none';
                    });
                    
                    // Mostrar la opción seleccionada
                    if (valor === 'asignar_existente') {
                        document.getElementById(`existente_${apartamento}`).style.display = 'block';
                    } else if (valor === 'crear_nuevo') {
                        document.getElementById(`nuevo_${apartamento}`).style.display = 'block';
                    } else if (valor === 'sin_propietario') {
                        document.getElementById(`sin_${apartamento}`).style.display = 'block';
                    }
                });
            });
        });
    </script>
</body>

<?php include("presentacion/Extremos/Pie.php"); ?>