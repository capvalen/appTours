<?php

if (isset($_GET['id'])) { $idDepartamento = $_GET['id']-1; } else { $idDepartamento = -1; }

if (isset($_GET['idTipo'])) { $idTipo = $_GET['idTipo']; } else { $idTipo = -1; }

if (isset($_GET['idDia'])) { $idDia = $_GET['idDia']; } else { $idDia = -1; }

$departamentos = ['Amazonas', 'Ancash', 'Apurimac', 'Arequipa', 'Ayacucho', 'Cajamarca', 'Cusco', 'Callao', 'Huancavelica','Huánuco', 'Ica', 'Junín', 'La Libertad', 'Lambayeque', 'Lima', 'Loreto', 'Madre de Dios', 'Moquegua', 'Pasco', 'Piura', 'Puno','San Martín', 'Tacna', 'Tumbes', 'Ucayali' ];

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<?php if($idDia=='1'):?>
		<title>Half Day en Perú - Grupo Euro Andino</title>
		<meta property="og:title" content="Paquetes Turísticos Half Day en Perú - Grupo Euro Andino">
		<meta property="og:image" content="https://grupoeuroandino.com/wp-content/uploads/2025/06/Destinos-Huanuco.jpg">
		<meta property="og:description" content="Aprovecha tu tiempo al máximo con nuestros tours Half Day en Perú. Excursiones de medio día ideales para conocer ciudades, museos y sitios arqueológicos.">
	<?php elseif($idDia=='2'):?>
		<title>Full Day en Perú - Grupo Euro Andino</title>
		<meta property="og:title" content="Paquetes Turísticos Full Day en Perú - Grupo Euro Andino">
		<meta property="og:image" content="https://grupoeuroandino.com/wp-content/uploads/2025/06/Destinos-Huanuco.jpg">
		<meta property="og:description" content="Vive un día inolvidable con nuestros tours Full Day en Perú. Excursiones de un día a la Montaña de 7 Colores, Valle Sagrado y más. ¡Reserva tu cupo!">
	<?php else:?>
		<title>Half Day / Full Day en Perú - Grupo Euro Andino</title>
	<?php endif;?>

<?php include(__DIR__."/../app/render/headers.php");?>
</head>
<body>

	<?php include(__DIR__."/../app/render/menu.php");?>

	<div class="container-fluid" id="app">
		<div class="container">
			<h1 class="fs-2 mt-3">
				<?php if($idDia=='1'):?> <span>Half Day en Perú</span><?php endif;?>
				<?php if($idDia=='2'):?> <span>Full Day en Perú</span><?php endif;?>
				<?php if(isset($_GET['id'])):?> <span>Paquetes y tours de: <?= $departamentos[$_GET['id']-1];?> </span><?php endif;?>
			</h1>

			<?php if($idDia=='1'):?>
				<p class="my-3">Descubre grandes maravillas en pocas horas con nuestros recorridos Half Day en Perú. Ofrecemos experiencias rápidas, dinámicas y completas, perfectas para viajeros con agendas ajustadas que no quieren perderse los puntos más emblemáticos de cada ciudad.</p>
			<?php elseif($idDia=='2'):?>
				<p class="my-3">Aventuras intensas de principio a fin. Con nuestros tours Full Day en Perú, exprimirás cada hora de tu día explorando los destinos más espectaculares. Disfruta de excursiones guiadas completas con transporte y asistencia permanente para una experiencia segura y fascinante.</p>
			<?php endif;?>
		</div>

		<div class="row row-cols-1 row-cols-lg-3 row-cols-xl-4">
			<div class="col my-2" v-for="(tour, index) in productos" :key="tour.id">
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

		var modalNuevo, modalNuevoPack, qDescripcion, qPartida, qItinerario, qNotas, offPanel,
			tostadaOk, tostadaMal;

		const {createApp} = Vue

		const app = createApp({
			components:{Card},
			data(){return {
				servidor: window.lugarApi,

				departamentos:['Amazonas', 'Ancash', 'Apurimac', 'Arequipa', 'Ayacucho', 'Cajamarca', 'Cusco', 'Callao', 'Huancavelica','Huánuco', 'Ica', 'Junín', 'La Libertad', 'Lambayeque', 'Lima', 'Loreto', 'Madre de Dios', 'Moquegua', 'Pasco', 'Piura', 'Puno','San Martín', 'Tacna', 'Tumbes', 'Ucayali' ],
				dias: [],
				actividades: [], categorias: [],

				idTour: <?= $idTipo; ?>,
				idActividad: -1,
				idDepartamento: <?= $idDepartamento; ?>,
				idCategoria: -1,
				idDia: <?= $idDia; ?>,
				idPrecio: -1, idTransporte:-1, idHospedaje:-1, texto:'',
				precios: ['Hasta S/ 150.00', 'De S/ 151.00 a S/ 300.00', 'De S/ 301.00 a S/ 500.00', 'De S/ 501.00 a S/ 1000.00', 'De S/ 1001.00 a S/ 1500.00', 'De S/ 1501.00 a S/ 2000.00', 'Más de S/ 2000.00'],
				hospedajes: ['','Albergue', 'Apartment', 'Bungalow', 'Hostal *', 'Hostal **', 'Hostal ***', 'Hotel *', 'Hotel **', 'Hotel ***', 'Hotel ****', 'Hotel *****', 'Lodge', 'Resort', 'Otro', 'Casa', 'Casa 2', 'Casa 3', 'Airbnb', 'Rural'],
				actividadSelect: '',
				categoriaSelect: '',

				productos: [], contenidos:[],
				duracion: [{clave: 1, valor: 'Half Day (Medio día)'}, {clave: 2, valor: 'Full Day (1 día)'} ],
				duracionDias: [{clave: 1, valor: 'Half Day (Medio día)'}, {clave: 2, valor: 'Full Day (1 día)'} ],
				duracionNoches:[{clave: 1, valor:'0 noches'}, {clave: 2, valor:'1 noche'}],
				pedidos: [],
			}},

			mounted() {
				for (let i = 1; i <= 31; i++) {
					this.dias.push(i);
				}
				for (let dia = 2; dia <= 31; dia++) {
					this.duracion.push({ clave: dia+1, valor: dia + ' días / 0 noches' });
					this.duracionDias.push({ clave: dia+1, valor: dia + ' días' });
					this.duracionNoches.push({ clave: dia+1, valor: dia + ' noches' });
				}
				this.cargar();
				this.buscarEnTienda();
			},

			methods: {

				async cargar() {
					let respServ = await fetch(this.servidor + 'pedirDatosTienda.php', {
						method: 'POST'
					});
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

					this.pedidos = (await respServ.json()).data;
					this.pedidos.forEach(dato => {
						this.productos.push( {...JSON.parse(dato.contenido),
							calificacion: dato.calificacion,
							url: dato.url,
							descuento: dato.descuento ?? []
						});
					})
				},

				queFoto(prod) {
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

				queDura(duracion){
					return this.duracion[duracion-1].valor;
				},
				queDuraDia(duracion){
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
				cuantasEstrellas(index){
					return parseInt(this.pedidos[index].calificacion)
				}
			}
		});
		app.mount('#app')
	</script>

</body>
</html>
