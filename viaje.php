<<<<<<< HEAD
<!DOCTYPE html>

<html lang="es">

<head>

	<meta charset="UTF-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/png" href="https://grupoeuroandino.com/wp-content/uploads/2023/07/cropped-Grupo-Euro-Andino-favicon.png">


	<?php

	ini_set('display_errors', 1);

	ini_set('display_startup_errors', 1);

	error_reporting(E_ALL);

	include('/home/perutra1/grupoeuroandino.com/app/api/conectkarl.php');

	$sqlBase = "SELECT id, JSON_UNQUOTE(contenido-> '$.nombre') as titulo,

	JSON_UNQUOTE(contenido-> '$.descripcion') as descripcion,

	IFNULL(JSON_UNQUOTE(contenido-> '$.fotos[0].nombreRuta'), 'defecto.jpg')as foto

	FROM `tours` where url = '{$_GET['variable']}' limit 1;";

	$sqlMeta = $db->query($sqlBase);

	//echo $sqlBase;

	if ($sqlMeta->execute()) {

		$rowMeta = $sqlMeta->fetch(PDO::FETCH_ASSOC);

	?>

		<meta property="og:title" content="<?= $rowMeta['titulo'] ?> - Grupo Euro Andino">

		<title><?= $rowMeta['titulo'] ?> - Grupo Euro Andino</title>

		<!-- <meta property="og:image" content="https://grupoeuroandino.com/images/marcapomacocha-2.png"> -->

		<meta property="og:image" content="https://grupoeuroandino.com/app/render/images/subidas/small-<?= $rowMeta['foto'] ?>">

		<meta property="og:description" content="<?= strip_tags($rowMeta['descripcion']) ?>">

	<?php

	}

	?>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">



	<link rel="stylesheet" href="https://grupoeuroandino.com/icofont/icofont.min.css">

	<link rel="stylesheet" href="https://grupoeuroandino.com/css/bootstrap-datepicker.min.css?v=1.1">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css" integrity="sha512-UTNP5BXLIptsaj5WdKFrkFov94lDx+eBvbKyoe1YAfjeRPC+gT5kyZ10kOHCfNZqEui1sxmqvodNUx3KbuYI/A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css" integrity="sha512-OTcub78R3msOCtY3Tc6FzeDJ8N9qvQn1Ph49ou13xgA9VsH9+LRxoFU6EqLhW4+PKRfU+/HReXmSZXHEkpYoOA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

	<link rel="preconnect" href="https://fonts.googleapis.com">

	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

</head>

