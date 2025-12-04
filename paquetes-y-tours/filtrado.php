<?php

//var_dump($_GET); die();

if (isset($_GET['id'])) { $idDepartamento = $_GET['id']-1; } else { $idDepartamento = -1; }

if (isset($_GET['idTipo'])) { $idTipo = $_GET['idTipo']; } else { $idTipo = -1; }

$departamentos = ['Amazonas', 'Ancash', 'Apurimac', 'Arequipa', 'Ayacucho', 'Cajamarca', 'Cusco', 'Callao', 'Huancavelica','Huánuco', 'Ica', 'Junín', 'La Libertad', 'Lambayeque', 'Lima', 'Loreto', 'Madre de Dios', 'Moquegua', 'Pasco', 'Piura', 'Puno','San Martín', 'Tacna', 'Tumbes', 'Ucayali' ];
$departamentosUrl = ['amazonas', 'ancash', 'apurimac', 'arequipa', 'ayacucho', 'cajamarca', 'cusco', 'callao', 'huancavelica','huanuco', 'ica', 'junin', 'la-libertad', 'lambayeque', 'lima', 'loreto', 'madre-de-dios', 'moquegua', 'pasco', 'piura', 'puno','san-martin', 'tacna', 'tumbes', 'ucayali' ];
$descripcion = ['Reserva online Paquetes y Tours de Amazonas. Destinos y Actividades en Amazonas. Lugares, festividades, ciudades y pueblos de Amazonas', 'Reserva online Paquetes y Tours de Áncash. Destinos y Actividades en Áncash. Lugares, festividades, playas, ciudades y pueblos de Áncash', 'Reserva online Paquetes y Tours de Apurímac. Destinos y Actividades en Apurímac. Lugares, festividades, ciudades y pueblos de Apurímac', 'Reserva online Paquetes y Tours de Apurímac. Destinos y Actividades en Apurímac. Lugares, festividades, ciudades y pueblos de Apurímac', 'Reserva online Paquetes y Tours de Ayacucho. Destinos y Actividades en Ayacucho. Lugares, festividades, ciudades y pueblos de Ayacucho', 'Reserva online Paquetes y Tours de Cajamarca. Destinos y Actividades en Cajamarca. Lugares, festividades, ciudades y pueblos de Cajamarca', 'Reserva online Paquetes y Tours de Cusco. Destinos y Actividades en Cusco. Lugares, festividades, ciudades y pueblos de Cusco', 'Reserva online Paquetes y Tours del Callao. Destinos y Actividades en el Callao. Lugares, festividades, playas, ciudades y pueblos del Callao', 'Reserva online Paquetes y Tours de Huancavelica. Destinos y Actividades en Huancavelica. Lugares, festividades, ciudades y pueblos de Huancavelica','Reserva online Paquetes y Tours de Huánuco. Destinos y Actividades en Huánuco. Lugares, festividades, ciudades y pueblos de Huánuco', 'Reserva online Paquetes y Tours de Ica. Destinos y Actividades en Ica. Lugares, festividades, playas, ciudades y pueblos de Ica', 'Reserva online Paquetes y Tours de Junín. Destinos y Actividades en Junín. Lugares, festividades, ciudades y pueblos de Junín', 'Reserva online Paquetes y Tours de La Libertad. Destinos y Actividades en La Libertad. Lugares, festividades, playas, ciudades y pueblos de La Libertad', 'Reserva online Paquetes y Tours de Lambayeque. Destinos y Actividades en Lambayeque. Lugares, festividades, playas, ciudades y pueblos de Lambayeque', 'Reserva online Paquetes y Tours de Lima. Destinos y Actividades en Lima. Lugares, festividades, playas, ciudades y pueblos de Lima', 'Reserva online Paquetes y Tours de Loreto. Destinos y Actividades en Loreto. Lugares, festividades, ciudades y pueblos de Loreto', 'Reserva online Paquetes y Tours de Madre de Dios. Destinos y Actividades en Madre de Dios. Lugares, festividades, ciudades y pueblos de Madre de Dios', 'Reserva online Paquetes y Tours de Madre de Dios. Destinos y Actividades en Madre de Dios. Lugares, festividades, ciudades y pueblos de Madre de Dios', 'Reserva online Paquetes y Tours de Pasco. Destinos y Actividades en Pasco. Lugares, festividades, ciudades y pueblos de Pasco', 'Reserva online Paquetes y Tours de Piura. Destinos y Actividades en Piura. Lugares, festividades, playas, ciudades y pueblos de Piura', 'Reserva online Paquetes y Tours de Puno. Destinos y Actividades en Puno. Lugares, festividades, ciudades y pueblos de Puno','Reserva online Paquetes y Tours de San Martín. Destinos y Actividades en San Martín. Lugares, festividades, ciudades y pueblos de San Martín', 'Reserva online Paquetes y Tours de Tacna. Destinos y Actividades en Tacna. Lugares, festividades, playas, ciudades y pueblos de Tacna', 'Reserva online Paquetes y Tours de Tumbes. Destinos y Actividades en Tumbes. Lugares, festividades, playas, ciudades y pueblos de Tumbes', 'Reserva online Paquetes y Tours de Ucayali. Destinos y Actividades en Ucayali. Lugares, festividades, ciudades y pueblos de Ucayali' ];
$fotos = ['https://grupoeuroandino.com/wp-content/uploads/2023/07/paquetes-y-tours-amazonas.jpg', 'https://grupoeuroandino.com/wp-content/uploads/2023/07/paquetes-y-tours-ancash.jpg', 'https://grupoeuroandino.com/wp-content/uploads/2023/07/paquetes-y-tours-apurimac.jpg', 'https://grupoeuroandino.com/wp-content/uploads/2023/07/paquetes-y-tours-arequipa.jpg', 'https://grupoeuroandino.com/wp-content/uploads/2023/07/paquetes-y-tours-ayacucho.jpg', 'https://grupoeuroandino.com/wp-content/uploads/2023/07/paquetes-y-tours-cajamarca.jpg', 'https://grupoeuroandino.com/wp-content/uploads/2023/07/paquetes-y-tours-cusco.jpg', 'https://grupoeuroandino.com/wp-content/uploads/2023/07/paquetes-y-tours-callao.jpg', 'https://grupoeuroandino.com/wp-content/uploads/2023/07/paquetes-y-tours-huancavelica.jpg', 'https://grupoeuroandino.com/wp-content/uploads/2023/07/paquetes-y-tours-huanuco.jpg', 'https://grupoeuroandino.com/wp-content/uploads/2023/07/paquetes-y-tours-ica.jpeg', 'https://grupoeuroandino.com/wp-content/uploads/2023/07/paquetes-y-tours-junin.jpg', 'https://grupoeuroandino.com/wp-content/uploads/2023/07/paquetes-y-tours-la-libertad.jpg', 'https://grupoeuroandino.com/wp-content/uploads/2023/07/paquetes-y-tours-lambayeque.jpg', 'https://grupoeuroandino.com/wp-content/uploads/2023/07/paquetes-y-tours-lima.jpg', 'https://grupoeuroandino.com/wp-content/uploads/2023/07/paquetes-y-tours-loreto.jpg', 'https://grupoeuroandino.com/wp-content/uploads/2023/07/paquetes-y-tours-madre-de-dios.jpg', 'https://grupoeuroandino.com/wp-content/uploads/2023/07/paquetes-y-tours-moquegua.jpg', 'https://grupoeuroandino.com/wp-content/uploads/2023/07/paquetes-y-tours-pasco.jpg', 'https://grupoeuroandino.com/wp-content/uploads/2023/07/paquetes-y-tours-piura.jpg', 'https://grupoeuroandino.com/wp-content/uploads/2023/07/paquetes-y-tours-puno.jpg', 'https://grupoeuroandino.com/wp-content/uploads/2023/07/paquetes-y-tours-san-martin.jpg', 'https://grupoeuroandino.com/wp-content/uploads/2023/07/paquetes-y-tours-tacna.jpg', 'https://grupoeuroandino.com/wp-content/uploads/2023/07/paquetes-y-tours-tumbes.jpg', 'https://grupoeuroandino.com/wp-content/uploads/2023/07/paquetes-y-tours-ucayali.jpg'];

