    <?php
    require_once("logica/Admin.php");

    ?>


    <!DOCTYPE html>
    <html>

    <head>
        <title>ViveLaVidaLoca</title>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>

    <body style="background-image: url('img/fondo.png'); background-size: cover; background-position: center;">
        <div class="container min-vh-100 d-flex justify-content-center align-items-center">
            <div class="row w-100 justify-content-center">

                <div class="col-12 col-md-4 col-lg-4 mb-4 mb-md-0 mt-4 mt-md-0">
                    <div class="card bg-light bg-opacity-50 shadow h-100 text-center p-4">

                        <div class="card-body d-flex flex-column justify-content-center align-items-center">
                            <img src="img/LogoMatasanos.png" alt="Logo Hospital Matasanos" class="img-fluid mb-3 rounded-circle">
                            <h4 class="card-title">Cunjunto Vive La Vida Loca</h4>
                            <p class="card-text">Bienvenido al sistema de acceso seguro de pagos de cuentas.</p>
                        </div>
                    </div>
                </div>


                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card bg-light bg-opacity-50 shadow p-4 h-100">

                        <div class="card-body d-flex flex-column justify-content-center">
                            <h3 class="mb-4 text-center">Iniciar Sesión</h3>
                            <form>
                                <div class="mb-3">
                                    <label for="usuario" class="form-label">Nombre de usuario</label>
                                    <input type="text" class="form-control" id="usuario" placeholder="Ej: juan" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Contraseña</label>
                                    <input type="password" class="form-control" id="password" placeholder="********" required>
                                </div>
                                <div class="d-grid">
                                    <a href="Main.html" class="btn btn-info">Entrar</a>
                                </div>

                                <p class="text-center">
                                    <br>
                                    ¿No tienes cuenta? <a href="crear_usuario.html">Crear Usuario</a>
                                </p>
                            </form>
                            <div class="card-header">
                                <h4>Admins</h4>
                            </div>
                            <div class="card-body">
                                <?php
                                $admin = new Admin();
                                $admins = $admin->consultar();
                                echo "<table class='table table-striped table-hover'>";
                                echo "<tr><td>Id</td><td>Nombre</td><td>Apellido</td></tr>";
                                foreach ($admins as $ad) {
                                    echo "<tr>";
                                    echo "<td>" . $ad->getId() . "</td>";
                                    echo "<td>" . $ad->getNombre() . "</td>";
                                    echo "<td>" . $ad->getApellido() . "</td>";
                                    echo "</tr>";
                                }
                                echo "</table>";
                                ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

    </html>