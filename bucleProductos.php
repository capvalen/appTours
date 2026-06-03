<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Bucle</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
	<link rel="stylesheet" href="https://grupoeuroandino.com/app/render/icofont/icofont.min.css">
	<link rel="stylesheet" href="https://grupoeuroandino.com/app/render/css/efecto.css?v=1.1">
</head>
<body class="container-fluid">
	<div id="app">
		<div class="row row-cols-1 row-cols-md-2 row-cols-lg-4">
			<div class="col my-3" v-for="tour in contenidos">
				<Card :duracion='duracion' :dias='dias' :noches='noches' :tour='tour'/>
			</div>
			
		</div>
	</div>
	<script src="https://grupoeuroandino.com/app/render/configuracion.js?v=1.0.2"></script>
	<!-- Vue desarrollo -->
<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script> -->
<!-- Vue producción -->
<!-- <script src="https://cdn.jsdelivr.net/npm/vue@2"></script> -->
<script type="module">
	import Card from 'https://grupoeuroandino.com/app/render/js/card.js?v=1.0.9';
	const { createApp } = Vue;
	const app = createApp({
		components:{Card},
		data(){ return {
			//servidor: 'http://localhost/appTours/api/',
			servidor: window.lugarApi,
			tours:[],
			contenidos:[], //{fotos:[{nombreRuta:''}], valor: 0, peruanos:{adultos:0, kids:0}, extranjeros:{adultos:0, kids:0},}
			duracion: [{ clave: 1, valor: 'Half Day (Medio día)' }, { clave: 2, valor: 'Full Day (1 día)' }],
			dias: [{ clave: 1, valor: 'Half Day (Medio día)' }, { clave: 2, valor: 'Full Day (1 día)' }],
			noches: [{ clave: 1, valor: '0 noches' }, { clave: 2, valor: '1 noche' }],
		}},
		mounted(){
			for (let dia = 2; dia <= 31; dia++) {
				this.duracion.push({ clave: dia+1, valor: dia + ' días / 0 noches' });
				this.dias.push({ clave: dia+1, valor: dia + ' días' });
				this.noches.push({ clave: dia+1, valor: dia + ' noches' });
			}
			this.cargarTours();
		},
		methods:{
			async cargarTours(){
				const respuesta = await fetch(this.servidor+'mostrarToursPortada.php',{
					method:'POST'
				})
				this.tours = await respuesta.json();
				this.contenidos=[];
				this.tours.forEach(dato=>{
					this.contenidos.push( {...JSON.parse(dato.contenido),
						calificacion: dato.calificacion,
						url: dato.url,
						descuento: dato.descuento ?? []
					});
				});
				console.table(this.contenidos);

			},
			
		}
	});
	app.mount('#app');
</script>
</body>