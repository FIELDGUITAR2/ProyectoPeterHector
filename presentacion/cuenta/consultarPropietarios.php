<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["rol"]) || $_SESSION["rol"] != "admin") {
    header("Location: index.php");
    exit();
}

require_once("logica/Propietario.php");

$propietarioObj = new Propietario();
$propietarios = $propietarioObj->consultarTodos();

include("presentacion/Extremos/Cabeza.php");
include("presentacion/menuAdmin.php");
?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4>Listado de Propietarios</h4>
        </div>
        <div class="card-body">
            <?php if (empty($propietarios)) { ?>
                <div class="alert alert-info text-center">
                    No hay propietarios registrados.
                </div>
            <?php } else { ?>
                <table class="table table-bordered table-hover text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Teléfono</th>
                            <th>Estado</th>
                            <th>Fecha de Ingreso</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($propietarios as $prop) {
                            $id = $prop["id"];
                            $nombre = $prop["nombre"] ?? "—";
                            $apellido = $prop["apellido"] ?? "";
                            $correo = $prop["correo"] ?? "—";
                            $telefono = $prop["telefono"] ?? "—";
                            $estado = $prop["estado"] ?? 0;
                            $fechaIngreso = $prop["fechaIngreso"] ?? "—";
                        ?>
                            <tr>
                                <td><?php echo htmlspecialchars($nombre . " " . $apellido); ?></td>
                                <td><?php echo htmlspecialchars($correo); ?></td>
                                <td><?php echo htmlspecialchars($telefono); ?></td>
                                <td>
                                    <?php echo $estado == 1
                                        ? '<span class="badge bg-success">Activo</span>'
                                        : '<span class="badge bg-secondary">Inactivo</span>'; ?>
                                </td>
                                <td><?php echo htmlspecialchars($fechaIngreso); ?></td>
                                <td class="d-flex gap-2 justify-content-center flex-wrap">
                                    <a href="index.php?pid=<?php echo base64_encode("presentacion/usuario/editarUsuario.php"); ?>&id=<?php echo $id; ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    <a href="index.php?pid=<?php echo base64_encode("presentacion/usuario/eliminarUsuario.php"); ?>&idUsuario=<?php echo $id; ?>&tipoUsuario=propietario" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </a>
                                    <a href="index.php?pid=<?php echo base64_encode("presentacion/usuario/cambiarPropietario.php"); ?>&idPropietario=<?php echo $id; ?>" class="btn btn-sm btn-outline-warning">
                                        <i class="fas fa-sync-alt"></i> Cambiar
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } ?>
        </div>
    </div>
</div>

<?php include("presentacion/Extremos/Pie.php"); ?>