<body>







	<style>
		.datepicker {
			padding: 0px !important;
		}

		.datepicker td,
		.datepicker th {

			width: 3rem !important;

			height: 2.4rem !important;

			padding: 6px 2px 0px 0px !important;

		}

		.datepicker-inline {

			width: 100% !important;

		}

		.datepicker table {

			margin: auto !important;

			border: none !important;

		}

		.datepicker .datepicker-days {

			border: none;

		}

		.datepicker table tr td.active.active {

			/* background-color: #2482e3!important; */
			background-image: none !important;

		}

		.datepicker table tr td.today,
		.datepicker table tr td.today.disabled,
		.datepicker table tr td.today.disabled:hover,
		.datepicker table tr td.today:hover,
		.datepicker table tr td.today.disabled,
		.datepicker table tr td.today.disabled {
			background-color: #dc3545 !important;
		}

		#divRecomendaciones img {

			width: 100%;

			height: 170px;

			object-fit: cover;

		}

		.dow {
			color: rgb(145 145 145) !important;
		}

		#divRecomendaciones .titulo {
			background-color: rgb(214, 214, 214);
		}

		#divIzquierda ul,
		ol {
			padding-left: 0 !important;
		}

		p {
			margin-bottom: 0;
		}

		.ql-align-center {
			text-align: center !important;
		}

		#divQuill h5,
		#divQuill p {
			margin-bottom: 0;
		}

		.estrellas {

			color: #ffd400;

		}

		.precio2 {

			font-size: 1.7rem;

			font-weight: bold;

		}

		.precioAnt2 {

			font-size: 0.8rem;

			text-decoration: line-through;

		}

		#divTransportes img {

			width: 60px;

		}

		.carousel-wrapper {

			/* width: 1000px; */

			margin: auto;

			position: relative;

			text-align: center;

			font-family: sans-serif;

		}

		.owl-carousel .owl-nav {

			overflow: hidden;

			height: 0px;

		}

		.owl-theme .owl-dots .owl-dot.active span,

		.owl-theme .owl-dots .owl-dot:hover span {

			background: #5110e9;

		}



		.owl-carousel .item {

			text-align: center;

		}

		.owl-carousel .nav-button {

			height: 50px;

			width: 25px;

			cursor: pointer;

			position: absolute;

			top: 110px !important;

		}

		.owl-carousel .owl-prev.disabled,

		.owl-carousel .owl-next.disabled {

			pointer-events: none;

			opacity: 0.25;

		}

		.owl-carousel .owl-prev {

			left: -35px;

		}

		.owl-carousel .owl-next {

			right: -35px;

		}

		.owl-theme .owl-nav [class*=owl-] {

			color: #ffffff;

			font-size: 39px;

			background: #000000;

			border-radius: 3px;

		}

		.owl-carousel .prev-carousel:hover {

			background-position: 0px -53px;

		}

		.owl-carousel .next-carousel:hover {

			background-position: -24px -53px;

		}

		.owl-theme .owl-nav [class*='owl-'] {

			margin: 0;

			padding: 0;

			display: table;

		}

		#divQuill img {

			max-width: 100%;

		}

		#menuVolver {

			background-image: url('https://grupoeuroandino.com/wp-content/uploads/2021/09/png-transparent-wood-texture-mapping-material-wood-texture-orange-wood-material.png');

			background-position: center left;

		}

		#pie {

			background-color: #026EB6;

			background-image: url('https://grupoeuroandino.com/wp-content/uploads/2021/09/Footer.png');

			background-position: 0px 0vh;

			background-repeat: no-repeat;

			background-size: cover;

		}

		#ulMenu {

			padding: 0 5rem;

		}

		#ulMenu>li {

			display: inline-block;

			width: 160px;

			padding: 1rem 0;

			text-align: center;

			color: white;

			font-size: 13px;

			font-weight: bold;

			text-decoration: none;

		}

		#ulMenu>li:hover {
			background: #BF9F00;
			cursor: pointer;
		}



		.Ico {
			margin: 0 0px 0 0;

			width: 33px;
			padding-right: 1rem;

		}

		#menuVolver,
		#menuCabecera {

			font-family: 'Roboto', sans-serif;

		}

		#imgLogo {
			width: 100px;
		}

		#menuCabecera p {

			font-size: 13px;
			color: #7a7a7a;

			font-weight: 400;

		}

		#menuCabecera h3 {

			font-size: 17px;
			color: #012c6d;

			font-weight: 600;

		}

		#menuCabecera a {
			text-decoration: none;
		}

		#mLateral {

			position: fixed;
			/* Sit on top of the page content */

			display: none;

			width: 300px;
			/* Full width (cover the whole page) */

			height: 100%;
			/* Full height (cover the whole page) */

			top: 0;

			left: 0;

			right: 50px;

			bottom: 0;

			background-color: #003793;
			/* Black background with opacity */

			z-index: 102;
			/* Specify a stack order in case you're using a different order for other elements */

			cursor: pointer;
			/* Add a pointer on hover */

		}

		#mLateralP {
			padding-top: 5em;
		}

		#mLateral .Ico {

			width: 40px !important;

		}

		#mLateral p {

			font-family: 'Roboto', sans-serif;

			font-size: 16px !important;

			font-weight: 300 !important;

			padding: 10px 10px 10px 10px;

			color: white;

			margin: 0.5em 0;

			padding: 1em 1em;

		}

		#mLateralP a {

			color: #ffffffba;

			padding-left: 0.3rem;

			text-decoration: none;

		}

		#mLateralP p:first-child,
		#mLateralP p:hover {

			background-color: #743eff;

		}



		#txtNombres1::placeholder {

			color: #ffffffba;

			padding-left: 0.3rem;

		}

		#txtNombres1 {
			width: 336px;

			background: #ffffff1c;

			color: white;

			border: none;

			height: 35px;

			margin-bottom: 0.8rem;

			padding-left: 0.9rem;

			outline: none;

		}

		#txtCorreo1::placeholder {

			padding-left: 0.3rem;

			color: #ffffffba;

			;

		}

		#txtCorreo1 {
			width: 336px;

			background: #ffffff1c;

			color: white;

			padding-left: 0.9rem;

			border: none;

			height: 35px;

			margin-bottom: 0.8rem;

			outline: none;

		}

		#btnFormulario {
			width: 336px;
			height: 40px;

			margin-bottom: 0.8rem;

			padding-left: 0.9rem;

			border: none;

			background: #FCAB1C;

			color: white;

			font-weight: bold;

		}

		#btnFormulario img {

			width: 15px;

		}
	</style>

	<!-- Inicio de Encabezado -->



	<div class="container fluid d-block d-sm-none">

		<div class="row row-cols-3">

			<div class="col mx-0 px-1" style="width:114px">

				<a href="https://grupoeuroandino.com"><img src="https://grupoeuroandino.com/wp-content/uploads/2020/09/Grupo-Euro-Andino-2048x1795.png" style="width: 94%; height: auto; margin-left:8px;" class="img-fluid p-3"></a>

			</div>

			<div class="col d-flex align-items-center" style="width:216px">

				<div class="container-fluid px-0 mx-0">

					<div class="row row-cols-3 ">

						<div class="col">

							<a href="tel:064788975"><img src="https://grupoeuroandino.com/app/render/images/phone-solid.svg" class="p-1" width="38" height="38"></a>

						</div>

						<div class="col">

							<a href="https://wa.me/51947614293"><img src="https://grupoeuroandino.com/app/render/images/whatsapp.svg" class="p-1" width="42" height="42"></a>

						</div>

						<div class="col" data-bs-toggle="modal" data-bs-target="#modalAgenda"> <img src="https://grupoeuroandino.com/app/render/images/clock-regular.svg" class="p-1" width="42" height="42"> </div>

					</div>

				</div>

			</div>

			<div class="col d-flex " style="width:61px" onclick="document.getElementById('mLateral').style.display = 'block';">

				<img src="https://grupoeuroandino.com/app/render/images/sliders-solid.svg?v=1" style="" width="36">

			</div>

		</div>

	</div>



	<div class="container my-4 px-5 d-none d-md-block" id="menuCabecera">

		<div class="container">

			<div class="row row-cols-4">

				<div class="col text-center">

					<a href="https://grupoeuroandino.com"><img src="https://grupoeuroandino.com/wp-content/uploads/2020/09/Grupo-Euro-Andino-2048x1795.png" id="imgLogo"></a>

				</div>

				<div class="col position-relative d-flex align-items-center">

					<a href="tel:064788975">

						<div class="position-absolute top-50 start-0 translate-middle-y">

							<img src="https://grupoeuroandino.com/app/render/images/phone-solid-gris.svg" style="width:50px">

						</div>

						<div style="padding-left:55px">

							<h3>Call Center</h3>

							<p class="mb-0">(064) 788975</p>

						</div>

					</a>

				</div>

				<div class="col position-relative d-flex align-items-center">

					<a href="https://wa.me/51947614293">

						<div class="position-absolute top-50 start-0 translate-middle-y">

							<img src="https://grupoeuroandino.com/app/render/images/whatsapp-gris.svg" style="width:50px">

						</div>

						<div style="padding-left:55px">

							<h3>Chatea con nosotros</h3>

							<p class="mb-0">(+51) 947614293</p>

						</div>

					</a>

				</div>

				<div class="col position-relative d-flex align-items-center">

					<div class="position-absolute top-50 start-0 translate-middle-y">

						<img src="https://grupoeuroandino.com/app/render/images/clock-regular-gris.svg" style="width:50px">

					</div>

					<div style="padding-left:55px">

						<h3>Atención al cliente</h3>

						<p class="mb-0">24/7/365</p>

					</div>

				</div>

			</div>

		</div>



	</div>



	<div id="mLateral">

		<div class="text-end mt-2 me-1" onclick="document.getElementById('mLateral').style.display = 'none';">

			<img src="https://grupoeuroandino.com/app/render/images/x-1.svg" width="60" height="auto">

		</div>

		<div id="mLateralP">

			<p class="mb-0" onclick="location.href='https://grupoeuroandino.com/'"> <img src="https://grupoeuroandino.com/wp-content/uploads/2022/06/path245.png" class="Ico"> Inicio</p>

			<p class="mb-0" onclick="location.href='https://grupoeuroandino.com/peru-interno/'"> <img src="https://grupoeuroandino.com/wp-content/uploads/2022/06/peruico.png" class="Ico"> Destinos</p>

			<p class="mb-0" onclick="location.href='https://grupoeuroandino.com/store/'"> <img src="https://grupoeuroandino.com/wp-content/uploads/2022/06/bolsaico.png" class="Ico"> Tienda</p>

			<p class="mb-0" onclick="location.href='https://grupoeuroandino.com/store/'"> <img src="https://grupoeuroandino.com/wp-content/uploads/2022/06/ofertaico.png" class="Ico"> + Filtros</p>

			<p class="mb-0" onclick="location.href='https://grupoeuroandino-com.translate.goog/?_x_tr_sl=es&_x_tr_tl=en&_x_tr_hl=es&_x_tr_pto=wapp'"> <img src="https://grupoeuroandino.com/wp-content/uploads/2022/06/baneeuu.png" class="Ico"> Inglés</p>

			<p class="mb-0" onclick="location.href='https://grupoeuroandino.com/shop-cart/'"> <img src="https://grupoeuroandino.com/wp-content/uploads/2022/06/cart.png" class="Ico"> Carrito</p>

		</div>

	</div>



	<div class="container-fluid mb-2 d-none d-md-block" id="menuVolver">

		<div class="container">

			<ul id="ulMenu">

				<li onclick="location.href='https://grupoeuroandino.com/'"><img src="https://grupoeuroandino.com/wp-content/uploads/2022/06/path245.png" class="Ico"> INICIO</li>

				<li onclick="location.href='https://grupoeuroandino.com/peru-interno/'"><img src="https://grupoeuroandino.com/wp-content/uploads/2022/06/peruico.png" class="Ico"> DESTINOS</li>

				<li onclick="location.href='https://grupoeuroandino.com/store/'"><img src="https://grupoeuroandino.com/wp-content/uploads/2022/06/bolsaico.png" class="Ico"> TIENDA</li>

				<li onclick="location.href='https://grupoeuroandino.com/store/'"><img src="https://grupoeuroandino.com/wp-content/uploads/2022/06/ofertaico.png" class="Ico"> + FILTROS</li>

				<li onclick="location.href='https://grupoeuroandino-com.translate.goog/?_x_tr_sl=es&_x_tr_tl=en&_x_tr_hl=es&_x_tr_pto=wapp'"><img src="https://grupoeuroandino.com/wp-content/uploads/2022/06/baneeuu.png" class="Ico"> INGLÉS</li>

				<li onclick="location.href='https://grupoeuroandino.com/shop-cart/'"><img src="https://grupoeuroandino.com/wp-content/uploads/2022/06/cart.png" class="Ico"></li>

			</ul>

		</div>

	</div>



	<!-- Fin de Encabezado -->



	<div class="container" id="app">

		<div class="row">

			<div class="col-12 col-md-8">

				<div class="fotorama" data-nav="thumbs" data-width="100%" @contextmenu="handler($event)">

					<img v-for="foto in tourActivo.fotos" :src="'https://grupoeuroandino.com/app/render/images/subidas/'+foto.nombreRuta">



				</div>



				<!-- Empieza el bloque de descripción -->

				<div class="my-3 p-4 border rounded" id="divIzquierda">

					<h2 class="text-danger text-capitalize">{{tourActivo.nombre}}</h2>

					<div class="row row-cols-2 row-cols-md-3" v-if="tourActivo.tipo===2" id="divTransportes">

						<div class="col" v-if="tourActivo.transporte!='3'">

							<div class="d-flex justify-content-between">

								<div class="m-auto ps-2">

									<img v-if="tourActivo.transporte==='2'" src="https://grupoeuroandino.com/app/render/images/vuelo.png" alt="">

									<img v-else src="https://grupoeuroandino.com/app/render/images/carro2.png" style="width:38px">

								</div>

								<div class="text-start">

									<h6 class="mb-1

									">Transporte</h6>

									<span>{{transportes[parseInt(tourActivo.transporte)-1]}}</span>

								</div>

							</div>

						</div>

						<div class="col ps-0">

							<div class="d-flex justify-content-between">

								<div class="m-auto px-2">

									<img src="https://grupoeuroandino.com/app/render/images/hostal.png" style="width:50px">

								</div>

								<div class="text-start">

									<h6 class="mb-1

									">Alojamiento</h6>

									<span>{{hospedajes[parseInt(tourActivo.alojamiento)-1]}}</span>

								</div>

							</div>

						</div>

					</div>

					<h4 class="mt-4 text-danger">Descripción</h4>

					<div v-html="tourActivo.descripcion"></div>

					<h4 class="mt-4 text-danger">Punto de Partida</h4>

					<div class="w-100 text-break" v-html="tourActivo.partida"></div>

					<h4 class="mt-4 text-danger">Itinerario</h4>

					<div class="w-100 text-break p-2" v-html="tourActivo.itinerario"></div>



					<h5 class="mt-3 text-danger">Incluye</h5>

					<div>

						<p class="ms-2 mb-0" v-for="cadena in incluidos"><i class="icofont-check-alt"></i> {{cadena}}</p>

					</div>



					<h5 class="mt-3 text-danger">No Incluye</h5>

					<div>

						<p class="ms-2 mb-0" v-for="cadena in noIncluidos"><i class="icofont-close-line"></i> {{cadena}}</p>

					</div>



					<h5 class="mt-3 text-danger">Notas</h5>

					<div class="w-100 text-break p-2" id="divNotas" v-html="entregarCorto(tourActivo.notas, !verMas)"></div>

					<p @click="verMas = !verMas">

						<a class="text-decoration-none" href="#!">

							<span v-if="!verMas">Ver más</span>

							<span v-else>Ver menos</span>

						</a>

					</p>







				</div>

			</div>

			<div class="col-12 col-md-4">

				<div class="row">

					<div class="col text-center bg-secondary bg-opacity-25 ">

						<span class="fs-1"><strong class="text-danger"><small class="fs-3">S/</small> {{precioPorPersona}}</strong> <small class="fs-5">por persona</small></span>

					</div>

				</div>

				<div class="row">

					<div class="col px-0">

						<div id="dtpFecha" data-date-format="dd/mm/yyyy"></div>

					</div>

				</div>

				<p class="fs-3 text-center text-muted mt-2">

					<span v-if="tourActivo.cupos==1">Úlimo cupo disponible</span>

					<span v-else>{{tourActivo.cupos}} cupos disponibles</span>

				</p>

				<div class="row container" id="divAdultos">

					<div class="col-5 ">

						<p v-if="tourActivo.tipo=='1'" class="text-muted text-end mb-0">Adultos</p>

						<p v-else class="text-muted mb-0">en hab. matrimonial, doble ó triple</p>

					</div>

					<div class="col-6 ms-3">

						<div class="input-group mx-auto">

							<button class="btn btn-outline-secondary border-0" type="button" @click='restarAdulto()'><i class="icofont-minus"></i></button>

							<input type="text" class="form-control w-25 border-0 text-center text-muted" placeholder=" " @focusout="contarMinimoPersonas()" v-model="cantAdultos">

							<button class="btn btn-outline-secondary border-0" type="button" @click="sumarAdulto()"><i class="icofont-plus"></i></button>

						</div>

					</div>

				</div>

				<div class="row container mt-2" id="divKids">

					<div class="col-5 ">

						<p v-if="tourActivo.tipo==1" class="text-muted text-end mb-0">Niños <br><small>(hasta 10 años)</small></p>

						<p v-else class="text-muted mb-0">en hab. simple <small class="text fst-italic">(1 persona por habitación)</small></p>

					</div>

					<div class="col-6 ms-3">

						<div class="input-group mx-auto">

							<button class="btn btn-outline-secondary border-0" type="button" @click="restarKid()"><i class="icofont-minus"></i></button>

							<input type="text" class="form-control w-25 border-0 text-center text-muted" placeholder=" " @focusout="contarMinimoPersonas()" v-model="cantKids">

							<button class="btn btn-outline-secondary border-0" type="button" @click="sumarKid()"><i class="icofont-plus"></i></button>

						</div>

					</div>

				</div>

				<div class="row col mx-auto my-3 " v-if="!faltaMinimo">
					<div class="alert alert-warning " role="alert">
						La <strong>cantidad mínima</strong> de viajeros debe ser <strong>{{tourActivo.minimo}}</strong>
					</div>
				</div>
				<div class="row col mx-auto my-3 " v-if="!faltaAdulto">
					<div class="alert alert-warning " role="alert">
						Mínimo debe haber un <strong>adulto</strong>
					</div>
				</div>



				<div class="row col-7 mx-auto my-3">

					<select class="form-select" id="sltPais" @change="comprobarNacionalidad()" v-model="nacionalidad">

						<option value="-1">País o Nacionalidad</option>

						<option value="159">PERU</option>
						<option value="1">Afganistán</option>
						<option value="2">Albania</option>
						<option value="3">Algeria</option>
						<option value="4">American Samoa</option>
						<option value="5">Andorra</option>
						<option value="6">Angola</option>
						<option value="7">Anguilla</option>
						<option value="8">Antigua and Barbuda</option>
						<option value="9">Argentina</option>
						<option value="10">Armenia</option>
						<option value="11">Aruba</option>
						<option value="12">Australia</option>
						<option value="13">Austria</option>
						<option value="14">Azerbaijan</option>
						<option value="15">Bahamas</option>
						<option value="16">Bahrain</option>
						<option value="17">Bangladesh</option>
						<option value="18">Barbados</option>
						<option value="19">Belarus</option>
						<option value="20">Belgium</option>
						<option value="21">Belize</option>
						<option value="22">Benin</option>
						<option value="23">Bermuda</option>
						<option value="24">Bhutan</option>
						<option value="25">Bolivia</option>
						<option value="26">Bosnia and Herzegovina</option>
						<option value="27">Botswana</option>
						<option value="28">Brazil</option>
						<option value="29">Brunei Darussalam</option>
						<option value="30">Bulgaria</option>
						<option value="31">Burkina Faso</option>
						<option value="32">Burundi</option>
						<option value="33">Cambodia</option>
						<option value="34">Cameroon</option>
						<option value="35">Canada</option>
						<option value="36">Cape Verde</option>
						<option value="37">Cayman Islands</option>
						<option value="38">Central African Republic</option>
						<option value="39">Chad</option>
						<option value="40">Chile</option>
						<option value="41">China</option>
						<option value="42">Colombia</option>
						<option value="43">Comoros</option>
						<option value="44">Congo</option>
						<option value="45">Congo, the Democratic Republic of the</option>
						<option value="46">Cook Islands</option>
						<option value="47">Costa Rica</option>
						<option value="48">Cote D'Ivoire</option>
						<option value="49">Croatia</option>
						<option value="51">Cyprus</option>
						<option value="52">Czech Republic</option>
						<option value="53">Denmark</option>
						<option value="54">Djibouti</option>
						<option value="55">Dominica</option>
						<option value="56">Dominican Republic</option>
						<option value="57">Ecuador</option>
						<option value="58">Egypt</option>
						<option value="59">El Salvador</option>
						<option value="60">Equatorial Guinea</option>
						<option value="61">Eritrea</option>
						<option value="62">Estonia</option>
						<option value="63">Ethiopia</option>
						<option value="64">Falkland Islands (Malvinas)</option>
						<option value="65">Faroe Islands</option>
						<option value="66">Fiji</option>
						<option value="67">Finland</option>
						<option value="68">France</option>
						<option value="69">French Guiana</option>
						<option value="70">French Polynesia</option>
						<option value="71">Gabon</option>
						<option value="72">Gambia</option>
						<option value="73">Georgia</option>
						<option value="74">Germany</option>
						<option value="75">Ghana</option>
						<option value="76">Gibraltar</option>
						<option value="77">Greece</option>
						<option value="78">Greenland</option>
						<option value="79">Grenada</option>
						<option value="80">Guadeloupe</option>
						<option value="81">Guam</option>
						<option value="82">Guatemala</option>
						<option value="83">Guinea</option>
						<option value="84">Guinea-Bissau</option>
						<option value="85">Guyana</option>
						<option value="86">Haiti</option>
						<option value="87">Holy See (Vatican City State)</option>
						<option value="88">Honduras</option>
						<option value="89">Hong Kong</option>
						<option value="90">Hungary</option>
						<option value="91">Iceland</option>
						<option value="92">India</option>
						<option value="93">Indonesia</option>
						<option value="95">Iraq</option>
						<option value="96">Ireland</option>
						<option value="97">Israel</option>
						<option value="98">Italy</option>
						<option value="99">Jamaica</option>
						<option value="100">Japan</option>
						<option value="101">Jordan</option>
						<option value="102">Kazakhstan</option>
						<option value="103">Kenya</option>
						<option value="104">Kiribati</option>
						<option value="106">Korea, Republic of</option>
						<option value="107">Kuwait</option>
						<option value="108">Kyrgyzstan</option>
						<option value="109">Lao People's Democratic Republic</option>
						<option value="110">Latvia</option>
						<option value="111">Lebanon</option>
						<option value="112">Lesotho</option>
						<option value="113">Liberia</option>
						<option value="114">Libyan Arab Jamahiriya</option>
						<option value="115">Liechtenstein</option>
						<option value="116">Lithuania</option>
						<option value="117">Luxembourg</option>
						<option value="118">Macao</option>
						<option value="119">Macedonia, the Former Yugoslav Republic of</option>
						<option value="120">Madagascar</option>
						<option value="121">Malawi</option>
						<option value="122">Malaysia</option>
						<option value="123">Maldives</option>
						<option value="124">Mali</option>
						<option value="125">Malta</option>
						<option value="126">Marshall Islands</option>
						<option value="127">Martinique</option>
						<option value="128">Mauritania</option>
						<option value="129">Mauritius</option>
						<option value="130">Mexico</option>
						<option value="131">Micronesia, Federated States of</option>
						<option value="132">Moldova, Republic of</option>
						<option value="133">Monaco</option>
						<option value="134">Mongolia</option>
						<option value="135">Montserrat</option>
						<option value="136">Morocco</option>
						<option value="137">Mozambique</option>
						<option value="139">Namibia</option>
						<option value="140">Nauru</option>
						<option value="141">Nepal</option>
						<option value="142">Netherlands</option>
						<option value="143">Netherlands Antilles</option>
						<option value="144">New Caledonia</option>
						<option value="145">New Zealand</option>
						<option value="146">Nicaragua</option>
						<option value="147">Niger</option>
						<option value="148">Nigeria</option>
						<option value="149">Niue</option>
						<option value="150">Norfolk Island</option>
						<option value="151">Northern Mariana Islands</option>
						<option value="152">Norway</option>
						<option value="153">Oman</option>
						<option value="154">Pakistan</option>
						<option value="155">Palau</option>
						<option value="156">Panama</option>
						<option value="157">Papua New Guinea</option>
						<option value="158">Paraguay</option>
						<option value="160">Philippines</option>
						<option value="161">Pitcairn</option>
						<option value="162">Poland</option>
						<option value="163">Portugal</option>
						<option value="164">Puerto Rico</option>
						<option value="165">Qatar</option>
						<option value="166">Reunion</option>
						<option value="167">Romania</option>
						<option value="168">Russian Federation</option>
						<option value="169">Rwanda</option>
						<option value="170">Saint Helena</option>
						<option value="171">Saint Kitts and Nevis</option>
						<option value="172">Saint Lucia</option>
						<option value="173">Saint Pierre and Miquelon</option>
						<option value="174">Saint Vincent and the Grenadines</option>
						<option value="175">Samoa</option>
						<option value="176">San Marino</option>
						<option value="177">Sao Tome and Principe</option>
						<option value="178">Saudi Arabia</option>
						<option value="179">Senegal</option>
						<option value="180">Seychelles</option>
						<option value="181">Sierra Leone</option>
						<option value="182">Singapore</option>
						<option value="183">Slovakia</option>
						<option value="184">Slovenia</option>
						<option value="185">Solomon Islands</option>
						<option value="186">Somalia</option>
						<option value="187">South Africa</option>
						<option value="188">Spain</option>
						<option value="189">Sri Lanka</option>
						<option value="190">Sudan</option>
						<option value="191">Suriname</option>
						<option value="192">Svalbard and Jan Mayen</option>
						<option value="193">Swaziland</option>
						<option value="194">Sweden</option>
						<option value="195">Switzerland</option>
						<option value="197">Taiwan, Province of China</option>
						<option value="198">Tajikistan</option>
						<option value="199">Tanzania, United Republic of</option>
						<option value="200">Thailand</option>
						<option value="201">Togo</option>
						<option value="202">Tokelau</option>
						<option value="203">Tonga</option>
						<option value="204">Trinidad and Tobago</option>
						<option value="205">Tunisia</option>
						<option value="206">Turkey</option>
						<option value="207">Turkmenistan</option>
						<option value="208">Turks and Caicos Islands</option>
						<option value="209">Tuvalu</option>
						<option value="210">Uganda</option>
						<option value="211">Ukraine</option>
						<option value="212">United Arab Emirates</option>
						<option value="213">United Kingdom</option>
						<option value="214">United States</option>
						<option value="215">Uruguay</option>
						<option value="216">Uzbekistan</option>
						<option value="217">Vanuatu</option>
						<option value="218">Venezuela</option>
						<option value="219">Viet Nam</option>
						<option value="220">Virgin Islands, British</option>
						<option value="221">Virgin Islands, U.s.</option>
						<option value="222">Wallis and Futuna</option>
						<option value="223">Western Sahara</option>
						<option value="224">Yemen</option>
						<option value="225">Zambia</option>
						<option value="226">Zimbabwe</option>

					</select>

				</div>

				<div class="row col-7 mx-auto my-3">

					<select name="" id="" class="form-select">

						<option value="-1">Inicia {{horaLatam(tourActivo.hora).replace('pm', 'p.m.').replace('am', 'a.m.')}}</option>

					</select>

				</div>

				<div class=" ms-5 ps-3" id="divDuracion">

					<span><strong>Duración:</strong> {{queDura}}</span><br>

					<span><strong>Comprar:</strong> {{queAnticipa(tourActivo.anticipacion)}} antes del viaje</span><br>

					<span><strong>Mínimo de viajeros:</strong>

						<span v-if="tourActivo.minimo==1">1 viajero</span>

						<span v-else>{{tourActivo.minimo}} viajeros</span>

					</span>

					<br><br>

					<span><strong>Ciudad:</strong> {{tourActivo.destino}} - {{queDepa(tourActivo.departamento)}}</span><br>

					<span><strong>Actividades:</strong> {{tourActivo.actividad}} {{variasActividades(tourActivo.actividades)}}</span><br>

					<span><strong>Categorías:</strong> {{variasCategorias(tourActivo.categorias)}}</span><br>

				</div>

				<div class="row col mx-auto mt-3 mb-0 " v-if="faltaPais">

					<div class="alert alert-warning " role="alert">

						{{msjError}}

					</div>

				</div>



				<div class="row">

					<div class="col text-center">

						<span class='fs-2 text-muted'>Total: <strong style="color:#60696d" class="">S/ {{formatoMoneda(precioTotal)}}</strong></span>

					</div>

				</div>

				<div class="row">

					<div class="col-10 mx-auto d-grid">

						<button class="btn btn-danger rounded-pill" @click="reservar"><strong>RESERVAR AHORA</strong></button>

					</div>

				</div>

				<div class="row col">

					<img src="https://grupoeuroandino.com/app/render/images/tarjetas.png" alt="" class="img-fluid">

				</div>



				<div class="row my-3 ">

					<div class="col m-4 p-3 border rounded" id="divQuill">

						<?php

						require("../app/api/cargarPanel.php")



						?>



					</div>

				</div>

			</div>

		</div>



		<div class="row">

			<div class="col-12 col-md-8">

				<div class="my-3 p-4 border rounded">

					<div id="divRecomendaciones">

						<div class="titulo p-2 mb-3">

							<h3 class="my-1">Tours y paquetes turísticos similares:</h3>

						</div>

						<div class="carousel-wrapper">

							<div class=" my-2 owl-carousel owl-theme">

								<div class=" item" v-for="recomendado in recomendados" :key="recomendado.id">

									<a :href="'https://grupoeuroandino.com/tour/'+recomendado.url"><img :src="'https://grupoeuroandino.com/app/render/images/subidas/'+recomendado.foto" alt="" class="img-fluid"></a>

									<h5 class="mb-0 text-start">{{recomendado.titulo}}</h5>

									<p class="card-text mb-0 text-start"><i class="icofont-google-map"></i> <span class="text-capitalize"><strong>{{recomendado.destino}}, {{departamentos[recomendado.depa]}}</strong></span></p>

									<div class="text-start estrellas"><i class="icofont-star"></i><i class="icofont-star"></i><i class="icofont-star"></i><i class="icofont-star"></i><i class="icofont-star"></i></div>

									<div class="row row-cols-2">

										<div class="text-start">

											<span>{{queDuraRecomendado(recomendado.tipo, recomendado.duracion, recomendado.duracion2)}}</span>

										</div>

										<div class="text-end "><span class="precio2"><span class="monedita fs-6">S/</span> {{formatoMoneda(recomendado.precio)}}</span>
											<p class="precioAnt2 mb-0">S/ {{formatoMoneda(recomendado.oferta)}}</p>
										</div>

									</div>

								</div>

							</div>

						</div>

					</div>

				</div>

			</div>

		</div>



	</div>

	</div>



	</div>

	</div>

	<!-- Modal -->

	<div class="modal fade" id="modalAgenda" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

		<div class="modal-dialog modal-dialog-centered">

			<div class="modal-content">

				<div class="modal-body">

					<div class="d-flex justify-content-between">

						<h1 class="modal-title fs-5" id="exampleModalLabel">Horario de atención</h1>

						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

					</div>

					<p class=" mt-2 lead">Lunes a Domingo</p>

					<p>De 9:00 am - 1:00 pm</p>

					<p>De 3:00 am - 7:00 pm</p>



				</div>

			</div>

		</div>

	</div>



	<footer class="container-fluid pt-5 pb-5" id="pie">



		<div class="container">

			<div class=" row" style="margin-top: 8rem!important;">

				<div class="col-12 col-md-4">

					<a href=""><img src="https://grupoeuroandino.com/wp-content/uploads/2022/11/yape.png" alt=""></a>

				</div>

				<div class="col-12 col-md-4">

					<a href=""><img src="https://grupoeuroandino.com/images/pie2.png?v=1" alt=""></a>

				</div>

				<div class="col-12 col-md-4">

					<a href=""><img src="https://grupoeuroandino.com/images/form.png?v=1" alt="" style="margin-bottom: 1em;"></a>

					<form id="formulario">

						<input type="text" id="txtNombres1" placeholder="Nombres y Apellidos">

						<input type="email" id="txtCorreo1" placeholder="Ingresa tu Email">

						<button id="btnFormulario"><img src="https://grupoeuroandino.com/images/address-book-solid.svg" id="enviarMnj"> SUSCRIBIRME</button>

					</form>

					<p class="text-white pb-2" style="font-size: 18px;"><strong>REDES SOCIALES</strong></p>

					<div class="d-flex" style="margin-bottom: 1em;">

						<a href="https://www.facebook.com/grupoeuroandino/"><img src="https://grupoeuroandino.com/images/facebook.png" width="50" height="50"></a>

						<a href="https://twitter.com/grupoeuroandino/"><img src="https://grupoeuroandino.com/images/twitter.png" width="50" height="50" style="margin:0 5px;"></a>

						<a href="https://twitter.com/grupoeuroandino/"><img src="https://grupoeuroandino.com/images/instagram.png" width="50" height="50" style="margin:0 5px;"></a>

						<a href="https://www.youtube.com/channel/UCG31MOsbyOuHr6-LpH4Mkbw"><img src="https://grupoeuroandino.com/images/youtube.png" width="50" height="50" style="margin:0 5px;"></a>

						<a href="https://www.linkedin.com/in/grupo-euro-andino-426b81123/"><img src="https://grupoeuroandino.com/images/in.png" width="50" height="50" style="margin:0 5px;"></a>

						<a href="https://www.flickr.com/photos/193956460@N06/"><img src="https://grupoeuroandino.com/images/cua.png" width="50" height="50" style="margin:0 5px;"></a>

					</div>

					<div>

						<a href="https://grupoeuroandino.com/libro-de-reclamaciones/"><img src="https://grupoeuroandino.com/wp-content/uploads/elementor/thumbs/Libro-de-Reclamaciones-pqjdp1qustruv9u46xq03mwub2nazjop222m18a8h4.jpg" width="160" height="auto" style="margin-right:10px;"></a>

						<a href="http://consultasenlinea.mincetur.gob.pe/directoriodeserviciosturisticos/DirPrestadores/DirBusquedaPrincipal/AgenciaViajes?IdGrupo=2"><img src="https://grupoeuroandino.com/wp-content/uploads/elementor/thumbs/Agencia-de-viajes-y-Turismo-Registrada-pqjfqac5b415hhgbj3eivnkskvnvqjfs4jzl6doxns.jpg" width="160" height="auto"></a>

					</div>

				</div>

			</div>

		</div>



	</footer>







	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>



	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

	<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>



	<script src="https://grupoeuroandino.com/app/render/js/axios.min.js"></script>

	<script src="https://grupoeuroandino.com/app/render/js/moment.min.js"></script>

	<!-- extraído de https://fotorama.io/docs/4/dimensions/ -->

	<link href="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css" rel="stylesheet">

	<script src="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js"></script>

	<script src="https://grupoeuroandino.com/app/render/js/bootstrap-datepicker.min.js"></script>

	<script src="https://grupoeuroandino.com/app/render/js/bootstrap-datepicker.es.min.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.js" integrity="sha512-gY25nC63ddE0LcLPhxUJGFxa2GoIyA5FLym4UJqHDEMHjp8RET6Zn/SHo1sltt3WuVtqfyxECP38/daUc/WVEA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>





	<script>
		var datepicker = $.fn.datepicker.noConflict();

		$.fn.bootstrapDP = datepicker;

		/* $('#dtpFecha').datepicker({

	    language: "es",

	    keyboardNavigation: false,

	    todayHighlight: false,

	    datesDisabled: ['07/02/2022','06/02/2022', '05/02/2022', '04/02/2022', '03/02/2022', '02/02/2022', '01/02/2022','31/01/2022' ]

		});

		$(".prev").each(function(i) {$(".prev")[i].innerHTML = `<i class="icofont-rounded-left"></i>`})

		$(".next").each(function(i) {$(".next")[i].innerHTML = `<i class="icofont-rounded-right"></i>`}) */

		var app = new Vue({

			el: '#app',

			data() {

				return {

					idProducto: -1,

					//servidor: 'http://localhost/euroAndinoApi/',

					servidor: 'https://grupoeuroandino.com/app/api/',

					variosTours: [],
					tourActivo: [{
						incluye: '',
						noIncluye: '',
						peruanos: {
							adultos: 0,
							kids: 0
						},
						extranjeros: {
							adultos: 0,
							kids: 0
						},
						duracion: 0,
						notas: ''

					}],

					precioPorPersona: 0,
					cantAdultos: 0,
					cantKids: 0,

					duracion: [{
						clave: 1,
						valor: 'Half Day (Medio día)'
					}, {
						clave: 2,
						valor: 'Full Day (1 día)'
					}],

					duracionDias: [{
						clave: 1,
						valor: 'Half Day (Medio día)'
					}, {
						clave: 2,
						valor: 'Full Day (1 día)'
					}],

					duracionNoches: [{
						clave: 1,
						valor: '0 noches'
					}, {
						clave: 2,
						valor: '1 noche'
					}],

					anticipacion: [{
						clave: 1,
						valor: '12 horas'
					}, {
						clave: 2,
						valor: '24 horas'
					}],

					departamentos: ['Amazonas', 'Ancash', 'Apurimac', 'Arequipa', 'Ayacucho', 'Cajamarca', 'Cusco', 'El Callao', 'Huancavelica', 'Huánuco', 'Ica', 'Junín', 'La Libertad', 'Lambayeque', 'Lima', 'Loreto', 'Madre de Dios', 'Moquegua', 'Pasco', 'Piura', 'Puno', 'San Martín', 'Tacna', 'Tumbes', 'Ucayali'],

					diasMuertos: [],
					precioTotal: 0,
					nacionalidad: -1,
					faltaPais: false,
					msjError: '',
					verMas: false,

					incluidos: [],
					noIncluidos: [],
					faltaMinimo: true, faltaAdulto:true,
					recomendados: [],
					categorias2: [],
					actividades2: [],

					transportes: ['Terrestre', 'Aéreo', 'Ninguno'],

					hospedajes: ['Albergue', 'Apartment', 'Bungalow', 'Hostal *', 'Hostal **', 'Hostal ***', 'Hotel *', 'Hotel **', 'Hotel ***', 'Hotel ****', 'Hotel *****', 'Lodge', 'Resort', 'Otro']

				}

			},

			mounted() {

				//sacando el ID

				const queryString = window.location.search;

				const urlParams = new URLSearchParams(queryString);

				this.idProducto = '<?= $rowMeta['id']; ?>'

				//console.log( 'el id es ' + this.idProducto );

				this.cargarComplementos();

				this.pedirDatos();

			},

			methods: {

				async cargarComplementos() {

					let servComplementos = await fetch(this.servidor + 'pedirComplementos.php', {

						method: 'POST'

					})

					/* .done()

					.done(letra =>{

						console.log( letra );

					}); */

					let resServidor = await servComplementos

					resServidor.json().then((queVino) => {

						this.actividades2 = queVino[0];

						this.categorias2 = queVino[1];



						//Obtener el valor de lo seleccionado

						//$('#sltActividad2').selectpicker('val');

						//asignar valor

						//$('#sltActividad2').selectpicker('val', ['51', '53']);



					})

				},

				async pedirDatos() {

					var hoy = moment();

					const respuesta = await axios.post(this.servidor + 'verTourPorId.php', {
						id: this.idProducto
					});

					this.variosTours = respuesta.data[0];

					this.tourActivo = JSON.parse(this.variosTours.contenido);

					this.precioPorPersona = this.tourActivo.peruanos.adultos;

					//this.cantAdultos = this.tourActivo.minimo;

					$('.fotorama').fotorama();

					for (let dia = 2; dia <= 31; dia++) {

						this.duracion.push({
							clave: dia + 1,
							valor: dia + ' días / 0 noches'
						});

						this.duracionDias.push({
							clave: dia + 1,
							valor: dia + ' días'
						});

						this.duracionNoches.push({
							clave: dia + 1,
							valor: dia + ' noches'
						});

					}

					for (let dia = 2; dia <= 15; dia++) {

						this.anticipacion.push({
							clave: dia + 1,
							valor: dia + ' días'
						});

					}

					switch (this.tourActivo.anticipacion) {

						case "1":
							this.bloquearFechaDesde(hoy);
							break;

						case "2":
							this.bloquearFechaDesde(hoy.add(1, 'days'));
							break;

						default:
							this.bloquearFechaDesde(hoy.add(parseInt(this.tourActivo.anticipacion) - 1, 'days'));
							break;

					}

					this.incluidos = this.tourActivo.incluye.split('\n');

					this.noIncluidos = this.tourActivo.noIncluye.split('\n');

					const myTimeout = setTimeout(function() {

						$('.fotorama').fotorama();

					}, 500);



					let datos = new FormData();

					datos.append('tipo', this.tourActivo.tipo);

					datos.append('departamento', this.tourActivo.departamento);

					let respRecomendados = await fetch(this.servidor + 'pedirRecomendadosRandom.php', {

							method: 'POST',
							body: datos

						})

						.then(response => response.json())

						.then(data => {

							this.recomendados = data;

						}).then(() => {

							$(".owl-carousel").owlCarousel({

								autoplay: true,

								loop: true,
								margin: 20,
								dots: true,

								nav: true,

								navText: ["<div class='nav-button owl-prev'>‹</div>", "<div class='nav-button owl-next'>›</div>"],

								responsive: {

									0: {

										items: 1

									},

									600: {

										items: 3

									}

								}

							});

						});

					/* this.recomendados = await respRecomendados.json()

					.then(()=>{

					}); */



				},

				formatoMoneda(valor) {

					return parseFloat(valor).toFixed(2)

				},

				contarMinimoPersonas() {

					if (this.nacionalidad == 159 || this.nacionalidad == -1) {
						this.precioTotal = parseFloat(this.cantAdultos * this.tourActivo.peruanos.adultos) + parseFloat(this.cantKids * this.tourActivo.peruanos.kids);
					} else {
						this.precioTotal = parseFloat(this.cantAdultos * this.tourActivo.extranjeros.adultos) + parseFloat(this.cantKids * this.tourActivo.extranjeros.kids);

					}


					if(this.cantKids>0 && this.cantAdultos==0 ){
						this.msjError = "Se debe reservar como mínimo un adulto";
						return this.faltaAdulto = false;
					}
					else
						this.faltaAdulto=true;
						if ((this.cantAdultos + this.cantKids) < parseInt(this.tourActivo.minimo)) {
							this.faltaPais = true;
							this.msjError = "Debe rellenar el campo de su nacionalidad antes de reservar";
							return this.faltaMinimo = false;
						} else {
							this.faltaPais = false;
							return this.faltaMinimo = true;
						}
				},

				restarAdulto() {

					if (this.cantAdultos > 0) {

						this.cantAdultos--;
						this.contarMinimoPersonas();

					}

				},

				sumarAdulto() {

					this.cantAdultos++;
					this.contarMinimoPersonas();

				},

				restarKid() {

					if (this.cantKids > 0) {

						this.cantKids--;
						this.contarMinimoPersonas();

					}

				},

				sumarKid() {

					this.cantKids++;
					this.contarMinimoPersonas();

				},

				queAnticipa(valor) {

					if (valor != null) {

						return this.anticipacion[parseInt(valor) - 1].valor;

					}

				},

				variasActividades(queActividad) {

					console.log('es la acti', queActividad);

					var actividades = "";

					if (queActividad != undefined) {

						queActividad.forEach(actividad => {

							actividades += " " + this.actividades2.find(x => x.id === actividad).concepto + ",";

						});

						return actividades.substring(0, actividades.length - 1)

					} else {

						return '-';

					}

				},

				variasCategorias(queCategoria) {

					if (queCategoria != undefined) {

						var categorias = "";

						queCategoria.forEach(actividad => {

							categorias += " " + this.categorias2.find(x => x.id === actividad).concepto + ",";

						});

						return categorias.substring(0, categorias.length - 1)

					} else {

						return '-';

					}

				},

				bloquearFechaDesde(fechaInicial) {

					//console.log( fechaInicial.format('DD/MM/YYYY') );

					for (let index = 0; index <= 160; index++) {

						this.diasMuertos.push(moment(fechaInicial, 'DD/MM/YYYY').subtract(index, 'days').format('DD/MM/YYYY'));

					}

					console.log(this.diasMuertos);



					//$('#dtpFecha').datepicker('destroy');

					$('#dtpFecha').bootstrapDP({

						language: "es",

						keyboardNavigation: false,

						todayHighlight: true,

						datesDisabled: this.diasMuertos

					});



					$(".prev").each(function(i) {
						$(".prev")[i].innerHTML = `<i class="icofont-rounded-left"></i>`
					})

					$(".next").each(function(i) {
						$(".next")[i].innerHTML = `<i class="icofont-rounded-right"></i>`
					})





				},

				horaLatam(hora) {

					return (moment(hora, 'HH:mm').format('h:mm a'))

				},

				queDepa(valor) {

					return this.departamentos[valor];

				},

				reservar() {

					if ($('#dtpFecha').bootstrapDP('getFormattedDate') == null || $('#dtpFecha').bootstrapDP('getFormattedDate') == '') {

						this.faltaPais = true;
						this.msjError = "Debe seleccionar una fecha inicial";
						return false;

					} else if (this.comprobarNacionalidad() && this.contarMinimoPersonas()) {

						window.location.href = "/carrito-compras/?id=" + this.idProducto + "&adults=" + this.cantAdultos + "&kids=" + this.cantKids + "&nationality=" + this.nacionalidad + "&start=" + $('#dtpFecha').bootstrapDP('getFormattedDate');

					}

				},

				comprobarNacionalidad() {

					if (this.nacionalidad == -1) {

						this.faltaPais = true;
						this.msjError = "Debe rellenar el campo de su nacionalidad antes de reservar";
						return false;

					} else {

						this.faltaPais = false;

						return true;

					}

				},

				formatoMoneda(valor) {

					return parseFloat(valor).toFixed(2)

				},

				/* 	

				comprobarRequisitos(){

					if(this.nacionalidad==-1){

						this.faltaPais=true; this.msjError = "Debe rellenar el campo de su nacionalidad antes de reservar"; return false;

					}else if(!this.contarMinimoPersonas()){

						this.faltaPais=true; this.msjError = "Se debe completar un mínimo de personas"; return false;

					}else{

						this.faltaPais=false;

						return true;

					}

				} */

				queDuraRecomendado(tipo, queDuracion, queDuracion2) {

					try {

						if (tipo == '2') {

							queDuracion3 = JSON.parse(queDuracion2);

							//return 'caso 2';

							return this.duracionDias.find(x => x.clave === queDuracion).valor + " / " + this.duracionNoches[queDuracion2].valor;;

							//return this.duracionDias[parseInt(this.tourActivo.duracion.dias)].valor + ", " + this.duracionNoches[parseInt(this.tourActivo.duracion.noches)].valor;

						}

						if (tipo == '1') {

							return this.duracion[parseInt(queDuracion) - 1].valor

							//return this.duracion.find( x => x.clave === duracion ).valor;

						}

					} catch (error) {



					}

				},

				expandirMas() {

					this.verMas = true;

					let divNotas = document.getElementById('divNotas');

					divNotas.style.height = "100%";

					divNotas.style.overflow = auto;

				},

				entregarCorto(texto, corto) {



					if (corto && texto != undefined) {

						return texto.substring(0, 1600) + '...';

					} else {

						return texto;

					}

				},
				handler: function(e) {
					//do stuff
					e.preventDefault();
				}

			},

			computed: {

				queDura() {

					try {

						if (this.tourActivo.tipo == '2') {

							return this.duracionDias.find(x => x.clave === this.tourActivo.duracion.dias).valor + " / " + this.duracionNoches.find(x => x.clave === this.tourActivo.duracion.noches).valor;

							//return this.duracionDias[parseInt(this.tourActivo.duracion.dias)].valor + ", " + this.duracionNoches[parseInt(this.tourActivo.duracion.noches)].valor;

						} else {

							return this.duracion.find(x => x.clave === this.tourActivo.duracion).valor;

						}

					} catch (error) {



					}

				},

			},

		})



		$(document).ready(function() {

			const signupForm = document.querySelector("#btnFormulario");



			signupForm.addEventListener("click", async function(event) {

				event.preventDefault();

				var dato = new FormData();

				dato.append('txtNombres', document.getElementById('txtNombres1').value)

				dato.append('txtCorreo', document.getElementById('txtCorreo1').value)



				let respuesta = await fetch('https://grupoeuroandino.com/app/api/correo_suscribir.php', {

					method: 'POST',
					body: dato

				});

				console.log(await respuesta.text())



			});







		});
	</script>

