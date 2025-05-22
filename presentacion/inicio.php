<div class="container-flex">
    <div class="row justify-content-center align-items-center g-2">
        <div class="col-5 m-3">
            <div class="card">
                <div class="card-header">¿Quienes somos?</div>
                <div class="card-body">
                    <h4 class="card-title">Title</h4>
                    <p class="card-text">Text</p>
                </div>
                <div class="card-footer text-muted">Footer</div>
            </div>

        </div>
        <div class="col-4 m-3">
            <div class="card">
                <div class="card-header">¿Como contactarnos?</div>
                <div class="card-body">
                    <h4 class="card-title">Title</h4>
                    <p class="card-text">Text</p>
                </div>
                <div class="card-footer text-muted">Footer</div>
            </div>

        </div>
        <div class="col-3 m-3">
            <div class="card">
                <div class="card-header">etc</div>
                <div class="card-body">
                    <h4 class="card-title">Title</h4>
                    <p class="card-text">Text</p>
                </div>
                <div class="card-footer text-muted">Footer</div>
            </div>

        </div>
    </div>

</div>



<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card w-75 w-md-50">
        <div class="card-header text-center">
            <div class="card">
                <div class="card-body text-center">
                    <h4 class="card-title mb-0">Propietarios</h4>
                </div>
            </div>
        </div>
        <div class="card-body text-center">
            <?php
            $apartamento = new Apartamento();
            $apartamentos = $apartamento->consultarTodos();

            // Ordenar por apellido y nombre del propietario, manejando propietarios null
            usort($apartamentos, function ($a, $b) {
                $propA = $a->getPropietario();
                $propB = $b->getPropietario();

                // Para ordenar, si un propietario es null, va al final
                if ($propA === null && $propB === null) return 0;
                if ($propA === null) return 1;
                if ($propB === null) return -1;

                $nombreA = $propA->getApellido() . ' ' . $propA->getNombre();
                $nombreB = $propB->getApellido() . ' ' . $propB->getNombre();
                return strcmp($nombreA, $nombreB);
            });

            echo "<table class='table table-striped table-hover'>";
            echo "<tr>
                    <td>Id</td>
                    <td>Nombre</td>
                    <td>Área (m²)</td>
                    <td>Propietario</td>
                    <td>Teléfono</td>
                </tr>";

            foreach ($apartamentos as $apt) {
                $prop = $apt->getPropietario();

                $nombrePropietario = $prop ? $prop->getNombre() . " " . $prop->getApellido() : "Sin asignar";
                $telefono = $prop ? $prop->getTelefono() : "---";

                echo "<tr>";
                echo "<td>" . $apt->getId() . "</td>";
                echo "<td>" . $apt->getNombre() . "</td>";
                echo "<td>" . $apt->getArea()->getMetrosCuadrados() . "</td>";
                echo "<td>" . $nombrePropietario . "</td>";
                echo "<td>" . $telefono . "</td>";
                echo "</tr>";
            }

            echo "</table>";
            ?>




        </div>
    </div>
</div>
<?php
include("presentacion/Extremos/Pie.php");
?>