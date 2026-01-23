<?php

//var_dump($_GET); die();

if (isset($_GET['id'])) { $idDepartamento = $_GET['id']-1; } else { $idDepartamento = -1; }

if (isset($_GET['idTipo'])) { $idTipo = $_GET['idTipo']; } else { $idTipo = -1; }

$ciudades = [
	"abancay" => [
	"descripcion" => "Abancay es una ciudad de la región Apurímac de Perú. Al noreste, el Mirador de Taraccasa ofrece vistas panorámicas de la ciudad. Al norte, en el Santuario Nacional de Ampay, hay bosques protegidos en donde viven pumas y osos andinos. Al noreste de la ciudad, el conjunto arqueológico Sayhuite tiene ruinas de piedras y una roca con un tallado elaborado. Los Baños Termales de Cconoc están un poco más al este, a orillas del río Apurimac.", 
	"nombre" => "Abancay", "foto" => "abancay.jpg" 
	], 
	"andahuaylas" => [
	"descripcion" => "Andahuaylas es una ciudad peruana capital del distrito y de la provincia homónimos en el departamento de Apurímac. Se encuentra a una altitud de 2846 m s. n. m. en el valle del río Chumbao. Su área metropolitana se extiende por los distritos de San Jerónimo y Talavera.", 
	"nombre" => "Andahuaylas", "foto" => "andahuaylas.jpg" 
	], 
	"arequipa" => [
	"descripcion" => "Arequipa es la capital de la época colonial de la región de Arequipa en Perú. La rodean 3 volcanes y cuenta con edificios barrocos construidos de sillar, una piedra volcánica blanca. En su centro histórico, se encuentra la Plaza de Armas, una imponente plaza principal, y al norte de ella está la Basílica Catedral neoclásica del siglo XVII, que alberga un museo donde se exhiben obras de arte y objetos religiosos.", 
	"nombre" => "Arequipa", "foto" => "arequipa.jpg" 
	], 
	"ayacucho" => [
	"descripcion" => "Ayacucho es una ciudad de la zona sur central de Perú. Sus numerosas iglesias coloniales incluyen el Templo de Santo Domingo, que se caracteriza por su campanario con tres arcos. La Plaza Mayor, también llamada Plaza de Armas, alberga la Catedral de Ayacucho del siglo XVII, con sus retablos de pan de oro. La ciudad también es conocida por sus artesanías folclóricas, incluidas las maquetas de madera detalladas conocidas como “retablos” y las animadas celebraciones de Semana Santa.", 
	"nombre" => "Ayacucho", "foto" => "ayacucho.jpg" 
	], 
	"cajamarca" => [
	"descripcion" => "Cajamarca es una ciudad del área montañosa del norte de Perú, en la cordillera de los Andes. La plaza principal histórica, la Plaza de Armas, está rodeada de arquitectura colonial barroca. La Catedral de Cajamarca tiene un altar cubierto de pan de oro, mientras que el Monasterio de San Francisco tiene catacumbas y un museo de arte religioso. Cerca está el Cuarto del Rescate, donde mantuvieron prisionero al último emperador inca, Atahualpa.", 
	"nombre" => "Cajamarca", "foto" => "cajamarca.jpg" 
	], 
	"chincha" => [
	"descripcion" => "Santo Domingo de Chincha, denominada Chincha Alta para distinguirla de la Chincha Baja, es una ciudad peruana, capital del distrito homónimo y a la vez de la provincia de Chincha ubicada en el departamento de Ica. Se halla en la cuenca del río San Juan, a 200 km al sur de Lima. Tiene una superficie de 238,34 km².", 
	"nombre" => "Chincha", "foto" => "chincha.jpg" 
	], 
	"callao" => [
	"descripcion" => "Callao es una ciudad portuaria ubicada en la provincia constitucional del Callao, en el centro-oeste del Perú y a su vez en la costa central del litoral peruano y en la zona central occidental de América del Sur. Tiene al oeste el océano Pacífico y a 15 kilómetros al este del Centro histórico de Lima.", 
	"nombre" => "Callao", "foto" => "callao.jpg" 
	], 
	"cerro_de_pasco" => [
	"descripcion" => "Cerro de Pasco es una ciudad peruana; capital del distrito de Chaupimarca y a la vez de la provincia de Pasco y del departamento homónimo. Está situada a 4380 m s. n. m.,  en la meseta del Bombón, altiplano de la cordillera de los Andes.", 
	"nombre" => "Cerro de Pasco", "foto" => "cerro_de_pasco.jpg" 
	], 
	"chachapoyas" => [
	"descripcion" => "Chachapoyas es una ciudad del norte de Perú, en un valle rodeado de bosques nubosos. Su Plaza de Armas tiene una fuente de bronce y edificios coloniales, como el Palacio Municipal. La ciudad es una vía de acceso a sitios arqueológicos como Kuélap, una ciudad amurallada con cientos de edificios de la cultura chachapoyas antigua. Al norte de la ciudad, la enorme catarata Gocta se ubica en medio de la selva, que alberga tucanes y monos.", 
	"nombre" => "Chachapoyas", "foto" => "chachapoyas.jpg" 
	], 
	"chiclayo" => [
	"descripcion" => "Chiclayo es la ciudad capital de la región de Lambayeque, en el noroeste de Perú. Es una vía de acceso a sitios arqueológicos como Huaca Rajada al este, el lugar de descubrimiento de la tumba del Señor de Sipán, un gobernante de la antigua cultura Moche. El Museo de las Tumbas Reales de Sipán en la ciudad cercana de Lambayeque exhibe artefactos de la tumba. Chiclayo también es conocida por sus parques, jardines y el acceso a centros turísticos como Pimentel.", 
	"nombre" => "Chiclayo", "foto" => "chiclayo.jpg" 
	], 
	"cusco" => [
	"descripcion" => "Cuzco es una ciudad de los Andes peruanos que fue la capital del Imperio Inca y es conocida por sus restos arqueológicos y la arquitectura colonial española. La Plaza de Armas es el centro de la ciudad antigua, con galerías, balcones de madera tallada y ruinas de murallas incas. El convento de Santo Domingo, de estilo barroco, se construyó sobre el Templo del Sol inca (Qoricancha) y tiene restos arqueológicos de cantería inca.", 
	"nombre" => "Cusco", "foto" => "Cusco.jpg" 
	], 
	"huancavelica" => [
	"descripcion" => "Huancavelica, fundada como Villa Rica de Oropesa el 4 de agosto de 1571, es una ciudad peruana, capital del distrito, de la provincia y del departamento homónimos. Está situada en la vertiente oriental de la cordillera de los Andes a orillas del río Ichu, afluente del Mantaro.", 
	"nombre" => "Huancavelica", "foto" => "Huancavelica.jpg" 
	], 
	"huancayo" => [
	"descripcion" => "Huancayo es la ciudad capital de la región de Junín, en el centro de Perú. Se conecta con la capital peruana, Lima, a través del Ferrocarril Central Andino, una de las rutas ferroviarias más altas del mundo. Las esculturas del Parque de la Identidad Huanca de la ciudad rinden homenaje a la cultura preincaica de la región. La Catedral de Huancayo, de estilo neoclásico, tiene vista a las plantas nativas de la Plaza de la Constitución, en el centro de la ciudad.", 
	"nombre" => "Huancayo", "foto" => "Huancayo.jpg" 
	], 
	"huanuco" => [
	"descripcion" => "Huánuco es una ciudad peruana, capital del distrito, la provincia y el departamento homónimos en el centro norte del país. La ciudad tiene una población de 235 529 hab., según proyecciones del INEI para 2020.", 
	"nombre" => "Huánuco", "foto" => "Huanuco.jpg" 
	], 
	"huaraz" => [
	"descripcion" => "Huaraz es una ciudad del valle Callejón de Huaylas en el norte de Perú. Es la capital de la región de Ancash y se ubica a más de 3,000 metros sobre el nivel del mar, con cimas nevadas de la Cordillera Blanca que forman un dramático horizonte en el este. El Parque Nacional Huarascán, que abarca gran parte de la Cordillera Blanca, alberga cóndores andinos y jaguares, así como también la montaña más alta de Perú, Huarascán.", 
	"nombre" => "Huaraz", "foto" => "Huaraz.jpg" 
	], 
	"ica" => [
	"descripcion" => "Ica es una ciudad del centro sur del Perú, capital del departamento de Ica, situada en el estrecho valle que forma el río Ica, entre el Gran Tablazo de Ica y las laderas occidentales de la cordillera de los Andes. La ciudad de Ica incluye cinco distritos urbanos.", 
	"nombre" => "Ica", "foto" => "Ica.jpg" 
	], 
	"iquitos" => [
	"descripcion" => "Iquitos es una ciudad puerto peruana y una vía de acceso a los alojamientos en la selva y las villas del norte del Amazonas. El distrito de Belén es conocido por su enorme mercado callejero al aire libre y los palafitos rústicos sobre pilotes que bordean el río Itaya. En el centro histórico, se encuentra la Plaza de Armas, rodeada de edificios con influencia europea que datan del auge que tuvo la región en el cambio al siglo XX con la producción de caucho.", 
	"nombre" => "Iquitos", "foto" => "Iquitos.jpg" 
	], 
	"jauja" => [
	"descripcion" => "Jauja es una ciudad peruana, capital del distrito y de la provincia homónimos, en el departamento de Junín.", 
	"nombre" => "Jauja", "foto" => "Jauja.jpg" 
	], 
	"juliaca" => [
	"descripcion" => "Juliaca es una ciudad de la provincia de San Román, en el sur de Perú. Es una ciudad de mucho tránsito y un buen punto de partida hacia el Lago Titicaca, el amplio lago andino, conocido por sus ruinas incas y los pueblos flotantes. En la Plaza Bolognesi del centro, los vendedores de la Galería Artesanal Las Calceteras venden artesanías y productos de lana. Algunas de sus iglesias son el Templo de la Merced, en la plaza, y la Iglesia Matriz de Santa Catalina, en el noroeste.", 
	"nombre" => "Juliaca", "foto" => "Juliaca.jpg" 
	], 
	"la_merced" => [
	"descripcion" => "La Merced es una ciudad peruana, capital del distrito y de la provincia de Chanchamayo ubicada en el departamento de Junín. Según el censo de 2017 tenía 24 629 hab. La ciudad en un importante centro comercial agrícola de la selva central.", 
	"nombre" => "La Merced", "foto" => "La_Merced.jpg" 
	], 
	"lima" => [
	"descripcion" => "Lima es la capital de Perú ubicada en la árida costa del Pacífico del país. Pese a que su centro colonial se conserva, es una desbordante metrópolis y una de las ciudades más grandes de Sudamérica. El Museo Larco alberga una colección de arte precolombino y el Museo de la Nación recorre la historia de las civilizaciones antiguas de Perú. La Plaza de Armas y la catedral del siglo XVI son el núcleo del antiguo centro de Lima.", 
	"nombre" => "Lima", "foto" => "Lima.jpg" 
	], 
	"moquegua" => [
	"descripcion" => "Moquegua, fundada como Santa Catalina de Guadalcázar del Valle de Moquegua el 25 de noviembre de 1541, es una ciudad peruana, capital del distrito homónimo, de la provincia de Mariscal Nieto y del departamento de Moquegua.", 
	"nombre" => "Moquegua", "foto" => "Moquegua.jpg" 
	], 
	"nazca" => [
	"descripcion" => "Nazca es una ciudad peruana capital del distrito homónimo ubicado en la provincia de Nazca en el departamento de Ica. Geográficamente se sitúa en la margen derecha del río Aja, afluente del río Grande en un estrecho valle a 520 m. s. n. m. a 439 km al sur de Lima.", 
	"nombre" => "Nazca", "foto" => "Nazca.jpg" 
	], 
	"oxapampa" => [
	"descripcion" => "Oxapampa es una ciudad peruana capital del distrito y de la provincia de Oxapampa, ubicada en el departamento de Pasco. Según el censo de 2017, tenía 15 677 hab. con una proyección de 17 255 hab. para 2020.", 
	"nombre" => "Oxapampa", "foto" => "Oxapampa.jpg" 
	], 
	"pichanaqui" => [
	"descripcion" => "El distrito de Pichanaqui es uno de los seis que conforman la provincia de Chanchamayo ubicada en el departamento de Junín en el centro del Perú. Abarca una superficie de 1 497 km². Dentro de la división eclesiástica de la Iglesia Católica del Perú, pertenece al Vicariato apostólico de San Ramón.", 
	"nombre" => "Pichanaqui", "foto" => "Pichanaqui.jpg" 
	], 
	"piura" => [
	"descripcion" => "Piura es la capital de la región de Piura, en el noroeste de Perú. Es conocida por sus edificios coloniales, como la Catedral de Piura, con su altar dorado ornamental. La catedral está frente a la Plaza de Armas, una plaza pequeña con árboles de tamarindo. La Casa Museo Almirante Miguel Grau conserva fotos y recuerdos del héroe de guerra del siglo XIX. La Iglesia de San Francisco es donde Piura declaró su independencia de España en 1821.", 
	"nombre" => "Piura", "foto" => "Piura.jpg" 
	], 
	"pucallpa" => [
	"descripcion" => "Pucallpa es una ciudad ubicada en el río Ucayali en la selva del Amazonas de la zona este de Perú. Su plaza moderna, la Plaza de Armas, tiene un obelisco, fuentes adornadas y esculturas. También alberga la Catedral de Pucallpa, de estilo neoclásico, que se distingue por su alto campanario y sus vitrales. Una torre del reloj decorada con imágenes de criaturas míticas se alza sobre los jardines de la ribera en la Plaza del Reloj cercana.", 
	"nombre" => "Pucallpa", "foto" => "Pucallpa.jpg" 
	], 
	"puerto_maldonado" => [
	"descripcion" => "Puerto Maldonado es la capital de la región de Madre de Dios en el sureste de Perú. También es conocida como la vía de acceso al sur de la selva del Amazonas. La torre central del Obelisco tiene vista desde lo alto a la ciudad, junto con exhibiciones de historia local. En la orilla del río Madre de Dios, hay un ajetreado muelle de transbordadores, cerca de la Plaza de Armas. Cerca de la ciudad está la biodiversa Reserva Nacional Tambopata que se extiende por la sabana y la selva antigua.", 
	"nombre" => "Puerto Maldonado", "foto" => "foto.jpg" 
	], 
	"puno" => [
	"descripcion" => "Puno es una ciudad del sur de Perú ubicada junto al lago Titicaca, uno de los lagos más grandes de Sudamérica y el cuerpo de agua navegable más alto del mundo. La ciudad es un núcleo comercial regional y también se considera la \"capital folclórica\" de Perú, por sus festivales tradicionales con animados espectáculos de música y danza. Los sitios icónicos incluyen la Catedral de Puno, una construcción andina de estilo barroco, y el barco a vapor Yavarí del siglo XIX (actualmente un hostal).", 
	"nombre" => "Puno", "foto" => "Puno.jpg" 
	], 
	"satipo" => [
	"descripcion" => "Satipo es una ciudad peruana, capital del distrito y de la provincia homónimos, ubicada en el departamento de Junín. Según el censo de 2017, cuenta con 30 000 habitantes.", 
	"nombre" => "Satipo", "foto" => "Satipo.jpg" 
	], 
	"tacna" => [
	"descripcion" => "Tacna es una ciudad del sur de Perú, cerca de la frontera con Chile. El Paseo Cívico de Tacna se encuentra en su centro y alberga la Catedral de Tacna, de estilo neorrenacentista. Cerca, está el monumento Arco Parabólico, dedicado a los soldados de la Guerra del Pacífico, y el Museo Histórico Regional, con documentos de esa guerra. Justo afuera de la ciudad está el complejo Campo de la Alianza, con un monumento de guerra, un museo y un cementerio.", 
	"nombre" => "Tacna", "foto" => "Tacna.jpg" 
	], 
	"tarapoto" => [
	"descripcion" => "Tarapoto es una ciudad peruana de la región de San Martín, que se caracteriza por el bosque nuboso amazónico y sus abundantes palmeras. Es conocida por las numerosas cascadas en las selvas circundantes, incluidas Ahuashiyacu, Huacamaíllo y Shapaja. Al sureste de la ciudad, las aguas claras del lago Lindo y la laguna Sauce más grande (también llamada Laguna Azul) están rodeadas de densos bosques verdes con abundantes especies de aves.", 
	"nombre" => "Tarapoto", "foto" => "Tarapoto.jpg" 
	], 
	"tarma" => [
	"descripcion" => "Tarma es una ciudad en las montañas andinas en el centro de Perú. La catedral neoclásica de Santa Ana de Tarma se encuentra en la plaza principal, la Plaza de Armas. En el norte de la ciudad, el Santuario del Señor de Muruhuay es una iglesia sobre una colina que tiene una imagen sagrada de Cristo. En el noroeste, se encuentra la imponente Gruta de Huagapo, caracterizada por sus estalactitas. Tarmatambo, en el sur de la ciudad, es un antiguo centro administrativo inca, con ruinas de lodo y piedra.", 
	"nombre" => "Tarma", "foto" => "Tarma.jpg" 
	], 
	"tingo_maria" => [
	"descripcion" => "Tingo María es una ciudad en el río Huallaga, en el centro de Perú, entre las montañas andinas y la selva amazónica. Aquí se encuentra el Parque nacional Tingo María que posee una abundante biodiversidad y es conocido por la Bella Durmiente, una montaña con la forma de una mujer acostada. Además, aquí está la Cueva de las Lechuzas, que alberga guácharos. Algunas de las cascadas locales son Santa Carmen, con una piscina natural, y Gloriapata, a la que se accede a través de un puente suspendido.", 
	"nombre" => "Tingo María", "foto" => "Tingo_Maria.jpg" 
	], 
	"trujillo" => [
	"descripcion" => "Trujillo es una ciudad del noroeste de Perú. Es conocida por la danza tradicional del país, la marinera. El centro colonial alberga la gran Catedral de Trujillo, con su fachada amarilla brillante y la Casa Urquiaga de color azul. En las cercanías, se encuentra el Palacio Iturregui de estilo neoclásico con estatuas de mármol italianas y un patio. Al oeste de la ciudad, el enorme complejo de adobe de Chan Chan es una ciudad abandonada que alguna vez fue el hogar del antiguo Reino chimú.", 
	"nombre" => "Trujillo", "foto" => "Trujillo.jpg" 
	], 
	"tumbes" => [
	"descripcion" => "Tumbes es una ciudad peruana, capital del distrito, de la provincia y del departamento homónimos, situada en el extremo Noroeste del país. Se halla cerca de la desembocadura del río Tumbes en el golfo de Guayaquil, a 30 km de la frontera con Ecuador. Tiene una población estimada de 115 300 hab. al 2022.", 
	"nombre" => "Tumbes", "foto" => "tumbes.jpg" 
	] 
];