</body>

=======
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	include ('/home/perutra1/public_html/WEBS/grupoeuroandino.com/app/api/conectkarl.php');
	$sqlMeta = $db->query("SELECT JSON_UNQUOTE(contenido-> '$.nombre') as titulo,
	JSON_UNQUOTE(contenido-> '$.descripcion') as descripcion,
	IFNULL(JSON_UNQUOTE(contenido-> '$.fotos[0].nombreRuta'), 'defecto.jpg')as foto
	FROM `tours` where id = {$_GET['id']};");
	if($sqlMeta->execute()){
		$row = $sqlMeta-> fetch(PDO::FETCH_ASSOC);
		?>
		<meta property="og:title" content="<?= $row['titulo']?> - Grupo Euro Andino">
		<title><?= $row['titulo']?> - Grupo Euro Andino</title>
		<meta property="og:image" content="https://grupoeuroandino.com/app/render/images/subidas/<?= $row['foto']?>">
		<meta property="og:description" content="<?= strip_tags($row['descripcion'])?>">
		<?php
	}
	?>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

	<link rel="stylesheet" href="https://grupoeuroandino.com/icofont/icofont.min.css">
	<link rel="stylesheet" href="https://grupoeuroandino.com/css/bootstrap-datepicker.min.css?v=1.1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css" integrity="sha512-UTNP5BXLIptsaj5WdKFrkFov94lDx+eBvbKyoe1YAfjeRPC+gT5kyZ10kOHCfNZqEui1sxmqvodNUx3KbuYI/A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css" integrity="sha512-OTcub78R3msOCtY3Tc6FzeDJ8N9qvQn1Ph49ou13xgA9VsH9+LRxoFU6EqLhW4+PKRfU+/HReXmSZXHEkpYoOA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
	


	<style>
	.datepicker{padding:0px!important;}
		.datepicker td, .datepicker th{
			width: 3rem!important;
   		    height: 2.4rem!important;
   		    padding: 6px 2px 0px 0px !important;
		}
		.datepicker-inline{
			width: 100%!important;
		}
		.datepicker table{
			margin: auto!important;
			border:none!important;
		}
		.datepicker .datepicker-days{
			border:none;
		}
		.datepicker table tr td.active.active{
			/* background-color: #2482e3!important; */background-image: none!important;
		}
		.datepicker table tr td.today, .datepicker table tr td.today.disabled, .datepicker table tr td.today.disabled:hover, .datepicker table tr td.today:hover,.datepicker table tr td.today.disabled,.datepicker table tr td.today.disabled
		{    background-color: #dc3545!important;}
		#divRecomendaciones img{
			width: 100%;
    	height: 170px;
    	object-fit: cover;
		}
		.dow{color:rgb(145 145 145)!important;}
		#divRecomendaciones .titulo{background-color: rgb(214, 214, 214); }
		#divIzquierda ul, ol{padding-left: 0!important;}
		p{margin-bottom: 0;}
		.ql-align-center{text-align: center!important;}
		#divQuill h5, #divQuill p{margin-bottom:0;}
		.estrellas {
			color: #ffd400;
		}
		.precio2 {
			font-size: 1.7rem;
			font-weight: bold;
		}
		.precioAnt2 {
			font-size: 0.8rem;
			text-decoration: line-through;
		}
		#divTransportes img{
			width: 60px;
		}
		.carousel-wrapper {
  /* width: 1000px; */
  margin: auto;
  position: relative;
  text-align: center;
  font-family: sans-serif;
}
.owl-carousel .owl-nav {
  overflow: hidden;
  height: 0px;
}
.owl-theme .owl-dots .owl-dot.active span,
.owl-theme .owl-dots .owl-dot:hover span {
  background: #5110e9;
}

