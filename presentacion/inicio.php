<?php
include("Extremos/Cabeza.php");
?>
<div class="container my-5">
    <div class="row justify-content-center g-4">
        <div class="col-md-5">
            <div class="card h-100 shadow">
                <div class="card-header bg-primary text-white">¿Quiénes somos?</div>
                <div class="card-body">
                    <h5 class="card-title">Nuestra misión</h5>
                    <p class="card-text">Somos una empresa dedicada a ofrecer soluciones innovadoras para la gestión residencial, priorizando la transparencia y el bienestar de la comunidad.</p>
                </div>
                <div class="card-footer text-muted">Conoce más sobre nosotros</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 shadow">
                <div class="card-header bg-success text-white">¿Cómo contactarnos?</div>
                <div class="card-body">
                    <h5 class="card-title">Estamos aquí para ayudarte</h5>
                    <p class="card-text">Puedes comunicarte con nosotros vía correo electrónico, redes sociales o visitando nuestras oficinas durante el horario laboral.</p>
                </div>
                <div class="card-footer text-muted">Atención de lunes a viernes</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 shadow">
                <div class="card-header bg-info text-white">Otros servicios</div>
                <div class="card-body">
                    <h5 class="card-title">Lo que ofrecemos</h5>
                    <p class="card-text">Consultoría, mantenimiento, administración financiera y mucho más.</p>
                </div>
                <div class="card-footer text-muted">Solicita información adicional</div>
            </div>
        </div>
    </div>
</div>
<br><br><br><br>
<div class="d-flex justify-content-center align-items-center vh-100 mt-5">
    <div class="card w-100 w-md-75 shadow">
        <div class="card-header text-center bg-dark text-white mt-5">
            <h4 class="mb-0">Listado de Propietarios por Apartamento</h4>
        </div>
        <div class="card-body">
            <?php
            $apartamento = new Apartamento();
            $apartamentos = $apartamento->consultarTodos();

            usort($apartamentos, function ($a, $b) {
                $propA = $a->getPropietario();
                $propB = $b->getPropietario();

                if (!$propA && !$propB) return 0;
                if (!$propA) return 1;
                if (!$propB) return -1;

                return strcmp(
                    $propA->getApellido() . ' ' . $propA->getNombre(),
                    $propB->getApellido() . ' ' . $propB->getNombre()
                );
            });

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

            foreach ($apartamentos as $apt) {
                $prop = $apt->getPropietario();
                $nombrePropietario = $prop ? $prop->getNombre() . " " . $prop->getApellido() : "<em>Sin asignar</em>";
                $telefono = $prop ? $prop->getTelefono() : "---";

                echo "<tr>
                        <td>{$apt->getId()}</td>
                        <td>{$apt->getNombre()}</td>
                        <td>{$apt->getArea()->getMetrosCuadrados()}</td>
                        <td>{$nombrePropietario}</td>
                        <td>{$telefono}</td>
                    </tr>";
            }

            echo "</tbody></table>";
            ?>
        </div>
    </div>
</div>

<?php
include("presentacion/Extremos/Pie.php");
?>