$aBuscar = strtolower($_GET['texto']);

$tildes = ['á', 'é', 'í', 'ó', 'ú', ' '];
$simple = ['a', 'e', 'i', 'o', 'u', '-'];

$aBuscar = str_replace( $tildes, $simple, $aBuscar );
$txtSimple = $aBuscar;
$aBuscar = str_replace( ' ', '_', $aBuscar );
$aBuscar = str_replace( '-', ' ', $aBuscar );
$buscarWeb =  str_replace( '-', '_', $txtSimple );

if(array_key_exists($buscarWeb, $ciudades)){
    $indice=$buscarWeb;
}else{
    $indice = -1;
}
//echo $indice;
?>

<!DOCTYPE html>

<html lang="es">



<head>

	<meta charset="UTF-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Tours y Paquetes de <?= $ciudades[$indice]['nombre'] ?> - Perú Travel</title>
	
	<?php
	if( $indice>=0 ){ ?>
		<meta property="og:title" content="Tours y paquetes de <?= $ciudades[$indice]['nombre'] ?> - Perú Travel">
		<meta property="og:image" content="https://peru-travel.pe/images/ciudades/<?= strtolower($ciudades[$indice]['foto']) ?>">
		<meta property="og:description" content="<?= strip_tags($ciudades[$indice]['descripcion']) ?>">
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


	.bandera {
		width: 20px;
	}

	.estrellas {

		color: #ffd400;

	}



	.precio2 {

		font-weight: bold;

	}



	.precioAnt2 {


		text-decoration: line-through;

	}

	.card-img-top {

		width: 100% !important;

		height: 320px !important;

		object-fit: cover !important;
	}

	.divOferta2 {
		width: 70px;
		height: 25px;
		/* rgb(192, 0, 67);  */
		margin-top: 1rem;
		margin-right: 0rem;
		color: white;
		font-size: 0.8rem;
	}

	#spanOferta {
		background-color: #2768b7;
	}

	#spanAlimentacion {
		background-color: #6745ef;
	}

	#spanTour {
		background-color: #0cbf19;
	}

	#spanGuia {
		background-color: #ffc107;
	}

	#spanTickets {
		background-color: #e91616;
	}

	#spanTransporte {
		background-color: #bf0ca9;
	}
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

			<?php if(isset($_GET['id'])):?> <span>Tours y Paquetes de: <?= $ciudades[$_GET['id']-1]['nombre'];?> </span><?php endif;?>

			<?php if(isset($_GET['texto'])):?> <span>Tours y Paquetes de <?php $texto=$_GET['texto']; echo $ciudades[$indice]['nombre']; ?> </span><?php else: $texto=''; echo "Resultados de la ciudad: ".$txtSimple; endif;?>

		</h1>
			<?php if($indice<>-1):?> 
			<div class="row col">
					<div class="text muted my-3"><p><?= $ciudades[$indice]['descripcion']?></p></div>
			</div>
			<?php endif;?>
		
		</div>

		<div class="row row-cols-1 row-cols-lg-3 row-cols-xl-4">
			<div class="col my-2 " v-for="(tour, index) in productos" :key="tour.id">
				<div class="card h-100 border-0  ">
					<div v-if="tour.fotos.length>0" class="divImagen card-img-top position-relative">
						<div class="divOferta2 w-100 position-absolute bottom-0 end-0 d-flex justify-content-end mb-2 me-1">
							<span class="text-capitalize mx-1 px-1 rounded" v-if="tour.idTransporte!=undefined && tour.idTransporte!=-1 && tour.transporte!=3" class="mx-1 px-1 rounded" id="spanTransporte">{{queTransporte(tour)}}</span>
							<span v-if="tour.alojamiento" class="mx-1 px-1 rounded" id="spanOferta"> {{hospedajes[parseInt(tour.alojamiento)]}}</span>
							<span v-if="tour.alimentacion" class="mx-1 px-1 rounded" id="spanAlimentacion">Alimentación</span>
							<span class="mx-1 px-1 rounded" id="spanTour">Tour</span>
							<span v-if="tour.guia" class="mx-1 px-1 rounded" id="spanGuia">Guía</span>
							<span v-if="tour.tickets" class="mx-1 px-1 rounded" id="spanTickets">Tickets</span>
						</div>
						<a class="aImgs" v-if="tour.tipo==1" :href="'https://peru-travel.pe/tours/' + tour.url" target="_parent"><img class="img-fluid rounded-top" :src="'https://peru-travel.pe/app/render/images/subidas/'+tour.fotos[0].nombreRuta" alt=""></a>
						<a class="aImgs" v-if="tour.tipo==2" :href="'https://peru-travel.pe/tours/' + tour.url" target="_parent"><img class="img-fluid rounded-top" :src="'https://peru-travel.pe/app/render/images/subidas/'+tour.fotos[0].nombreRuta" alt=""></a>
					</div>
					<div class="card-body">
						<div class="divProducto ">
							<div>
								<p class="mb-0 titulo ps-1 ">
									<a class="text-decoration-none text-dark fw-bold" v-if="tour.tipo==1" :href="'https://peru-travel.pe/tours/' + tour.url" target="_parent">{{tour.nombre}}</a>
									<a class="text-decoration-none text-dark fw-bold" v-if="tour.tipo==2" :href="'https://peru-travel.pe/tours/' + tour.url" target="_parent">{{tour.nombre}}</a>
								</p>
								<!-- <div class="d-flex justify-content-between">
									aquí iba la bandera
								</div> -->								
								<div class="row row-cols-2">
									<div>
										<span><img class="bandera" src="https://peru-travel.pe/images/banderas/peru.jpeg"> <strong>{{tour.destino}},</strong></span>
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

				servidor: 'https://peru-travel.pe/app/api/',

				departamentos:['Amazonas', 'Ancash', 'Apurimac', 'Arequipa', 'Ayacucho', 'Cajamarca', 'Cusco', 'Callao', 'Huancavelica','Huánuco', 'Ica', 'Junín', 'La Libertad', 'Lambayeque', 'Lima', 'Loreto', 'Madre de Dios', 'Moquegua', 'Pasco', 'Piura', 'Puno','San Martín', 'Tacna', 'Tumbes', 'Ucayali' ],

				dias: [],

				actividades: [],

				categorias: [],

				idTour: -1,

				idActividad: -1,

				idDepartamento: -1,

				idCategoria: -1,

				idDia: -1,

				idPrecio: -1, idTransporte:-1, idHospedaje:-1,
				texto:'<?= $aBuscar;?>',

				precios: ['Hasta S/ 150.00', 'De S/ 151.00 a S/ 300.00', 'De S/ 301.00 a S/ 500.00', 'De S/ 501.00 a S/ 1000.00', 'De S/ 1001.00 a S/ 1500.00', 'De S/ 1501.00 a S/ 2000.00', 'Más de S/ 2000.00'],
				hospedajes: ['','Albergue', 'Apartment', 'Bungalow', 'Hostal *', 'Hostal **', 'Hostal ***', 'Hotel *', 'Hotel **', 'Hotel ***', 'Hotel ****', 'Hotel *****', 'Lodge', 'Resort', 'Otro', 'Casa', 'Casa 2', 'Casa 3', 'Airbnb', 'Rural'],

				actividadSelect: '',
				categoriaSelect: '',

				productos: [], contenidos:[],
				duracion: [{clave: 1, valor: 'Half Day (Medio día)'}, {clave: 2, valor: 'Full Day (1 día)'} ],
				duracionDias: [{clave: 1, valor: 'Half Day (Medio día)'}, {clave: 2, valor: 'Full Day (1 día)'} ],
				duracionNoches:[{clave: 1, valor:'0 noches'}, {clave: 2, valor:'1 noche'}],
				departamentos:['Amazonas', 'Ancash', 'Apurimac', 'Arequipa', 'Ayacucho', 'Cajamarca', 'Cusco', 'Callao', 'Huancavelica','Huánuco', 'Ica', 'Junín', 'La Libertad', 'Lambayeque', 'Lima', 'Loreto', 'Madre de Dios', 'Moquegua', 'Pasco', 'Piura', 'Puno','San Martín', 'Tacna', 'Tumbes', 'Ucayali' ],
				pedidos: [],
				queTransportes: [
					{ id: 0, transporte: "ninguno", idTransporte: 3 },
					// Terrestre (1)
					{ id: 1, transporte: "tren", idTransporte: 1 },
					{ id: 2, transporte: "bus", idTransporte: 1 },
					// Aéreo (2)
					{ id: 3, transporte: "avión", idTransporte: 2 },
					{ id: 4, transporte: "avioneta", idTransporte: 2 },
					// Acuático (4)
					{ id: 5, transporte: "barco", idTransporte: 4 },
					{ id: 6, transporte: "lancha", idTransporte: 4 }
				],

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

					datos.append('texto', this.texto);

					let respServ = await fetch(this.servidor + 'mostrarTours_scriptCiudadesReal.php?v1', {
						method: 'POST',
						body: datos

					});

					//console.log( await respServ.json() );

					this.pedidos = await respServ.json();
					//console.log(this.pedidos)

					this.pedidos.forEach(data => {
						this.productos.push(JSON.parse(data.contenido))
					})
				},

				queFoto(prod) {

					//console.log( prod );

					if (prod.fotos.length == 0) {

						return 'https://peru-travel.pe/app/render/images/defecto.jpg';

					} else {

						return 'https://peru-travel.pe/app/render/images/subidas/' + prod.fotos[0].nombreRuta;

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
				},
				queTransporte(tourActivo){
					if ( 'idTransporte' in tourActivo )
						return this.queTransportes.find(tra => tra.id == tourActivo.idTransporte )?.transporte
					else{
						let texto = ''
						switch(tourActivo.transporte){
							case '1': texto = 'bus'; break;
							case '2': texto = 'avión'; break;
							case '3': texto = 'Ninguno'; break;
							case '4': texto = 'barco'; break;
						}
						return texto
					}
				}

			}

		});

	</script>

</body>


</html>
