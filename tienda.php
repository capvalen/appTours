<!DOCTYPE html>

<html lang="es">

<head>

	<meta charset="UTF-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Filtro por producto</title>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

	<link rel="stylesheet" href="https://grupoeuroandino.com/app/render/icofont/icofont.min.css">
	<link rel="stylesheet" href="https://grupoeuroandino.com/app/render/css/efecto.css?v=1.5">


</head>

<body>


	<div class="container-fluid" id="app">

		<div class="row">

			

			<div class="col-12 col-md-3" id="panelIzquierdo" @contextmenu.prevent="onRightClick">

				<div class="col">

					<div class="accordion accordion-flush" id="acordeonPadre">

						<div class="accordion-item">

							<h2 class="accordion-header" id="acordeon1">

								<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#tipoViaje" aria-expanded="true" aria-controls="tipoViaje" data-bs-parent="#acordeonPadre">

									Tipo de Viaje

								</button>

							</h2>

							<div id="tipoViaje" class="accordion-collapse collapse show" aria-labelledby="tipoViaje" >

								<div class="accordion-body">

									<p class="my-1"><a href="#!" class="text-decoration-none text-secondary" :class="{activo: idTour==-1 }" @click="idTour = -1; idDia=-1; idCategoria=-1" >Todos</a></p>

									<p class="my-1"><a href="#!" class="text-decoration-none text-secondary" :class="{activo: idTour==1 }" @click="idTour = 1; idDia=1; idCategoria=-1" >Tours</a></p>

									<p class="my-1"><a href="#!" class="text-decoration-none text-secondary" :class="{activo: idTour==2 }" @click="idTour = 2; idDia=-1; idCategoria=-1" >Paquetes Turísticos</a></p>
									<p class="my-1"><a href="#!" class="text-decoration-none text-secondary" :class="{activo: idDia==0 }" @click="idTour=-1; idDia = 0; idCategoria=-1" >Half Day (Medio Día)</a></p>
									<p class="my-1"><a href="#!" class="text-decoration-none text-secondary" :class="{activo: idDia==1 }" @click="idTour=-1; idDia = 1; idCategoria=-1" >Full Day (1 Día)</a></p>
									<p class="my-1"><a href="#!" class="text-decoration-none text-secondary" :class="{activo: idCategoria==38 }" @click="idTour=-1; idDia=-1; idCategoria=38" >Viajes de Promoción Escolar</a></p>

								</div>

							</div>

						</div>

						<div class="accordion-item">
							<h2 class="accordion-header" id="acordeon3">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#tipoCiudad" aria-expanded="false" aria-controls="tipoCiudad" data-bs-parent="#acordeonPadre">
									Países
								</button>
							</h2>

							<div id="tipoCiudad" class="accordion-collapse collapse " aria-labelledby="tipoCiudad" >
								<div class="accordion-body">
									<p class="my-1"><a href="#!" class="text-decoration-none text-secondary" :class="{activo: idPais ==-1 }" @click="idPais = -1" >Todos</a></p>
									<p  v-for="pais in paises" class="my-1"><a href="#!" class="text-decoration-none text-secondary" :class="{activo: idPais == pais.idPais }" @click="idPais = pais.idPais" >{{pais.name}}</a></p>
								</div>
							</div>
						</div>

						<div class="accordion-item">

							<h2 class="accordion-header" id="acordeon2">

								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#tipoDepartamento" aria-expanded="false" aria-controls="tipoDepartamento" data-bs-parent="#acordeonPadre">

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
							<h2 class="accordion-header" id="acordeonCiudades">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#tipoCiudadesLista" aria-expanded="false" aria-controls="tipoCiudadesLista" data-bs-parent="#acordeonPadre">
									Ciudades
								</button>
							</h2>

							<div id="tipoCiudadesLista" class="accordion-collapse collapse " aria-labelledby="acordeonCiudades" >
								<div class="accordion-body">
									<p class="my-1"><a href="#!" class="text-decoration-none text-secondary" :class="{activo: idCiudad =='' }" @click="idCiudad = ''" >Todos</a></p>
									<p  v-for="ciudad in ciudades" class="my-1"><a href="#!" class="text-decoration-none text-secondary" :class="{activo: idCiudad == ciudad }" @click="idCiudad = ciudad" >{{ciudad}}</a></p>
								</div>
							</div>
						</div>



						<div class="accordion-item">

							<h2 class="accordion-header" id="acordeon4">

								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#tipoActividad" aria-expanded="false" aria-controls="tipoActividad" data-bs-parent="#acordeonPadre">

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

							<h2 class="accordion-header" id="acordeon5">

								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#tipoCategoria" aria-expanded="false" aria-controls="tipoCategoria" data-bs-parent="#acordeonPadre">

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

							<h2 class="accordion-header" id="acordeon6">

								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#tipoTransporte" aria-expanded="false" aria-controls="tipoTransporte" data-bs-parent="#acordeonPadre">

									Transporte

								</button>

							</h2>

							<div id="tipoTransporte" class="accordion-collapse collapse " aria-labelledby="tipoTransporte" >

								<div class="accordion-body">

									<p class="my-1"><a href="#!" class="text-decoration-none text-secondary" :class="{activo: idTransporte ==-1 }" @click="idTransporte = -1; transporteSelect='';" >Todos</a></p>

									<p  v-for="(transporte, index) in transportes" class="my-1"><a href="#!" class="text-decoration-none text-secondary" :class="{activo: idTransporte == transporte.id }" @click="idTransporte = transporte.id; transporteSelect=transporte.id" >{{transporte.transporte}}</a></p>

								</div>

							</div>

						</div>



						<div class="accordion-item">

							<h2 class="accordion-header" id="acordeon7">

								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#tipoHospedaje" aria-expanded="false" aria-controls="tipoHospedaje" data-bs-parent="#acordeonPadre">

									Alojamientos

								</button>

							</h2>

							<div id="tipoHospedaje" class="accordion-collapse collapse " aria-labelledby="tipoHospedaje" >

								<div class="accordion-body">

									<p class="my-1"><a href="#!" class="text-decoration-none text-secondary" :class="{activo: idHospedaje ==-1 }" @click="idHospedaje = -1; hospedajeSelect='';" >Todos</a></p>

									<p  v-for="(hospedaje, index) in hospedajes" class="my-1"><a href="#!" class="text-decoration-none text-secondary" :class="{activo: idHospedaje == hospedaje.id }" @click="idHospedaje = hospedaje.id; hospedajeSelect=index" >{{hospedaje.alojamiento}}</a></p>

								</div>

							</div>

						</div>



						<div class="accordion-item">

							<h2 class="accordion-header" id="acordeon8">

								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#tipoDia" aria-expanded="false" aria-controls="tipoDia" data-bs-parent="#acordeonPadre">

									Días

								</button>

							</h2>

							<div id="tipoDia" class="accordion-collapse collapse " aria-labelledby="tipoDia" >

								<div class="accordion-body">

									<p class="my-1"><a href="#!" class="text-decoration-none text-secondary" :class="{activo: idDia ==-1 }" @click="idDia = -1" >Todos</a></p>

									<p  v-for="(dia, index) in dias" class="my-1"><a href="#!" class="text-decoration-none text-secondary" :class="{activo: idDia == index }" @click="idDia = index" >{{dia.valor}}</a></p>

								</div>

							</div>

						</div>



						<div class="accordion-item">

							<h2 class="accordion-header" id="acordeon9">

								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#tipoPrecios" aria-expanded="false" aria-controls="tipoPrecios" data-bs-parent="#acordeonPadre">

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



			<div class="col-12 col-md-9 " id="top">

				<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3">
					<div class="col my-2 " v-for="(tour, index) in productos" :key="tour.id">
						<Card :duracion='duracion' :dias='dias' :noches='noches' :tour='tour'/>
					</div>
				</div>
				<div v-if="productos.length==0" class="text-center my-5">
					<img src="https://grupoeuroandino.com/images/vacio.png" alt="Sin resultados" class="img-fluid mb-3" style="max-width: 200px;">
					<h5 class="text-muted">No existen productos que coincidan</h5>
					<p class="text-muted">Intenta con otros filtros de búsqueda</p>
				</div>

				<div class="text-center my-4" v-if="paginaActual < totalPaginas">
					<button class="btn btn-outline-primary btn-lg rounded-pill px-5" @click="cargarMas" :disabled="cargando">
						<span v-if="!cargando"> <i class="icofont-dotted-down"></i> ¡Cargar más aventuras!</span>
						<span v-else>Cargando...</span>
					</button>
				</div>

			</div>

			

		</div>

	</div>


	<script src="https://grupoeuroandino.com/app/render/configuracion.js?v=1.0.2"></script>
	<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>

	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
	<script src="https://grupoeuroandino.com/app/render/js/axios.min.js"></script>


	<script type="module">
	import Card from 'https://grupoeuroandino.com/app/render/js/card.js?v=1.0.14';
	var modalNuevo, modalNuevoPack, qDescripcion, qPartida, qItinerario, qNotas, offPanel,

	tostadaOk, tostadaMal;

	//var rutaDocs = 'C:/xampp8/htdocs/euroAndinoApi/subidas/'; 

	
	const { createApp } = Vue;

	const app = createApp({

		el: '#app',
		components:{Card},
		data(){ return {

			//servidor: 'http://localhost/appTours/api/',

			servidor: window.lugarApi, 
			dias:[], actividades:[], categorias:[],
			idTour:-1, idActividad:-1, idDepartamento:-1,idCategoria:-1, idDia:-1, idPrecio:-1, idTransporte:-1, idHospedaje:-1, idCiudad:-1, texto:'', idDuracion:-1,

			precios:['Hasta S/ 150.00', 'De S/ 151.00 a S/ 300.00', 'De S/ 301.00 a S/ 500.00', 'De S/ 501.00 a S/ 1000.00', 'De S/ 1001.00 a S/ 1500.00', 'De S/ 1501.00 a S/ 2000.00', 'Más de S/ 2000.00' ], 

			actividadSelect:'', categoriaSelect:'',transporteSelect:'', hospedajes:[], hospedajeSelect:'', productos:[],
			departamentos:['Amazonas', 'Ancash', 'Apurimac', 'Arequipa', 'Ayacucho', 'Cajamarca', 'Cusco', 'Callao', 'Huancavelica','Huánuco', 'Ica', 'Junín', 'La Libertad', 'Lambayeque', 'Lima', 'Loreto', 'Madre de Dios', 'Moquegua', 'Pasco', 'Piura', 'Puno','San Martín', 'Tacna', 'Tumbes', 'Ucayali' ],
			duracion: [{ clave: 1, valor: 'Half Day (Medio día)' }, { clave: 2, valor: 'Full Day (1 día)' }],
			dias: [{ clave: 1, valor: 'Half Day (Medio día)' }, { clave: 2, valor: 'Full Day (1 día)' }],
			noches: [{ clave: 1, valor: '0 noches' }, { clave: 2, valor: '1 noche' }],
			transportes:[
				{id: 1, transporte:'Terrestre'},
				{id: 2, transporte:'Aéreo'},
				{id: 4, transporte:'Acuático'}
			],
			paises:[], idPais:140,
			paginaActual: 1,
			totalPaginas: 1,
			bloque: 50,
			cargando: false,
		}},

		mounted(){

			for (let dia = 2; dia <= 31; dia++) {
				this.duracion.push({ clave: dia+1, valor: dia + ' días / 0 noches' });
				this.dias.push({ clave: dia+1, valor: dia + ' días' });
				this.noches.push({ clave: dia+1, valor: dia + ' noches' });
			}
			
			this.cargar();
			this.buscarEnTienda();
		},

		methods:{

			async cargar(){

				let respServ = await fetch(this.servidor+'pedirDatosTienda.php',{
					method:'POST'
				});
				axios.post(this.servidor + 'Alojamientos.php',{
					pedir: 'listar'
				})
				.then(serv=> this.hospedajes = serv.data )
				let temporal = await respServ.json();

				this.actividades = temporal[0];
				this.categorias = temporal[1];
				this.ciudades = temporal[2];
				this.paises = temporal[3];

			},

			async buscarEnTienda(){
				this.cargando = true;
				this.paginaActual = 1;
				this.pedidos=[];
				this.productos=[];

				let datos = new FormData();
				datos.append('idTour', this.idTour);
				datos.append('idActividad', this.idActividad);
				datos.append('actividad', this.actividadSelect);
				datos.append('idPais', this.idPais);
				datos.append('idDepartamento', this.idDepartamento);
				datos.append('idCiudad', this.idCiudad);
				datos.append('idCategoria', this.idCategoria);
				datos.append('idTransporte', this.idTransporte);
				datos.append('idHospedaje', this.idHospedaje);
				datos.append('categoria', this.categoriaSelect);
				datos.append('idDia', this.idDia+1);
				datos.append('idPrecio', this.idPrecio);
				datos.append('texto', this.texto);
				datos.append('bloque', this.bloque);
				datos.append('pagina', this.paginaActual);

				let respServ = await fetch(this.servidor+'buscarFiltroTienda.php',{
					method:'POST', body:datos
				});

				let resp = await respServ.json();
				this.totalPaginas = resp.totalPaginas;
				this.pedidos = resp.data;

				this.bandera = resp.data[0]?.namePais.toLowerCase().replace('/ \w+/g', '_') + '.jpeg'

				resp.data.forEach(dato =>{
					this.productos.push( {...JSON.parse(dato.contenido),
						calificacion: dato.calificacion,
						url: dato.url,
						descuento: dato.descuento ?? []
					});
				})
				this.cargando = false;

				const elementoTop = document.getElementById('top');
				window.scrollTo({
            top: elementoTop.offsetTop,
            behavior: 'smooth'
        });

			},

			queFoto(prod){
				//console.log( prod );

				if(prod.fotos.length==0){

					return 'https://grupoeuroandino.com/app/render/images/defecto.jpg';

				}else{

					return 'https://grupoeuroandino.com/app/render/images/subidas/'+ prod.fotos[0].nombreRuta;

				}
			},
			formatoMoneda(valor){
				return parseFloat(valor).toFixed(0)
			},

			queId(index){

				return this.pedidos[index].id;

			},
			
			onRightClick(event) {
				console.log("Clic derecho detectado", event);
			},
			async cargarMas(){
				this.cargando = true;
				this.paginaActual++;

				let datos = new FormData();
				datos.append('idTour', this.idTour);
				datos.append('idActividad', this.idActividad);
				datos.append('actividad', this.actividadSelect);
				datos.append('idPais', this.idPais);
				datos.append('idDepartamento', this.idDepartamento);
				datos.append('idCiudad', this.idCiudad);
				datos.append('idCategoria', this.idCategoria);
				datos.append('idTransporte', this.idTransporte);
				datos.append('idHospedaje', this.idHospedaje);
				datos.append('categoria', this.categoriaSelect);
				datos.append('idDia', this.idDia+1);
				datos.append('idPrecio', this.idPrecio);
				datos.append('texto', this.texto);
				datos.append('bloque', this.bloque);
				datos.append('pagina', this.paginaActual);

				let respServ = await fetch(this.servidor+'buscarFiltroTienda.php',{
					method:'POST', body:datos
				});

				let resp = await respServ.json();

				resp.data.forEach(dato =>{
					this.productos.push( {...JSON.parse(dato.contenido),
						calificacion: dato.calificacion,
						url: dato.url,
						descuento: dato.descuento ?? []
					});
				})
				this.cargando = false;
			},
		}

	});
	app.mount('#app');
	

</script>

</body>

</html>