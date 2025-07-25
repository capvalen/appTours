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

	.accordion-button:not(.collapsed){

		background-color: #ffffff;

		font-weight: bold;

	}

	.activo{

		color: #000!important;

		font-weight: bold;

	}

	.estrellas{color: #ffd400;}
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

			height: 320px!important;

    	object-fit: cover!important;

		}

	.subText {
    font-size: 0.8rem;
}
.card:hover {
    transition: transform 220ms ease 0s;
    transform: translateX(0px) translateY(-11px);
}
.card {
    box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
    transition: transform 220ms ease 0s;
}
.divOferta2 {
    width: 70px;
    height: 25px;
    margin-top: 1rem;
    margin-right: 0rem;
    color: white;
    font-size: 0.8rem;
}

#spanOferta{ background-color: #2768b7; }
		#spanAlimentacion{ background-color: #6745ef; }
		#spanTour{ background-color: #0cbf19; }
		#spanGuia{ background-color: #ffc107; }
		#spanTickets{ background-color: #e91616; }
		#spanTransporte{ background-color: #bf0ca9; }
		.bandera { width: 20px; }
		.titulo{font-size: 1.25rem;}
		.icofont-google-map{margin-left:3px!important;}
</style>

	<div class="container-fluid" id="app">

		<div class="row">

			

			<div class="col-12 col-md-3">

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

									<p class="my-1"><a href="#!" class="text-decoration-none text-secondary" :class="{activo: idTour==-1 }" @click="idTour = -1; idDia=-1" >Todos</a></p>

									<p class="my-1"><a href="#!" class="text-decoration-none text-secondary" :class="{activo: idTour==1 }" @click="idTour = 1" >Tours</a></p>

									<p class="my-1"><a href="#!" class="text-decoration-none text-secondary" :class="{activo: idTour==2 }" @click="idTour = 2" >Paquetes turísticos</a></p>
									<p class="my-1"><a href="#!" class="text-decoration-none text-secondary" :class="{activo: idTour==2 }" @click="idDia = 1" >Half Day (Medio Día)</a></p>
									<p class="my-1"><a href="#!" class="text-decoration-none text-secondary" :class="{activo: idTour==2 }" @click="idDia = 1" >Full Day (1 Día)</a></p>

								</div>

							</div>

						</div>

						<div class="accordion-item">
							<h2 class="accordion-header" id="acordeon3">
								<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#tipoCiudad" aria-expanded="false" aria-controls="tipoCiudad" data-bs-parent="#acordeonPadre">
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
							<h2 class="accordion-header" id="acordeon3">
								<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#tipoCiudad" aria-expanded="false" aria-controls="tipoCiudad" data-bs-parent="#acordeonPadre">
									Ciudades
								</button>
							</h2>

							<div id="tipoCiudad" class="accordion-collapse collapse " aria-labelledby="tipoCiudad" >
								<div class="accordion-body">
									<p class="my-1"><a href="#!" class="text-decoration-none text-secondary" :class="{activo: idCiudad =='' }" @click="idCiudad = ''" >Todos</a></p>
									<p  v-for="ciudad in ciudades" class="my-1"><a href="#!" class="text-decoration-none text-secondary" :class="{activo: idCiudad == ciudad }" @click="idCiudad = ciudad" >{{ciudad}}</a></p>
								</div>
							</div>
						</div>



						<div class="accordion-item">

							<h2 class="accordion-header" id="acordeon4">

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

							<h2 class="accordion-header" id="acordeon5">

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

							<h2 class="accordion-header" id="acordeon6">

								<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#tipoTransporte" aria-expanded="false" aria-controls="tipoTransporte" data-bs-parent="#acordeonPadre">

									Transporte

								</button>

							</h2>

							<div id="tipoTransporte" class="accordion-collapse collapse " aria-labelledby="tipoTransporte" >

								<div class="accordion-body">

									<p class="my-1"><a href="#!" class="text-decoration-none text-secondary" :class="{activo: idTransporte ==-1 }" @click="idTransporte = -1; transporteSelect='';" >Todos</a></p>

									<p  v-for="(transporte, index) in transportes" class="my-1"><a href="#!" class="text-decoration-none text-secondary" :class="{activo: idTransporte == index+1 }" @click="idTransporte = index+1; transporteSelect=transporte" >{{transporte}}</a></p>

								</div>

							</div>

						</div>



						<div class="accordion-item">

							<h2 class="accordion-header" id="acordeon7">

								<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#tipoHospedaje" aria-expanded="false" aria-controls="tipoHospedaje" data-bs-parent="#acordeonPadre">

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

								<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#tipoDia" aria-expanded="false" aria-controls="tipoDia" data-bs-parent="#acordeonPadre">

									Días

								</button>

							</h2>

							<div id="tipoDia" class="accordion-collapse collapse " aria-labelledby="tipoDia" >

								<div class="accordion-body">

									<p class="my-1"><a href="#!" class="text-decoration-none text-secondary" :class="{activo: idDia ==-1 }" @click="idDia = -1" >Todos</a></p>

									<p  v-for="(dia, index) in dias" class="my-1"><a href="#!" class="text-decoration-none text-secondary" :class="{activo: idDia == index }" @click="idDia = index" >{{dia}}</a></p>

								</div>

							</div>

						</div>



						<div class="accordion-item">

							<h2 class="accordion-header" id="acordeon9">

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



			<div class="col-12-col-md-8 col-lg-9">

				<div class="row row-cols-1 row-cols-md-3 row-cols-lg-3">

					<div class="col my-2 " v-for="(producto, index) in productos" :key="producto.id">

						<div class="card h-100 border-0  " >
						    <div class="position-relative">
									<div class="divOferta2 w-100 position-absolute bottom-0 end-0 d-flex justify-content-end mb-2 me-1">
											<span v-if="producto.transporte==1" class="mx-1 px-1 rounded" id="spanTransporte">Bus</span>
											<span v-if="producto.transporte==2" class="mx-1 px-1 rounded" id="spanTransporte">Avión</span>
											<span v-if="producto.alojamiento" class="mx-1 px-1 rounded" id="spanOferta"> {{retornarHospedaje(producto.alojamiento)}}</span>
											<span v-if="producto.alimentacion" class="mx-1 px-1 rounded" id="spanAlimentacion">Alimentación</span>
											<span class="mx-1 px-1 rounded" id="spanTour">Tour</span>
											<span v-if="producto.guia" class="mx-1 px-1 rounded" id="spanGuia">Guía</span>
											<span v-if="producto.tickets" class="mx-1 px-1 rounded" id="spanTickets">Tickets</span>
										</div>
									<a :href="'https://grupoeuroandino.com/tours/' + pedidos[index].url" target="_parent">
										<img :src="queFoto(producto)" class="card-img-top rounded-top" alt="...">
									</a>
								</div>

							<div class="card-body">

								<h5 class="card-title mb-0">

									<a class="text-decoration-none text-dark" v-if="producto.tipo=='1'" :href="'https://grupoeuroandino.com/tours/' + pedidos[index].url" target="_parent">{{producto.nombre}}</a></strong>

									<a class="text-decoration-none text-dark" v-if="producto.tipo=='2'" :href="'https://grupoeuroandino.com/tours/' + pedidos[index].url" target="_parent">{{producto.nombre}}</a></strong>

								</h5>

						<div class="row row-cols-2">
							<div style="color:#000">
									<span><img class="bandera" src="https://grupoeuroandino.com/images/banderas/peru.jpeg"> <strong>{{queDepa(producto.departamento)}},</strong></span>
									<br>
									<i class="icofont-google-map"></i> <span class="text-capitalize"><strong> {{producto.destino}}</strong></span>
									<div class="estrellas"><i class="icofont-star"></i><i class="icofont-star"></i><i class="icofont-star"></i><i class="icofont-star"></i><i class="icofont-star"></i></div>
								<span class="text-muted subText">{{queDuracion(producto.duracion, producto.tipo)}}</span>
							</div>

							<div class="text-end " style="color:#000">

								<span class="precio2"><span class="monedita fs-6">S/</span> {{formatoMoneda(producto.peruanos.adultos)}}</span>
								<p class="mb-0 text-end"><small>Precio normal</small></p>

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

			

		</div>

	</div>



	<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>

	

	

	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
	<script src="https://grupoeuroandino.com/app/render/js/axios.min.js"></script>



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
			ciudades:[], idCiudad:'', bandera:'',

			dias:[], actividades:[], categorias:[],

			idTour:-1, idActividad:-1, idDepartamento:-1,idCategoria:-1, idDia:-1, idPrecio:-1, idTransporte:-1, idHospedaje:-1, texto:'', idDuracion:-1,

			precios:['Hasta S/ 150.00', 'De S/ 151.00 a S/ 300.00', 'De S/ 301.00 a S/ 500.00', 'De S/ 501.00 a S/ 1000.00', 'De S/ 1001.00 a S/ 1500.00', 'De S/ 1501.00 a S/ 2000.00', 'Más de S/ 2000.00' ], 

			actividadSelect:'', categoriaSelect:'',transporteSelect:'', hospedajeSelect:'', productos:[],

			duracion: [{clave: 1, valor: 'Half Day (Medio día)'}, {clave: 2, valor: 'Full Day (1 día)'} ], 

			duracionDias: [{clave: 1, valor: 'Half Day (Medio día)'}, {clave: 2, valor: 'Full Day (1 día)'} ], 

			duracionNoches:[{clave: 1, valor:'0 noches'}, {clave: 2, valor:'1 noche'}], pedidos:[], transportes:['Terrestre', 'Aéreo'],

			hospedajes:[], paises:[], idPais:140

		},

		mounted:function(){

			this.cargar();
			this.dias.push('Half Day (Medio Día)')
			this.dias.push('Full Day (1 Día)')

			for(let i=2; i<=31 ; i++ ){
				this.dias.push(i +' días');
			}

			for (let dia = 2; dia <= 31; dia++) {

				this.duracion.push({ clave: dia+1, valor: dia + " días / 0 noches" });

				this.duracionDias.push({ clave: dia+1, valor: dia + " días" });

				this.duracionNoches.push({ clave: dia+1, valor: dia + ' noches' });

			}

			this.buscarEnTienda();



			

			//modalNuevo = new bootstrap.Modal( document.getElementById('modalNuevo') );

			

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
				//console.log( await respServ.text() );

				let temporal = await respServ.json();

				this.actividades = temporal[0];
				this.categorias = temporal[1];
				this.ciudades = temporal[2];
				this.paises = temporal[3];

			},

			async buscarEnTienda(){
				
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

				let respServ = await fetch(this.servidor+'buscarFiltroTienda.php',{

					method:'POST', body:datos

				});

				//console.log( await respServ.json() );

				this.pedidos = await respServ.json();
				this.bandera = this.pedidos[0].namePais.toLowerCase().replace('/ \w+/g', '_') + '.jpeg'

				this.pedidos.forEach(data =>{

					this.productos.push(JSON.parse(data.contenido))

				})

			},

			queFoto(prod){

				//console.log( prod );

				if(prod.fotos.length==0){

					return 'https://grupoeuroandino.com/app/render/images/defecto.jpg';

				}else{

					return 'https://grupoeuroandino.com/app/render/images/subidas/'+ prod.fotos[0].nombreRuta;

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

			queDepa(valor){

				return this.departamentos[valor];

			},

			formatoMoneda(valor){

				return parseFloat(valor).toFixed(2)

			},

			queId(index){

				return this.pedidos[index].id;

			},
			retornarHospedaje(id){
				let al = this.hospedajes.find(x=> x.id == id)
				if (al) return al.alojamiento
			}

		}

	});

	

</script>

</body>

</html>