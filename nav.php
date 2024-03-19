<?php $pagina = basename($_SERVER['SCRIPT_FILENAME']); ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="container">
			<a class="navbar-brand" href="#">Grupo Euro Andino</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
				<div class="navbar-nav">
					<a class="nav-link <?= $pagina =="tours.php" ? 'active': ''?>" aria-current="page" href="tours.php">Tours</a>
					<a class="nav-link <?= $pagina =="paquetes.php" ? 'active': ''?>" href="paquetes.php">Paquetes turísticos</a>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle  <?= $pagina =="internacionales-tours.php" || $pagina =="internacionales-paquetes.php" ? 'active': ''?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Internacionales</a>
						<ul class="dropdown-menu">
							<li><a class="dropdown-item" href="internacionales-tours.php">Tours</a></li>
							<li><a class="dropdown-item" href="internacionales-paquetes.php">Paquetes</a></li>
						</ul>
					</li>
					<a class="nav-link <?= $pagina =="reservas.php" ? 'active': ''?>" href="reservas.php">Reservas</a>
					<a class="nav-link <?= $pagina =="lateral.php" ? 'active': ''?>" href="lateral.php">Configuraciones</a>
				</div>
			</div>
		</div>
	</nav>