<?php
$datosApartamento = null;
$cuentaAnterior = null; // Nueva variable para saldo
$nombreBuscado = "";

if (isset($_POST["nombreApartamento"])) {
    $nombreBuscado = trim($_POST["nombreApartamento"]);

    $apartamento = new Apartamento();
    $datosApartamento = $apartamento->consultarPorNombre($nombreBuscado);

    if ($datosApartamento) {
        // Crear objeto Cuenta y consultar por idApartamento
        $cuenta = new Cuenta();
        $cuentaAnterior = $cuenta->consultarPorApartamento($datosApartamento->getId());
        // $cuentaAnterior es un objeto Cuenta o null si no encontró
    }
}
?>
<?php
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
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Dirección:</label>
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
                                value="<?php
                                        echo $cuentaAnterior !== null ? '$' . number_format($cuentaAnterior->getSaldoAnterior(), 0, ',', '.') : 'Sin información';
                                        ?>" readonly>
                        </div>

                    </form>
                <?php elseif ($nombreBuscado): ?>
                    <div class="alert alert-warning mt-3">No se encontró ningún apartamento con ese nombre.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>