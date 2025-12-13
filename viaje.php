<!DOCTYPE html>

<html lang="es">

<head>

	<meta charset="UTF-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/png" href="https://grupoeuroandino.com/wp-content/uploads/2023/07/cropped-Grupo-Euro-Andino-favicon.png">


	<?php
/*
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	*/

	include('/home/grupemde/public_html/app/api/conectkarl.php');

	$sqlBase = "SELECT id, JSON_UNQUOTE(JSON_EXTRACT(contenido, '$.nombre')) as titulo,

	JSON_UNQUOTE(JSON_EXTRACT(contenido, '$.descripcion')) as descripcion,

	IFNULL(JSON_UNQUOTE(JSON_EXTRACT(contenido, '$.fotos[0].nombreRuta')), 'defecto.jpg')as foto

	FROM `tours` where url = '{$_GET['variable']}' and activo = 1 limit 1;";

	$sqlMeta = $db->query($sqlBase);

	//echo $sqlBase;

	if ($sqlMeta->execute()) {

		$rowMeta = $sqlMeta->fetch(PDO::FETCH_ASSOC);

	?>

		<meta property="og:title" content="<?= $rowMeta['titulo'] ?> - Grupo Euro Andino">

		<title><?= $rowMeta['titulo'] ?> - Grupo Euro Andino</title>

		<!-- <meta property="og:image" content="https://grupoeuroandino.com/images/marcapomacocha-2.png"> -->

		<meta property="og:image" content="https://grupoeuroandino.com/app/render/images/subidas/small-<?= $rowMeta['foto'] ?>">

		<meta property="og:description" content="<?= strip_tags($rowMeta['descripcion']) ?>">

	<?php

	}

	?>

<?php include("../app/render/headers.php");?>
</head>