$comentario =  [
   "El bosque tropical del Amazonas, que abarca gran parte del noroeste de Brasil y se extiende hasta Colombia, Perú y otros países de Sudamérica, es el bosque tropical más grande del mundo y es famoso por su biodiversidad. Está entrecruzado por miles de ríos, incluido el caudaloso Amazonas. Las ciudades aledañas, con arquitectura del siglo XIX de los días de la fiebre del caucho, incluyen a Manaos y Belém, en Brasil, y a Iquitos y Puerto Maldonado, en Perú.", 
   "Áncash es una región peruana al norte de Lima en la costa del océano Pacífico. Huaraz, su capital y centro de transporte, se ubica en el Callejón de Huaylas, un valle entre las 2 cadenas montañosas de Áncash. La Cordillera Blanca, al este del valle, tiene cumbres nevadas de más de 6,000 metros. El Parque Nacional Huascarán, que abarca gran parte de la Cordillera Blanca, es hogar de cóndores y jaguares andinos.", 
   "Apurímac es un departamento de la República del Perú situado en el sur del país, en la región andina. Limita por el noreste con Cusco, por el sur con Arequipa y por el oeste con Ayacucho. Con 20 896 km², es el quinto departamento menos extenso, por delante de Tacna, Moquegua, Lambayeque y Tumbes.", 
   "Arequipa es la capital de la época colonial de la región de Arequipa en Perú. La rodean 3 volcanes y cuenta con edificios barrocos construidos de sillar, una piedra volcánica blanca. En su centro histórico, se encuentra la Plaza de Armas, una imponente plaza principal, y al norte de ella está la Basílica Catedral neoclásica del siglo XVII, que alberga un museo donde se exhiben obras de arte y objetos religiosos.", 
   "Ayacucho es una ciudad de la zona sur central de Perú. Sus numerosas iglesias coloniales incluyen el Templo de Santo Domingo, que se caracteriza por su campanario con tres arcos. La Plaza Mayor, también llamada Plaza de Armas, alberga la Catedral de  Ayacucho del siglo XVII, con sus retablos de pan de oro. La ciudad también es conocida por sus artesanías folclóricas, incluidas  las maquetas de madera detalladas conocidas como “retablos” y las animadas celebraciones de Semana Santa.", 
   "Cajamarca es una ciudad del área montañosa del norte de Perú, en la cordillera de los Andes. La plaza principal histórica, la Plaza de Armas, está rodeada de arquitectura colonial barroca. La Catedral de Cajamarca tiene un altar cubierto de pan de oro, mientras que el Monasterio de San Francisco tiene catacumbas y un museo de arte religioso. Cerca está el Cuarto del Rescate, donde mantuvieron prisionero al último emperador inca, Atahualpa.", 
    "Cuzco es una ciudad de los Andes peruanos que fue la capital del Imperio Inca y es conocida por sus restos arqueológicos y la arquitectura colonial española. La Plaza de Armas es el centro de la ciudad antigua, con galerías, balcones de madera tallada y ruinas de murallas incas. El convento de Santo Domingo, de estilo barroco, se construyó sobre el Templo del Sol inca (Qoricancha) y tiene restos arqueológicos de cantería inca.", 
    "Callao es una ciudad portuaria ubicada en la provincia constitucional del Callao, en el centro-oeste del Perú y a su vez en la costa central del litoral peruano y en la zona central occidental de América del Sur. Tiene al oeste el océano Pacífico y a 15 kilómetros al este del Centro histórico de Lima.", 
   "Huancavelica, fundada como Villa Rica de Oropesa el 4 de agosto de 1571, es una ciudad peruana, capital del distrito, de la provincia y del departamento homónimos. Está situada en la vertiente oriental de la cordillera de los Andes a orillas del río Ichu, afluente del Mantaro.", 
    "Huánuco es una ciudad peruana, capital del distrito, la provincia y el departamento homónimos en el centro norte del país. La ciudad tiene una población de 235 529 hab., según proyecciones del INEI para 2020.", 
   "Ica es una ciudad del centro sur del Perú, capital del departamento de Ica, situada en el estrecho valle que forma el río Ica, entre el Gran Tablazo de Ica y las laderas occidentales de la cordillera de los Andes. La ciudad de Ica incluye cinco distritos urbanos.", 
    "Junín, fundada como Pueblo de Reyes en 1539, es una ciudad peruana, capital del distrito y de la provincia homónimos en departamento de Junín. Está situada a 4105 m de altitud, en la orilla sur del lago Junín.", 
    "La Libertad es uno de los veinticuatro departamentos que, junto con la provincia constitucional del Callao, forman la República del Perú. Su capital y ciudad más poblada es Trujillo. Tiene 2 patrimonios de la humanidad declarados por la Unesco: el parque nacional del Río Abiseo en 1983 y Chan Chan en 1986.", 
   "Lambayeque es una ciudad de la costa norte del Perú y capital del distrito y provincia homónimas en el departamento de Lambayeque.", 
    "Lima es la capital de Perú ubicada en la árida costa del Pacífico del país. Pese a que su centro colonial se conserva, es una desbordante metrópolis y una de las ciudades más grandes de Sudamérica. El Museo Larco alberga una colección de arte precolombino y el Museo de la Nación recorre la historia de las civilizaciones antiguas de Perú. La Plaza de Armas y la catedral del siglo XVI son el núcleo del antiguo centro de Lima.", 
   "Loreto es un departamento de la República del Perú con capital en la ciudad de Iquitos, situado en el noreste del país, en plena Amazonía. Limita por el norte con Ecuador y Colombia, por el este con Brasil, por el sur con Ucayali y Huánuco, y por el oeste con San Martín y Amazonas. Con 368 852 km² (28 % del territorio nacional), es el departamento más extenso, la séptima mayor entidad subnacional de América Latina.", 
   "Madre de Dios es un departamento de la República del Perú con capital en la ciudad de Puerto Maldonado, ubicado en el sureste del país, en la Amazonía, limitando al norte con Ucayali y Brasil, al este con Bolivia, al sur con Puno y al oeste con Cuzco.", 
  "Moquegua, fundada como Santa Catalina de Guadalcázar del Valle de Moquegua el 25 de noviembre de 1541, es una ciudad peruana, capital del distrito homónimo, de la provincia de Mariscal Nieto y del departamento de Moquegua.", 
   "Pasco es un departamento de la República del Perú ubicado en el centro del país, cuya capital es la ciudad de Cerro de Pasco. Comprende una parte andina en su parte oeste y una parte amazónica en el este. Limitando al norte con Huánuco, al este con Ucayali, al sur con Junín y al oeste con Lima.", 
 "Piura es la capital de la región de Piura, en el noroeste de Perú. Es conocida por sus edificios coloniales, como la Catedral de Piura, con su altar dorado ornamental. La catedral está frente a la Plaza de Armas, una plaza pequeña con árboles de tamarindo. La Casa Museo Almirante Miguel Grau conserva fotos y recuerdos del héroe de guerra del siglo XIX. La Iglesia de San Francisco es donde Piura declaró su independencia de España en 1821.", 
   "Puno es una ciudad del sur de Perú ubicada junto al lago Titicaca, uno de los lagos más grandes de Sudamérica y el cuerpo de agua navegable más alto del mundo. La ciudad es un núcleo comercial regional y también se considera la \"capital folclórica\" de Perú, por sus festivales tradicionales con animados espectáculos de música y danza. Los sitios icónicos incluyen la Catedral de Puno, una construcción andina de estilo barroco, y el barco a vapor Yavarí del siglo XIX (actualmente un hostal).", 
   "San Martín es un departamento del Perú situado en la parte norte del país, con capital en la ciudad de Moyobamba. Su ciudad más poblada es Tarapoto.", 
    "Tacna es una ciudad del sur de Perú, cerca de la frontera con Chile. El Paseo Cívico de Tacna se encuentra en su centro y alberga la Catedral de Tacna, de estilo neo renacentista. Cerca, está el monumento Arco Parabólico, dedicado a los soldados de la Guerra del Pacífico, y el Museo Histórico Regional, con documentos de esa guerra. Justo afuera de la ciudad está el complejo Campo de la Alianza, con un monumento de guerra, un museo y un cementerio.", 
    "Tumbes es una ciudad peruana, capital del distrito, de la provincia y del departamento homónimos, situada en el extremo Noroeste del país. Se halla cerca de la desembocadura del río Tumbes en el golfo de Guayaquil, a 30 km de la frontera con Ecuador. Tiene una población estimada de 115 300 hab. al 2022.", 
    "Ucayali es un departamento de la República del Perú con capital en la ciudad de Pucallpa, ubicado en la zona centro oriental del país, en la región amazónica. Su capital y ciudad más poblada es Pucallpa. Está ubicado en la zona central del país, en la región amazónica." 
]; 
$aBuscar = strtolower($_GET['texto']);

