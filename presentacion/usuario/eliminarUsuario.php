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

// Verificar que solo los administradores puedan eliminar usuarios
if ($rol != "admin") {
    header("Location: index.php");
    exit();
}

// Asegurar que las clases estén incluidas
require_once("logica/Admin.php");
require_once("logica/Propietario.php");

// Variables para almacenar los usuarios
$administradores = [];
$propietarios = [];

// Obtener todos los usuarios activos
try {
    // Obtener administradores activos
    $adminObj = new Admin();
    $administradores = $adminObj->consultarTodos();
    
    // Obtener propietarios activos
    $propietarioObj = new Propietario();
    $propietarios = $propietarioObj->consultarTodos();
} catch (Exception $e) {
    $mensajeError = "Error al consultar usuarios: " . $e->getMessage();
}

// Procesar eliminación
if (isset($_POST['eliminarUsuario'])) {
    $tipoUsuario = trim($_POST['tipoUsuario'] ?? '');
    $idUsuario = trim($_POST['idUsuario'] ?? '');
    
    if (empty($tipoUsuario) || empty($idUsuario)) {
        $mensajeError = "Debe seleccionar un usuario para eliminar.";
    } else {
        // Verificar que no se esté eliminando a sí mismo
        if ($tipoUsuario == "admin" && $idUsuario == $_SESSION["id"]) {
            $mensajeError = "No puede eliminarse a sí mismo.";
        } else {
            try {
                $resultado = false;
                
                if ($tipoUsuario == "admin") {
                    $admin = new Admin($idUsuario);
                    $resultado = $admin->eliminar(); // Esto debería hacer soft delete
                } elseif ($tipoUsuario == "propietario") {
                    $propietario = new Propietario($idUsuario);
                    $resultado = $propietario->eliminar(); // Esto debería hacer soft delete
                }
                
                if ($resultado) {
                    $mensaje = "Usuario eliminado correctamente.";
                    // Recargar listas después de eliminar
                    $administradores = $adminObj->consultarTodos();
                    $propietarios = $propietarioObj->consultarTodos();
                } else {
                    $mensajeError = "Error al eliminar el usuario.";
                }
            } catch (Exception $e) {
                $mensajeError = "Error al eliminar el usuario: " . $e->getMessage();
            }
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
                <h4>Eliminar Usuario</h4>
                <small class="text-muted">Los usuarios eliminados se desactivan pero conservan su información</small>
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

                <form method="post" action="" id="formEliminar">
                    <div class="row">
                        <!-- Tipo de Usuario -->
                        <div class="col-md-6 mb-3">
                            <label for="tipoUsuario" class="form-label">Tipo de Usuario:</label>
                            <select name="tipoUsuario" id="tipoUsuario" class="form-control" required onchange="cargarUsuarios()">
                                <option value="">Seleccione un tipo</option>
                                <option value="admin">Administrador</option>
                                <option value="propietario">Propietario</option>
                            </select>
                        </div>

                        <!-- Usuario -->
                        <div class="col-md-6 mb-3">
                            <label for="idUsuario" class="form-label">Usuario:</label>
                            <select name="idUsuario" id="idUsuario" class="form-control" required disabled>
                                <option value="">Primero seleccione el tipo</option>
                            </select>
                        </div>
                    </div>

                    <!-- Información del usuario seleccionado -->
                    <div id="infoUsuario" class="alert alert-info" style="display: none;">
                        <h6>Información del usuario:</h6>
                        <div id="datosUsuario"></div>
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        <button type="submit" name="eliminarUsuario" class="btn btn-danger me-2" 
                                onclick="return confirmarEliminacion()">
                            <i class="fas fa-trash"></i> Eliminar Usuario
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="history.back()">
                            <i class="fas fa-arrow-left"></i> Atrás
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Datos de usuarios pasados desde PHP
        const administradores = <?php echo json_encode($administradores); ?>;
        const propietarios = <?php echo json_encode($propietarios); ?>;
        const idSesion = <?php echo $_SESSION["id"]; ?>;

        function cargarUsuarios() {
            const tipoUsuario = document.getElementById('tipoUsuario').value;
            const selectUsuario = document.getElementById('idUsuario');
            const infoUsuario = document.getElementById('infoUsuario');
            
            // Limpiar select
            selectUsuario.innerHTML = '<option value="">Seleccione un usuario</option>';
            infoUsuario.style.display = 'none';
            
            if (tipoUsuario === '') {
                selectUsuario.disabled = true;
                selectUsuario.innerHTML = '<option value="">Primero seleccione el tipo</option>';
                return;
            }
            
            selectUsuario.disabled = false;
            let usuarios = tipoUsuario === 'admin' ? administradores : propietarios;
            
            usuarios.forEach(usuario => {
                // No mostrar el usuario actual en la lista de administradores
                if (!(tipoUsuario === 'admin' && usuario.id == idSesion)) {
                    const option = document.createElement('option');
                    option.value = usuario.id;
                    option.textContent = `${usuario.nombre} ${usuario.apellido} (${usuario.correo})`;
                    option.dataset.usuario = JSON.stringify(usuario);
                    selectUsuario.appendChild(option);
                }
            });
        }

        function mostrarInfoUsuario() {
            const selectUsuario = document.getElementById('idUsuario');
            const infoUsuario = document.getElementById('infoUsuario');
            const datosUsuario = document.getElementById('datosUsuario');
            
            if (selectUsuario.value === '') {
                infoUsuario.style.display = 'none';
                return;
            }
            
            const selectedOption = selectUsuario.selectedOptions[0];
            const usuario = JSON.parse(selectedOption.dataset.usuario);
            
            datosUsuario.innerHTML = `
                <strong>Nombre:</strong> ${usuario.nombre} ${usuario.apellido}<br>
                <strong>Correo:</strong> ${usuario.correo}<br>
                <strong>Teléfono:</strong> ${usuario.telefono}
                ${usuario.fechaIngreso ? `<br><strong>Fecha Ingreso:</strong> ${usuario.fechaIngreso}` : ''}
            `;
            
            infoUsuario.style.display = 'block';
        }

        function confirmarEliminacion() {
            const selectUsuario = document.getElementById('idUsuario');
            if (selectUsuario.value === '') {
                alert('Debe seleccionar un usuario para eliminar.');
                return false;
            }
            
            const selectedOption = selectUsuario.selectedOptions[0];
            const nombreUsuario = selectedOption.textContent;
            
            return confirm(`¿Está seguro de que desea eliminar al usuario: ${nombreUsuario}?\n\nNota: El usuario será desactivado pero su información se conservará.`);
        }

        // Agregar evento para mostrar info del usuario
        document.getElementById('idUsuario').addEventListener('change', mostrarInfoUsuario);
    </script>
</body>

<?php include("presentacion/Extremos/Pie.php"); ?>