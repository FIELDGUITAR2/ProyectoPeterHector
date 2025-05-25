
<?php
require_once("logica/Propietario.php");
require_once("logica/Cuenta.php");
require_once("persistencia/CuentaDAO.php");
require_once("persistencia/Conexion.php");
include ("presentacion/Extremos/Cabeza.php");
include ("presentacion/Extremos/pie.php");
$idPropietario = $_SESSION["id"];
$propietario = new Propietario($idPropietario);
$propietario->consultar();

$conexion = new Conexion();
$conexion->abrir();

$cuentaDAO = new CuentaDAO();
$consulta = $cuentaDAO->listarPorPropietario($idPropietario);
$conexion->ejecutar($consulta);

$cuentas = [];
while ($fila = $conexion->registro()) {
    
    if ($fila[4] != "PAGADO") {
        $cuentas[] = $fila;
    }
}

$mensaje = "";


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["cuenta"])) {
    $idCuenta = $_POST["cuenta"];
    $fechaPago = date("Y-m-d");


    $pagoSQL = "INSERT INTO Pagos (fechaPago, Cuenta_idCuenta) VALUES ('$fechaPago', $idCuenta)";
    $conexion->ejecutar($pagoSQL);

    
   $cuentaDAO = new CuentaDAO();
$conexion->ejecutar($cuentaDAO->actualizarEstadoPago($idCuenta, 1));


    $mensaje = "<div class='alert alert-success mt-3'>Pago registrado correctamente.</div>";

    
    $conexion->ejecutar($cuentaDAO->listarPorPropietario($idPropietario));
    $cuentas = [];
    while ($fila = $conexion->registro()) {
        if ($fila[4] != "PAGADO") {
            $cuentas[] = $fila;
        }
    }
}

$conexion->cerrar();
?>

<div class="container mt-5">
    <h2>Realizar Pago</h2>
    <p><strong>Propietario:</strong> <?php echo $propietario->getNombre() . " " . $propietario->getApellido(); ?></p>
    <p><strong>Fecha de ingreso:</strong> <?php echo $propietario->getFecha(); ?></p>

    <?php echo $mensaje; ?>

    <?php if (count($cuentas) > 0): ?>
        <form method="post">
            <div class="mb-3">
                <label for="cuenta" class="form-label">Seleccione cuenta a pagar</label>
                <select name="cuenta" id="cuenta" class="form-select" required>
                    <option value="">Seleccione una cuenta</option>
                    <?php foreach ($cuentas as $cuenta): ?>
                        <option value="<?php echo $cuenta[0]; ?>">
                            Apto <?php echo $cuenta[5]; ?> | Total: $<?php echo number_format($cuenta[2], 0); ?> | Estado: <?php echo $cuenta[4]; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Pagar</button>
        </form>
    <?php else: ?>
        <div class="alert alert-info">No tienes cuentas pendientes por pagar.</div>
    <?php endif; ?>
</div>
