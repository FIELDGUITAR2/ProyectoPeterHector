<?php

$rol = $_SESSION["rol"];

$datosApartamento = null;
$cuentaAnterior = null;
$nombreBuscado = "";
$cuentaExiste = false;

function calcularFechaLimite($fechaIngreso) {
    $fechaActual = new DateTime();
    $dia = (int)date("d", strtotime($fechaIngreso));
    $fechaActual->modify('first day of next month');
    $ultimoDia = (int)$fechaActual->format('t');
    $fechaActual->setDate(
        (int)$fechaActual->format('Y'),
        (int)$fechaActual->format('m'),
        min($dia, $ultimoDia)
    );
    return $fechaActual->format('Y-m-d');
}

if (isset($_POST["registrarCuenta"])) {
    $fechaLimite = $_POST["fechaLimite"];
    $cantidad = floatval($_POST["cantidad"]);
    $saldoAnterior = 0; 
    $idAdmin = $_POST["idAdmin"];
    $idApartamento = $_POST["idApartamento"];
    $idEstadoPago = $_POST["idEstadoPago"];

    // Crear objeto cuenta para la nueva cuenta
    $cuenta = new Cuenta("", $fechaLimite, $cantidad, $saldoAnterior, $idAdmin, $idApartamento, $idEstadoPago);

    $cuentaExiste = $cuenta->existeCuentaEnFecha($idApartamento, $fechaLimite);

    if ($cuentaExiste) {
        $mensajeError = "Ya existe una cuenta registrada para este apartamento en este mes.";
    } else {
        // Buscar la cuenta anterior y actualizar su saldoAnterior a 0 directamente en el método actualizarSaldoAnterior()
        $cuentaAnterior = new Cuenta();
       
        $cuentaAnterior = $cuentaAnterior->consultarPorApartamento($idApartamento);

        if ($cuentaAnterior !== null) {
             $idCuentaAnterior = $cuentaAnterior -> getId(); 
            $cuentaAnterior->actualizarSaldoAnterior($idCuentaAnterior,$saldoAnterior);  
        }

        $resultado = $cuenta->insertar();

        if ($resultado) {
            header("Location: " . $_SERVER["REQUEST_URI"]);
            exit();
        }
    }
}



if (isset($_POST["nombreApartamento"]) && !isset($_POST["registrarCuenta"])) {
    $nombreBuscado = trim($_POST["nombreApartamento"]);

    $apartamento = new Apartamento();
    $datosApartamento = $apartamento->consultarPorNombre($nombreBuscado);

    if ($datosApartamento) {
        $propietario = $datosApartamento->getPropietario();

        if ($propietario !== null) {
            $propietario->consultar();
            $fechaIngreso = $propietario->getFecha();
            $fechaLimite = !empty($fechaIngreso) ? calcularFechaLimite($fechaIngreso) : date("Y-m-d");
        } else {
            $fechaLimite = date("Y-m-d");
        }

        $cuenta = new Cuenta();
        $cuentaAnterior = $cuenta->consultarPorApartamento($datosApartamento->getId());
        $cuentaExiste = $cuenta->existeCuentaEnFecha($datosApartamento->getId(), $fechaLimite);
        $areaMetros = $datosApartamento->getArea()->getMetrosCuadrados();
        $valorArriendo = $datosApartamento->getArea()->getValorArriendo();

        $tarifaAdministracionPorMetro = 3000;
        $cuotaArriendo = $valorArriendo;
        $cuotaAdministracion = $areaMetros * $tarifaAdministracionPorMetro;

        $saldoAnterior = $cuentaAnterior !== null ? $cuentaAnterior->getSaldoAnterior() : 0;
        $cantidadAPagar = $saldoAnterior + $cuotaAdministracion + $cuotaArriendo;
    }
}



include("presentacion/Extremos/Cabeza.php");
include("presentacion/menu" . ucfirst($_SESSION["rol"]) . ".php");
?>




<body>

    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h4>Buscar Apartamento</h4>
            </div>
            <div class="card-body">
                <form method="post" action="">
                    <div class="mb-3">
                        <label for="nombreApartamento" class="form-label">Nombre del Apartamento:</label>
                        <input type="text" name="nombreApartamento" id="nombreApartamento" class="form-control" value="<?php echo htmlspecialchars($nombreBuscado); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </form>

                <?php if ($datosApartamento): ?>
                    <hr>
                    <h5>Detalles del Apartamento</h5>

                    <form method="post" action="">
                        <div class="mb-3">
                            <label class="form-label">Numero Apartamento:</label>
                            <input type="text" class="form-control" value="<?php echo $datosApartamento->getNombre(); ?>" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Propietario:</label>
                            <input type="text" class="form-control"
                                value="<?php echo $datosApartamento->getPropietario() !== null ? $datosApartamento->getPropietario()->getNombre() . ' ' . $datosApartamento->getPropietario()->getApellido() : 'Sin asignar'; ?>" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Saldo Anterior:</label>
                            <input type="text" class="form-control"
                                value="<?php echo $cuentaAnterior !== null ? '$' . number_format($cuentaAnterior->getSaldoAnterior(), 0, ',', '.') : '0'; ?>" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Cuota Administración:</label>
                            <input type="text" class="form-control"
                                value="<?php echo '$' . number_format($cuotaAdministracion, 0, ',', '.'); ?>" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Fecha Límite de Pago:</label>
                            <input type="text" class="form-control"
                                value="<?php echo date("d/m/Y", strtotime($fechaLimite)); ?>" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Cantidad a Pagar:</label>
                            <input type="text" class="form-control"
                                value="<?php echo '$' . number_format($cantidadAPagar, 0, ',', '.'); ?>" readonly>
                        </div>

                        <!-- Campos ocultos con los valores que necesita el POST para insertar -->
                        <input type="hidden" name="nombreApartamento" value="<?php echo htmlspecialchars($nombreBuscado); ?>">
                        <input type="hidden" name="fechaLimite" value="<?php echo htmlspecialchars($fechaLimite); ?>">
                        <input type="hidden" name="cantidad" value="<?php echo htmlspecialchars($cantidadAPagar); ?>">
                        <input type="hidden" name="saldoAnterior" value="0">
                        <input type="hidden" name="idAdmin" value="<?php echo htmlspecialchars($id); ?>"> <!-- Usas el id de sesión -->
                        <input type="hidden" name="idApartamento" value="<?php echo htmlspecialchars($datosApartamento->getId()); ?>">
                        <input type="hidden" name="idEstadoPago" value="3">


                        

                        <?php if ($cuentaExiste): ?>
                            <div class="alert alert-danger mt-3">
                                Ya existe una cuenta registrada para este apartamento en esa fecha. No puedes volver a crearla.
                            </div>
                        <?php else: ?>
                            <button type="submit" name="registrarCuenta" class="btn btn-success">Registrar Cuenta</button>
                            <div class="alert alert-success mt-3">
                                No existe una cuenta registrada para esta fecha. Puede ser creada.
                            </div>
                        <?php endif; ?>


                    </form>

                <?php elseif ($nombreBuscado): ?>
                    <div class="alert alert-warning mt-3">No se encontró ningún apartamento con ese nombre.</div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</body>