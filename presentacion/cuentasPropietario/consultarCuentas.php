<?php
require_once("logica/Cuenta.php");
require_once("persistencia/CuentaDAO.php");
include ("presentacion/Extremos/Cabeza.php");
include ("presentacion/menuPropietario.php");

$idPropietario = $_SESSION["id"]; // ya lo tenés en tu sesión

$conexion = new Conexion();
$conexion->abrir();

$cuentaDAO = new CuentaDAO();
$conexion->ejecutar($cuentaDAO->listarPorPropietario($idPropietario));

$cuentas = array();

while (($registro = $conexion->registro()) != null) {
    $cuentas[] = $registro;
}

$conexion->cerrar();
?>

<div class="container mt-4">
    <h4>Cuentas de Cobro</h4>
    <?php if (empty($cuentas)) { ?>
        <div class="alert alert-info">No se encontraron cuentas de cobro.</div>
    <?php } else { ?>
        <table class="table table-striped table-bordered mt-3">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Apartamento</th>
                    <th>Fecha Límite</th>
                    <th>Cantidad</th>
                    <th>Saldo Anterior</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cuentas as $cuenta) { ?>
                    <tr>
                        <td><?php echo $cuenta[0]; ?></td>
                        <td><?php echo $cuenta[5]; ?></td>
                        <td><?php echo $cuenta[1]; ?></td>
                        <td>$<?php echo number_format($cuenta[2], 0, ',', '.'); ?></td>
                        <td>$<?php echo number_format($cuenta[3], 0, ',', '.'); ?></td>
                        <td>
                            <?php
                                if (strtolower($cuenta[4]) === 'pagado') {
                                    echo "<span class='text-success fw-bold'>Pagado</span>";
                                } else {
                                    echo "<span class='text-danger fw-bold'>No pagado</span>";
                                }
                            ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } ?>
</div>
