<<<<<<< HEAD
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Bucle</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" href="https://grupoeuroandino.com/app/render/icofont/icofont.min.css">
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
		.precioAnt2{font-size: 0.8rem;text-decoration:line-through; /* color: rgb(192, 0, 67); */}
		.divOferta2{width: 70px; height: 25px; /* rgb(192, 0, 67);  */ margin-top: 1rem; margin-right: 0rem; color:white; font-size: 0.8rem;  }
		/* .titulo>a, .estrellas{color: rgb(58, 91, 255);} */
		.estrellas{color: #ffd400;}
		.divImagen img{
			width:100%!important;
			height: 320px!important;
    	object-fit: cover!important;
		}
		.card{box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;transition: transform 220ms ease 0s;}
		.card:hover{ transition: transform 220ms ease 0s; transform: translateX(0px) translateY(-11px); }
		#spanOferta{ background-color: #2768b7; }
		#spanAlimentacion{ background-color: #f19c02; }
		#spanTour{ background-color: #0cbf19; }
		#spanGuia{ background-color: #ffc107; }
		#spanTickets{ background-color: #e91616; }
		#spanTransporte{ background-color: #bf0ca9; }
	</style>
	<div id="app">
		<div class="row row-cols-12 row-cols-md-2 row-cols-lg-4">
			<div class="col my-3" v-for="(tour, index) in contenidos">
				<div class="card border-0  position-relative">
					<div class="divOferta2 w-100 position-absolute end-0 d-flex justify-content-end">
						<span v-if="tour.transporte==1" class="mx-1 px-1 rounded" id="spanTransporte"><i class="icofont-car-alt-4"></i></span>
						<span v-if="tour.transporte==2" class="mx-1 px-1 rounded" id="spanTransporte"><i class="icofont-airplane-alt"></i></span>
						<span v-if="tour.alojamiento" class="mx-1 px-1 rounded" id="spanOferta"> {{hospedajes[tour.alojamiento]}}</span>
						<span class="mx-1 px-1 rounded" id="spanAlimentacion">Alimentación</span>
						<span v-if="tour.tipo==1" class="mx-1 px-1 rounded" id="spanTour">Tour</span>
						<span v-else class="mx-1 px-1 rounded" id="spanTour">Paquete</span>
						<span class="mx-1 px-1 rounded" id="spanGuia">Guía</span>
						<span class="mx-1 px-1 rounded" id="spanTickets">Tickets</span>
					</div>

					<div v-if="tour.fotos.length>0" class="divImagen card-img-top">
						<a class="aImgs" v-if="tour.tipo==1" :href="'https://grupoeuroandino.com/tours/' + tours[index].url" target="_parent"><img class="img-fluid rounded-top" :src="'https://grupoeuroandino.com/app/render/images/subidas/'+tour.fotos[0].nombreRuta" alt=""></a>
						<a class="aImgs" v-if="tour.tipo==2" :href="'https://grupoeuroandino.com/tours/' + tours[index].url" target="_parent"><img class="img-fluid rounded-top" :src="'https://grupoeuroandino.com/app/render/images/subidas/'+tour.fotos[0].nombreRuta" alt=""></a>
					</div>
					<div class="card-body">
						<div class="divProducto ">
							
							
							<div>
								<p class="mb-0 titulo text-capitalize"><strong>
									<a class="text-decoration-none text-dark" v-if="tour.tipo==1" :href="'https://grupoeuroandino.com/tours/' + tours[index].url" target="_parent">{{tour.nombre}}</a>
									<a class="text-decoration-none text-dark" v-if="tour.tipo==2" :href="'https://grupoeuroandino.com/tours/' + tours[index].url" target="_parent">{{tour.nombre}}</a>
									</strong>
								</p>
								<div class="estrellas">
									<i class="icofont-star"></i><i class="icofont-star"></i><i class="icofont-star"></i><i class="icofont-star"></i><i class="icofont-star"></i>
								</div>
								
								<div class="row row-cols-2">
									<div><i class="icofont-google-map"></i> <span class="text-capitalize"><strong>{{tour.destino}}, {{queDepa(tour.departamento)}}</strong></span> <br>
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
			
		</div>
	</div>
<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
<script>
	
	var app = new Vue({
		el: '#app',
		data:{
			//servidor: 'http://localhost/euroAndinoApi/',
			servidor: 'https://grupoeuroandino.com/app/api/',
			duracion: [{clave: 1, valor: 'Half Day (Medio día)'}, {clave: 2, valor: 'Full Day (1 día)'} ],
			duracionDias: [{clave: 1, valor: 'Half Day (Medio día)'}, {clave: 2, valor: 'Full Day (1 día)'} ],
			duracionNoches:[{clave: 1, valor:'0 noches'}, {clave: 2, valor:'1 noche'}],
			departamentos:['Amazonas', 'Ancash', 'Apurimac', 'Arequipa', 'Ayacucho', 'Cajamarca', 'Cusco', 'Callao', 'Huancavelica','Huánuco', 'Ica', 'Junín', 'La Libertad', 'Lambayeque', 'Lima', 'Loreto', 'Madre de Dios', 'Moquegua', 'Pasco', 'Piura', 'Puno','San Martín', 'Tacna', 'Tumbes', 'Ucayali' ],
			tours:[],
			contenidos:[], //{fotos:[{nombreRuta:''}], valor: 0, duracion:0, peruanos:{adultos:0, kids:0}, extranjeros:{adultos:0, kids:0},}
			hospedajes: ['Albergue', 'Apartment', 'Bungalow', 'Hostal *', 'Hostal **', 'Hostal ***', 'Hotel *', 'Hotel **', 'Hotel ***', 'Hotel ****', 'Hotel *****', 'Lodge', 'Resort', 'Otro']
		},
		mounted(){
			for (let dia = 2; dia <= 31; dia++) {
				this.duracion.push({ clave: dia+1, valor: dia + ' días / 0 noches' });
				this.duracionDias.push({ clave: dia+1, valor: dia + ' días' });
				this.duracionNoches.push({ clave: dia+1, valor: dia + ' noches' });
			}
			this.cargarTours();

		},
		methods:{
			async cargarTours(){
				const respuesta = await fetch(this.servidor+'mostrarTours.php',{
					method:'POST'
				})
				this.tours = await respuesta.json();
				this.contenidos=[];
				this.tours.forEach(dato=>{
					this.contenidos.push( JSON.parse(dato.contenido));
				});
				console.log( this.contenidos);

			},
			queDura(duracion){
				return this.duracion[duracion-1].valor;
			},
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
			}
		}
	});