.owl-carousel .item {
  text-align: center;
}
.owl-carousel .nav-button {
  height: 50px;
  width: 25px;
  cursor: pointer;
  position: absolute;
  top: 110px !important;
}
.owl-carousel .owl-prev.disabled,
.owl-carousel .owl-next.disabled {
  pointer-events: none;
  opacity: 0.25;
}
.owl-carousel .owl-prev {
  left: -35px;
}
.owl-carousel .owl-next {
  right: -35px;
}
.owl-theme .owl-nav [class*=owl-] {
  color: #ffffff;
  font-size: 39px;
  background: #000000;
  border-radius: 3px;
}
.owl-carousel .prev-carousel:hover {
  background-position: 0px -53px;
}
.owl-carousel .next-carousel:hover {
  background-position: -24px -53px;
}
.owl-theme .owl-nav [class*='owl-'] {
	margin: 0;
	padding: 0;
	display: table;
}
#divQuill img{
	max-width: 100%;
}
#menuVolver{
	background-image: url('https://grupoeuroandino.com/wp-content/uploads/2021/09/png-transparent-wood-texture-mapping-material-wood-texture-orange-wood-material.png');
	background-position: center left;	
}
#pie{
	background-color: #026EB6;
    background-image: url('https://grupoeuroandino.com/wp-content/uploads/2021/09/Footer.png');
    background-position: 0px 0vh;
    background-repeat: no-repeat;
    background-size: cover;
}
#ulMenu{
	padding: 0 5rem ;
}
#ulMenu>li{
	display: inline-block;
	width: 160px;
	padding: 1rem 0;
	text-align: center;
	color: white;
	font-size: 13px;
	font-weight: bold;
	text-decoration: none;
}
#ulMenu>li:hover{background: #BF9F00;cursor: pointer;}

