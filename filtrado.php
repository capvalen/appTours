<?php

//var_dump($_GET); die();

if (isset($_GET['id'])) { $idDepartamento = $_GET['id']-1; } else { $idDepartamento = -1; }

if (isset($_GET['idTipo'])) { $idTipo = $_GET['idTipo']; } else { $idTipo = -1; }

$departamentos = ['Amazonas', 'Ancash', 'Apurimac', 'Arequipa', 'Ayacucho', 'Cajamarca', 'Cusco', 'Callao', 'Huancavelica','Huánuco', 'Ica', 'Junín', 'La Libertad', 'Lambayeque', 'Lima', 'Loreto', 'Madre de Dios', 'Moquegua', 'Pasco', 'Piura', 'Puno','San Martín', 'Tacna', 'Tumbes', 'Ucayali' ];
$departamentosUrl = ['amazonas', 'ancash', 'apurimac', 'arequipa', 'ayacucho', 'cajamarca', 'cusco', 'callao', 'huancavelica','huanuco', 'ica', 'junin', 'la-libertad', 'lambayeque', 'lima', 'loreto', 'madre-de-dios', 'moquegua', 'pasco', 'piura', 'puno','san-martin', 'tacna', 'tumbes', 'ucayali' ];
$descripcion = ['Reserva online Paquetes y Tours de Amazonas. Destinos y Actividades en Amazonas. Lugares, festividades, ciudades y pueblos de Amazonas', 'Reserva online Paquetes y Tours de Áncash. Destinos y Actividades en Áncash. Lugares, festividades, playas, ciudades y pueblos de Áncash', 'Reserva online Paquetes y Tours de Apurímac. Destinos y Actividades en Apurímac. Lugares, festividades, ciudades y pueblos de Apurímac', 'Reserva online Paquetes y Tours de Apurímac. Destinos y Actividades en Apurímac. Lugares, festividades, ciudades y pueblos de Apurímac', 'Reserva online Paquetes y Tours de Ayacucho. Destinos y Actividades en Ayacucho. Lugares, festividades, ciudades y pueblos de Ayacucho', 'Reserva online Paquetes y Tours de Cajamarca. Destinos y Actividades en Cajamarca. Lugares, festividades, ciudades y pueblos de Cajamarca', 'Reserva online Paquetes y Tours de Cusco. Destinos y Actividades en Cusco. Lugares, festividades, ciudades y pueblos de Cusco', 'Reserva online Paquetes y Tours del Callao. Destinos y Actividades en el Callao. Lugares, festividades, playas, ciudades y pueblos del Callao', 'Reserva online Paquetes y Tours de Huancavelica. Destinos y Actividades en Huancavelica. Lugares, festividades, ciudades y pueblos de Huancavelica','Reserva online Paquetes y Tours de Huánuco. Destinos y Actividades en Huánuco. Lugares, festividades, ciudades y pueblos de Huánuco', 'Reserva online Paquetes y Tours de Ica. Destinos y Actividades en Ica. Lugares, festividades, playas, ciudades y pueblos de Ica', 'Reserva online Paquetes y Tours de Junín. Destinos y Actividades en Junín. Lugares, festividades, ciudades y pueblos de Junín', 'Reserva online Paquetes y Tours de La Libertad. Destinos y Actividades en La Libertad. Lugares, festividades, playas, ciudades y pueblos de La Libertad', 'Reserva online Paquetes y Tours de Lambayeque. Destinos y Actividades en Lambayeque. Lugares, festividades, playas, ciudades y pueblos de Lambayeque', 'Reserva online Paquetes y Tours de Lima. Destinos y Actividades en Lima. Lugares, festividades, playas, ciudades y pueblos de Lima', 'Reserva online Paquetes y Tours de Loreto. Destinos y Actividades en Loreto. Lugares, festividades, ciudades y pueblos de Loreto', 'Reserva online Paquetes y Tours de Madre de Dios. Destinos y Actividades en Madre de Dios. Lugares, festividades, ciudades y pueblos de Madre de Dios', 'Reserva online Paquetes y Tours de Madre de Dios. Destinos y Actividades en Madre de Dios. Lugares, festividades, ciudades y pueblos de Madre de Dios', 'Reserva online Paquetes y Tours de Pasco. Destinos y Actividades en Pasco. Lugares, festividades, ciudades y pueblos de Pasco', 'Reserva online Paquetes y Tours de Piura. Destinos y Actividades en Piura. Lugares, festividades, playas, ciudades y pueblos de Piura', 'Reserva online Paquetes y Tours de Puno. Destinos y Actividades en Puno. Lugares, festividades, ciudades y pueblos de Puno','Reserva online Paquetes y Tours de San Martín. Destinos y Actividades en San Martín. Lugares, festividades, ciudades y pueblos de San Martín', 'Reserva online Paquetes y Tours de Tacna. Destinos y Actividades en Tacna. Lugares, festividades, playas, ciudades y pueblos de Tacna', 'Reserva online Paquetes y Tours de Tumbes. Destinos y Actividades en Tumbes. Lugares, festividades, playas, ciudades y pueblos de Tumbes', 'Reserva online Paquetes y Tours de Ucayali. Destinos y Actividades en Ucayali. Lugares, festividades, ciudades y pueblos de Ucayali' ];
$fotos = ['https://grupoeuroandino.com/wp-content/uploads/2023/07/', 'https://grupoeuroandino.com/wp-content/uploads/2023/07/paquetes-y-tours-ancash.jpg', 'https://grupoeuroandino.com/wp-content/uploads/2023/07/paquetes-y-tours-apurimac.jpg', 'https://grupoeuroandino.com/wp-content/uploads/2023/07/paquetes-y-tours-arequipa.jpg', 'https://grupoeuroandino.com/wp-content/uploads/2023/07/paquetes-y-tours-ayacucho.jpg', 'https://grupoeuroandino.com/wp-content/uploads/2023/07/paquetes-y-tours-cajamarca.jpg', 'https://grupoeuroandino.com/wp-content/uploads/2023/07/paquetes-y-tours-cusco.jpg', 'https://grupoeuroandino.com/wp-content/uploads/2023/07/paquetes-y-tours-callao.jpg', 'https://grupoeuroandino.com/wp-content/uploads/2023/07/paquetes-y-tours-huancavelica.jpg', 'https://grupoeuroandino.com/wp-content/uploads/2023/07/paquetes-y-tours-huanuco.jpg', 'https://grupoeuroandino.com/wp-content/uploads/2023/07/paquetes-y-tours-ica.jpeg', 'https://grupoeuroandino.com/wp-content/uploads/2023/07/paquetes-y-tours-junin.jpg', 'https://grupoeuroandino.com/wp-content/uploads/2023/07/paquetes-y-tours-la-libertad.jpg', 'https://grupoeuroandino.com/wp-content/uploads/2023/07/paquetes-y-tours-lambayeque.jpg', 'https://grupoeuroandino.com/wp-content/uploads/2023/07/paquetes-y-tours-lima.jpg', 'https://grupoeuroandino.com/wp-content/uploads/2023/07/paquetes-y-tours-loreto.jpg', 'https://grupoeuroandino.com/wp-content/uploads/2023/07/paquetes-y-tours-madre-de-dios.jpg', 'https://grupoeuroandino.com/wp-content/uploads/2023/07/paquetes-y-tours-moquegua.jpg', 'https://grupoeuroandino.com/wp-content/uploads/2023/07/paquetes-y-tours-pasco.jpg', 'https://grupoeuroandino.com/wp-content/uploads/2023/07/paquetes-y-tours-piura.jpg', 'https://grupoeuroandino.com/wp-content/uploads/2023/07/paquetes-y-tours-puno.jpg', 'https://grupoeuroandino.com/wp-content/uploads/2023/07/paquetes-y-tours-san-martin.jpg', 'https://grupoeuroandino.com/wp-content/uploads/2023/07/paquetes-y-tours-tacna.jpg', 'https://grupoeuroandino.com/wp-content/uploads/2023/07/paquetes-y-tours-tumbes.jpg', 'https://grupoeuroandino.com/wp-content/uploads/2023/07/paquetes-y-tours-ucayali.jpg'];

