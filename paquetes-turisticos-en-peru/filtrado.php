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

	<title>Paquetes Turísticos en Perú - Grupo Euro Andino</title>

	<meta property="og:title" content="Paquetes Turísticos en Perú - Grupo Euro Andino">
	<meta property="og:image" content="https://grupoeuroandino.com/wp-content/uploads/2025/06/Destinos-Huanuco.jpg">
	<meta property="og:description" content="Encuentra paquetes turísticos en Perú con todo incluido. Viajes a medida para vacaciones perfectas en Cusco, la selva y la costa peruana. ¡Cotiza ahora!">

	<?php include(__DIR__."/../app/render/headers.php");?>

</head>
<body>
<!-- Inicio de Encabezado -->
<?php include ( __DIR__."/../app/render/menu.php");?>

<!-- Fin de Encabezado -->
 <div class="container">
	<h1 class="fs-2 mt-3">

			<?php if(isset($_GET['idTipo']) && $_GET['idTipo']=='1'):?> <span>Tours</span> <?php endif;?>

			<?php if(isset($_GET['idTipo']) && $_GET['idTipo']=='2'):?> <span>Paquetes Turísticos en Perú</span><?php endif;?>

			<?php if(isset($_GET['id'])):?> <span>Paquetes y Tours de: <?= $departamentos[$_GET['id']-1];?> </span><?php endif;?>

			<?php if(isset($_GET['texto'])):?> <span>Resultados por: <?= $texto=$_GET['texto'];?> </span><?php else: $texto=''; endif;?>

		</h1>
		<p class="my-3">Disfruta de la máxima comodidad con nuestros Paquetes Turísticos en Perú. Nos encargamos de todo el itinerario, hoteles, traslados y excursiones para que solo te dediques a disfrutar. Encuentra el viaje perfecto, desde escapadas románticas hasta vacaciones familiares.</p>

 </div>

	<div class="container-fluid" id="app">

		

		<div class="row row-cols-1 row-cols-lg-3 row-cols-xl-4">
			<div class="col my-2 " v-for="(tour, index) in productos" :key="tour.id">
				<Card :duracion='duracion' :dias='dias' :noches='noches' :tour='tour'/>
			</div>

			<div v-if="productos.length==0" class="text-center my-5">
				<img src="https://grupoeuroandino.com/images/vacio.png" alt="Sin resultados" class="img-fluid mb-3" style="max-width: 200px;">
				<h5 class="text-muted">No existen productos que coincidan</h5>
				<p class="text-muted">Intenta con otros filtros de búsqueda</p>
			</div>

		</div>





	</div>


	<?php include(__DIR__."/../app/render/footer.php");?>

	<script type="module">
	import Card from 'https://grupoeuroandino.com/app/render/js/card.js?v=1.0.13';
		const {createApp} = Vue

		var modalNuevo, modalNuevoPack, qDescripcion, qPartida, qItinerario, qNotas, offPanel,

			tostadaOk, tostadaMal;

		//var rutaDocs = 'C:/xampp8/htdocs/euroAndinoApi/subidas/'; 

		const app = createApp({

			components:{Card},
			data(){return {

				servidor: window.lugarApi,
				actividades: [], categorias: [],

				idTour: <?= $idTipo; ?>,
				idActividad: -1,
				idDepartamento: <?= $idDepartamento; ?>,
				idCategoria: -1,
				idDia: -1,
				idPrecio: -1, idTransporte:-1, idHospedaje:-1, texto:'<?= $texto;?>',
				precios: ['Hasta S/ 150.00', 'De S/ 151.00 a S/ 300.00', 'De S/ 301.00 a S/ 500.00', 'De S/ 501.00 a S/ 1000.00', 'De S/ 1001.00 a S/ 1500.00', 'De S/ 1501.00 a S/ 2000.00', 'Más de S/ 2000.00'],
				actividadSelect: '',
				categoriaSelect: '',

				productos: [], contenidos:[],
				duracion: [{ clave: 1, valor: 'Half Day (Medio día)' }, { clave: 2, valor: 'Full Day (1 día)' }],
				dias: [{ clave: 1, valor: 'Half Day (Medio día)' }, { clave: 2, valor: 'Full Day (1 día)' }],
				noches: [{ clave: 1, valor: '0 noches' }, { clave: 2, valor: '1 noche' }],
				pedidos: [],
			}},

			mounted() {
				for (let dia = 2; dia <= 31; dia++) {
					this.duracion.push({ clave: dia+1, valor: dia + ' días / 0 noches' });
					this.dias.push({ clave: dia+1, valor: dia + ' días' });
					this.noches.push({ clave: dia+1, valor: dia + ' noches' });
				}
				this.cargar();
				this.buscarEnTienda();
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

					let respServ = await fetch(this.servidor + 'buscarFiltroTienda.php', {

						method: 'POST',

						body: datos

					});

					//console.log( await respServ.json() );

					this.pedidos = await respServ.json();
					this.pedidos.forEach(dato => {
						this.productos.push( {...JSON.parse(dato.contenido),
							calificacion: dato.calificacion,
							url: dato.url,
							descuento: dato.descuento ?? []
						});

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

				queId(index) {
					return this.pedidos[index].id;
				},
				
				formatoMoneda(valor){
					return parseFloat(valor).toFixed(0)					
				},
			}

		});
		app.mount('#app')

	</script>

</body>



</html>