.Ico{    margin: 0 0px 0 0;
	width: 33px;padding-right: 1rem;
}
#menuVolver, #menuCabecera{
	font-family: 'Roboto', sans-serif;
}
#imgLogo{width: 120px;}
#menuCabecera p{
	font-size: 13px; color: #7a7a7a;
	font-weight: 400;
}
#menuCabecera h3{
	font-size: 17px; color: #012c6d;
	font-weight: 600;
}
#menuCabecera a{text-decoration: none;}
#mLateral{
	position: fixed; /* Sit on top of the page content */
  display: none; 
  width: 300px; /* Full width (cover the whole page) */
  height: 100%; /* Full height (cover the whole page) */
  top: 0;
  left: 0;
  right: 50px;
  bottom: 0;
  background-color: #003793; /* Black background with opacity */
  z-index: 102; /* Specify a stack order in case you're using a different order for other elements */
  cursor: pointer; /* Add a pointer on hover */
}
#mLateralP{padding-top: 5em;}
#mLateral .Ico{
	width: 40px!important;
}
#mLateral p{
	font-family: 'Roboto', sans-serif;
	font-size: 16px!important;
	font-weight: 300!important;
	padding: 10px 10px 10px 10px;
	color: white;
	margin: 0.5em 0;
	padding: 1em 1em;
}
#mLateralP a{
	color: white;
	text-decoration: none;
}
#mLateralP p:first-child, #mLateralP p:hover{
	background-color: #743eff;
}

