<?php

//var_dump($_GET); die();

$idDepartamento = -1;

if (isset($_GET['ciudad'])) {
	$idCiudad = $_GET['ciudad'];
} else {
	$idCiudad = '';
}

if (isset($_GET['idTipo'])) {
	$idTipo = $_GET['idTipo'];
} else {
	$idTipo = -1;
}

$departamentos = ['Amazonas', 'Ancash', 'Apurimac', 'Arequipa', 'Ayacucho', 'Cajamarca', 'Cusco', 'Callao', 'Huancavelica', 'Huánuco', 'Ica', 'Junín', 'La Libertad', 'Lambayeque', 'Lima', 'Loreto', 'Madre de Dios', 'Moquegua', 'Pasco', 'Piura', 'Puno', 'San Martín', 'Tacna', 'Tumbes', 'Ucayali'];

?>

<!DOCTYPE html>

<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Filtro por producto</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

	<link rel="stylesheet" href="https://grupoeuroandino.com/app/render/icofont/icofont.min.css">

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

		.card-img-top {

			width: 100% !important;

			height: 250px !important;

			object-fit: cover !important;

		}
	</style>

	<div class="container-fluid" id="app">

		<h1 class="fs-2 mt-3">

			<?php if (isset($_GET['idTipo']) && $_GET['idTipo'] == '1') : ?> <span>Tours</span> <?php endif; ?>

			<?php if (isset($_GET['idTipo']) && $_GET['idTipo'] == '2') : ?> <span>Paquetes turísticos</span><?php endif; ?>

			<?php if (isset($_GET['id'])) : ?> <span>Paquetes y tours de: <?= $departamentos[$_GET['id'] - 1]; ?> </span><?php endif; ?>

			<?php if (isset($_GET['texto'])) : ?> <span>Resultados por: <?= $texto = $_GET['texto']; ?> </span><?php else : $texto = '';
			endif; ?>

		</h1>

		<div class="row row-cols-1 row-cols-lg-3 row-cols-xl-4">

			<div class="col my-2 " v-for="(producto, index) in productos" :key="producto.id">

				<div class="card h-100">

					<img :src="queFoto(producto)" class="card-img-top" alt="...">

					<div class="card-body">

						<h5 class="card-title text-capitalize mb-0">

							<a v-if="producto.tipo==1" class="text-decoration-none text-dark" :href="'https://grupoeuroandino.com/tour/?id=' + pedidos[index].id" target="_parent">{{producto.nombre}}</a></strong>

							<a v-if="producto.tipo==2" class="text-decoration-none text-dark" :href="'https://grupoeuroandino.com/paqueteturistico/?id=' + pedidos[index].id" target="_parent">{{producto.nombre}}</a></strong>

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

				departamentos: ['Amazonas', 'Ancash', 'Apurimac', 'Arequipa', 'Ayacucho', 'Cajamarca', 'Cusco', 'Callao', 'Huancavelica', 'Huánuco', 'Ica', 'Junín', 'La Libertad', 'Lambayeque', 'Lima', 'Loreto', 'Madre de Dios', 'Moquegua', 'Pasco', 'Piura', 'Puno', 'San Martín', 'Tacna', 'Tumbes', 'Ucayali'],

				dias: [],

				actividades: [],

				categorias: [],

				idTour: <?= $idTipo; ?>,

				idActividad: -1,

				idDepartamento: <?= $idDepartamento; ?>,

				idCategoria: -1,

				idDia: -1,

				idPrecio: -1,
				idTransporte: -1,
				idHospedaje: -1,
				texto: '<?= $texto; ?>',

				precios: ['Hasta S/ 150.00', 'De S/ 151.00 a S/ 300.00', 'De S/ 301.00 a S/ 500.00', 'De S/ 501.00 a S/ 1000.00', 'De S/ 1001.00 a S/ 1500.00', 'De S/ 1501.00 a S/ 2000.00', 'Más de S/ 2000.00'],

				actividadSelect: '',

				categoriaSelect: '',

				productos: [],

				duracion: [

					{
						clave: 1,
						valor: 'Half Day (Medio día)'
					},

					{
						clave: 2,
						valor: 'Full Day (1 día)'
					}
				],

				duracionDias: [

					{
						clave: 1,
						valor: 'Half Day (Medio día)'
					},

					{
						clave: 2,
						valor: 'Full Day (1 día)'
					}
				],

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
					datos.append('idCiudad', "<?= $idCiudad?>");

					datos.append('idCategoria', this.idCategoria);

					datos.append('idTransporte', this.idTransporte);

					datos.append('idHospedaje', this.idHospedaje);

					datos.append('categoria', this.categoriaSelect);

					datos.append('idDia', this.idDia);

					datos.append('idPrecio', this.idPrecio);

					datos.append('texto', this.texto);

					let respServ = await fetch(this.servidor + 'buscarFiltroTienda.php', {

						method: 'POST',

						body: datos

					});

					//console.log( await respServ.json() );

					this.pedidos = await respServ.json();



					this.pedidos.forEach(data => {

						this.productos.push(JSON.parse(data.contenido))

					})



				},

				queFoto(prod) {

					//console.log( prod );

					if (prod.fotos.length == 0) {

						return 'https://grupoeuroandino.com/app/render/images/defecto.jpg';

					} else {

						return 'https://grupoeuroandino.com/app/render/images/subidas/' + prod.fotos[0].nombreRuta;

					}

				},

				queDuracion(idDuracion, tipo) {

					if (tipo === 1) {

						//return this.duracion[idDuracion].valor ;

						return this.duracion.find(x => x.clave === idDuracion).valor;

					}

					if (tipo === 2) {

						//console.log( idDuracion );

						//return this.duracion[idDuracion.dias-1].valor + " y "+ this.duracionNoches[idDuracion.noches-1].valor ;

						return this.duracionDias.find(x => x.clave === idDuracion.dias).valor + " / " + this.duracionNoches.find(x => x.clave === idDuracion.noches).valor;

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