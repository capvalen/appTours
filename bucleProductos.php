<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Bucle</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
	<link rel="stylesheet" href="https://grupoeuroandino.com/app/render/icofont/icofont.min.css">
	<link rel="stylesheet" href="https://grupoeuroandino.com/app/render/css/efecto.css?v?1">
</head>
<body class="container-fluid">
	<style>
	
		.subText{
			font-size: 0.8rem;
		}
		.precio{font-size: 1.7rem;font-weight:bold; color: rgb(58, 91, 255);}
		.precioAnt{font-size: 0.8rem;text-decoration:line-through; color: rgb(58, 91, 255);}
		.divOferta{ height:60px; border-radius: 50%; color:white; font-size: 0.8rem;  }
		.precio2{font-size: 1.7rem;font-weight:bold; /* color: rgb(192, 0, 67); */}
		.precioAnt2{text-decoration:line-through; /* color: rgb(192, 0, 67); */}
		.divOferta2{width: 70px; height: 25px; /* rgb(192, 0, 67);  */ margin-top: 1rem; margin-right: 0rem; color:white; font-size: 0.8rem;  }
		/* .estrellas{color: rgb(58, 91, 255);} */
		.estrellas{color: #ffd400;}
		.divImagen img{
			width:100%!important;
			height: 320px!important;
    	object-fit: cover!important;
		}
		.card{box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;transition: transform 220ms ease 0s;}
		.card:hover{ transition: transform 220ms ease 0s; transform: translateX(0px) translateY(-11px); }
		#spanOferta{ background-color: #2768b7; }
		#spanAlimentacion{ background-color: #6745ef; }
		#spanTour{ background-color: #0cbf19; }
		#spanGuia{ background-color: #ffc107; }
		#spanTickets{ background-color: #e91616; }
		#spanTransporte{ background-color: #bf0ca9; }	
		.bandera {width: 20px;}
		.titulo{font-size: 1.25rem;}
		.icofont-google-map{margin-left:3px!important;}
		.moneda-peque{font-size:15px}
		#pegar p{line-height: 1;}
	</style>
	<div id="app">
		<div class="row row-cols-1 row-cols-md-2 row-cols-lg-4">
			<div class="col my-3" v-for="tour in contenidos">
				<Card :duracion='duracion' :dias='dias' :noches='noches' :tour='tour'/>
			</div>
			
		</div>
	</div>
	<script src="https://grupoeuroandino.com/app/render/configuracion.js?v=1.0.1"></script>
	<!-- Vue desarrollo -->
<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script> -->
<!-- Vue producción -->
<!-- <script src="https://cdn.jsdelivr.net/npm/vue@2"></script> -->
<script type="module">
	import Card from 'https://grupoeuroandino.com/app/render/js/card.js?v=1.0.6';
	const { createApp } = Vue;
	const app = createApp({
		data(){ return {
			//servidor: 'http://localhost/appTours/api/',
			servidor: window.lugarApi,
			tours:[],
			contenidos:[], //{fotos:[{nombreRuta:''}], valor: 0, duracion:0, peruanos:{adultos:0, kids:0}, extranjeros:{adultos:0, kids:0},}
			duracion: [{ clave: 1, valor: 'Half Day (Medio día)' }, { clave: 2, valor: 'Full Day (1 día)' }],
			dias: [{ clave: 1, valor: 'Half Day (Medio día)' }, { clave: 2, valor: 'Full Day (1 día)' }],
			noches: [{ clave: 1, valor: '0 noches' }, { clave: 2, valor: '1 noche' }],
		}},
		components:{Card},
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