</style>
	<!-- Inicio de Encabezado -->

	<div class="container fluid d-block d-sm-none">
		<div class="row row-cols-3">
			<div class="col mx-0 px-1" style="width:114px">
				<a href="https://grupoeuroandino.com"><img src="https://grupoeuroandino.com/wp-content/uploads/2020/09/Grupo-Euro-Andino-2048x1795.png" style="width: 94%; height: auto; margin-left:8px;" class="img-fluid p-3"></a>
			</div>
			<div class="col d-flex align-items-center" style="width:216px">
				<div class="container-fluid px-0 mx-0">
					<div class="row row-cols-3 ">
						<div class="col">
							<a href="tel:064788975"><img src="https://grupoeuroandino.com/app/render/images/phone-solid.svg" class="p-1" width="38" height="38"></a>
						</div>
						<div class="col">
							<a href="https://wa.me/51947614293"><img src="https://grupoeuroandino.com/app/render/images/whatsapp.svg" class="p-1" width="42" height="42"></a>
						</div>
						<div class="col" data-bs-toggle="modal" data-bs-target="#modalAgenda"> <img src="https://grupoeuroandino.com/app/render/images/clock-regular.svg" class="p-1" width="42" height="42"> </div>
					</div>
				</div>
			</div>
			<div class="col d-flex " style="width:61px"  onclick="document.getElementById('mLateral').style.display = 'block';">
				<img src="https://grupoeuroandino.com/app/render/images/sliders-solid.svg?v=1" style="" width="36">
			</div>
		</div>
	</div>

	<div class="container my-3 d-none d-md-block" id="menuCabecera">
		<div class="row row-cols-5">
			<div class="col">
				<a href="https://grupoeuroandino.com"><img src="https://grupoeuroandino.com/wp-content/uploads/2020/09/Grupo-Euro-Andino-2048x1795.png" id="imgLogo"></a>
			</div>
			<div class="col position-relative d-flex align-items-center">
				<a href="tel:064788975">
					<div class="position-absolute top-50 start-0 translate-middle-y">
						<img src="https://grupoeuroandino.com/app/render/images/phone-solid-gris.svg" style="width:50px">
					</div>
					<div style="padding-left:55px">
						<h3>Call Center</h3>
						<p class="mb-0">(064) 788975</p>
					</div>
				</a>
			</div>
			<div class="col position-relative d-flex align-items-center">
				<a href="https://wa.me/51947614293">
					<div class="position-absolute top-50 start-0 translate-middle-y">
						<img src="https://grupoeuroandino.com/app/render/images/whatsapp-gris.svg" style="width:50px">
					</div>
					<div style="padding-left:55px">
						<h3>Chatea con nosotros</h3>
						<p class="mb-0">(+51) 947614293</p>
					</div>
				</a>
			</div>
			<div class="col position-relative d-flex align-items-center">
				<div class="position-absolute top-50 start-0 translate-middle-y">
					<img src="https://grupoeuroandino.com/app/render/images/clock-regular-gris.svg" style="width:50px">
				</div>
				<div style="padding-left:55px">
					<h3>Atención al cliente</h3>
					<p class="mb-0">24/7/365</p>
				</div>
			</div>
			<div class="col"></div>
		</div>

	</div>

	<div id="mLateral">
		<div class="text-end mt-2 me-1" onclick="document.getElementById('mLateral').style.display = 'none';">
			<img src="https://grupoeuroandino.com/app/render/images/x-1.svg" width="60" height="auto">
		</div>
		<div id="mLateralP">
			<p class="mb-0" onclick="location.href='https://grupoeuroandino.com/'"> <img src="https://grupoeuroandino.com/wp-content/uploads/2022/06/path245.png" class="Ico"> Inicio</p>
			<p class="mb-0" onclick="location.href='https://grupoeuroandino.com/peru-interno/'"> <img src="https://grupoeuroandino.com/wp-content/uploads/2022/06/peruico.png" class="Ico"> Destinos</p>
			<p class="mb-0" onclick="location.href='https://grupoeuroandino.com/store/'"> <img src="https://grupoeuroandino.com/wp-content/uploads/2022/06/bolsaico.png" class="Ico"> Tienda</p>
			<p class="mb-0" onclick="location.href='https://grupoeuroandino.com/store/'"> <img src="https://grupoeuroandino.com/wp-content/uploads/2022/06/ofertaico.png" class="Ico"> + Filtros</p>
			<p class="mb-0" onclick="location.href='https://grupoeuroandino-com.translate.goog/?_x_tr_sl=es&_x_tr_tl=en&_x_tr_hl=es&_x_tr_pto=wapp'"> <img src="https://grupoeuroandino.com/wp-content/uploads/2022/06/baneeuu.png" class="Ico"> Inglés</p>
			<p class="mb-0" onclick="location.href='https://grupoeuroandino.com/shop-cart/'"> <img src="https://grupoeuroandino.com/wp-content/uploads/2022/06/cart.png" class="Ico"> Carrito</p>
		</div>
	</div>

	<div class="container-fluid mb-2 d-none d-md-block" id="menuVolver">
		<div class="container">
			<ul id="ulMenu">
				<li onclick="location.href='https://grupoeuroandino.com/'"><img src="https://grupoeuroandino.com/wp-content/uploads/2022/06/path245.png" class="Ico"> INICIO</li>
				<li onclick="location.href='https://grupoeuroandino.com/peru-interno/'"><img src="https://grupoeuroandino.com/wp-content/uploads/2022/06/peruico.png" class="Ico"> DESTINOS</li>
				<li onclick="location.href='https://grupoeuroandino.com/store/'"><img src="https://grupoeuroandino.com/wp-content/uploads/2022/06/bolsaico.png" class="Ico"> TIENDA</li>
				<li onclick="location.href='https://grupoeuroandino.com/store/'"><img src="https://grupoeuroandino.com/wp-content/uploads/2022/06/ofertaico.png" class="Ico"> + FILTROS</li>
				<li onclick="location.href='https://grupoeuroandino-com.translate.goog/?_x_tr_sl=es&_x_tr_tl=en&_x_tr_hl=es&_x_tr_pto=wapp'"><img src="https://grupoeuroandino.com/wp-content/uploads/2022/06/baneeuu.png" class="Ico"> INGLÉS</li>
				<li onclick="location.href='https://grupoeuroandino.com/shop-cart/'"><img src="https://grupoeuroandino.com/wp-content/uploads/2022/06/cart.png" class="Ico"></li>
			</ul>
		</div>
	</div>

	<!-- Fin de Encabezado -->

	<div class="container" id="app">
		<div class="row">
			<div class="col-12 col-md-8">
				<div class="fotorama" data-nav="thumbs" data-width="100%">
					<img v-for="foto in tourActivo.fotos" :src="'https://grupoeuroandino.com/app/render/images/subidas/'+foto.nombreRuta">
					
				</div>

				<!-- Empieza el bloque de descripción -->
				<div class="my-3 p-4 border rounded" id="divIzquierda">
					<h2 class="text-danger text-capitalize">{{tourActivo.nombre}}</h2>
					<div class="row row-cols-3" v-if="tourActivo.tipo===2" id="divTransportes">
						<div class="col" v-if="tourActivo.transporte!='3'">
							<div class="d-flex justify-content-between">
								<div class="m-auto pe-2" >
									<img v-if="tourActivo.transporte==='2'" src="https://grupoeuroandino.com/app/render/images/vuelo.png" alt="">
									<img v-else  src="https://grupoeuroandino.com/app/render/images/carro.png" alt="">
								</div>
								<div class="text-start" >
									<h6 class="mb-1
									">Transporte</h6>
									<span>{{transportes[parseInt(tourActivo.transporte)-1]}}</span>
								</div>
							</div>
						</div>
						<div class="col">
							<div class="d-flex justify-content-between">
								<div class="m-auto ps-2">
									<img src="https://grupoeuroandino.com/app/render/images/hostal.png" alt="">
								</div >
								<div class="text-start">
									<h6 class="mb-1
									">Alojamiento</h6>
									<span>{{hospedajes[parseInt(tourActivo.alojamiento)-1]}}</span>
								</div>
							</div>
						</div>
					</div>
					<h4 class="mt-4 text-danger">Descripción</h4>
					<div v-html="tourActivo.descripcion"></div>
					<h4 class="mt-4 text-danger">Punto de Partida</h4>
					<div class="w-100 text-break" v-html="tourActivo.partida"></div>
					<h4 class="mt-4 text-danger">Itinerario</h4>
					<div class="w-100 text-break p-2" v-html="tourActivo.itinerario"></div>

					<h5 class="mt-3 text-danger">Incluye</h5>
					<div>
						<p class="ms-2 mb-0" v-for="cadena in incluidos"><i class="icofont-check-alt"></i> {{cadena}}</p>
					</div>

					<h5 class="mt-3 text-danger">No Incluye</h5>
					<div>
						<p class="ms-2 mb-0" v-for="cadena in noIncluidos"><i class="icofont-close-line"></i> {{cadena}}</p>
					</div>

					<h5 class="mt-3 text-danger">Notas</h5>
					<div  class="w-100 text-break p-2" id="divNotas" v-html="entregarCorto(tourActivo.notas, !verMas)"></div>
					<p @click="verMas = !verMas" >
						<a class="text-decoration-none" href="#!">
							<span v-if="!verMas">Ver más</span>
							<span v-else>Ver menos</span>
						</a>
					</p>

					

				</div>
			</div>
			<div class="col-12 col-md-4">
				<div class="row">
					<div class="col text-center bg-secondary bg-opacity-25 ">
						<span class="fs-1"><strong class="text-danger"><small class="fs-3">S/</small> {{precioPorPersona}}</strong> <small class="fs-5">por persona</small></span>
					</div>
				</div>
				<div class="row">
					<div class="col px-0">
						<div id="dtpFecha" data-date-format="dd/mm/yyyy"></div>
					</div>
				</div>
				<p class="fs-3 text-center text-muted mt-2">
					<span v-if="tourActivo.cupos==1">Úlimo cupo disponible</span>
					<span v-else>{{tourActivo.cupos}} cupos disponibles</span>
				</p>
				<div class="row container" id="divAdultos">
					<div class="col-5 ">
						<p v-if="tourActivo.tipo=='1'" class="text-muted text-end mb-0">Adultos</p>
						<p v-else class="text-muted mb-0">en hab. matrimonial, doble ó triple</p>
					</div>
					<div class="col-6 ms-3">
						<div class="input-group mx-auto">
							<button class="btn btn-outline-secondary border-0" type="button" @click='restarAdulto()'><i class="icofont-minus"></i></button>
							<input type="text" class="form-control w-25 border-0 text-center text-muted" placeholder=" " @focusout="contarMinimoPersonas()" v-model="cantAdultos">
							<button class="btn btn-outline-secondary border-0" type="button" @click="sumarAdulto()"><i class="icofont-plus"></i></button>
						</div>
					</div>
				</div>
				<div class="row container mt-2" id="divKids">
					<div class="col-5 ">
						<p v-if="tourActivo.tipo==1" class="text-muted text-end mb-0">Niños <br><small>(hasta 10 años)</small></p>
						<p v-else class="text-muted mb-0">en hab. simple <small class="text fst-italic">(1 persona por habitación)</small></p>
					</div>
					<div class="col-6 ms-3">
						<div class="input-group mx-auto">
							<button class="btn btn-outline-secondary border-0" type="button" @click="restarKid()"><i class="icofont-minus"></i></button>
							<input type="text" class="form-control w-25 border-0 text-center text-muted" placeholder=" " @focusout="contarMinimoPersonas()" v-model="cantKids">
							<button class="btn btn-outline-secondary border-0" type="button" @click="sumarKid()"><i class="icofont-plus"></i></button>
						</div>
					</div>
				</div>
				<div class="row col mx-auto my-3 " v-if="!faltaMinimo">
					<div class="alert alert-warning " role="alert">
						La <strong>cantidad mínima</strong> de viajeros debe ser <strong>{{tourActivo.minimo}}</strong>
					</div>
				</div>
				
				<div class="row col-7 mx-auto my-3">
					<select class="form-select" id="sltPais" @change="comprobarNacionalidad()" v-model="nacionalidad">
						<option value="-1">País o Nacionalidad</option>
						<option value="159">PERU</option><option value="1">Afganistán</option><option value="2">Albania</option><option value="3">Algeria</option><option value="4">American Samoa</option><option value="5">Andorra</option><option value="6">Angola</option><option value="7">Anguilla</option><option value="8">Antigua and Barbuda</option><option value="9">Argentina</option><option value="10">Armenia</option><option value="11">Aruba</option><option value="12">Australia</option><option value="13">Austria</option><option value="14">Azerbaijan</option><option value="15">Bahamas</option><option value="16">Bahrain</option><option value="17">Bangladesh</option><option value="18">Barbados</option><option value="19">Belarus</option><option value="20">Belgium</option><option value="21">Belize</option><option value="22">Benin</option><option value="23">Bermuda</option><option value="24">Bhutan</option><option value="25">Bolivia</option><option value="26">Bosnia and Herzegovina</option><option value="27">Botswana</option><option value="28">Brazil</option><option value="29">Brunei Darussalam</option><option value="30">Bulgaria</option><option value="31">Burkina Faso</option><option value="32">Burundi</option><option value="33">Cambodia</option><option value="34">Cameroon</option><option value="35">Canada</option><option value="36">Cape Verde</option><option value="37">Cayman Islands</option><option value="38">Central African Republic</option><option value="39">Chad</option><option value="40">Chile</option><option value="41">China</option><option value="42">Colombia</option><option value="43">Comoros</option><option value="44">Congo</option><option value="45">Congo, the Democratic Republic of the</option><option value="46">Cook Islands</option><option value="47">Costa Rica</option><option value="48">Cote D'Ivoire</option><option value="49">Croatia</option><option value="51">Cyprus</option><option value="52">Czech Republic</option><option value="53">Denmark</option><option value="54">Djibouti</option><option value="55">Dominica</option><option value="56">Dominican Republic</option><option value="57">Ecuador</option><option value="58">Egypt</option><option value="59">El Salvador</option><option value="60">Equatorial Guinea</option><option value="61">Eritrea</option><option value="62">Estonia</option><option value="63">Ethiopia</option><option value="64">Falkland Islands (Malvinas)</option><option value="65">Faroe Islands</option><option value="66">Fiji</option><option value="67">Finland</option><option value="68">France</option><option value="69">French Guiana</option><option value="70">French Polynesia</option><option value="71">Gabon</option><option value="72">Gambia</option><option value="73">Georgia</option><option value="74">Germany</option><option value="75">Ghana</option><option value="76">Gibraltar</option><option value="77">Greece</option><option value="78">Greenland</option><option value="79">Grenada</option><option value="80">Guadeloupe</option><option value="81">Guam</option><option value="82">Guatemala</option><option value="83">Guinea</option><option value="84">Guinea-Bissau</option><option value="85">Guyana</option><option value="86">Haiti</option><option value="87">Holy See (Vatican City State)</option><option value="88">Honduras</option><option value="89">Hong Kong</option><option value="90">Hungary</option><option value="91">Iceland</option><option value="92">India</option><option value="93">Indonesia</option><option value="95">Iraq</option><option value="96">Ireland</option><option value="97">Israel</option><option value="98">Italy</option><option value="99">Jamaica</option><option value="100">Japan</option><option value="101">Jordan</option><option value="102">Kazakhstan</option><option value="103">Kenya</option><option value="104">Kiribati</option><option value="106">Korea, Republic of</option><option value="107">Kuwait</option><option value="108">Kyrgyzstan</option><option value="109">Lao People's Democratic Republic</option><option value="110">Latvia</option><option value="111">Lebanon</option><option value="112">Lesotho</option><option value="113">Liberia</option><option value="114">Libyan Arab Jamahiriya</option><option value="115">Liechtenstein</option><option value="116">Lithuania</option><option value="117">Luxembourg</option><option value="118">Macao</option><option value="119">Macedonia, the Former Yugoslav Republic of</option><option value="120">Madagascar</option><option value="121">Malawi</option><option value="122">Malaysia</option><option value="123">Maldives</option><option value="124">Mali</option><option value="125">Malta</option><option value="126">Marshall Islands</option><option value="127">Martinique</option><option value="128">Mauritania</option><option value="129">Mauritius</option><option value="130">Mexico</option><option value="131">Micronesia, Federated States of</option><option value="132">Moldova, Republic of</option><option value="133">Monaco</option><option value="134">Mongolia</option><option value="135">Montserrat</option><option value="136">Morocco</option><option value="137">Mozambique</option><option value="139">Namibia</option><option value="140">Nauru</option><option value="141">Nepal</option><option value="142">Netherlands</option><option value="143">Netherlands Antilles</option><option value="144">New Caledonia</option><option value="145">New Zealand</option><option value="146">Nicaragua</option><option value="147">Niger</option><option value="148">Nigeria</option><option value="149">Niue</option><option value="150">Norfolk Island</option><option value="151">Northern Mariana Islands</option><option value="152">Norway</option><option value="153">Oman</option><option value="154">Pakistan</option><option value="155">Palau</option><option value="156">Panama</option><option value="157">Papua New Guinea</option><option value="158">Paraguay</option><option value="160">Philippines</option><option value="161">Pitcairn</option><option value="162">Poland</option><option value="163">Portugal</option><option value="164">Puerto Rico</option><option value="165">Qatar</option><option value="166">Reunion</option><option value="167">Romania</option><option value="168">Russian Federation</option><option value="169">Rwanda</option><option value="170">Saint Helena</option><option value="171">Saint Kitts and Nevis</option><option value="172">Saint Lucia</option><option value="173">Saint Pierre and Miquelon</option><option value="174">Saint Vincent and the Grenadines</option><option value="175">Samoa</option><option value="176">San Marino</option><option value="177">Sao Tome and Principe</option><option value="178">Saudi Arabia</option><option value="179">Senegal</option><option value="180">Seychelles</option><option value="181">Sierra Leone</option><option value="182">Singapore</option><option value="183">Slovakia</option><option value="184">Slovenia</option><option value="185">Solomon Islands</option><option value="186">Somalia</option><option value="187">South Africa</option><option value="188">Spain</option><option value="189">Sri Lanka</option><option value="190">Sudan</option><option value="191">Suriname</option><option value="192">Svalbard and Jan Mayen</option><option value="193">Swaziland</option><option value="194">Sweden</option><option value="195">Switzerland</option><option value="197">Taiwan, Province of China</option><option value="198">Tajikistan</option><option value="199">Tanzania, United Republic of</option><option value="200">Thailand</option><option value="201">Togo</option><option value="202">Tokelau</option><option value="203">Tonga</option><option value="204">Trinidad and Tobago</option><option value="205">Tunisia</option><option value="206">Turkey</option><option value="207">Turkmenistan</option><option value="208">Turks and Caicos Islands</option><option value="209">Tuvalu</option><option value="210">Uganda</option><option value="211">Ukraine</option><option value="212">United Arab Emirates</option><option value="213">United Kingdom</option><option value="214">United States</option><option value="215">Uruguay</option><option value="216">Uzbekistan</option><option value="217">Vanuatu</option><option value="218">Venezuela</option><option value="219">Viet Nam</option><option value="220">Virgin Islands, British</option><option value="221">Virgin Islands, U.s.</option><option value="222">Wallis and Futuna</option><option value="223">Western Sahara</option><option value="224">Yemen</option><option value="225">Zambia</option><option value="226">Zimbabwe</option>
					</select>
				</div>
				<div class="row col-7 mx-auto my-3">
					<select name="" id="" class="form-select">
						<option value="-1">Inicia {{horaLatam(tourActivo.hora).replace('pm', 'p.m.').replace('am', 'a.m.')}}</option>
					</select>
				</div>
				<div class=" ms-5 ps-3" id="divDuracion">
					<span><strong>Duración:</strong> {{queDura}}</span><br>
					<span><strong>Comprar:</strong> {{queAnticipa(tourActivo.anticipacion)}} antes del viaje</span><br>
					<span><strong>Mínimo de viajeros:</strong> 
						<span v-if="tourActivo.minimo==1">1 viajero</span>
						<span v-else>{{tourActivo.minimo}} viajeros</span>
					</span>
					<br><br>
					<span><strong>Ciudad:</strong> {{tourActivo.destino}} - {{queDepa(tourActivo.departamento)}}</span><br>
					<span><strong>Actividades:</strong> {{tourActivo.actividad}} {{variasActividades(tourActivo.actividades)}}</span><br>
					<span><strong>Categorías:</strong> {{variasCategorias(tourActivo.categorias)}}</span><br>
				</div>
				<div class="row col mx-auto mt-3 mb-0 " v-if="faltaPais">
					<div class="alert alert-warning " role="alert">
						{{msjError}}
					</div>
				</div>
				
				<div class="row">
					<div class="col text-center">
						<span class='fs-2 text-muted'>Total: <strong style="color:#60696d" class="">S/ {{formatoMoneda(precioTotal)}}</strong></span>
					</div>
				</div>
				<div class="row">
					<div class="col-10 mx-auto d-grid">
						<button class="btn btn-danger rounded-pill" @click="reservar"><strong>RESERVAR AHORA</strong></button>
					</div>
				</div>
				<div class="row col">
					<img src="https://grupoeuroandino.com/app/render/images/tarjetas.png" alt="" class="img-fluid">
				</div>

				<div class="row my-3 ">
					<div class="col m-4 p-3 border rounded" id="divQuill">
						<?php
							include realpath(__DIR__."/app/api/cargarPanel.php");
						?>
							
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-12 col-md-8">
				<div class="my-3 p-4 border rounded">
					<div id="divRecomendaciones">
						<div class="titulo p-2 mb-3">
							<h3 class="my-1">Tours y paquetes turísticos similares:</h3>
						</div>
							<div class="carousel-wrapper">
								<div class=" my-2 owl-carousel owl-theme">
									<div class=" item" v-for="recomendado in recomendados" :key="recomendado.id">
										<a :href="'https://grupoeuroandino.com/viaje.php?id='+recomendado.id"><img :src="'https://grupoeuroandino.com/app/render/images/subidas/'+recomendado.foto" alt="" class="img-fluid"></a>
										<h5 class="mb-0 text-start">{{recomendado.titulo}}</h5>
										<p class="card-text mb-0 text-start"><i class="icofont-google-map"></i> <span class="text-capitalize"><strong>{{recomendado.destino}}, {{departamentos[recomendado.depa]}}</strong></span></p>
										<div class="text-start estrellas"><i class="icofont-star"></i><i class="icofont-star"></i><i class="icofont-star"></i><i class="icofont-star"></i><i class="icofont-star"></i></div>
										<div class="row row-cols-2">
											<div class="text-start">
												<span>{{queDuraRecomendado(recomendado.tipo, recomendado.duracion, recomendado.duracion2)}}</span>
											</div>
											<div class="text-end "><span class="precio2"><span class="monedita fs-6">S/</span> {{formatoMoneda(recomendado.precio)}}</span> <p class="precioAnt2 mb-0">S/ {{formatoMoneda(recomendado.oferta)}}</p></div>
										</div>
									</div>
								</div>
							</div>
					</div>
				</div>
			</div>
		</div>

	</div>
	</div>

