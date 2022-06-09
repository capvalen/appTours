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
	</style>
	<div id="app">
		<div class="row row-cols-12 row-cols-md-2 row-cols-lg-4">
			<div class="divProducto position-relative" v-for="(tour, index) in contenidos">
				<div class="divOferta2 position-absolute top-0 end-0 d-flex justify-content-center align-items-center"><span class="">¡Oferta!</span></div>
				<div class="divImagen mt-3">
					<a :href="'/viaje/?id=' + queId(index)" target="_parent"><img :src="'https://grupoeuroandino.com/app/render/images/subidas/'+tour.fotos[0].nombreRuta" alt="" class="img-fluid"></a>
				</div>
				<div>
					<p class="mb-0 titulo text-capitalize"><strong>
						<a class="text-decoration-none text-dark" :href="'/viaje/?id=' + queId(index)" target="_parent">{{tour.nombre}}</a></strong>
					</p>
					<div class="estrellas">
						<i class="icofont-star"></i><i class="icofont-star"></i><i class="icofont-star"></i><i class="icofont-star"></i><i class="icofont-star"></i>
					</div>
					
					<div class="row row-cols-2">
						<div><i class="icofont-google-map"></i> <span class="text-capitalize"><strong>{{tour.destino}}, {{queDepa(tour.departamento)}}</strong></span> <br>
							<span v-if="tour.tipo==1" class="text-muted subText">{{queDura(tour.duracion)}} / 0 noches</span>
							<span v-else class="text-muted subText">{{queDura(tour.duracion.dias)}} {{queDuraNoche(tour.duracion.noches)}}</span>
						</div>
						<div class="text-end ">
							<span class="precio2">S/ {{formatoMoneda(tour.peruanos.adultos)}}</span>
							<p class="precioAnt2 mb-0">S/ {{formatoMoneda(tour.extranjeros.adultos)}}</p>
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
			mensaje: 'hola',
			//servidor: 'http://localhost/euroAndinoApi/',
			servidor: 'https://grupoeuroandino.com/app/api/',
			duracion: [{clave: 1, valor: 'Half Day (Medio día)'}, {clave: 2, valor: 'Full Day (1 día)'} ],
			duracionNoches:[{clave: 1, valor:'0 noches'}, {clave: 2, valor:'1 noche'}],
			departamentos:['Amazonas', 'Ancash', 'Apurimac', 'Arequipa', 'Ayacucho', 'Cajamarca', 'Cusco', 'Huancavelica','Huánuco', 'Ica', 'Junín', 'Chanchamayo', 'Chupaca', 'Concepción', 'Huancayo', 'Jauja', 'Junín', 'Satipo', 'Tarma', 'Yauli', 'La Libertad', 'Lambayeque', 'Lima', 'Loreto', 'Madre de Dios', 'Moquegua', 'Pasco', 'Piura', 'Puno','San Martín', 'Tacna', 'Tumbes', 'Ucayali' ],
			tours:[],
			contenidos:[{fotos:[{nombreRuta:''}], valor: 0, duracion:0, peruanos:{adultos:0, kids:0}, extranjeros:{adultos:0, kids:0},}]
		},
		mounted(){
			for (let dia = 2; dia <= 31; dia++) {
				this.duracion.push({ clave: dia+1, valor: dia + ' días' });
				this.duracionNoches.push({ clave: dia+2, valor: dia + ' noches' });
			}
			this.cargarTours();

		},
		methods:{
			async cargarTours(){
				const respuesta = await fetch(this.servidor+'mostrarTours.php')
				this.tours = await respuesta.json();
				this.contenidos=[];
				this.tours.forEach(dato=>{
					this.contenidos.push( JSON.parse(dato.contenido));
				});
				console.log( this.contenidos);

			},
			queDura(duracion){
				return this.duracion[duracion].valor;
			},
			queDuraNoche(duracion){ return this.duracionNoches[duracion].valor; },
			queDepa(valor){
				return this.departamentos[valor];
			},
			formatoMoneda(valor){
				return parseFloat(valor).toFixed(2)
			},
			queId(index){
				return this.tours[index].id;
			}
		}
	});
</script>
</body>
</html>