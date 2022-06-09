<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Filtro por producto</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" href="icofont/icofont.min.css">
</head>
<body>
	<style>
		.accordion-button:not(.collapsed){
			background-color: #ffffff;
			font-weight: bold;
		}
		.activo{
			color: #000!important;
			font-weight: bold;
		}
	</style>
	<div class="container-fluid" id="app">
		<div class="row">
			
			<div class="col-12 col-md-4 col-lg-3">
				<div class="col">
					<div class="accordion accordion-flush" id="acordeonPadre">
						<div class="accordion-item">
							<h2 class="accordion-header" id="acordeon1">
								<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#tipoViaje" aria-expanded="true" aria-controls="tipoViaje" data-bs-parent="#acordeonPadre">
									Tipo de viaje
								</button>
							</h2>
							<div id="tipoViaje" class="accordion-collapse collapse show" aria-labelledby="tipoViaje" >
								<div class="accordion-body">
									<p class="my-1"><a href="#!" class="text-decoration-none text-secondary" :class="{activo: idTour==-1 }" @click="idTour = -1" >Todos</a></p>
									<p class="my-1"><a href="#!" class="text-decoration-none text-secondary" :class="{activo: idTour==1 }" @click="idTour = 1" >Tours</a></p>
									<p class="my-1"><a href="#!" class="text-decoration-none text-secondary" :class="{activo: idTour==2 }" @click="idTour = 2" >Paquetes turísticos</a></p>
								</div>
							</div>
						</div>

						<div class="accordion-item">
							<h2 class="accordion-header" id="acordeon2">
								<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#tipoActividad" aria-expanded="false" aria-controls="tipoActividad" data-bs-parent="#acordeonPadre">
									Actividades
								</button>
							</h2>
							<div id="tipoActividad" class="accordion-collapse collapse " aria-labelledby="tipoActividad" >
								<div class="accordion-body">
									<p class="my-1"><a href="#!" class="text-decoration-none text-secondary" :class="{activo: idActividad ==-1 }" @click="idActividad = -1; actividadSelect='';" >Todos</a></p>
									<p  v-for="actividad in actividades" class="my-1"><a href="#!" class="text-decoration-none text-secondary" :class="{activo: idActividad == actividad.id }" @click="idActividad = actividad.id; actividadSelect=actividad.nombre;" >{{actividad.nombre}}</a></p>
								</div>
							</div>
						</div>

						<div class="accordion-item">
							<h2 class="accordion-header" id="acordeon3">
								<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#tipoDepartamento" aria-expanded="false" aria-controls="tipoDepartamento" data-bs-parent="#acordeonPadre">
									Departamentos
								</button>
							</h2>
							<div id="tipoDepartamento" class="accordion-collapse collapse " aria-labelledby="tipoDepartamento" >
								<div class="accordion-body">
									<p class="my-1"><a href="#!" class="text-decoration-none text-secondary" :class="{activo: idDepartamento ==-1 }" @click="idDepartamento = -1" >Todos</a></p>
									<p  v-for="(departamento, index) in departamentos" class="my-1"><a href="#!" class="text-decoration-none text-secondary" :class="{activo: idDepartamento == index }" @click="idDepartamento = index" >{{departamento}}</a></p>
								</div>
							</div>
						</div>

						<div class="accordion-item">
							<h2 class="accordion-header" id="acordeon4">
								<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#tipoCategoria" aria-expanded="false" aria-controls="tipoCategoria" data-bs-parent="#acordeonPadre">
									Categorías
								</button>
							</h2>
							<div id="tipoCategoria" class="accordion-collapse collapse " aria-labelledby="tipoCategoria" >
								<div class="accordion-body">
									<p class="my-1"><a href="#!" class="text-decoration-none text-secondary" :class="{activo: idCategoria ==-1 }" @click="idCategoria = -1; categoriaSelect='';" >Todos</a></p>
									<p  v-for="categoria in categorias" class="my-1"><a href="#!" class="text-decoration-none text-secondary" :class="{activo: idCategoria == categoria.id }" @click="idCategoria = categoria.id; categoriaSelect=categoria.nombre" >{{categoria.nombre}}</a></p>
								</div>
							</div>
						</div>

						<div class="accordion-item">
							<h2 class="accordion-header" id="acordeon5">
								<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#tipoDia" aria-expanded="false" aria-controls="tipoDia" data-bs-parent="#acordeonPadre">
									Días
								</button>
							</h2>
							<div id="tipoDia" class="accordion-collapse collapse " aria-labelledby="tipoDia" >
								<div class="accordion-body">
									<p class="my-1"><a href="#!" class="text-decoration-none text-secondary" :class="{activo: idDia ==-1 }" @click="idDia = -1" >Todos</a></p>
									<p  v-for="dia in dias" class="my-1"><a href="#!" class="text-decoration-none text-secondary" :class="{activo: idDia == dia }" @click="idDia = dia" >{{dia}}</a></p>
								</div>
							</div>
						</div>

						<div class="accordion-item">
							<h2 class="accordion-header" id="acordeon5">
								<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#tipoPrecios" aria-expanded="false" aria-controls="tipoPrecios" data-bs-parent="#acordeonPadre">
									Precios
								</button>
							</h2>
							<div id="tipoPrecios" class="accordion-collapse collapse " aria-labelledby="tipoPrecios" >
								<div class="accordion-body">
									<p class="my-1"><a href="#!" class="text-decoration-none text-secondary" :class="{activo: idPrecio ==-1 }" @click="idPrecio = -1" >Todos</a></p>
									<p  v-for="(precio, index) in precios" class="my-1"><a href="#!" class="text-decoration-none text-secondary" :class="{activo: idPrecio == index }" @click="idPrecio =index" >{{precio}}</a></p>
								</div>
							</div>
						</div>
						
					</div>
					<div class="d-grid gap-1 mt-3">
						<button class="btn btn-primary" type="button" @click="buscarEnTienda()"><i class="icofont-search-1"></i> Realizar búsqueda</button>
					</div>
				</div>
			
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
			departamentos:['Amazonas', 'Ancash', 'Apurimac', 'Arequipa', 'Ayacucho', 'Cajamarca', 'Cusco', 'El Callao', 'Huancavelica','Huánuco', 'Ica', 'Junín', 'Chanchamayo', 'Chupaca', 'Concepción', 'Huancayo', 'Jauja', 'Junín', 'Satipo', 'Tarma', 'Yauli', 'La Libertad', 'Lambayeque', 'Lima', 'Loreto', 'Madre de Dios', 'Moquegua', 'Pasco', 'Piura', 'Puno','San Martín', 'Tacna', 'Tumbes', 'Ucayali' ],
			dias:[], actividades:[], categorias:[],
			idTour:-1, idActividad:-1, idDepartamento:-1,idCategoria:-1, idDia:-1, idPrecio:-1,
			precios:['Hasta S/ 150.00', 'De S/ 151.00 a S/ 300.00', 'De S/ 301.00 a S/ 500.00', 'De S/ 501.00 a S/ 1000.00', 'De S/ 1001.00 a S/ 1500.00', 'De S/ 1501.00 a S/ 2000.00', 'Más de S/ 2000.00' ], actividadSelect:'', categoriaSelect:''
		},
		mounted:function(){
			this.cargar();
			for(let i=1; i<=31 ; i++ ){
				this.dias.push(i);
			}
			
			//modalNuevo = new bootstrap.Modal( document.getElementById('modalNuevo') );
			
		},
		methods:{
			async cargar(){
				let respServ = await fetch(this.servidor+'pedirDatosTienda.php',{
					method:'POST'
				});
				//console.log( await respServ.text() );
				let temporal = await respServ.json();
				this.actividades = temporal[0]
				this.categorias = temporal[1]
			},
			async buscarEnTienda(){
				let datos = new FormData();
				datos.append('idTour', this.idTour);
				datos.append('idActividad', this.idActividad);
				datos.append('actividad', this.actividadSelect);
				datos.append('idDepartamento', this.idDepartamento);
				datos.append('idCategoria', this.idCategoria);
				datos.append('categoria', this.categoriaSelect);
				datos.append('idDia', this.idDia);
				datos.append('idPrecio', this.idPrecio);
				let respServ = await fetch(this.servidor+'buscarFiltroTienda.php',{
					method:'POST', body:datos
				});
				console.log( await respServ.json() );
			}
		}
	});
	
</script>
</body>
</html>