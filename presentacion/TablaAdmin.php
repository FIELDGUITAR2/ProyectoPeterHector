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