</div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalAgenda" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
				<div class="d-flex justify-content-between">
					<h1 class="modal-title fs-5" id="exampleModalLabel">Horario de atención</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<p class=" mt-2 lead">Lunes a Domingo</p>
				<p >De 9:00 am - 1:00 pm</p>
				<p>De 3:00 am - 7:00 pm</p>
				
      </div>
    </div>
  </div>
</div>

	<footer class="container-fluid pt-5"  id="pie">

			<div class="container">
				<div class=" row" style="margin-top: 8rem!important;">
					<div class="col-12 col-md-4">
						<a href=""><img src="https://grupoeuroandino.com/wp-content/uploads/2022/09/pie1.png" alt=""></a>
					</div>
					<div class="col-12 col-md-4">
						<a href="http://consultasenlinea.mincetur.gob.pe/set-regiones/(S(10qphogewbrx3wgqzxz0myve))/Reportes/WebReportes/RptListadoCoincidencias.aspx?StrTipo=1&Var=02|20568390629|GRUPO%20EURO%20ANDINO%20S.A.C.||"><img src="https://grupoeuroandino.com/wp-content/uploads/2022/09/pie2.png" alt=""></a>
					</div>
					<div class="col-12 col-md-4">
						<a href=""><img src="https://grupoeuroandino.com/wp-content/uploads/2022/09/pie3.png" alt=""></a>
						<div class="container-fluid">
							<div class="row row-cols-2">
								<div class="col">
									<img src="https://grupoeuroandino.com/app/render/images/reclamos.jpg" alt="">
								</div>
								<div class="col">
									<img src="https://grupoeuroandino.com/app/render/images/protegeme.jpg" alt="">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

	</footer>

	
	
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
	
	<script src="https://grupoeuroandino.com/app/render/js/axios.min.js"></script>
	<script src="https://grupoeuroandino.com/app/render/js/moment.min.js"></script>
	<!-- extraído de https://fotorama.io/docs/4/dimensions/ -->
	<link  href="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css" rel="stylesheet">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js"></script>
	<script src="https://grupoeuroandino.com/app/render/js/bootstrap-datepicker.min.js"></script>
	<script src="https://grupoeuroandino.com/app/render/js/bootstrap-datepicker.es.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.js" integrity="sha512-gY25nC63ddE0LcLPhxUJGFxa2GoIyA5FLym4UJqHDEMHjp8RET6Zn/SHo1sltt3WuVtqfyxECP38/daUc/WVEA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


	<script>