$aBuscar = strtolower($_GET['texto']);

$tildes = ['á', 'é', 'í', 'ó', 'ú', ' '];
$simple = ['a', 'e', 'i', 'o', 'u', '-'];

$aBuscar = str_replace( $tildes, $simple, $aBuscar );
$indice =  array_search( $aBuscar, $departamentosUrl);
$idDepartamento = $indice;
?>

<!DOCTYPE html>

<html lang="es">



<head>

	<meta charset="UTF-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Filtro por producto</title>
	<?php
	if( $indice ){ ?>
		<meta property="og:title" content="Paquetes y tours de <?= $departamentos[$indice] ?> - Grupo Euro Andino">
		<meta property="og:image" content="<?= $fotos[$indice] ?>">
		<meta property="og:description" content="<?= strip_tags($descripcion[$indice]) ?>">
		<?php
	}
	?>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

	<link rel="stylesheet" href="https://grupoeuroandino.com/app/render/icofont/icofont.min.css">
	<link rel="stylesheet" href="https://grupoeuroandino.com/app/render/css/estilos.css">

</head>

<body>

	<style>

		.accordion-button:not(.collapsed) {

			background-color: #ffffff;

			font-weight: bold;

		}



		.activo {

			color: #000 !important;

			font-weight: bold;

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

		.card-img-top{

			width:100%!important;

			height: 250px!important;

    	object-fit: cover!important;

		}

	</style>

	<!-- Inicio de Encabezado -->
	<nav>
		<div class="container d-block d-sm-none">
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
	</nav>
	<!-- Fin de Encabezado -->

	<div class="container" id="app">

		<h1 class="fs-2 mt-3">

			<?php if(isset($_GET['idTipo']) && $_GET['idTipo']=='1'):?> <span>Tours</span> <?php endif;?>

			<?php if(isset($_GET['idTipo']) && $_GET['idTipo']=='2'):?> <span>Paquetes turísticos</span><?php endif;?>

			<?php if(isset($_GET['id'])):?> <span>Paquetes y tours de: <?= $departamentos[$_GET['id']-1];?> </span><?php endif;?>

			<?php if(isset($_GET['texto'])):?> <span>Resultados por: <?php $texto=$_GET['texto']; echo $departamentos[$indice]; ?> </span><?php else: $texto=''; endif;?>

		</h1>

		<div class="row row-cols-1 row-cols-lg-3 row-cols-xl-4">

			<div class="col my-2 " v-for="(producto, index) in productos" :key="producto.id">

				<div class="card h-100">

					<img :src="queFoto(producto)" class="card-img-top" alt="...">

					<div class="card-body">

						<h5 class="card-title text-capitalize mb-0">

							<a v-if="producto.tipo==1" class="text-decoration-none text-dark" :href="'https://grupoeuroandino.com/tours/' + pedidos[index].url" target="_parent">{{producto.nombre}}</a></strong>

							<a v-if="producto.tipo==2" class="text-decoration-none text-dark" :href="'https://grupoeuroandino.com/tours/' + pedidos[index].url" target="_parent">{{producto.nombre}}</a></strong>

						</h5>



						<p class="card-text mb-0"><i class="icofont-google-map"></i> <span class="text-capitalize"><strong>{{producto.destino}}, {{queDepa(producto.departamento)}}</strong></span></p>

						<div class="estrellas"><i class="icofont-star"></i><i class="icofont-star"></i><i class="icofont-star"></i><i class="icofont-star"></i><i class="icofont-star"></i></div>





						<div class="row row-cols-2">

							<div>

								<span>{{queDuracion(producto.duracion, producto.tipo)}}</span>

							</div>

							<div class="text-end ">

								<span class="precio2"><span class="monedita fs-6">S/</span> {{formatoMoneda(producto.peruanos.adultos)}}</span>

								<p v-if="producto.oferta>0" class="precioAnt2 mb-0">S/ {{formatoMoneda(producto.oferta)}}</p>

							</div>

						</div>

					</div>

				</div>

			</div>

			<div v-if="productos.length==0">

				<p>No existen productos que coincidan</p>

			</div>

		</div>





	</div>



	<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>





	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>



	<script>

		var modalNuevo, modalNuevoPack, qDescripcion, qPartida, qItinerario, qNotas, offPanel,

			tostadaOk, tostadaMal;

		//var rutaDocs = 'C:/xampp8/htdocs/euroAndinoApi/subidas/'; 



		var app = new Vue({

			el: '#app',

			data: {

				//servidor: 'http://localhost/euroAndinoApi/',

				servidor: 'https://grupoeuroandino.com/app/api/',

				departamentos:['Amazonas', 'Ancash', 'Apurimac', 'Arequipa', 'Ayacucho', 'Cajamarca', 'Cusco', 'Callao', 'Huancavelica','Huánuco', 'Ica', 'Junín', 'La Libertad', 'Lambayeque', 'Lima', 'Loreto', 'Madre de Dios', 'Moquegua', 'Pasco', 'Piura', 'Puno','San Martín', 'Tacna', 'Tumbes', 'Ucayali' ],

				dias: [],

				actividades: [],

				categorias: [],

				idTour: <?= $idTipo; ?>,

				idActividad: -1,

				idDepartamento: <?= $idDepartamento; ?>,

				idCategoria: -1,

				idDia: -1,

				idPrecio: -1, idTransporte:-1, idHospedaje:-1, texto:'<?= $texto;?>',

				precios: ['Hasta S/ 150.00', 'De S/ 151.00 a S/ 300.00', 'De S/ 301.00 a S/ 500.00', 'De S/ 501.00 a S/ 1000.00', 'De S/ 1001.00 a S/ 1500.00', 'De S/ 1501.00 a S/ 2000.00', 'Más de S/ 2000.00'],

				actividadSelect: '',

				categoriaSelect: '',

				productos: [],

				duracion: [

					{ clave: 1, valor: 'Half Day (Medio día)' },

					{ clave: 2, valor: 'Full Day (1 día)' }],

				duracionDias: [

					{ clave: 1, valor: 'Half Day (Medio día)' },

					{ clave: 2, valor: 'Full Day (1 día)' }],

				duracionNoches: [{

					clave: 1,

					valor: '0 noches'

				}, {

					clave: 2,

					valor: '1 noche'

				}],

				pedidos: []

			},

			mounted: function() {

				this.cargar();

				for (let i = 1; i <= 31; i++) {

					this.dias.push(i);

				}

				for (let dia = 2; dia <= 31; dia++) {

					this.duracion.push({

						clave: dia + 1,

						valor: dia + " días / 0 noches"

					});

					this.duracionDias.push({

						clave: dia + 1,

						valor: dia + " días"

					});

					this.duracionNoches.push({

						clave: dia + 1,

						valor: dia + ' noches'

					});

				}

				this.buscarEnTienda();





				//modalNuevo = new bootstrap.Modal( document.getElementById('modalNuevo') );



			},

			methods: {

				async cargar() {

					let respServ = await fetch(this.servidor + 'pedirDatosTienda.php', {

						method: 'POST'

					});

					//console.log( await respServ.text() );

					let temporal = await respServ.json();

					this.actividades = temporal[0]

					this.categorias = temporal[1]

				},

				async buscarEnTienda() {

					this.pedidos = [];

					this.productos = [];

					let datos = new FormData();

					datos.append('idTour', this.idTour);

					datos.append('idActividad', this.idActividad);

					datos.append('actividad', this.actividadSelect);

					datos.append('idDepartamento', this.idDepartamento);

					datos.append('idCategoria', this.idCategoria);

					datos.append('idTransporte', this.idTransporte);

					datos.append('idHospedaje', this.idHospedaje);

					datos.append('categoria', this.categoriaSelect);

					datos.append('idDia', this.idDia);

					datos.append('idPrecio', this.idPrecio);

					datos.append('texto', this.texto);

					let respServ = await fetch(this.servidor + 'buscarFiltroTienda.php?v1', {

						method: 'POST',

						body: datos

					});

					//console.log( await respServ.json() );

					this.pedidos = await respServ.json();
					//console.log(pedidos)



					this.pedidos.forEach(data => {

						this.productos.push(JSON.parse(data.contenido))

					})



				},

				queFoto(prod) {

					//console.log( prod );

					if (prod.fotos.length == 0) {

						return 'https://grupoEuroAndino.com/app/render/images/defecto.jpg';

					} else {

						return 'https://grupoEuroAndino.com/app/render/images/subidas/' + prod.fotos[0].nombreRuta;

					}

				},

				queDuracion(idDuracion, tipo){

				if(tipo===1){

					//return this.duracion[idDuracion].valor ;

					return this.duracion.find( x => x.clave === idDuracion ).valor;

				}

				if(tipo===2){

					//console.log( idDuracion );

					//return this.duracion[idDuracion.dias-1].valor + " y "+ this.duracionNoches[idDuracion.noches-1].valor ;

					return this.duracionDias.find( x => x.clave === idDuracion.dias ).valor + " / " + this.duracionNoches.find( x => x.clave === idDuracion.noches ).valor;

				}

			},

				queDepa(valor) {

					return this.departamentos[valor];

				},

				formatoMoneda(valor) {

					return parseFloat(valor).toFixed(2)

				},

				queId(index) {

					return this.pedidos[index].id;

				}

			}

		});

	</script>

</body>


</html>