</script>
</body>
=======
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Bucle</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" href="https://grupoeuroandino.com/app/render/icofont/icofont.min.css">
</head>
<body class="container-fluid">
	<style>
	
		.subText{
			font-size: 0.8rem;
		}
		.precio{font-size: 1.7rem;font-weight:bold; color: rgb(58, 91, 255);}
		.precioAnt{font-size: 0.8rem;text-decoration:line-through; color: rgb(58, 91, 255);}
		.divOferta{width: 60px; height:60px; background-color: rgb(58, 91, 255); border-radius: 50%; color:white; font-size: 0.8rem;  }
		.precio2{font-size: 1.7rem;font-weight:bold; /* color: rgb(192, 0, 67); */}
		.precioAnt2{font-size: 0.8rem;text-decoration:line-through; /* color: rgb(192, 0, 67); */}
		.divOferta2{width: 70px; height: 25px; background-color: #2768b7; /* rgb(192, 0, 67);  */ margin-top: 2rem; margin-right: 0.6rem; color:white; font-size: 0.8rem;  }
		/* .titulo>a, .estrellas{color: rgb(58, 91, 255);} */
		.estrellas{color: #ffd400;}
		.divImagen img{
			width:100%!important;
			height: 320px!important;
    	object-fit: cover!important;
		}
	</style>
	<div id="app">
		<div class="row row-cols-12 row-cols-md-2 row-cols-lg-4">
			<div class="divProducto position-relative" v-for="(tour, index) in contenidos">
				<div class="divOferta2 position-absolute top-0 end-0 d-flex justify-content-center align-items-center"><span class="">¡Oferta!</span></div>
				<div class="divImagen mt-3">
					<a class="aImgs" v-if="tour.tipo==1" :href="'https://grupoeuroandino.com/viaje.php?id=' + tours[index].id" target="_parent"><img :src="'https://grupoeuroandino.com/app/render/images/subidas/'+tour.fotos[0].nombreRuta" alt="" class="img-fluid"></a>
					<a class="aImgs" v-if="tour.tipo==2" :href="'https://grupoeuroandino.com/viaje.php?id=' + tours[index].id" target="_parent"><img :src="'https://grupoeuroandino.com/app/render/images/subidas/'+tour.fotos[0].nombreRuta" alt="" class="img-fluid"></a>
				</div>
				<div>
					<p class="mb-0 titulo text-capitalize"><strong>
						<a class="text-decoration-none text-dark" v-if="tour.tipo==1" :href="'https://grupoeuroandino.com/viaje.php?id=' + tours[index].id" target="_parent">{{tour.nombre}}</a></strong>
						<a class="text-decoration-none text-dark" v-if="tour.tipo==2" :href="'https://grupoeuroandino.com/viaje.php?id=' + tours[index].id" target="_parent">{{tour.nombre}}</a></strong>
					</p>
					<div class="estrellas">
						<i class="icofont-star"></i><i class="icofont-star"></i><i class="icofont-star"></i><i class="icofont-star"></i><i class="icofont-star"></i>
					</div>
					
					<div class="row row-cols-2">
						<div><i class="icofont-google-map"></i> <span class="text-capitalize"><strong>{{tour.destino}}, {{queDepa(tour.departamento)}}</strong></span> <br>
							<span v-if="tour.tipo==1" class="text-muted subText">{{queDura(tour.duracion)}}</span>
							<span v-else class="text-muted subText">{{queDuraDia(tour.duracion.dias)}} / {{queDuraNoche(tour.duracion.noches-1)}}</span>
						</div>
						<div class="text-end ">
							<span class="precio2">S/ {{formatoMoneda(tour.peruanos.adultos)}}</span>
							<p v-if="tour.oferta!='0' && tour.oferta!=''" class="precioAnt2 mb-0">S/ {{formatoMoneda(tour.oferta)}}</p>
						</div>
					</div>
				</div>
			</div>
			
		</div>
	</div>
<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
<script>
	
	var app = new Vue({
		el: '#app',
		data:{
			//servidor: 'http://localhost/euroAndinoApi/',
			servidor: 'https://grupoeuroandino.com/app/api/',
			duracion: [{clave: 1, valor: 'Half Day (Medio día)'}, {clave: 2, valor: 'Full Day (1 día)'} ],
			duracionDias: [{clave: 1, valor: 'Half Day (Medio día)'}, {clave: 2, valor: 'Full Day (1 día)'} ],
			duracionNoches:[{clave: 1, valor:'0 noches'}, {clave: 2, valor:'1 noche'}],
			departamentos:['Amazonas', 'Ancash', 'Apurimac', 'Arequipa', 'Ayacucho', 'Cajamarca', 'Cusco', 'Callao', 'Huancavelica','Huánuco', 'Ica', 'Junín', 'La Libertad', 'Lambayeque', 'Lima', 'Loreto', 'Madre de Dios', 'Moquegua', 'Pasco', 'Piura', 'Puno','San Martín', 'Tacna', 'Tumbes', 'Ucayali' ],
			tours:[],
			contenidos:[] //{fotos:[{nombreRuta:''}], valor: 0, duracion:0, peruanos:{adultos:0, kids:0}, extranjeros:{adultos:0, kids:0},}
		},
		mounted(){
			for (let dia = 2; dia <= 31; dia++) {
				this.duracion.push({ clave: dia+1, valor: dia + ' días / 0 noches' });
				this.duracionDias.push({ clave: dia+1, valor: dia + ' días' });
				this.duracionNoches.push({ clave: dia+1, valor: dia + ' noches' });
			}
			this.cargarTours();

		},
		methods:{
			async cargarTours(){
				const respuesta = await fetch(this.servidor+'mostrarTours.php',{
					method:'POST'
				})
				this.tours = await respuesta.json();
				this.contenidos=[];
				this.tours.forEach(dato=>{
					this.contenidos.push( JSON.parse(dato.contenido));
				});
				console.log( this.contenidos);

			},
			queDura(duracion){
				return this.duracion[duracion-1].valor;
			},
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
			}
		}
	});
</script>
</body>
>>>>>>> 1b5f9020bf7ace8daa2a5a0c4fc61e5d557cff86
</html>