var datepicker = $.fn.datepicker.noConflict();
$.fn.bootstrapDP = datepicker;
		/* $('#dtpFecha').datepicker({
	    language: "es",
	    keyboardNavigation: false,
	    todayHighlight: false,
	    datesDisabled: ['07/02/2022','06/02/2022', '05/02/2022', '04/02/2022', '03/02/2022', '02/02/2022', '01/02/2022','31/01/2022' ]
		});
		$(".prev").each(function(i) {$(".prev")[i].innerHTML = `<i class="icofont-rounded-left"></i>`})
		$(".next").each(function(i) {$(".next")[i].innerHTML = `<i class="icofont-rounded-right"></i>`}) */
	var app = new Vue({
		el: '#app',
		data(){
			return {
				idProducto:-1,
				//servidor: 'http://localhost/euroAndinoApi/',
				servidor: 'https://grupoeuroandino.com/app/api/',
				variosTours:[], tourActivo:[{incluye:'', noIncluye:'', peruanos:{adultos:0, kids:0}, extranjeros:{adultos:0, kids:0}, duracion:0, notas:''
			}],
				precioPorPersona: 0, cantAdultos:0, cantKids:0,
				duracion: [{clave: 1, valor: 'Half Day (Medio día)'}, {clave: 2, valor: 'Full Day (1 día)'} ],
				duracionDias: [{clave: 1, valor: 'Half Day (Medio día)'}, {clave: 2, valor: 'Full Day (1 día)'} ],
				duracionNoches:[{clave: 1, valor:'0 noches'}, {clave: 2, valor:'1 noche'}],
				anticipacion: [{clave: 1, valor: '12 horas'}, {clave: 2, valor: '24 horas'} ],
				departamentos:['Amazonas', 'Ancash', 'Apurimac', 'Arequipa', 'Ayacucho', 'Cajamarca', 'Cusco', 'El Callao', 'Huancavelica','Huánuco', 'Ica', 'Junín', 'La Libertad', 'Lambayeque', 'Lima', 'Loreto', 'Madre de Dios', 'Moquegua', 'Pasco', 'Piura', 'Puno','San Martín', 'Tacna', 'Tumbes', 'Ucayali' ],
				diasMuertos:[], precioTotal:0, nacionalidad:-1, faltaPais:false, msjError:'', verMas:false,
				incluidos:[], noIncluidos:[], faltaMinimo:true, recomendados:[],categorias2:[], actividades2:[],
				transportes:['Terrestre', 'Aéreo', 'Ninguno'],
				hospedajes:['Albergue', 'Apartment', 'Bungalow', 'Hostal *', 'Hostal **', 'Hostal ***', 'Hotel *', 'Hotel **', 'Hotel ***', 'Hotel ****', 'Hotel *****', 'Lodge','Resort','Otro']
			}
		},
		mounted(){
			//sacando el ID
			const queryString = window.location.search;
			const urlParams = new URLSearchParams(queryString);
			this.idProducto = urlParams.get('id')
			//console.log( 'el id es ' + this.idProducto );
			this.cargarComplementos();
			this.pedirDatos();
		},
		methods: {
			async cargarComplementos(){
				let servComplementos  = await fetch(this.servidor+'pedirComplementos.php',{
					method:'POST'
				})
				/* .done()
				.done(letra =>{
					console.log( letra );
				}); */
				let resServidor = await servComplementos
				 resServidor.json().then((queVino)=>{
					this.actividades2  = queVino[0];
					this.categorias2  = queVino[1];
					
					//Obtener el valor de lo seleccionado
					//$('#sltActividad2').selectpicker('val');
					//asignar valor
					//$('#sltActividad2').selectpicker('val', ['51', '53']);
					
				}) 
			},
			async pedirDatos(){
				var hoy= moment();
				const respuesta = await axios.post( this.servidor + 'verTourPorId.php', {id: this.idProducto});
				this.variosTours=respuesta.data[0];
				this.tourActivo = JSON.parse(this.variosTours.contenido);
				this.precioPorPersona = this.tourActivo.peruanos.adultos;
				//this.cantAdultos = this.tourActivo.minimo;
				$('.fotorama').fotorama();
				for (let dia = 2; dia <= 31; dia++) {
					this.duracion.push({ clave: dia+1, valor: dia + ' días / 0 noches' });
					this.duracionDias.push({ clave: dia+1, valor: dia + ' días' });
					this.duracionNoches.push({ clave: dia+1, valor: dia + ' noches' });
				}
				for (let dia = 2; dia <= 15; dia++) {
					this.anticipacion.push({ clave: dia+1, valor: dia + ' días' });
				}
				switch(this.tourActivo.anticipacion){
					case "1": this.bloquearFechaDesde( hoy ); break;
					case "2": this.bloquearFechaDesde( hoy.add(1,'days') ); break;
					default: this.bloquearFechaDesde( hoy.add( parseInt(this.tourActivo.anticipacion)-1 ,'days') ); break;
				}
				this.incluidos=this.tourActivo.incluye.split('\n');
				this.noIncluidos=this.tourActivo.noIncluye.split('\n');
				const myTimeout = setTimeout(function(){
					$('.fotorama').fotorama();
				}, 500);

				let datos = new FormData();
				datos.append('tipo', this.tourActivo.tipo);
				datos.append('departamento', this.tourActivo.departamento);
				let respRecomendados = await fetch(this.servidor+'pedirRecomendadosRandom.php',{
					method:'POST', body:datos
				})
				.then( response => response.json())
				.then(data => {
					this.recomendados = data;
				}).then( ()=>{
					$(".owl-carousel").owlCarousel({
						autoplay:true,
						loop:true, margin:20, dots: true,
						nav: true,
						navText: ["<div class='nav-button owl-prev'>‹</div>", "<div class='nav-button owl-next'>›</div>"],
						responsive:{
							0:{
								items:1
							},
							600:{
								items: 3
							}
						}
					});
				});
				/* this.recomendados = await respRecomendados.json()
				.then(()=>{
				}); */
				
			},
			formatoMoneda(valor){
				return parseFloat(valor).toFixed(2)
			},
			contarMinimoPersonas(){
				if(this.nacionalidad==159 || this.nacionalidad==-1){
					this.precioTotal = parseFloat(this.cantAdultos * this.tourActivo.peruanos.adultos) + parseFloat(this.cantKids * this.tourActivo.peruanos.kids) ;
				}else{
					this.precioTotal = parseFloat(this.cantAdultos * this.tourActivo.extranjeros.adultos) + parseFloat(this.cantKids * this.tourActivo.extranjeros.kids) ;
				}
				
				if((this.cantAdultos + this.cantKids) < parseInt(this.tourActivo.minimo)){
					return this.faltaMinimo=false;
					this.faltaPais=true; this.msjError = "Debe rellenar el campo de su nacionalidad antes de reservar";
				}else{
					return this.faltaMinimo=true;
					this.faltaPais=false;
				}
				
				
			},
			restarAdulto(){
				if(this.cantAdultos>0){
					this.cantAdultos--; this.contarMinimoPersonas();
				}
			},
			sumarAdulto(){
				this.cantAdultos++; this.contarMinimoPersonas();
			},
			restarKid(){
				if(this.cantKids>0){
					this.cantKids--; this.contarMinimoPersonas();
				}
			},
			sumarKid(){
				this.cantKids++; this.contarMinimoPersonas();
			},
			queAnticipa(valor){ 
				if(valor!=null){
					return this.anticipacion[parseInt(valor)-1].valor;
				}
			},
			variasActividades(queActividad){
				console.log('es la acti', queActividad);
				var actividades = "";
				if(queActividad != undefined){
					queActividad.forEach(actividad =>{
						actividades += " " + this.actividades2.find(x=> x.id === actividad ).concepto+",";
					});
					return actividades.substring(0, actividades.length-1)
				}else{
					return '-';
				}
			},
			variasCategorias( queCategoria ){
				if( queCategoria != undefined){
					var categorias = "";
					queCategoria.forEach(actividad =>{
						categorias += " " + this.categorias2.find(x=> x.id === actividad ).concepto+",";
					});
					return categorias.substring(0, categorias.length-1)
				}else{
					return '-';
				}
			},
			bloquearFechaDesde(fechaInicial){
				//console.log( fechaInicial.format('DD/MM/YYYY') );
				for (let index = 0; index <= 160; index++) {
					this.diasMuertos.push(  moment(fechaInicial, 'DD/MM/YYYY').subtract(index,'days').format('DD/MM/YYYY') );
				}
				console.log( this.diasMuertos );
				
				//$('#dtpFecha').datepicker('destroy');
				$('#dtpFecha').bootstrapDP({
			    language: "es",
			    keyboardNavigation: false,
			    todayHighlight: true,
			    datesDisabled: this.diasMuertos
				});

				$(".prev").each(function(i) {$(".prev")[i].innerHTML = `<i class="icofont-rounded-left"></i>`})
				$(".next").each(function(i) {$(".next")[i].innerHTML = `<i class="icofont-rounded-right"></i>`})
				
				
			},
			horaLatam(hora){
				return( moment(hora, 'HH:mm').format('h:mm a') )
			},
			queDepa(valor){
				return this.departamentos[valor];
			},
			reservar(){
				if($('#dtpFecha').bootstrapDP('getFormattedDate')==null || $('#dtpFecha').bootstrapDP('getFormattedDate')==''){
					this.faltaPais=true; this.msjError = "Debe seleccionar una fecha inicial"; return false;
				}else if(this.comprobarNacionalidad() && this.contarMinimoPersonas()){
					window.location.href="/carrito-compras/?id="+this.idProducto+"&adults="+this.cantAdultos+"&kids="+this.cantKids+"&nationality="+this.nacionalidad+"&start="+$('#dtpFecha').bootstrapDP('getFormattedDate');
				}
			},
			comprobarNacionalidad(){
				if(this.nacionalidad==-1){
					this.faltaPais=true; this.msjError = "Debe rellenar el campo de su nacionalidad antes de reservar"; return false;
				}else{
					this.faltaPais=false;
					return true;
				}
			},
			formatoMoneda(valor){
				return parseFloat(valor).toFixed(2)
			},
			/* 	
			comprobarRequisitos(){
				if(this.nacionalidad==-1){
					this.faltaPais=true; this.msjError = "Debe rellenar el campo de su nacionalidad antes de reservar"; return false;
				}else if(!this.contarMinimoPersonas()){
					this.faltaPais=true; this.msjError = "Se debe completar un mínimo de personas"; return false;
				}else{
					this.faltaPais=false;
					return true;
				}
			} */
			queDuraRecomendado(tipo, queDuracion, queDuracion2){
				try {
					if(tipo=='2'){
						queDuracion3 = JSON.parse(queDuracion2);
						//return 'caso 2';
						return this.duracionDias.find( x => x.clave === queDuracion ).valor + " / " + this.duracionNoches[queDuracion2].valor;;
						//return this.duracionDias[parseInt(this.tourActivo.duracion.dias)].valor + ", " + this.duracionNoches[parseInt(this.tourActivo.duracion.noches)].valor;
					}
					if(tipo=='1'){
						return this.duracion[ parseInt(queDuracion)-1 ].valor
						//return this.duracion.find( x => x.clave === duracion ).valor;
					}
				} catch (error) {
					
				}
			},
			expandirMas(){
				this.verMas=true;
				let divNotas = document.getElementById('divNotas');
				divNotas.style.height = "100%";
				divNotas.style.overflow = auto;
			},
			entregarCorto(texto, corto){
				
					if(corto && texto != undefined ){
						return texto.substring(0, 1600)+'...';
					}else{
						return texto;
					}
			}
		},
		computed:{
			queDura(){
				try {
					if(this.tourActivo.tipo=='2'){
						return this.duracionDias.find( x => x.clave === this.tourActivo.duracion.dias ).valor + " / " + this.duracionNoches.find( x => x.clave === this.tourActivo.duracion.noches ).valor;
						//return this.duracionDias[parseInt(this.tourActivo.duracion.dias)].valor + ", " + this.duracionNoches[parseInt(this.tourActivo.duracion.noches)].valor;
					}else{
						return this.duracion.find( x => x.clave === this.tourActivo.duracion ).valor;
					}
				} catch (error) {
					
				}
			},	
		},
	})
	</script>
</body>
>>>>>>> 1b5f9020bf7ace8daa2a5a0c4fc61e5d557cff86
</html>