
<div class="container min-vh-100 d-flex flex-column justify-content-center pt-5 ">
    <div class="row w-100 justify-content-center g-4">
        <!-- ¿Quiénes somos? -->
       <div class="col-12 col-md-6 col-lg-4 ">
            <div class="card h-100 shadow bg-light bg-opacity-50 p-3">
                <div class="card-header bg-primary text-white text-center">
                    ¿Quiénes somos?
                </div>
                <div class="card-body">
                    <h5 class="card-title text-center">Nuestra misión</h5>
                    <p class="card-text text-justify">
                        Somos una empresa dedicada a ofrecer soluciones innovadoras para la gestión residencial, priorizando la transparencia y el bienestar de la comunidad.
                    </p>
                </div>
                <div class="card-footer text-muted text-center">
                    Conoce más sobre nosotros
                </div>
            </div>
        </div>

        <!-- ¿Cómo contactarnos? -->
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 shadow bg-light bg-opacity-50 p-3">
                <div class="card-header bg-success text-white text-center">
                    ¿Cómo contactarnos?
                </div>
                <div class="card-body">
                    <h5 class="card-title text-center">Estamos aquí para ayudarte</h5>
                    <p class="card-text text-justify">
                        Puedes comunicarte con nosotros vía correo electrónico, redes sociales o visitando nuestras oficinas durante el horario laboral.
                    </p>
                </div>
                <div class="card-footer text-muted text-center">
                    Atención de lunes a viernes
                </div>
            </div>
        </div>

        <!-- Otros servicios -->
        <div class="col-12 col-md-12 col-lg-4">
            <div class="card h-100 shadow bg-light bg-opacity-50 p-3">
                <div class="card-header bg-info text-white text-center">
                    Otros servicios
                </div>
                <div class="card-body">
                    <h5 class="card-title text-center">Lo que ofrecemos</h5>
                    <p class="card-text text-justify">
                        Consultoría, mantenimiento, administración financiera y mucho más.
                    </p>
                </div>
                <div class="card-footer text-muted text-center">
                    Solicita información adicional
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de propietarios -->
    <div class="row mt-5 justify-content-center">
        <div class="col-12 col-lg-10">
            <div class="card shadow bg-light bg-opacity-50">
                <div class="card-header bg-dark text-white text-center">
                    <h4 class="mb-0">Listado de Propietarios por Apartamento</h4>
                </div>
                <div class="card-body table-responsive">
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
    </div>
</div>