$tildes = ['á', 'é', 'í', 'ó', 'ú', ' '];
$simple = ['a', 'e', 'i', 'o', 'u', '-'];

$aBuscar = str_replace( $tildes, $simple, $aBuscar );
$indice =  array_search( $aBuscar, $departamentosUrl);
$idDepartamento = $indice;
//echo 'indice'. $indice; die();
//echo  $departamentos[$indice];
//echo $aBuscar;
?>

<!DOCTYPE html>

<html lang="es">



<head>

	<meta charset="UTF-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Paquetes y Tours de <?= $departamentos[$indice] ?> - Grupo Euro Andino </title>
	
	<?php
	if( $indice>=0 ){ ?>
		<meta property="og:title" content="Paquetes y tours de <?= $departamentos[$indice] ?> - Grupo Euro Andino">
		<meta property="og:image" content="<?= $fotos[$indice] ?>">
		<meta property="og:description" content="<?= strip_tags($descripcion[$indice]) ?>">
		<?php
	}
	?>

<?php include("../app/render/headers.php");?>

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


.bandera {width: 20px;}
		.estrellas {

			color: #ffd400;

		}



		.precio2 {

			font-size: 1.7rem;

			font-weight: bold;

		}



		.precioAnt2 {

			text-decoration: line-through;

		}

		.card-img-top{

			width:100%!important;

			height: 320px!important;

    	    object-fit: cover!important;
		}
		.divOferta2{width: 70px; height: 25px; /* rgb(192, 0, 67);  */ margin-top: 1rem; margin-right: 0rem; color:white; font-size: 0.8rem;  }
		#spanOferta{ background-color: #2768b7; }
		#spanAlimentacion{ background-color: #6745ef; }
		#spanTour{ background-color: #0cbf19; }
		#spanGuia{ background-color: #ffc107; }
		#spanTickets{ background-color: #e91616; }
		#spanTransporte{ background-color: #bf0ca9; }
		.moneda-peque{font-size:15px}
		#pegar p{line-height: 1; color: #000;}
	</style>

	<!-- Inicio de Encabezado -->
	<?php include ("../app/render/menu.php");?>

	<!-- Fin de Encabezado -->

	<div class="container-fluid" id="app">

		<div class="container">
		    <h1 class="fs-2 mt-3">

			<?php if(isset($_GET['idTipo']) && $_GET['idTipo']=='1'):?> <span>Tours</span> <?php endif;?>

			<?php if(isset($_GET['idTipo']) && $_GET['idTipo']=='2'):?> <span>Paquetes Turísticos</span><?php endif;?>

			<?php if(isset($_GET['id'])):?> <span>Paquetes y Tours de: <?= $departamentos[$_GET['id']-1];?> </span><?php endif;?>

			<?php if(isset($_GET['texto'])):?> <span>Paquetes y Tours de <?php $texto=$_GET['texto']; echo $departamentos[$indice]; ?> </span><?php else: $texto=''; endif;?>

		</h1>
		<p class="my-3"><?= $comentario[$indice];?></p>
		
		</div>

		<div class="row row-cols-1 row-cols-lg-3 row-cols-xl-4">
			<div class="col my-2 " v-for="(tour, index) in productos" :key="tour.id">
				<div class="card h-100 border-0  ">
					<div v-if="tour.fotos?.length>0" class="divImagen card-img-top position-relative">
						<div class="divOferta2 w-100 position-absolute bottom-0 end-0 d-flex justify-content-end mb-2 me-1">
							<span v-if="tour.transporte==1" class="mx-1 px-1 rounded" id="spanTransporte">Bus</span>
							<span v-if="tour.transporte==2" class="mx-1 px-1 rounded" id="spanTransporte">Avión</span>
							<span v-if="tour.transporte==4" class="mx-1 px-1 rounded" id="spanTransporte">Barco</span>
							<span v-if="tour.alojamiento" class="mx-1 px-1 rounded" id="spanOferta"> {{hospedajes[tour.alojamiento]}}</span>
							<span v-if="tour.alimentacion" class="mx-1 px-1 rounded" id="spanAlimentacion">Alimentación</span>
							<span class="mx-1 px-1 rounded" id="spanTour">Tour</span>
							<span v-if="tour.guia" class="mx-1 px-1 rounded" id="spanGuia">Guía</span>
							<span v-if="tour.tickets" class="mx-1 px-1 rounded" id="spanTickets">Tickets</span>
						</div>
						<a class="aImgs" v-if="tour.tipo==1" :href="'https://grupoeuroandino.com/tours/' + tour.url" target="_parent"><img class="img-fluid rounded-top" :src="'https://grupoeuroandino.com/app/render/images/subidas/'+tour.fotos[0].nombreRuta" alt=""></a>
						<a class="aImgs" v-if="tour.tipo==2" :href="'https://grupoeuroandino.com/tours/' + tour.url" target="_parent"><img class="img-fluid rounded-top" :src="'https://grupoeuroandino.com/app/render/images/subidas/'+tour.fotos[0].nombreRuta" alt=""></a>
					</div>
					<div class="card-body">
						<div class="divProducto ">
							<div>
								<p class="mb-0 titulo ps-1 ">
									<a class="text-decoration-none text-dark fw-bold" v-if="tour.tipo==1" :href="'https://grupoeuroandino.com/tours/' + tour.url" target="_parent">{{tour.nombre}}</a>
									<a class="text-decoration-none text-dark fw-bold" v-if="tour.tipo==2" :href="'https://grupoeuroandino.com/tours/' + tour.url" target="_parent">{{tour.nombre}}</a>
								</p>
								<!-- <div class="d-flex justify-content-between">
									aquí iba la bandera
								</div> -->								
								<div class="row row-cols-2">
									<div>
										<span><img class="bandera" src="https://grupoeuroandino.com/images/banderas/peru.jpeg"> <strong>{{tour.destino}},</strong></span>
										<br>
										<i class="icofont-google-map"></i> <span class="text-capitalize"><strong> {{queDepa(tour.departamento)}}</strong></span>
										<div class="estrellas">
											<i v-for="star in cuantasEstrellas(index)" class="icofont-star"></i>
										</div>
										<span v-if="tour.tipo==1" class="text-muted subText">{{queDura(tour.duracion)}}</span>
										<span v-else class="text-muted subText">{{queDuraDia(tour.duracion.dias)}} / {{queDuraNoche(tour.duracion.noches-1)}}</span>
									</div>
									<div class="d-flex flex-column align-items-end justify-content-end" id="pegar">
										<p class="mb-0" style="font-size: 12px;">Desde</p>
										<p><span class="precio2"><span class="moneda-peque">S/.</span> {{formatoMoneda(tour.peruanos.adultos)}}</span></p>
										<p v-if="tour.oferta!='0' && tour.oferta!=''" class="precioAnt2 mb-0" style="font-size: 14px">S/. {{formatoMoneda(tour.oferta)}}</p>
									</div>
								</div>
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

				departamentos:['Amazonas', 'Ancash', 'Apurimac', 'Arequipa', 'Ayacucho', 'Cajamarca', 'Cusco', 'Callao', 'Huancavelica','Huánuco', 'Ica', 'Junín', 'La Libertad', 'Lambayeque', 'Lima', 'Loreto', 'Madre de Dios', 'Moquegua', 'Pasco', 'Piura', 'Puno','San Martín', 'Tacna', 'Tumbes', 'Ucayali' ],

				dias: [],

				actividades: [],

				categorias: [],

				idTour: <?= $idTipo; ?>,

				idActividad: -1,

				idDepartamento: <?= $idDepartamento; ?>,

				idCategoria: -1,

				idDia: -1,

				idPrecio: -1, idTransporte:-1, idHospedaje:-1, texto:'',

				precios: ['Hasta S/ 150.00', 'De S/ 151.00 a S/ 300.00', 'De S/ 301.00 a S/ 500.00', 'De S/ 501.00 a S/ 1000.00', 'De S/ 1001.00 a S/ 1500.00', 'De S/ 1501.00 a S/ 2000.00', 'Más de S/ 2000.00'],
				hospedajes: ['','Albergue', 'Apartment', 'Bungalow', 'Hostal *', 'Hostal **', 'Hostal ***', 'Hotel *', 'Hotel **', 'Hotel ***', 'Hotel ****', 'Hotel *****', 'Lodge', 'Resort', 'Otro', 'Casa', 'Casa 2', 'Casa 3', 'Airbnb', 'Rural'],

				actividadSelect: '',
				categoriaSelect: '',

				productos: [], contenidos:[],
				duracion: [{clave: 1, valor: 'Half Day (Medio día)'}, {clave: 2, valor: 'Full Day (1 día)'} ],
				duracionDias: [{clave: 1, valor: 'Half Day (Medio día)'}, {clave: 2, valor: 'Full Day (1 día)'} ],
				duracionNoches:[{clave: 1, valor:'0 noches'}, {clave: 2, valor:'1 noche'}],
				departamentos:['Amazonas', 'Ancash', 'Apurimac', 'Arequipa', 'Ayacucho', 'Cajamarca', 'Cusco', 'Callao', 'Huancavelica','Huánuco', 'Ica', 'Junín', 'La Libertad', 'Lambayeque', 'Lima', 'Loreto', 'Madre de Dios', 'Moquegua', 'Pasco', 'Piura', 'Puno','San Martín', 'Tacna', 'Tumbes', 'Ucayali' ],
				pedidos: []

			},

			mounted: function() {

				this.cargar();

				for (let i = 1; i <= 31; i++) {
					this.dias.push(i);
				}

				for (let dia = 2; dia <= 31; dia++) {
				this.duracion.push({ clave: dia+1, valor: dia + ' días / 0 noches' });
				this.duracionDias.push({ clave: dia+1, valor: dia + ' días' });
				this.duracionNoches.push({ clave: dia+1, valor: dia + ' noches' });
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

					datos.append('idCategoria', this.idCategoria);

					datos.append('idTransporte', this.idTransporte);

					datos.append('idHospedaje', this.idHospedaje);

					datos.append('categoria', this.categoriaSelect);

					datos.append('idDia', this.idDia);

					datos.append('idPrecio', this.idPrecio);

					datos.append('texto', ''); //<!?= $departamentos[$indice]; ?>

					let respServ = await fetch(this.servidor + 'buscarFiltroTienda.php?v1', {

						method: 'POST',

						body: datos

					});

					//console.log( await respServ.json() );

					this.pedidos = await respServ.json();
					//console.log(this.pedidos)

					try {
						this.pedidos.forEach(data => {
							this.productos.push(JSON.parse(data.contenido))
						})
					} catch (error) {
						console.log('err')
						console.log(error)
					}
				},

				queFoto(prod) {

					//console.log( prod );

					if (prod.fotos?.length == 0) {

						return 'https://grupoEuroAndino.com/app/render/images/defecto.jpg';

					} else {

						return 'https://grupoEuroAndino.com/app/render/images/subidas/' + prod.fotos[0].nombreRuta;

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


				queId(index) {

					return this.pedidos[index].id;

				},
				queDura(duracion){
				return this.duracion[duracion-1].valor;
				},
				//Nuevos:
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
					return parseFloat(valor).toFixed(0)
				},
				cuantasEstrellas(index){
					return parseInt(this.pedidos[index].calificacion)
				}

			}

		});

	</script>

</body>


</html>
