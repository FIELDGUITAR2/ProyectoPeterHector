<div class="row mt-5 justify-content-center">
        <div class="col-12 col-lg-10">
            <div class="card shadow bg-light bg-opacity-50">
                <div class="card-header bg-dark text-white text-center">
                    <h4 class="mb-0">Listado de propiedades</h4>
                </div>
                <div class="card-body table-responsive">
                    <?php
                        $cuenta = new Cuenta();
        				$cuenta -> consultarCuentas("");
                        $cuentas = $cuenta->getCuentasLista();
        				echo "<table class='table table-striped table-hover'>";
        				echo "
                        <tr>
                        <td>ID_Apartamento</td>
                        <td>Nombre_Apartamento</td>
                        <td>Area</td>
                        <td>ID_Cuenta</td>
                        <td>Cantidad</td>
                        <td>Estado_Pago</td>
                        </tr>";
        				foreach($cuentas as $cute){
        				    echo "<tr>";
        				    echo "<td>" . $cute -> getIdApartamento() -> getId() . "</td>";
        				    echo "<td>" . $cute -> getIdApartamento() -> getNombre() . "</td>";
                            echo "<td>" . $cute -> getIdApartamento() -> getArea() -> getId() . "</td>";
        				    echo "<td>" . $cute -> getId() . "</td>";
        				    echo "<td>" . $cute -> getCantidad() . "</td>";
                            echo "<td>" . $cute -> getIdEstadoPago() -> getId() . "</td>";
        				    echo "</tr>";
        				}
        				echo "</table>";
                    ?>
                </div>
            </div>
        </div>
    </div>