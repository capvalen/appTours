<?php

//var_dump($_GET); die();

if (isset($_GET['id'])) { $idDepartamento = $_GET['id']-1; } else { $idDepartamento = -1; }

if (isset($_GET['idTipo'])) { $idTipo = $_GET['idTipo']; } else { $idTipo = -1; }

$departamentos = ['Amazonas', 'Ancash', 'Apurimac', 'Arequipa', 'Ayacucho', 'Cajamarca', 'Cusco', 'Callao', 'Huancavelica','Huánuco', 'Ica', 'Junín', 'La Libertad', 'Lambayeque', 'Lima', 'Loreto', 'Madre de Dios', 'Moquegua', 'Pasco', 'Piura', 'Puno','San Martín', 'Tacna', 'Tumbes', 'Ucayali' ];

?>

<!DOCTYPE html>

<html lang="es">



<head>

	<meta charset="UTF-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Filtro por producto</title>
	
	<?php
	if( $indice>=0 ){ ?>
		<meta property="og:title" content="Paquetes y tours half day - Grupo Euro Andino">
		<meta property="og:image" content="https://grupoeuroandino.com/app/render/images/subidas/62c5a4e444d93.jpg">
		<meta property="og:description" content="Paquetes y tours half day - Grupo Euro Andino">
		<?php
	}
	?>

<?php include("../app/render/headers.php");?>

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


	.bandera {
		width: 20px;
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

	.card-img-top {

		width: 100% !important;

		height: 320px !important;

		object-fit: cover !important;
	}

	.divOferta2 {
		width: 70px;
		height: 25px;
		/* rgb(192, 0, 67);  */
		margin-top: 1rem;
		margin-right: 0rem;
		color: white;
		font-size: 0.8rem;
	}

	#spanOferta {
		background-color: #2768b7;
	}

	#spanAlimentacion {
		background-color: #6745ef;
	}

	#spanTour {
		background-color: #0cbf19;
	}

	#spanGuia {
		background-color: #ffc107;
	}

	#spanTickets {
		background-color: #e91616;
	}

	#spanTransporte {
		background-color: #bf0ca9;
	}