<body>
	<style>
		#divIncluye ul{ list-style-type: "✅ "; }
		#divNoIncluye ul{ list-style-type: "❌ "; }
		.divOferta2{width: 70px; height: 25px; /* rgb(192, 0, 67);  */ margin-top: 1rem; margin-right: 0rem; color:white; font-size: 0.8rem;  }
		/* .estrellas{color: rgb(58, 91, 255);} */
		.estrellas{color: #ffd400;}
		.divImagen img{
			width:100%!important;
			height: 320px!important;
    	object-fit: cover!important;
		}
		.icofont-google-map{margin-left:3px!important;}
		ul{margin-bottom:0}
		.moneda-peque{font-size:15px}
	#pegar p{line-height: 1; color: #000;}
	#spanAvion {display: inline-block; transform:rotate(45deg)}
	.ql-align-justify{text-align: justify;}
	.day { background: #eee; }
	.datepicker table tr td.active.active{background-color: #FFD019;color: brown;}
	.datepicker table tr td.active:hover.active{background-color: #FFD019;color: brown;}
	.datepicker table tr td.day:hover {
  background: #dc3545; color:white;}
	#mostrarRestriccionHorario .alert{padding: 0px!important;}
	</style>


	<!-- Inicio de Encabezado -->
	<?php include ("../app/render/menu.php");?>

    <!-- Fin de Encabezado -->



	<div class="container" id="app">

		<div class="row">

			<div class="col-12 col-md-8">

				<div class="fotorama" data-nav="thumbs" data-width="100%" @contextmenu="handler($event)">

					<img v-for="foto in tourActivo.fotos" :src="'https://grupoeuroandino.com/app/render/images/subidas/'+foto.nombreRuta">



				</div>



				<!-- Empieza el bloque de descripción -->

				<div class="my-3 p-3 border rounded" id="divIzquierda">

					<h2 class="text-dark text-center">{{tourActivo.nombre}}</h2>

					<div class="row">						
							<div v-if="tourActivo.transporte !=3 && tourActivo.transporte!=undefined " class="col col-md text-center fs-6 text-capitalize">
								<span  v-if="tourActivo.transporte==='1'">
									<span class="fs-2">
										<i v-if="queTransporte()=='bus'" class="icofont-bus"></i>
										<i v-if="queTransporte()=='tren'" class="icofont-train-line"></i>
									</span>
									<span>{{queTransporte()}}</span>
								</span>
								<span v-if="tourActivo.transporte==='2'"><span class="fs-2"><span id="spanAvion"><i class="icofont-airplane"></i></span></span> <span>{{queTransporte()}}</span></span>
								<span v-if="tourActivo.transporte==='4'"><span class="fs-2"><i class="icofont-ship-alt"></i></span> <span>{{queTransporte()}}</span></span>
							</div>
							<div v-if="tourActivo.alojamiento" class="col col-md text-center fs-6"><span class="fs-2"><i class="icofont-bed"></i></span> {{retornarHospedaje(tourActivo.alojamiento)}}</div>
							<div v-if="tourActivo.alimentacion" class="col col-md text-center fs-6"> <span class="fs-2"><i class="icofont-fork-and-knife"></i></span> Alimentación </div>
						<div class="col col-md text-center fs-6"><span class="fs-2"><i class="icofont-google-map"></i></span> <span>Tour</span></div>
						<div v-if="tourActivo.guia" class="col col-md text-center fs-6"><span class="fs-2"><i class="icofont-tracking"></i></span> Guía</div>
						<div v-if="tourActivo.tickets" class="col col-md text-center fs-6"><span class="fs-2"><i class="icofont-ticket"></i></span> Tickets</div>
					</div>

					<!-- <div class="row row-cols-2 row-cols-md-3" v-if="tourActivo.tipo===2" id="divTransportes">

						<div class="col" v-if="tourActivo.transporte!='3'">

							<div class="d-flex justify-content-between">

								<div class="m-auto ps-2">
									

									<img v-if="tourActivo.transporte==='2'" src="https://grupoeuroandino.com/app/render/images/vuelo.png" alt="">

									<img v-else src="https://grupoeuroandino.com/app/render/images/carro2.png" style="width:38px">

								</div>

								<div class="text-start">

									<h6 class="mb-1 ">Transporte</h6>

									<span>{{transportes[parseInt(tourActivo.transporte)-1]}}</span>

								</div>

							</div>

						</div>

						<div class="col ps-0">

							<div class="d-flex justify-content-between">

								<div class="m-auto px-2">

									<img src="https://grupoeuroandino.com/app/render/images/hostal.png" style="width:50px">

								</div>

								<div class="text-start">

									<h6 class="mb-1

									">Alojamiento</h6>

									<span>{{hospedajes[parseInt(tourActivo.alojamiento)-1]}}</span>

								</div>

							</div>

						</div>

					</div> -->

					<h5 class="mt-3 text-danger">Descripción</h5>
					<div class="text-justify" v-html="tourActivo.descripcion"></div>

					<h5 class="mt-3 text-danger">Punto de Partida</h5>

					<div class="w-100 text-break text-justify" v-html="tourActivo.partida"></div>

					<h5 class="mt-3 text-danger">Itinerario</h5>					
					<div class="w-100 px-2 text-justify" v-html="tourActivo.itinerario"></div>
					<h5 class="mt-3 text-danger">Incluye</h5>
					<div class="w-100 px-2 text-justify" id="divIncluye" v-html="tourActivo.incluye"></div>
					<h5 class="mt-3 text-danger">No Incluye</h5>
					<div class="w-100 px-2 text-justify" id="divNoIncluye" v-html="tourActivo.noIncluye"></div>



					<!-- <h5 class="mt-3 text-danger">Incluye</h5>

					<div>

						<p class="ms-2 mb-0" v-for="cadena in incluidos"><i class="icofont-check-alt"></i> {{cadena}}</p>

					</div> 



					<h5 class="mt-3 text-danger">No Incluye</h5>

					<div>

						<p class="ms-2 mb-0" v-for="cadena in noIncluidos"><i class="icofont-close-line"></i> {{cadena}}</p>

					</div>-->



					<h5 class="mt-3 text-danger">Notas</h5>
					<div v-html="formatear(tourActivo.notas)"></div>

					<div class="w-100 text-break px-2" id="divNotas" v-html="entregarCorto(inferior, !verMas)"></div>

					<p @click="verMas = !verMas">

						<a class="text-decoration-none" href="#!">

							<span v-if="!verMas">Ver más</span>

							<span v-else>Ver menos</span>

						</a>

					</p>







				</div>

			</div>

			<div class="col-12 col-md-4">

				<div class="row">

					<div class="col text-center bg-secondary bg-opacity-25 ">

						<span class="fs-1"><strong class="text-danger"><small class="fs-3">S/</small> {{precioPorPersona}}</strong> <small class="fs-5">por persona</small></span>

					</div>

				</div>

				<div class="row">

					<div class="col px-0">

						<div id="dtpFecha" data-date-format="dd/mm/yyyy"></div>

					</div>

				</div>
				<div class="row col-7 mx-auto my-3">
					<label for=""><strong>Horarios</strong>:</label>
					<select name="" id="sltHorario" class="form-select" v-model="horarioSelect" @change="revisarAnticipacion()">
						<option value="-1">{{horaLatam(tourActivo.hora).replace('pm', 'p.m.').replace('am', 'a.m.')}}</option>
						<option v-if="tourActivo.hora2" value="1">{{horaLatam(tourActivo.hora2).replace('pm', 'p.m.').replace('am', 'a.m.')}}</option>
					</select>
				</div>
				<div class="row col-8 mx-auto my-1" v-if="mostrarRestriccionHorario" id="mostrarRestriccionHorario">
					<div class="alert alert-warning text-center mb-0" role="alert">
						<i class="icofont-warning"></i> No cumple con el tiempo de <br>anticipación de reserva
					</div>
				</div>
				<div class="row col-7 mx-auto my-3">
					<select class="form-select" id="sltPais" @change="comprobarNacionalidad()" v-model="nacionalidad">
						<option value="-1">País o Nacionalidad</option>
						<option v-for="pais in listaPaises" :value="pais.id">{{pais.pais}}</option>
					</select>
				</div>

				<p class="fs-3 text-center text-muted mt-2">

					<span v-if="tourActivo.cupos==1">Último cupo disponible</span>

					<span v-else>{{tourActivo.cupos}} cupos disponibles</span>

				</p>

				<div class="row container" id="divAdultos">

					<div class="col-5 ">

						<p v-if="tourActivo.tipo=='1'" class="text-muted text-end mb-0">Adultos</p>

						<p v-else class="text-muted mb-0">en hab. matrimonial, doble ó triple</p>

					</div>

					<div class="col-6 ms-3">

						<div class="input-group mx-auto">

							<button class="btn btn-outline-secondary border-0" type="button" @click='restarAdulto()'><i class="icofont-minus"></i></button>

							<input type="text" class="form-control w-25 border-0 text-center text-muted" placeholder=" " @focusout="contarMinimoPersonas()" v-model="cantAdultos">

							<button class="btn btn-outline-secondary border-0" type="button" @click="sumarAdulto()"><i class="icofont-plus"></i></button>

						</div>

					</div>

				</div>

				<div class="row container mt-2" id="divKids">

					<div class="col-5 ">

						<p v-if="tourActivo.tipo==1" class="text-muted text-end mb-0">Niños <br><small>(hasta 10 años)</small></p>

						<p v-else class="text-muted mb-0">en hab. simple <small class="text fst-italic">(1 persona por habitación)</small></p>

					</div>

					<div class="col-6 ms-3">

						<div class="input-group mx-auto">

							<button class="btn btn-outline-secondary border-0" type="button" @click="restarKid()"><i class="icofont-minus"></i></button>

							<input type="text" class="form-control w-25 border-0 text-center text-muted" placeholder=" " @focusout="contarMinimoPersonas()" v-model="cantKids">

							<button class="btn btn-outline-secondary border-0" type="button" @click="sumarKid()"><i class="icofont-plus"></i></button>

						</div>

					</div>

				</div>

				<div class="row col mx-auto my-3 " v-if="!faltaMinimo">
					<div class="alert alert-warning " role="alert">
						La <strong>cantidad mínima</strong> de viajeros debe ser <strong>{{tourActivo.minimo}}</strong>
					</div>
				</div>
				<div class="row col mx-auto my-3 " v-if="!faltaAdulto">
					<div class="alert alert-warning " role="alert">
						Mínimo debe haber un <strong>adulto</strong>
					</div>
				</div>

				<div class=" ms-5 ps-3" id="divDuracion">

					<span><strong>Anticipación:</strong> {{queAnticipa(tourActivo.anticipacion)}}</span><br>
					<span><strong>Duración:</strong> {{queDuraComp}}</span><br>


					<span><strong>Mínimo de viajeros:</strong>

						<span v-if="tourActivo.minimo==1">1 viajero</span>

						<span v-else>{{tourActivo.minimo}} viajeros</span>

					</span>

					<br><br>

					<span class="text-capitalize" v-if="variosTours.pais == '140'"><strong>Ciudad:</strong> {{tourActivo.destino}} - {{queDepa(tourActivo.departamento)}}</span>
					<span class="text-capitalize" v-else><strong>Departamento - Ciudad:</strong> {{tourActivo.destino}} - {{tourActivo.departamento}}</span><br>

					<span><strong>Actividades:</strong> {{tourActivo.actividad}} {{variasActividades(tourActivo.actividades)}}</span><br>

					<span><strong>Categorías:</strong> {{variasCategorias(tourActivo.categorias)}}</span><br>

				</div>

				<div class="row col mx-auto mt-3 mb-0 " v-if="faltaPais">

					<div class="alert alert-warning " role="alert">

						{{msjError}}

					</div>

				</div>



				<div class="row">

					<div class="col text-center">

						<span class='fs-2 text-muted'>Total: <strong style="color:#60696d" class="">S/ {{formatoMoneda(precioTotal)}}</strong></span>
						<p class="mb-2"><span>Total en dólares: <strong> USD {{precioDolares.toFixed(2)}}</strong></span></p>
						
					</div>

				</div>

				<div class="row">

					<div class="col-10 mx-auto d-grid">

						<button class="btn btn-danger rounded-pill" @click="reservar"><strong>RESERVAR AHORA</strong></button>

					</div>

				</div>

				<div class="row col mt-3">
					<img src="https://grupoeuroandino.com/app/render/images/tarjetas.png" alt="" class="img-fluid">

				</div>



				<div class="row my-3 ">

					<div class="col m-4 p-3 border rounded" id="divQuill" v-html="lateral"></div>

				</div>

			</div>

		</div>



		<div class="row">

			<div class="col-12">

				<div class="my-3 p-4 border rounded">

					<div id="divRecomendaciones">

						<div class="titulo p-2 mb-3">

							<h3 class="my-1">Tours y paquetes turísticos similares:</h3>

						</div>

					<!-- 	<div class="row row-cols-12 row-cols-lg-3">
							
						</div> -->

						<div class="carousel-wrapper">

							<div class=" my-2 owl-carousel owl-theme">
								<div class="col-12 my-3" v-for="(tour, index) in contenidos">
									<div class="card border-0 h-100">


										<div v-if="tour.fotos.length>0" class="divImagen card-img-top position-relative">
											<div class="divOferta2 w-100 position-absolute bottom-0 end-0 d-flex justify-content-end mb-2 me-1">
													<span v-if="tour.transporte==1" class="mx-1 px-1 rounded" id="spanTransporte">Bus {{variosTours.tipo}}</span>
													<span v-if="tour.transporte==2" class="mx-1 px-1 rounded" id="spanTransporte">Avión</span>
													<span v-if="tour.transporte==4" class="mx-1 px-1 rounded" id="spanTransporte">Barco</span>													
													<span v-if="tour.alojamiento" class="mx-1 px-1 rounded" id="spanOferta"> {{retornarHospedaje(tour.alojamiento)}}</span>
													<span v-if="tour.alimentacion" class="mx-1 px-1 rounded" id="spanAlimentacion">Alimentación</span>
												<span class="mx-1 px-1 rounded" id="spanTour">Tour</span>
												<span v-if="tour.guia" class="mx-1 px-1 rounded" id="spanGuia">Guía</span>
												<span v-if="tour.tickets" class="mx-1 px-1 rounded" id="spanTickets">Tickets</span>
											</div>
											<a class="aImgs" v-if="tour.tipo==1" :href="'https://grupoeuroandino.com/tours/' + tours[index].url" target="_parent"><img class="img-fluid rounded-top" :src="'https://grupoeuroandino.com/app/render/images/subidas/'+tour.fotos[0].nombreRuta" alt=""></a>
											<a class="aImgs" v-if="tour.tipo==2" :href="'https://grupoeuroandino.com/tours/' + tours[index].url" target="_parent"><img class="img-fluid rounded-top" :src="'https://grupoeuroandino.com/app/render/images/subidas/'+tour.fotos[0].nombreRuta" alt=""></a>
										</div>
										
										<div class="card-body">
											<div class="divProducto ">								
												<div>
													<p class="mb-0 titulo text-capitalize text-start"><strong>
														<a class="text-decoration-none text-dark" v-if="tour.tipo==1" :href="'https://grupoeuroandino.com/tours/' + tours[index].url" target="_parent">{{tour.nombre}}</a>
														<a class="text-decoration-none text-dark" v-if="tour.tipo==2" :href="'https://grupoeuroandino.com/tours/' + tours[index].url" target="_parent">{{tour.nombre}}</a>
														</strong>
													</p>
													
												</div>
								
												<div class="row row-cols-2">
													<div class="text-start">
														<span class="text-capitalize"><img class="bandera" src="https://grupoeuroandino.com/images/banderas/peru.jpeg" style="width:20px; height:13.59px; display:inline;"></span> <span ><strong>{{tour.destino}},</strong></span><br>
														<i class="icofont-google-map"></i> <span class="text-capitalize"><strong>{{queDepa(tour.departamento)}}</strong></span>
														<div class="estrellas">
															<i v-for="star in cuantasEstrellas(index)" class="icofont-star"></i>
														</div>
														<span v-if="tour.tipo==1" class="text-muted subText">{{queDura(tour.duracion)}}</span>
														<span v-else class="text-muted subText">{{queDuraDia(tour.duracion.dias)}} / {{queDuraNoche(tour.duracion.noches-1)}}</span>
													
													</div>
													<div class="d-flex flex-column align-items-end justify-content-end" id="pegar">
														<p class="mb-0" style="font-size: 12px;">Desde</p>
														<p><span class="precio2"><span class="moneda-peque">S/.</span> {{formatoMonedaCero(tour.peruanos.adultos)}}</span></p>
														<p v-if="tour.oferta!='0' && tour.oferta!=''" class="precioAnt2 mb-0">S/. {{formatoMonedaCero(tour.oferta)}}</p>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>

								<!-- <div class=" item" v-for="recomendado in recomendados" :key="recomendado.id">

									<a :href="'https://grupoeuroandino.com/tour/'+recomendado.url"><img :src="'https://grupoeuroandino.com/app/render/images/subidas/'+recomendado.foto" alt="" class="img-fluid"></a>

									<h5 class="mb-0 text-start">{{recomendado.titulo}}</h5>

									<p class="card-text mb-0 text-start"><i class="icofont-google-map"></i> <span class="text-capitalize"><strong>{{recomendado.destino}}, {{departamentos[recomendado.depa]}}</strong></span></p>

									<div class="text-start estrellas"><i class="icofont-star"></i><i class="icofont-star"></i><i class="icofont-star"></i><i class="icofont-star"></i><i class="icofont-star"></i></div>

									<div class="row row-cols-2">

										<div class="text-start">

											<span>{{queDuraRecomendado(recomendado.tipo, recomendado.duracion, recomendado.duracion2)}}</span>

										</div>

										<div class="text-end "><span class="precio2"><span class="monedita fs-6">S/</span> {{formatoMoneda(recomendado.precio)}}</span>
											<p class="precioAnt2 mb-0">S/ {{formatoMoneda(recomendado.oferta)}}</p>
										</div>

									</div>

								</div> -->

							</div>

						</div>

					</div>

				</div>

			</div>

		</div>
		<div class="row">
			<div class="col-12 col-md-8">
				<div class="my-3 p-4 border rounded">
					<div class="titulo p-2 mb-3">
						<h3 class="my-1">Que opinan los viajeros que compraron este tour</h3>
						<ul class="list-group list-group-flush">
							<li class="list-group-item" v-for="(comentario, index) in comentarios">
								<div class="d-flex w-100 justify-content-between">
									<h5 class="mb-1 text-capitalize">{{index+1}}. {{comentario.nombre}}</h5>
									<small>Viajó el {{fechaFrom(comentario.fecha)}}</small>
								</div>
								<div>
									<span>Nos calificó con</span> <span v-for="estrella in parseInt(comentario.calificacion)"><img src="https://grupoeuroandino.com/images/star.png" alt="estrella"></span>
									<p class="text-capitalize">Comentario: {{comentario.comentario || 'Me gustó'}}</p>
								</div>
							</li>
						</ul>
					</div>
				</div>
				<p>Comentaron {{parseInt(variosTours.votantes) - comentarios.length }} viajeros más...</p>
			</div>
		</div>



	</div>

	</div>



	</div>

	</div>

	<!-- Modal -->

	<div class="modal fade" id="modalAgenda" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

		<div class="modal-dialog modal-dialog-centered">

			<div class="modal-content">

				<div class="modal-body">

					<div class="d-flex justify-content-between">

						<h1 class="modal-title fs-5" id="exampleModalLabel">Horario de atención</h1>

						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

					</div>

					<p class=" mt-2 lead">Lunes a Domingo</p>

					<p>De 9:00 am - 1:00 pm</p>

					<p>De 3:00 am - 7:00 pm</p>



				</div>

			</div>

		</div>

	</div>



	<footer class="container-fluid pt-5 pb-5" id="pie">



		<div class="container">

			<div class=" row" style="margin-top: 8rem!important;">

				<div class="col-12 col-md-4">

					<a href=""><img src="https://grupoeuroandino.com/wp-content/uploads/2022/11/yape.png" alt=""></a>

				</div>

				<div class="col-12 col-md-4">

					<a href=""><img src="https://grupoeuroandino.com/images/pie2.png?v=2" alt=""></a>

				</div>

				<div class="col-12 col-md-4">

					<a href=""><img src="https://grupoeuroandino.com/images/form.png?v=1" alt="" style="margin-bottom: 1em;"></a>

					<form id="formulario">

						<input type="text" id="txtNombres1" placeholder="Nombres y Apellidos">

						<input type="email" id="txtCorreo1" placeholder="Ingresa tu Email">

						<button id="btnFormulario"><img src="https://grupoeuroandino.com/images/address-book-solid.svg" id="enviarMnj"> SUSCRIBIRME</button>

					</form>

					<p class="text-white pb-2" style="font-size: 18px;"><strong>REDES SOCIALES</strong></p>

					<div class="d-flex" style="margin-bottom: 1em;">

						<a href="https://www.facebook.com/grupoeuroandino/"><img src="https://grupoeuroandino.com/images/facebook.png" width="50" height="50"></a>

						<a href="https://twitter.com/grupoeuroandino/"><img src="https://grupoeuroandino.com/images/twitter.png" width="50" height="50" style="margin:0 5px;"></a>

						<a href="https://twitter.com/grupoeuroandino/"><img src="https://grupoeuroandino.com/images/instagram.png" width="50" height="50" style="margin:0 5px;"></a>

						<a href="https://www.youtube.com/channel/UCG31MOsbyOuHr6-LpH4Mkbw"><img src="https://grupoeuroandino.com/images/youtube.png" width="50" height="50" style="margin:0 5px;"></a>

						<a href="https://www.linkedin.com/in/grupo-euro-andino-426b81123/"><img src="https://grupoeuroandino.com/images/in.png" width="50" height="50" style="margin:0 5px;"></a>

						<a href="https://www.flickr.com/photos/193956460@N06/"><img src="https://grupoeuroandino.com/images/cua.png" width="50" height="50" style="margin:0 5px;"></a>

					</div>

					<div>

						<a href="https://grupoeuroandino.com/libro-de-reclamaciones/"><img src="https://grupoeuroandino.com/wp-content/uploads/elementor/thumbs/Libro-de-Reclamaciones-pqjdp1qustruv9u46xq03mwub2nazjop222m18a8h4.jpg" width="160" height="auto" style="margin-right:10px;"></a>

						<a href="https://consultasenlinea.mincetur.gob.pe/directoriodeserviciosturisticos/DirPrestadores/DirBusquedaPrincipal/AgenciaViajes?IdGrupo=2"><img src="https://grupoeuroandino.com/wp-content/uploads/elementor/thumbs/Agencia-de-viajes-y-Turismo-Registrada-pqjfqac5b415hhgbj3eivnkskvnvqjfs4jzl6doxns.jpg" width="160" height="auto"></a>

					</div>

				</div>

			</div>

		</div>



	</footer>







	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>



	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<!-- Desarrollo -->
<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
<!-- Produccion -->
<!-- <script src="https://cdn.jsdelivr.net/npm/vue@2"></script> -->


	<script src="https://grupoeuroandino.com/app/render/js/axios.min.js"></script>

	<script src="https://grupoeuroandino.com/app/render/js/moment.min.js"></script>
	
	<link href="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css" rel="stylesheet">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js"></script>
	<script src="https://grupoeuroandino.com/app/render/js/bootstrap-datepicker.min.js"></script>
	<script src="https://grupoeuroandino.com/app/render/js/bootstrap-datepicker.es.min.js"></script>
	<script src="https://grupoeuroandino.com/js/owl.carousel.min.js" ></script>
	<script src="https://grupoeuroandino.com/app/render/js/paises.js" ></script>
	


	<script>
		var datepicker = $.fn.datepicker.noConflict();

		$.fn.bootstrapDP = datepicker;

		/* $('#dtpFecha').datepicker({

	    language: "es",

	    keyboardNavigation: false,

	    todayHighlight: false,

	    datesDisabled: ['07/02/2022','06/02/2022', '05/02/2022', '04/02/2022', '03/02/2022', '02/02/2022', '01/02/2022','31/01/2022' ]

		});

		$(".prev").each(function(i) {$(".prev")[i].innerHTML = `<i class="icofont-rounded-left"></i>`})

		$(".next").each(function(i) {$(".next")[i].innerHTML = `<i class="icofont-rounded-right"></i>`}) */

		var app = new Vue({

			el: '#app',

			data() {

				return {

					idProducto: -1, horarioSelect:-1,

					//servidor: 'http://localhost/appTours/api/',
					servidor: 'https://grupoeuroandino.com/app/api/',
					lateral:'', dolar:0, precioDolares:0, inferior:'',
					listaPaises: PAISES_DATA,
					variosTours: [],
					tourActivo: [{
						incluye: '',
						noIncluye: '',
						peruanos: {
							adultos: 0,
							kids: 0
						},
						extranjeros: {
							adultos: 0,
							kids: 0
						},
						duracion: 0,
						notas: ''

					}],

					precioPorPersona: 0,
					cantAdultos: 0,
					cantKids: 0,

					duracion: [{
						clave: 1,
						valor: 'Half Day (Medio día)'
					}, {
						clave: 2,
						valor: 'Full Day (1 día)'
					}],

					duracionDias: [{
						clave: 1,
						valor: 'Half Day (Medio día)'
					}, {
						clave: 2,
						valor: 'Full Day (1 día)'
					}],

					duracionNoches: [{
						clave: 1,
						valor: '0 noches'
					}, {
						clave: 2,
						valor: '1 noche'
					}],

					anticipacion: [{
						clave: 1,
						valor: '12 horas'
					}, {
						clave: 2,
						valor: '1 día'
					}],

					departamentos: ['Amazonas', 'Ancash', 'Apurimac', 'Arequipa', 'Ayacucho', 'Cajamarca', 'Cusco', 'El Callao', 'Huancavelica', 'Huánuco', 'Ica', 'Junín', 'La Libertad', 'Lambayeque', 'Lima', 'Loreto', 'Madre de Dios', 'Moquegua', 'Pasco', 'Piura', 'Puno', 'San Martín', 'Tacna', 'Tumbes', 'Ucayali'],
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
					diasMuertos: [],
					precioTotal: 0,
					nacionalidad: -1,
					faltaPais: false,
					msjError: '',
					verMas: false, mostrarRestriccionHorario:false,

					incluidos: [],
					noIncluidos: [],
					faltaMinimo: true, faltaAdulto:true,
					recomendados: [],
					categorias2: [],
					actividades2: [], contenidos:[], comentarios:[],
					transportes: ['Terrestre', 'Aéreo', 'Ninguno'],
					hospedajes: []

				}

			},

			mounted() {
				//sacando el ID

				const queryString = window.location.search;

				const urlParams = new URLSearchParams(queryString);

				this.idProducto = '<?= $rowMeta['id']; ?>'

				//console.log( 'el id es ' + this.idProducto );

				this.cargarComplementos();

				this.pedirDatos();

			},

		methods: {

			async cargarComplementos() {

				let servComplementos = await fetch(this.servidor + 'pedirComplementos.php', {

					method: 'POST'

				})
				axios.post(this.servidor + 'Alojamientos.php',{
					pedir: 'listar'
				})
				.then(serv=> this.hospedajes = serv.data )

				let resServidor = await servComplementos

				resServidor.json().then((queVino) => {
					this.actividades2 = queVino[0];
					this.categorias2 = queVino[1];
					//Obtener el valor de lo seleccionado
					//$('#sltActividad2').selectpicker('val');
					//asignar valor
					//$('#sltActividad2').selectpicker('val', ['51', '53']);
				})
				let servConfig = await fetch(this.servidor+ 'cargarPanel.php',{ method:'POST' })
				let resConfig = await servConfig.json();
				this.lateral = resConfig.lateral;
				this.inferior = resConfig.inferior;
				this.dolar = resConfig.dolar

			},
			async cargarTours(){
				let datos = new FormData()
				datos.append('departamento', this.tourActivo.departamento+1)
				const respuesta = await fetch(this.servidor+'mostrarTours_scriptDepartamentos.php',{
					method:'POST', body:datos
				})
				let temp = await respuesta.json()
				//console.log('temp',temp);
				this.tours = temp;
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

			async pedirDatos() {

				var hoy = moment();

				const respuesta = await axios.post(this.servidor + 'verTourPorId_v2.php', {
					id: this.idProducto
				});

				this.variosTours = respuesta.data['tour'];
				this.comentarios = respuesta.data['comentarios'];

				this.tourActivo = JSON.parse(this.variosTours.contenido);

				this.precioPorPersona = this.tourActivo.peruanos.adultos;

				//this.cantAdultos = this.tourActivo.minimo;

				$('.fotorama').fotorama();

				for (let dia = 2; dia <= 31; dia++) {

					this.duracion.push({
						clave: dia + 1,
						valor: dia + ' días / 0 noches'
					});

					this.duracionDias.push({
						clave: dia + 1,
						valor: dia + ' días'
					});

					this.duracionNoches.push({
						clave: dia + 1,
						valor: dia + ' noches'
					});

				}

				for (let dia = 2; dia <= 15; dia++) {
					this.anticipacion.push({ clave: dia+1, valor: dia + ' días' });
				}
				this.anticipacion.push({ clave: 31, valor: 31 + ' días' });
				for (let mes = 2; mes <= 11; mes++) {
					this.anticipacion.push({ clave: mes*31, valor: mes + ' mes' });
				}
				this.anticipacion.push({ clave: 365, valor: '1 año' });

				//$('#dtpFecha').bootstrapDP('setDate', moment().format('DD/MM/YYYY'))
				/* $('#dtpFecha').bootstrapDP({
					language: 'es',
					setDate: moment().format('DD/MM/YYYY')
				}) */

				switch (this.tourActivo.anticipacion) {
					case "1":
						this.bloquearFechaDesde(hoy.diff(1, 'days'));break;
					case "2":
						this.bloquearFechaDesde(hoy.add(1, 'days'));break;
					default:
						this.bloquearFechaDesde(hoy.add(parseInt(this.tourActivo.anticipacion) - 1, 'days'));break;
				}

				this.incluidos = this.tourActivo.incluye.split('\n');

				this.noIncluidos = this.tourActivo.noIncluye.split('\n');

				const myTimeout = setTimeout(function() {

					$('.fotorama').fotorama();

				}, 500);

				this.cargarTours()



				let datos = new FormData();

				datos.append('tipo', this.tourActivo.tipo);

				datos.append('departamento', this.tourActivo.departamento);

				const response = await fetch(this.servidor + 'pedirRecomendadosRandom.php', {
						method: 'POST',
						body: datos
					})
				this.recomendados = await response.json()
				setTimeout(() => {
					$('.owl-carousel').owlCarousel('destroy');

				}, 1000);
				setTimeout(() => {
					$(".owl-carousel").owlCarousel({
						autoplay: true,
						loop: true,
						margin: 20,
						dots: false,
						lazyLoad: true,
						nav: true,
						navText: ["<div class='nav-button owl-prev'>‹</div>", "<div class='nav-button owl-next'>›</div>"],
						responsive: {
							0: {
								items: 1
							},
							600: {
								items: 3
							}
						}
					});
				}, 1000);

				
					/* .then(response => response.json())
					.then(data => {
						this.recomendados = data;
					}).then(() => {
						
					}); */

				/* this.recomendados = await respRecomendados.json()

				.then(()=>{

				}); */



			},

			contarMinimoPersonas() {

				if (this.nacionalidad == 159 || this.nacionalidad == -1) {
					this.precioTotal = parseFloat(this.cantAdultos * this.tourActivo.peruanos.adultos) + parseFloat(this.cantKids * this.tourActivo.peruanos.kids);
				} else {
					this.precioTotal = parseFloat(this.cantAdultos * this.tourActivo.extranjeros.adultos) + parseFloat(this.cantKids * this.tourActivo.extranjeros.kids);

				}
				this.precioDolares = this.precioTotal / this.dolar


				if(this.cantKids>0 && this.cantAdultos==0 ){
					this.msjError = "Se debe reservar como mínimo un adulto";
					return this.faltaAdulto = false;
				}
				else
					this.faltaAdulto=true;
					if ((this.cantAdultos + this.cantKids) < parseInt(this.tourActivo.minimo)) {
						this.faltaPais = true;
						this.msjError = "Debe rellenar el campo de su nacionalidad antes de reservar";
						return this.faltaMinimo = false;
					} else {
						this.faltaPais = false;
						return this.faltaMinimo = true;
					}
			},

			restarAdulto() {

				if (this.cantAdultos > 0) {

					this.cantAdultos--;
					this.contarMinimoPersonas();

				}

			},

			sumarAdulto() {

				this.cantAdultos++;
				this.contarMinimoPersonas();

			},

			restarKid() {

				if (this.cantKids > 0) {

					this.cantKids--;
					this.contarMinimoPersonas();

				}

			},

			sumarKid() {

				this.cantKids++;
				this.contarMinimoPersonas();

			},

			queAnticipa(valor) {
				if (valor != null) {
					if(valor >= 365)
						return '1 año'
					if(valor > 31)
						return parseInt(valor/31) + ' meses'
					else if(valor==1){
						if( this.tourActivo.antes)
						    if(this.tourActivo.antes == "0") return "Sin restricciones"
							else return `${this.tourActivo.antes} hora${this.tourActivo.antes == 1 ? '':'s'} antes`
						else{
							return 'Sin restricciones';
						}
					}else if(valor>1){
						return this.anticipacion[parseInt(valor) - 1].valor + " antes del viaje";
					}
				}
			},

			variasActividades(queActividad) {

				//console.log('es la acti', queActividad);

				var actividades = "";

				if (queActividad != undefined) {

					queActividad.forEach(actividad => {

						actividades += " " + this.actividades2.find(x => x.id === actividad)?.concepto + ",";

					});

					return actividades.substring(0, actividades.length - 1)

				} else {

					return '-';

				}

			},

			variasCategorias(queCategoria) {

				if (queCategoria != undefined) {

					var categorias = "";

					queCategoria.forEach(actividad => {

						categorias += " " + this.categorias2.find(x => x.id === actividad)?.concepto + ",";

					});

					return categorias.substring(0, categorias.length - 1)

				} else {

					return '-';

				}

			},

			bloquearFechaDesde(fechaInicial) {

				//console.log('inicial', fechaInicial.format('DD/MM/YYYY') );
				//console.log('fechas', this.tourActivo.fechas)
				if(this.tourActivo.fechas){
					for(let index = 0; index< this.tourActivo.fechas.length; index++){
						this.diasMuertos.push(moment(this.tourActivo.fechas[index].fecha).format('DD/MM/YYYY'))
					}
				}
				
				if( this.tourActivo.anticipacion==1) //horas
					if( parseInt(this.tourActivo.antes) >=12 )
						this.diasMuertos.push(moment().format('DD/MM/YYYY'));
				if( this.tourActivo.anticipacion>1)
					for (let index = 0; index < this.tourActivo.anticipacion-1; index++)
						this.diasMuertos.push(moment(moment.now()).add(index, 'days').format('DD/MM/YYYY'));

				
				//console.log(this.diasMuertos);

				//$('#dtpFecha').datepicker('destroy');
				let diasDisponibles = []
				if(this.tourActivo.atencion){
					diasDisponibles = this.tourActivo.atencion?.length==0 ? [] : [0,1,2,3,4,5,6]
					this.tourActivo.atencion?.forEach(diaNo=>{
						const index = diasDisponibles.indexOf(parseFloat(diaNo));
						if (index > -1) diasDisponibles.splice(index, 1);
					})
				}

				$('#dtpFecha').bootstrapDP({
					language: 'es',
					setDate: moment().format('DD/MM/YYYY'),
					language: "es",
					keyboardNavigation: false,
					daysOfWeekDisabled: diasDisponibles,
					todayHighlight: false,
					datesDisabled: this.diasMuertos,
					startDate: new Date(),
				})
				.on('changeDate', function(e) {
					app.revisarAnticipacion()
				});

				$(".prev").each(function(i) {
					$(".prev")[i].innerHTML = `<i class="icofont-rounded-left"></i>`
				})

				$(".next").each(function(i) {
					$(".next")[i].innerHTML = `<i class="icofont-rounded-right"></i>`
				})

			},
			revisarAnticipacion(){
				this.mostrarRestriccionHorario = false
				let ahora = moment()
				let horarioSeleccionado = moment( $('#dtpFecha').bootstrapDP('getFormattedDate') +' '+ ($('#sltHorario').val()  == -1 ? this.tourActivo.hora : this.tourActivo.hora2), 'DD/MM/YYYY HH:mm')
				let diferencia = 
					this.tourActivo.anticipacion == 1 ? horarioSeleccionado.diff(ahora, 'hours'): horarioSeleccionado.diff(ahora, 'days') //el 1 es horas, a partir de 2 es días
				
				if(this.tourActivo.anticipacion == 2 && parseInt(this.tourActivo.antes) == 0)	{
					diferencia = horarioSeleccionado.diff(ahora, 'hours')
					console.log('diff extra', diferencia)
					if(diferencia <24 && diferencia <0) this.mostrarRestriccionHorario=true
					return false
				}
				console.log('diff oficial', diferencia, parseInt(this.tourActivo.anticipacion)-1)
				if(diferencia >= parseInt(this.tourActivo.anticipacion)-1 ){
						console.log('se puede comprar')
					}else
						this.mostrarRestriccionHorario = true
			},
			horaLatam(hora) {

				return (moment(hora, 'HH:mm').format('h:mm a'))

			},

				reservar() {
					if ($('#dtpFecha').bootstrapDP('getFormattedDate') == null || $('#dtpFecha').bootstrapDP('getFormattedDate') == '') {

						this.faltaPais = true;
						this.msjError = "Debe seleccionar una fecha inicial";
						return false;
					}else if( $('#dtpFecha').bootstrapDP('getFormattedDate') == moment().format('DD/MM/YYYY')){ //Es hoy
						if(this.tourActivo.anticipacion == 1 ){
							const horaActual = moment()
							var horaElegida = null
							const horasAntes = parseInt(this.tourActivo.antes) ?? 0
							if( this.horarioSelect=='-1') horaElegida = moment(this.tourActivo.hora, 'HH:mm')
							else horaElegida = moment(this.tourActivo.hora2, 'HH:mm')
							const diferenciaHoras = horaElegida.diff(horaActual, 'hours') - horasAntes;
							if (diferenciaHoras >= 0) { //Se puede comprar esta en el rango
								this.faltaPais = false;
								this.msjError=''
								console.log("La horaComparar en el rango.", diferenciaHoras );
								this.prepararCompra();

							} else { //Esta muy atrás
								console.log("La horaComparar no está en el rango.", diferenciaHoras );
								this.faltaPais = true;
								this.msjError = `Se debe reservar ${Math.abs(horasAntes)} hora${Math.abs(horasAntes) == 1 ? '':'s'} antes a la hora elegida`;
								return false;
							}
						}
					}
					else{
						this.prepararCompra();
					}
				},
				prepararCompra(){
					if (this.comprobarNacionalidad() && this.contarMinimoPersonas()) {
						window.location.href = "/carrito-compras/?id=" + this.idProducto + "&adults=" + this.cantAdultos + "&kids=" + this.cantKids + "&nationality=" + this.nacionalidad + "&start=" + $('#dtpFecha').bootstrapDP('getFormattedDate')+'&horario='+this.horarioSelect;
					}
				},

				comprobarNacionalidad() {

					if (this.nacionalidad == -1) {

						this.faltaPais = true;
						this.msjError = "Debe rellenar el campo de su nacionalidad antes de reservar";
						return false;

					} else {

						this.faltaPais = false;

						return true;

					}

				},

				formatoMoneda(valor) { return parseFloat(valor).toFixed(2) },
				formatoMonedaCero(valor) { return parseFloat(valor).toFixed(0) },

				queDuraRecomendado(tipo, queDuracion, queDuracion2) {

					try {

						if (tipo == '2') {

							queDuracion3 = JSON.parse(queDuracion2);

							//return 'caso 2';

							return this.duracionDias.find(x => x.clave === queDuracion).valor + " / " + this.duracionNoches[queDuracion2].valor;;

							//return this.duracionDias[parseInt(this.tourActivo.duracion.dias)].valor + ", " + this.duracionNoches[parseInt(this.tourActivo.duracion.noches)].valor;

						}

						if (tipo == '1') {

							return this.duracion[parseInt(queDuracion) - 1].valor

							//return this.duracion.find( x => x.clave === duracion ).valor;

						}

					} catch (error) {



					}

				},
				formatear(){
					let texto =  this.tourActivo.notas?.replace('<p><br></p>', '')
					if( texto !='') texto = texto+'<p><br></p>'
					return texto
				},
				fechaFrom(fecha){
					return moment(fecha).format('DD/MM/YYYY');
				},
				cuantasEstrellas(index){
					return parseInt(this.tours[index].calificacion)
				},
				expandirMas() {

					this.verMas = true;

					let divNotas = document.getElementById('divNotas');

					divNotas.style.height = "100%";

					divNotas.style.overflow = auto;

				},

				entregarCorto(texto, corto) {



					if (corto && texto != undefined) {

						return texto.substring(0, 1600) + '...';

					} else {

						return texto;

					}

				},
				handler: function(e) {
					//do stuff
					e.preventDefault();
				},
				retornarHospedaje(id){
					let al = this.hospedajes.find(x=> x.id == id)
					if (al) return al.alojamiento
				},
				queTransporte(){
					if ( 'idTransporte' in this.tourActivo )
						return this.queTransportes.find(tra => tra.id == this.tourActivo.idTransporte )?.transporte
					else{
						let texto = ''
						switch(this.tourActivo.transporte){
							case '1': texto = 'bus'; break;
							case '2': texto = 'avión'; break;
							case '3': texto = 'Ninguno'; break;
							case '4': texto = 'barco'; break;
						}
						return texto
					}
				}
			},

			computed: {

				queDuraComp() {

					try {

						if (this.tourActivo.tipo == '2') {

							return this.duracionDias.find(x => x.clave === this.tourActivo.duracion.dias).valor + " / " + this.duracionNoches.find(x => x.clave === this.tourActivo.duracion.noches).valor;

							//return this.duracionDias[parseInt(this.tourActivo.duracion.dias)].valor + ", " + this.duracionNoches[parseInt(this.tourActivo.duracion.noches)].valor;

						} else {

							return this.duracion.find(x => x.clave === this.tourActivo.duracion).valor;

						}

					} catch (error) {



					}

				},

			},

		})



		$(document).ready(function() {
			const signupForm = document.querySelector("#btnFormulario");
			signupForm.addEventListener("click", async function(event) {
				event.preventDefault();

				var dato = new FormData();
				dato.append('txtNombres', document.getElementById('txtNombres1').value)
				dato.append('txtCorreo', document.getElementById('txtCorreo1').value)

				let respuesta = await fetch('https://grupoeuroandino.com/app/api/correo_suscribir.php', {
					method: 'POST',
					body: dato

				});
				console.log(await respuesta.text())
			});
		});
	</script>

</body>

</html>