<div class="row mt-5 justify-content-center">
    <div class="col-12 col-lg-10">
        <div class="card shadow bg-light bg-opacity-50">
            <div class="card-header bg-dark text-white text-center">
                <h4 class="mb-0">Mis Apartamentos Registrados</h4>
            </div>
            <div class="card-body table-responsive">
                <?php
                include_once ("persistencia/Conexion.php");

                $idPropietario = $_SESSION['id']; // ID del propietario logueado

                $conexion = new Conexion();
                $conexion->abrir();

                include_once("persistencia/PropietarioDAO.php");
                $propietarioDAO = new PropietarioDAO();
                $sql = $propietarioDAO->consultarApartamento($idPropietario);
                $conexion->ejecutar($sql);

                echo "<table class='table table-bordered table-striped table-hover text-center'>";
                echo "<thead class='table-secondary'>
                        <tr>
                            <th>ID</th>
                            <th>Nombre del Apartamento</th>
                            <th>Área (m²)</th>
                            <th>Propietario</th>
                            <th>Teléfono</th>
                        </tr>
                    </thead>";
                echo "<tbody>";

                while ($fila = $conexion->extraer()) {
                    $id = $fila['idApartamento'];
                    $nombreApto = $fila['nombreApartamento'];
                    $area = $fila['metrosCuadrados'];
                    $nombrePropietario = $fila['nombrePropietario'] . ' ' . $fila['apellido'];
                    $telefono = $fila['telefono'];

                    echo "<tr>
                            <td>$id</td>
                            <td>$nombreApto</td>
                            <td>$area</td>
                            <td>$nombrePropietario</td>
                            <td>$telefono</td>
                        </tr>";
                }

                echo "</tbody></table>";
                $conexion->cerrar();
                ?>
            </div>
        </div>
    </div>
</div>

