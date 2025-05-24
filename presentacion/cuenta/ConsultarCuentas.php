ConsultarCuentas
<div class="container">
    <div class="row justify-content-center align-items-center g-2">
        <div class="col">Column</div>
        <div class="col">Column</div>
        <div class="col">Column</div>
    </div>

</div>

<?php
    require_once("Logica/Cuenta.php");

    $rol = $_SESSION["rol"];
    function Mostrar_Cuentas(){
        $cuenta = new Cuenta();
        $cuenta->consultar();
        $res = $cuenta->getDatos();
        
    }
?>