</style>

	<!-- Inicio de Encabezado -->
	<?php include ("../app/render/menu.php");?>

	<!-- Fin de Encabezado -->

	<div class="container-fluid" id="app">

		<div class="container">
		    <h1 class="fs-2 mt-3">

			<?php if(isset($_GET['idTipo']) && $_GET['idTipo']=='1'):?> <span>Tours en Perú</span> <?php endif;?>

			<?php if(isset($_GET['idTipo']) && $_GET['idTipo']=='2'):?> <span>Paquetes turísticos en Perú</span><?php endif;?>

			<?php if(isset($_GET['id'])):?> <span>Paquetes y tours de: <?= $departamentos[$_GET['id']-1];?> </span><?php endif;?>

			<?php if(isset($_GET['texto'])):?> <span>Resultados por: <?php $texto=$_GET['texto']; echo $departamentos[$indice]; ?> </span><?php else: $texto=''; endif;?>

		</h1>
		<p class="my-3"><?= $comentario[$indice];?></p>
		
		</div>

		<div class="row row-cols-1 row-cols-lg-3 row-cols-xl-4">
			<div class="col my-2 " v-for="(tour, index) in productos" :key="tour.id">
				<div class="card h-100 border-0  ">
					<div v-if="tour.fotos.length>0" class="divImagen card-img-top position-relative">
						<div class="divOferta2 w-100 position-absolute bottom-0 end-0 d-flex justify-content-end mb-2 me-1">
							<span v-if="tour.transporte==1" class="mx-1 px-1 rounded" id="spanTransporte">Bus</span>
							<span v-if="tour.transporte==2" class="mx-1 px-1 rounded" id="spanTransporte">Avión</span>
							<span v-if="tour.alojamiento" class="mx-1 px-1 rounded" id="spanOferta"> {{hospedajes[tour.alojamiento]}}</span>
							<span v-if="tour.alimentacion" class="mx-1 px-1 rounded" id="spanAlimentacion">Alimentación</span>
							<span class="mx-1 px-1 rounded" id="spanTour">Tour</span>
							<span v-if="tour.guia" class="mx-1 px-1 rounded" id="spanGuia">Guía</span>
							<span v-if="tour.tickets" class="mx-1 px-1 rounded" id="spanTickets">Tickets</span>
						</div>
						<a class="aImgs" v-if="tour.tipo==1" :href="'https://grupoeuroandino.com/tours/' + tour.url" target="_parent"><img class="img-fluid rounded-top" :src="'https://grupoeuroandino.com/app/render/images/subidas/'+tour.fotos[0].nombreRuta" alt=""></a>
						<a class="aImgs" v-if="tour.tipo==2" :href="'https://grupoeuroandino.com/tours/' + tour.url" target="_parent"><img class="img-fluid rounded-top" :src="'https://grupoeuroandino.com/app/render/images/subidas/'+tour.fotos[0].nombreRuta" alt=""></a>
					</div>
					<div class="card-body">
						<div class="divProducto ">
							<div>
								<p class="mb-0 titulo ps-1 ">
									<a class="text-decoration-none text-dark fw-bold" v-if="tour.tipo==1" :href="'https://grupoeuroandino.com/tours/' + tour.url" target="_parent">{{tour.nombre}}</a>
									<a class="text-decoration-none text-dark fw-bold" v-if="tour.tipo==2" :href="'https://grupoeuroandino.com/tours/' + tour.url" target="_parent">{{tour.nombre}}</a>
								</p>
								<!-- <div class="d-flex justify-content-between">
									aquí iba la bandera
								</div> -->								
								<div class="row row-cols-2">
									<div>
										<span><img class="bandera" src="https://grupoeuroandino.com/images/banderas/peru.jpeg"> <strong>{{tour.destino}},</strong></span>
										<br>
										<i class="icofont-google-map"></i> <span class="text-capitalize"><strong> {{queDepa(tour.departamento)}}</strong></span>
										<div class="estrellas">
											<i v-for="star in cuantasEstrellas(index)" class="icofont-star"></i>
										</div>
										<span v-if="tour.tipo==1" class="text-muted subText">{{queDura(tour.duracion)}}</span>
										<span v-else class="text-muted subText">{{queDuraDia(tour.duracion.dias)}} / {{queDuraNoche(tour.duracion.noches-1)}}</span>
									</div>
									<div class="text-end ">
										<span class="precio2">S/ {{formatoMoneda(tour.peruanos.adultos)}}</span>
										<p class="mb-0 text-end"><small>Precio normal</small></p>
										<p v-if="tour.oferta!='0' && tour.oferta!=''" class="precioAnt2 mb-0">S/ {{formatoMoneda(tour.oferta)}}</p>
									</div>
								</div>
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
				hospedajes: ['Albergue', 'Apartment', 'Bungalow', 'Hostal *', 'Hostal **', 'Hostal ***', 'Hotel *', 'Hotel **', 'Hotel ***', 'Hotel ****', 'Hotel *****', 'Lodge', 'Resort', 'Otro'],

				actividadSelect: '',
				categoriaSelect: '',

				productos: [], contenidos:[],
				duracion: [{clave: 1, valor: 'Half Day (Medio día)'}, {clave: 2, valor: 'Full Day (1 día)'} ],
				duracionDias: [{clave: 1, valor: 'Half Day (Medio día)'}, {clave: 2, valor: 'Full Day (1 día)'} ],
				duracionNoches:[{clave: 1, valor:'0 noches'}, {clave: 2, valor:'1 noche'}],
				departamentos:['Amazonas', 'Ancash', 'Apurimac', 'Arequipa', 'Ayacucho', 'Cajamarca', 'Cusco', 'Callao', 'Huancavelica','Huánuco', 'Ica', 'Junín', 'La Libertad', 'Lambayeque', 'Lima', 'Loreto', 'Madre de Dios', 'Moquegua', 'Pasco', 'Piura', 'Puno','San Martín', 'Tacna', 'Tumbes', 'Ucayali' ],
				pedidos: []

			},

			mounted: function() {

				this.cargar();

				for (let i = 1; i <= 31; i++) {
					this.dias.push(i);
				}

				for (let dia = 2; dia <= 31; dia++) {
					this.duracion.push({ clave: dia+1, valor: dia + ' días / 0 noches' });
					this.duracionDias.push({ clave: dia+1, valor: dia + ' días' });
					this.duracionNoches.push({ clave: dia+1, valor: dia + ' noches' });
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

					datos.append('idDia', '<?= $_GET['idDia'] ?>');

					datos.append('idPrecio', this.idPrecio);

					datos.append('texto', this.texto);

					let respServ = await fetch(this.servidor + 'buscarFiltroTienda.php?v1', {

						method: 'POST',

						body: datos

					});

					//console.log( await respServ.json() );

					this.pedidos = await respServ.json();
					//console.log(this.pedidos)

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


				queId(index) {
					return this.pedidos[index].id;
				},
				queDura(duracion){
				return this.duracion[duracion-1].valor;
				},
				//Nuevos:
				queDuraDia(duracion){
					//return this.duracion[duracion].valor;
					return this.duracionDias.find( x => x.clave === duracion ).valor;
				},
				queDuraNoche(duracion){ 
					if(duracion>=1){
						return this.duracionNoches[duracion].valor;
					}
				},
				queDepa(valor){
					return this.departamentos[valor];
				},
				formatoMoneda(valor){
					return parseFloat(valor).toFixed(2)
				},
				cuantasEstrellas(index){
					return parseInt(this.pedidos[index].calificacion)
				}

			}

		});

	</script>

</body>


</html>
