<?php 
$id = $_SESSION["id"];
$propietario = new Propietario($id);
$propietario->consultar();
?>
<div class="container">
	<nav class="navbar navbar-expand-lg " style=" background-color: #b6fff6;">
		<div class="container">
			<a class="navbar-brand" href="?pid=<?php echo base64_encode("presentacion/sesionPropietario.php")?>"><i class="fa-solid fa-house"></i></a>
			<button class="navbar-toggler" type="button"
				data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
				aria-controls="navbarSupportedContent" aria-expanded="false"
				aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav me-auto mb-2 mb-lg-0">
					<li class="nav-item dropdown"><a class="nav-link dropdown-toggle"
						href="#" role="button" data-bs-toggle="dropdown"
						aria-expanded="false"> Cuenta </a>
						<ul class="dropdown-menu">
							<li><a class="dropdown-item" href="?pid=<?php echo base64_encode("presentacion/cuenta/ConsultarCuentaProp.php")?>">Consultar</a></li>
							<li><a class="dropdown-item" href="?pid=<?php echo base64_encode("presentacion/cuenta/pagarPropietario.php")?>">Pagar</a></li>
						</ul></li>
					
				</ul>
				<ul class="navbar-nav ms-auto mb-2 mb-lg-0">
					<li class="nav-item dropdown"><a class="nav-link dropdown-toggle"
						href="#" role="button" data-bs-toggle="dropdown"
						aria-expanded="false"> Propietario: <?php echo $propietario->getNombre() . " " . $propietario->getApellido() ?> </a>
						<ul class="dropdown-menu">
								<li><a class="dropdown-item" href="?pid=<?php echo base64_encode("presentacion/usuario/editarUsuario.php")?>">Editar Perfil</a></li>
							<li><a class="dropdown-item" href="?pid=<?php echo base64_encode("presentacion/Autenticar.php")?>&sesion=false">Cerrar Sesion</a></li>
						</ul></li>
				</ul>
			</div>
		</div>
	</nav>
</div>