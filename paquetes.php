<?php
if(!isset($_COOKIE['ckUsuario'])){ header("Location: index.html");die(); }
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Panel de paguetes - Grupo Euro-Andino</title>
	<link rel="icon" type="image/png" href="https://grupoeuroandino.com/wp-content/uploads/2023/07/cropped-Grupo-Euro-Andino-favicon.png">

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" href="icofont/icofont.min.css">
	<link rel="stylesheet" href="css/bootstrap-datepicker.min.css">
	<link rel="stylesheet" href="css/quill.bubble.css">
	<link rel="stylesheet" href="css/quill.snow.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
</head>
<body>
	<style>
		.bg-success {background-color: #00b749!important;}
		.toast-container{z-index: 1046;}
		tr{cursor: pointer;}
		p{margin-bottom: 0;}
		.bootstrap-select .dropdown-toggle{
			padding-top: 1.625rem;
    	padding-bottom: 0.625rem;
			
	    line-height: 1.25;
			display: block;
	    width: 100%;
	    padding: 0.375rem 2.25rem 0.375rem 0.75rem;
	    -moz-padding-start: calc(0.75rem - 3px);
	    font-size: 1rem;
	    font-weight: 400;
	    line-height: 1.5;
	    color: #212529;
	    background-color: #fff;
	    background-repeat: no-repeat;
	    background-position: right 0.75rem center;
	    background-size: 16px 12px;
	    border: 1px solid #ced4da;
	    border-radius: 0.25rem;
	    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
	    -webkit-appearance: none;
	    -moz-appearance: none;
	    appearance: none;
		}
		.sltPicker .bootstrap-select{
			width: 100%!important;
		}
		#divFotografias label{font-size: 0.9rem;}
	</style>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="container">
			<a class="navbar-brand" href="#">Grupo Euro Andino</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
				<div class="navbar-nav">
					<a class="nav-link " aria-current="page" href="tours.php">Tours</a>
					<a class="nav-link active" href="paquetes.php">Paquetes turísticos</a>
					<a class="nav-link" href="pedidos.php">Pedidos</a>
					<a class="nav-link" href="lateral.php">Configuraciones</a>
				</div>
			</div>
		</div>
	</nav>

	<div class="container" id="app">
		<div class="row ">
			<div class="col-8">
				<p class="fs-1">Paquetes turísticos</p>
			</div>
			<div class="col-4 d-flex align-items-center">
				<button class="btn btn-outline-success ms-2" @click="nuevoTourSimple()"><i class="icofont-list"></i> Crear Paquete turístico</button>
				<!-- <button class="btn btn-outline-success ms-2" @click="verTours()"><i class="icofont-list"></i> pedir datos</button> -->
			</div>
		</div>
		<div class="row">
			<div class="col-12 col-md-6">
				<label for="" class="form-label"><i class="icofont-filter"></i> Filtrar</label>
				<div class="input-group mb-3">
					<input type="text" name="" id="txtFiltro" ref="txtFiltro" class="form-control" placeholder="Buscar" >
					<button class="btn btn-outline-secondary" type="button" @click="buscarProducto()"><i class="icofont-search"></i> Buscar</button>
				</div>
			</div>
			<div class="col-12 col-md-6">
				<label for="" class="form-label"><i class="icofont-filter"></i> Departamentos</label>
				<select class="form-select" v-model="idDepartamento" @change="buscarProducto()">
					<option value="-1">Todos</option>
					<option v-for="(departamento, index) in departamentos" :value="index">{{departamento}}</option>
				</select>
			</div>
		</div>
		<table class="table table-hover">
			<thead>
				<tr>
					<th>N°</th>
					<th>Título</th>
					<th>Precio Perú</th>
					<th>Precio Ext.</th>
					<th>Fechas</th>
					<th><i class="icofont-eye-alt"></i></th>
				</tr>
			</thead>
			<tbody>
				<tr v-if="variosTours.length == 0">
					<td colspan=5>No hay paquetes</td>
				</tr>
				<tr v-else v-for="(vTour, index) in variosTours" :data-id="todosTours[index].id">
					<td @click="cargarPanel(todosTours[index].id, index)">{{index+1}}</td>
					<td @click="cargarPanel(todosTours[index].id, index)" class="text-capitalize">{{vTour.nombre}}</td>
					<td @click="cargarPanel(todosTours[index].id, index)">{{parseFloat(vTour.peruanos.adultos).toFixed(2)}}</td>
					<td @click="cargarPanel(todosTours[index].id, index)">{{parseFloat(vTour.extranjeros.adultos).toFixed(2)}}</td>
					<td>
						<button data-bs-toggle="offcanvas" data-bs-target="#offFechas" class="btn btn-sm btn-outline-secondary" @click.prevent="idGlobal=todosTours[index].id;tourActivo =JSON.parse(todosTours[index].contenido)"><span v-if="vTour.fechas">{{vTour.fechas.length}}</span> <span v-else>0</span></button>
					</td>
					<td @click="cargarPanel(todosTours[index].id, index)" >
						<span class="text-primary" v-if="esVisible(index)=='1'"><i class="icofont-check"></i></span>
						<span class="text-danger" v-else><i class="icofont-close"></i></span>
					</td>
					
				</tr>
			</tbody>
		</table>


		<div class="modal fade" id="modalNuevo" data-bs-backdrop="static" tabindex="-1">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-body">
						<div class="d-flex justify-content-between mb-3">
							<h5 class="modal-title">Nuevo anuncio: Paquete turístico</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="form-floating mb-3">
							<input type="text" class="form-control" id="floNombre" placeholder=" " autocomplete="off" v-model="tour.nombre">
							<label for="floNombre">Nombre del paquete turístico</label>
						</div>
						<div class="form-floating mb-3" v-if="!activarEditar">
							<input type="text" class="form-control" id="floURL" placeholder=" " autocomplete="off" v-model="tour.url">
							<label for="floURL">URL del tour</label>
						</div>
						<p class="mb-0">Precio de Oferta:</p>
						<div class="row">
							<div class="col">
								<div class="form-floating mb-3">
									<input type="number" class="form-control" id="floOferta" placeholder=" " autocomplete="off" v-model="tour.oferta">
									<label for="floNombre">Oferta</label>
								</div>
							</div>
						</div>
						<p class="mb-0">Precio para Peruanos:</p>
						<div class="row ">
							<div class="col-12">
								<div class="form-floating mb-3">
									<input type="number" class="form-control" id="floNombre" placeholder=" " autocomplete="off" v-model="tour.peruanos.adultos">
									<label for="floNombre">Hab. matrimonial, doble ó triple</label>
								</div>
							</div>
							<div class="col">
								<div class="form-floating mb-3">
									<input type="number" class="form-control" id="floNombre" placeholder=" " autocomplete="off" v-model="tour.peruanos.kids">
									<label for="floNombre">Hab. simple (1 persona por habitación)</label>
								</div>
							</div>
						</div>
						<p class="mb-0">Precio para Extranjeros:</p>
						<div class="row ">
							<div class="col-12">
								<div class="form-floating mb-3">
									<input type="number" class="form-control" id="floNombre" placeholder=" " autocomplete="off" v-model="tour.extranjeros.adultos">
									<label for="floNombre">Hab. matrimonial, doble ó triple</label>
								</div>
							</div>
							<div class="col">
								<div class="form-floating mb-3">
									<input type="number" class="form-control" id="floNombre" placeholder=" " autocomplete="off" v-model="tour.extranjeros.kids">
									<label for="floNombre">Hab. simple (1 persona por habitación)</label>
								</div>
							</div>
						</div>
						<div class="form-floating mb-3">
							<input type="number" class="form-control" id="floCupos" placeholder=" " max="250" min="1" autocomplete="off" v-model="tour.cupos">
							<label for="floCupos">Cupos disponibles</label>
						</div>
						
						<div class="row">
							<div class="col">
								<div class="form-floating mb-3">
									<select class="form-select" id="floatingSelect" aria-label="Floating label select example" v-model="tour.duracion.dias">
										<option v-for="dia in duracion" :value="dia.clave">{{dia.valor}}</option>
									</select>
									<label for="floatingSelect">Días</label>
								</div>
							</div>
							<div class="col">
								<div class="form-floating mb-3">
								<select class="form-select" id="floatingSelect" aria-label="Floating label select example" v-model="tour.duracion.noches">
										<option v-for="noche in duracionNoches" :value="noche.clave">{{noche.valor}}</option>
									</select>
									<label for="floatingSelect">Noches</label>
								</div>
							</div>
						</div>
						<div class="form-floating mb-3">
							<input type="time" class="form-control" id="floHora" placeholder=" " autocomplete="off" value="14:15" v-model="tour.hora">
							<label for="floHora">Hora de inicio</label>
						</div>
						<p class="mb-0">Reglas de compra</p>
						<div class="row">
							<div class="col">
								<div class="form-floating mb-3">
									<select class="form-select" id="floatingSelect" aria-label="Floating label select example" v-model="tour.anticipacion">
										<option v-for="dia in anticipacion" :value="dia.clave">{{dia.valor}}</option>
									</select>
									<label for="floatingSelect">Anticipación</label>
								</div>
							</div>
							<div class="col">
								<div class="form-floating mb-3">
									<input type="number" class="form-control" id="floCupos" placeholder=" " max="250" min="1" autocomplete="off" value="1" v-model="tour.minimo">
									<label for="floCupos">Mínimo viajeros</label>
								</div>
							</div>
						</div>
						<div class="form-floating mb-3">
							<select class="form-select" id="floatingSelect" aria-label="Floating label select example" v-model="tour.transporte">
								<option value="3">Ninguno</option>
								<option value="2">Aéreo</option>
								<option value="1">Terrestre</option>
							</select>
							<label for="floatingSelect">Tipo de transporte</label>
						</div>
						<div class="form-floating mb-3">
							<select class="form-select" id="floatingSelect" aria-label="Floating label select example" v-model="tour.alojamiento">
								<option value="1">Albergue</option>
								<option value="2">Apartment</option>
								<option value="3">Bungalow</option>
								<option value="4">Hostal *</option>
								<option value="5">Hostal **</option>
								<option value="6">Hostal ***</option>
								<option value="7">Hotel *</option>
								<option value="8">Hotel **</option>
								<option value="9">Hotel ***</option>
								<option value="10">Hotel ****</option>
								<option value="11">Hotel *****</option>
								<option value="12">Lodge</option>
								<option value="13">Resort</option>
								<option value="14">Otro</option>
							</select>
							<label for="floatingSelect">Tipo de alojamiento</label>
						</div>
						<div class="row">
							<div class="col">
								<div class="form-floating mb-3">
									<input type="text" class="form-control" id="floDestino" placeholder=" " max="250" min="1" autocomplete="off" v-model="tour.destino">
									<label for="floDestino">Ciudad <em style="font-size: 0.7rem">Ejm: Laguna de Paca</em></label>
								</div>

							</div>
							<div class="col">
								<div class="form-floating mb-3">
								<select class="form-select" id="floatingSelect" aria-label="Floating label select example" v-model="tour.departamento">
									<option v-for="(depa, index) in departamentos" :value="index">{{depa}}</option>
								</select>
								<label for="floatingSelect">Departamento</label>
							</div>
							</div>
						</div>
						<!-- <div class="form-floating mb-3">
							<input type="text" class="form-control" id="floDestino" placeholder=" " autocomplete="off" v-model="tour.actividad">
							<label for="floDestino">Actividades</label>
						</div> -->
						<div class=" mb-3">
							<label for="floDestino">Actividades</label>
							<div class="sltPicker">
								<select class="selectpicker" id="sltActividad2" data-live-search="true" multiple data-max-options="3">
									<option v-for="nActividad in actividades2" :key="nActividad.id" :value="nActividad.id">{{nActividad.concepto}}</option>
								</select>
							</div>
						</div>
						<!-- <div class="form-floating mb-3">
							<input type="text" class="form-control" id="floDestino" placeholder=" "autocomplete="off" v-model="tour.categoria">
							<label for="floDestino">Categoría</label>
						</div> -->
						<div class=" mb-3">
							<label for="floDestino">Categorías</label>
							<div class="sltPicker">
								<select class="selectpicker" id="sltCategoria2" data-live-search="true" multiple data-max-options="3">
									<option v-for="nCategoria in categorias2" :key="nCategoria.id" :value="nCategoria.id">{{nCategoria.concepto}}</option>
								</select>
							</div>
						</div>
							<!-- Create the editor container -->
							<p class="mb-0 mt-2">Descripción</p>
						<div class="editor" id="qDescripcion" ></div>
						<p class="mb-0 mt-2">Punto de partida</p>
						<div class="editor" id="qPartida"></div>
						<p class="mb-0 mt-2">Itinerario</p>
						<div class="editor" id="qItinerario"></div>
						
						<div class="form-floating mt-3">
							<textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px" v-model="tour.incluye"></textarea>
							<label for="floatingTextarea2">Incluye <em style="font-size: 0.7rem">(1 item por línea)</em></label>
						</div>
						<div class="form-floating mt-3">
							<textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px" v-model="tour.noIncluye"></textarea>
							<label for="floatingTextarea2">No incluye <em style="font-size: 0.7rem">(1 item por línea)</em></label>
						</div>
						<p class="mb-0 mt-2">Notas</p>
						<div class="editor" id="qNotas"></div>
						<div class="editor" id="qNotas"></div>
						<p class="mb-0 mt-2">Opciones</p>
						<div class="form-check">
							<input class="form-check-input" type="checkbox" value="" id="chkAlimentacion" v-model="tour.alimentacion">
							<label class="form-check-label" for="chkAlimentacion"> Alimentación</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="checkbox" value="" id="flexGuia"  v-model="tour.guia">
							<label class="form-check-label" for="flexGuia"> Guía </label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="checkbox" value="" id="flexTickets"  v-model="tour.tickets">
							<label class="form-check-label" for="flexTickets"> Tickets </label>
						</div>
					</div>
					<div class="modal-footer">
						<button v-if="!activarEditar" type="button" @click="guardarTour()" class="btn btn-outline-primary"><i class="icofont-save"></i> Guardar anuncio</button>
						<button v-else type="button" @click="actualizarTour()" class="btn btn-outline-primary"><i class="icofont-save"></i> Actualizar anuncio</button>
					</div>
				</div>
			</div>
		</div>

		<div class="position-relative">
			<div class="toast-container position-absolute bottom-0 end-0 p-3 me-4">
				<div class="toast align-items-center text-white bg-success border-0" id="tostadaOk" role="alert" aria-live="assertive" aria-atomic="true">
					<div class="d-flex">
						<div class="toast-body"> <i class="icofont-check"></i>
							{{mensajeBien}}
						</div>
						<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
					</div>
				</div>
				<div class="toast align-items-center text-white bg-danger border-0" id="tostadaMal" role="alert" aria-live="assertive" aria-atomic="true">
					<div class="d-flex">
						<div class="toast-body"> <i class="icofont-close-circled"></i>
							{{mensajeMal}}
						</div>
						<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
					</div>
				</div>
			</div>
		</div>

		<div class="offcanvas offcanvas-end" tabindex="-1" id="offPanel" aria-labelledby="offcanvasExampleLabel">
			<div class="offcanvas-header">
				<h5 class="offcanvas-title text-capitalize" id="offcanvasExampleLabel">{{tourActivo.nombre}}</h5>
				<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
			</div>
			<div class="offcanvas-body">
				<div class="contenido"  v-if="indexGlobal!=-1">
					<div class="form-check form-switch">
						<input class="form-check-input" type="checkbox" role="switch" id="chkVisible" @click="hacerVisible($event)" :checked="esVisible(indexGlobal)=='1'? 'checked':''">
						<label v-if="esVisible(indexGlobal)=='1'" class="form-check-label text-primary" for="chkVisible"><i class="icofont-eye-alt"></i> Es visible</label>
						<label v-else class="form-check-label " for="chkVisible"><i class="icofont-eye-blocked"></i> No está publicado</label>
					</div>
					<div class="row col d-grid gap-2 col-6 mx-auto">
						<button type="button" class="btn btn-outline-dark" @click="abrirEdicion()"><i class="icofont-pen-alt-4"></i> Actualizar datos</button>
					</div>
					<p class="my-1"><strong>Oferta:</strong> <span>S/ {{formatoMoneda(tourActivo.oferta)}}</span> </p>
					<p class="my-1"><strong>Precio Peruanos</strong></p>
					<p class="my-1"><strong>Adultos:</strong> <span>S/ {{formatoMoneda(tourActivo.peruanos.adultos)}}</span> </p>
					<p class="my-1"><strong> Niños:</strong> <span>S/ {{formatoMoneda(tourActivo.peruanos.kids)}}</span> </p>
					<p class="my-1 mt-3"><strong>Precio Peruanos</strong></p>
					<p class="my-1"><strong>Adultos:</strong> <span>S/ {{formatoMoneda(tourActivo.extranjeros.adultos)}}</span> </p>
					<p class="my-1"><strong> Niños:</strong> <span>S/ {{formatoMoneda(tourActivo.extranjeros.kids)}}</span> </p>
					<p class="my-1 mt-3"><strong>Duración:</strong> <span>{{queDuraDia(tourActivo.duracion.dias)}} / {{queDuraNoche(tourActivo.duracion.noches)}}</span></p>
					<p class="my-1 mt-3"><strong>1° Hora de inicio:</strong> <span>{{horaLatam(tourActivo.hora)}}</span></p>
					<p class="my-1 mt-3"><strong>Reglas de compra:</strong> </p>
					<p class="my-1 mt-3"><strong>Tiempo de anticipación:</strong> <span>{{queAnticipa(tourActivo.anticipacion)}}</span></p>
					<p class="my-1 mt-3"><strong>Cantidad min. de viajeros:</strong> <span>{{tourActivo.minimo}}</span></p>
					<p class="my-1 mt-3"><strong>Destino:</strong> <span class="text-capitalize">{{tourActivo.destino}} - {{queDepa(tourActivo.departamento)}}</span></p>
					<p class="my-1 mt-3"><strong>Actividades:</strong> <span>{{tourActivo.actividad}} {{variasActividades()}}</span></p>
					<p class="my-1 mt-3"><strong>Categorías:</strong> <span>{{variasCategorias()}}</span></p>
					<p class="my-1 mt-3"><strong>Descripción:</strong> <br> </p>
					<div class="w-100 text-break" v-html="tourActivo.descripcion"></div>
					<p class="my-1"><strong>Punto de partida:</strong> <br> </p>
					<div class="w-100 text-break" v-html="tourActivo.partida"></div>
					<p class="my-1"><strong>Itinerario:</strong> <br> </p>
					<div class="w-100 text-break" v-html="tourActivo.itinerario"></div>
					<p class="my-1"><strong>Incluye:</strong></p>
					<p class="ms-2" v-for="cadena in tourActivo.incluye.split('\n')"><i class="icofont-check-alt"></i> {{cadena}}</p>
					<p class="my-1 mt-3"><strong>No incluye:</strong></p>
					<p class="ms-2" v-for="cadena in tourActivo.noIncluye.split('\n')"><i class="icofont-close-line"></i> {{cadena}}</p>
					<p class="my-1"><strong>Notas:</strong> <br> </p>
					<div class="w-100 text-break" v-html="tourActivo.notas"></div>
					
					<div>
						<p></p>
					</div>
					<button type="button" @click="eliminar()" class="btn btn-danger mt-3"><i class="icofont-ui-delete"></i> Eliminar paquete</button>
					<div class="row my-2">
						<div class="col" v-if="tourActivo.fotos.length<16">
							<p class="mb-0">Subir imágen:</p>
							<div class="input-group mb-3">
								<input type="file" class="form-control" ref="archivoFile" id="txtArchivo" accept="image/*">
								<button class="btn btn-outline-secondary" type="button" id="btnSubirArchivo" @click="subirANube()"><i class="icofont-upload-alt"></i></button>
							</div>
						</div>
						<div class="col" v-else>
							<p class="text-danger"><i class="icofont-gear-alt"></i> Se alcanzó el máximo de fotos</p>
						</div>
					</div>
					<p class="my-1 mt-3"><strong>Fotografías</strong></p>
					<div class="row row-cols-2" id="divFotografias">
						<div class="col" v-for="(imagen, indice) in tourActivo.fotos">
							<div class="card mb-3" >
								<img :src="'images/subidas/'+imagen.nombreRuta" class="card-img-top" alt="...">
								<ul class="list-group list-group-flush">
									<li class="list-group-item">
									<div class="form-check">
										<input class="form-check-input" type="radio" name="flexRadios" :id="'flexRadioDefault'+indice" @change="fotoPrincipal(indice);">
										<label class="form-check-label" :for="'flexRadioDefault'+indice"  @change="fotoPrincipal(indice);">
											<span class="text-primary" v-if="queIndice==indice">Img. Principal</span>
											<span v-else>Img. Secundaria</span>
										</label>
									</div>
									</li>
								</ul>
								<div class="card-body py-1 ps-3">
									<a href="#!" class="card-link text-danger text-decoration-none" @click="borrarFoto(indice)"><i class="icofont-close"></i> Borrar</a>
								</div>
							</div>
						</div>
					</div>
					<!-- <div class="my-1" v-for="imagen in tourActivo.fotos">
						<img :src="'images/subidas/'+imagen.nombreRuta" class="img-fluid img-thumbnail border-0" alt="">
					</div> -->

				</div>
			</div>
		</div>
		
		<div class="offcanvas offcanvas-start" tabindex="-1" id="offFechas" aria-labelledby="offFechasLabel">
			<div class="offcanvas-header">
				<h5 class="offcanvas-title" id="offFechasLabel">Offcanvas</h5>
				<button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
			</div>
			<div class="offcanvas-body">
				<div>
					Ingrese las fechas para anular

					<div class="input-group mb-3">
						<input type="date" class="form-control" v-model="fechaSeleccionada" @keyup.enter="vetarFecha()">
						<button class="btn btn-outline-secondary" type="button" id="button-addon2" @click="vetarFecha()"><i class="icofont-simple-right"></i> Agregar</button>
					</div>
				</div>
				<p>Fechas anuladas:</p>
				<ol class="list-group list-group-numbered">
					<li class="list-group-item d-flex justify-content-between align-items-start" v-for="(fecha, indice) in tourActivo.fechas">
						<div class="ms-2 me-auto"> <span>Fecha: {{fecha.fecha}}</span> </div>
						<span class="badge bg-danger rounded-pill" @click="eliminarFecha(indice)"><i class="icofont-close"></i></span>
					</li>
				</ol>
			</div>
		</div>

	</div>

	<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
	
	
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
	<script src="js/quill.min.js"></script>
	<script src="js/axios.min.js"></script>
	<script src="js/moment.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
	<script>
	var modalNuevo, modalNuevoPack, qDescripcion, qPartida, qItinerario, qNotas, offPanel,
	tostadaOk, tostadaMal;
	//var rutaDocs = 'C:/xampp8/htdocs/euroAndinoApi/subidas/'; 
	var rutaDocs = '/home/perutra1/grupoeuroandino.com/app/render/images/subidas/'
	var app = new Vue({
		el: '#app',
		data: {
			//servidor: 'http://localhost/euroAndinoApi/',
			servidor: 'https://grupoeuroandino.com/app/api/', fechasAnuladas:[], fechaSeleccionada:moment().format('YYYY-MM-DD'),
			tour:{
				nombre: '', url:'',
				peruanos:{ adultos: 0, kids: 0 },
				extranjeros:{ adultos:0, kids:0 },
				cupos: 1, duracion: {dias:1, noches:1}, hora: "12:00",
				anticipacion: 1, minimo: 1, transporte:3, alojamiento: 1,
				destino: '', departamento: '', actividad:'', categoria:'',
				descripcion: '', partida: '', itinerario: '', incluye: '', noIncluye:'', notas:'', fotos:[], tipo:2, oferta:0, actividades:[], categorias: []
			},
			mensajeBien:'Guardado correctamente', mensajeMal:'Hubo un error al conectar',
			variosTours:[], todosTours:[], idGlobal:-1, indexGlobal:-1, tourActivo:[],
			duracion: [{clave: 1, valor: 'Half Day (Medio día)'}, {clave: 2, valor: 'Full Day (1 día)'} ], duracionNoches:[{clave: 1, valor:'0 noches'}, {clave: 2, valor:'1 noche'}],
			anticipacion: [{clave: 1, valor: '12 horas'}, {clave: 2, valor: '24 horas'} ],
			departamentos:['Amazonas', 'Ancash', 'Apurimac', 'Arequipa', 'Ayacucho', 'Cajamarca', 'Cusco', 'Callao', 'Huancavelica','Huánuco', 'Ica', 'Junín', 'La Libertad', 'Lambayeque', 'Lima', 'Loreto', 'Madre de Dios', 'Moquegua', 'Pasco', 'Piura', 'Puno','San Martín', 'Tacna', 'Tumbes', 'Ucayali' ],
			activarEditar:false, categorias2:[], actividades2:[], queIndice:-1, idDepartamento:-1
		},
		mounted:function(){
			this.verTours();
			this.cargarComplementos();
			modalNuevo = new bootstrap.Modal( document.getElementById('modalNuevo') );
			
			tostadaOk = new bootstrap.Toast( document.getElementById('tostadaOk') );
			tostadaMal = new bootstrap.Toast( document.getElementById('tostadaMal') );
			offPanel = new bootstrap.Offcanvas( document.getElementById('offPanel') );
			
			for (let dia = 2; dia <= 31; dia++) {
				this.duracion.push({ clave: dia+1, valor: dia + ' días' });
				this.duracionNoches.push({ clave: dia+1, valor: dia + ' noches' });
			}
			for (let dia = 2; dia <= 15; dia++) {
				this.anticipacion.push({ clave: dia+1, valor: dia + ' días' });
			}

			var toolbarOptions = [
			  ['bold', 'italic', 'underline', 'strike'],
			  [{ 'list': 'ordered'}, { 'list': 'bullet' }],
				[{ 'header': [3, 4, false] }],
			];

			qDescripcion = new Quill('#qDescripcion', { theme: 'snow', modules: {
		    toolbar: toolbarOptions
		  } });
			qPartida = new Quill('#qPartida', { theme: 'snow', modules: {
		    toolbar: toolbarOptions
		  } });
			qItinerario = new Quill('#qItinerario', { theme: 'snow', modules: {
		    toolbar: toolbarOptions
		  } });
			qNotas = new Quill('#qNotas', { theme: 'snow', modules: {
		    toolbar: toolbarOptions
		  } });
	
			
			
		},
		methods:{
			async vetarFecha(){
				if(!this.tourActivo.fechas)
					this.tourActivo['fechas']=[]
				this.tourActivo.fechas.push({fecha: this.fechaSeleccionada})
				this.actualizarTour(this.tourActivo);
			},
			eliminarFecha(indice){
				this.tourActivo.fechas.splice(indice, 1)
				this.actualizarTour(this.tourActivo)
			},
			async cargarComplementos(){
				let servComplementos  = await fetch(this.servidor+'pedirComplementos.php',{
					method:'POST'
				})
				/* .done()
				.done(letra =>{
					console.log( letra );
				}); */
				let resServidor = await servComplementos
				 resServidor.json().then((queVino)=>{
					this.actividades2  = queVino[0];
					this.categorias2  = queVino[1];
					
					//Obtener el valor de lo seleccionado
					//$('#sltActividad2').selectpicker('val');
					//asignar valor
					//$('#sltActividad2').selectpicker('val', ['51', '53']);
					
				}).then(()=>{
					$('#sltActividad2').selectpicker('refresh');
					$('#sltCategoria2').selectpicker('refresh');
				})
			},
			nuevoTourSimple(){
				this.tour={
					nombre: '', url:'',
					peruanos:{ adultos: 0, kids: 0 },
					extranjeros:{ adultos:0, kids:0 },
					cupos: 1, duracion: {dias:1, noches:1}, hora: "12:00",
					anticipacion: 1, minimo: 1, transporte:3, alojamiento: 1,
					destino: '', departamento: '', actividad:'', categoria:'',
					descripcion: '', partida: '', itinerario: '', incluye: '', noIncluye:'', notas:'', fotos:[], tipo:2, oferta:0, actividades:[], categorias: []
				}
				this.activarEditar=false;
				$('#sltActividad2').selectpicker('val', '');
				//$('#sltActividad2').selectpicker('refresh');
				$('#sltCategoria2').selectpicker('val', '');
				//$('#sltCategoria2').selectpicker('refresh');
				modalNuevo.show();
			},
			extraerHtml(){
				this.tour.descripcion = qDescripcion.root.innerHTML.trim();
				this.tour.partida = qPartida.root.innerHTML.trim();
				this.tour.itinerario = qItinerario.root.innerHTML.trim();
				this.tour.notas = qNotas.root.innerHTML.trim();
				if($('#sltActividad2').selectpicker('val') !=null){
					this.tour.actividades = $('#sltActividad2').selectpicker('val');
				}else{
					this.tour.actividades = [];
				}
				if($('#sltCategoria2').selectpicker('val') !=null){
					this.tour.categorias = $('#sltCategoria2').selectpicker('val');
				}else{
					this.tour.categorias = [];
				}
			},
			guardarTour(){
				this.extraerHtml();
				console.log( this.tour );

				axios.post(this.servidor+'guardarPaquete.php', { tour: this.tour, actividad: this.tour.actividad, categoria: this.tour.categoria })
				.then((response)=>{ //console.log( response.data );
					if(response.data =='ok'){
						this.verTours();
						modalNuevo.hide();
						tostadaOk.show();

					}
				})
				.catch((error)=>{ console.log( error );});
				
				
			},
			async verTours(){
				var that = this;
				this.todosTours=[];
				this.variosTours=[];
			
				let respuesta = await axios.get(this.servidor+'verPaquetes.php');
				respuesta.data.forEach(dato=>{
					that.todosTours.push(dato)
					that.variosTours.push(JSON.parse(dato.contenido));
				})
				
				//console.log( that.variosTours );
			},
			obtenerHTML(){
				//Getting el contenido en HTML para la DB
				//Para coger de uno solo llamar al ID
				console.log( qDescripcion.root.innerHTML.trim() );
			},
			setearHTML(){
				//Seteando un HTML al editor				
				qDescripcion.setContents([])
		    qDescripcion.clipboard.dangerouslyPasteHTML(0, '<p>Hola <em><u> mundo!</u></em></p><p>Texto simple</p>');
			},
			esVisible(index){
				return this.todosTours[index].visible;
			},
			queId(index){
				return this.todosTours[index].id;
			},
			cargarPanel(queEs, indexEs){
				$('#sltActividad2').selectpicker('val', '');
				$('#sltCategoria2').selectpicker('val', '');
				this.idGlobal = queEs;
				this.indexGlobal = indexEs;
				this.tourActivo = this.variosTours[indexEs];
				this.queIndice=0;
				offPanel.show();
				
				
			},
			subirANube(){
				var that = this; let nombreSubida='';
				this.archivo = this.$refs.archivoFile.files[0];
				if(document.getElementById("txtArchivo").files.length>0){
					let formData = new FormData();
					formData.append('archivo', this.archivo);
					formData.append('ruta', rutaDocs);
					
					axios.post(this.servidor+'/subidaAdjunto.php', formData, {
						headers: {
							'Content-Type' : 'multipart/form-data'
						}
					}).then( function (response){
						console.log( response.data );
						if( response.data =='Error subida' ){
							nombreSubida='';
							console.log( 'err1' );
						}else{ //subió bien
							console.log( 'subio bien al indice ' + that.indexGlobal  );
							
							that.tourActivo.fotos.push({
								'nombreRuta': response.data
							});
							
							that.actualizarTour(that.tourActivo);
							/* if(that.tourActivo==1){
							} */
						} 

					}).catch(function(ero){
						console.log( 'err2' + ero );
						//that.$emit('mostrarToastMal', 'Error subiendo el archivo adjunto'); return false;
					})
				}

			},
			actualizarTour(queTour){
				this.extraerHtml();
				if(queTour==null){ queTour = this.tourActivo }
				axios.post(this.servidor+'actualizarTours.php', { id: this.idGlobal, tour: queTour, actividad: this.tour.actividad, categoria: this.tour.categoria })
				.then((response)=>{ console.log( response.data );
					if(response.data =='ok'){
						modalNuevo.hide();
						this.mensajeBien = "Se actualizó correctamente";
						tostadaOk.show();
						this.verTours();
					}
				})
				.catch((error)=>{ console.log( error );});
			},
			eliminar(){
				if(confirm('¿Realmente desea eliminar el paquete?')){
					axios.post(this.servidor+'eliminarTour.php', { id: this.idGlobal })
						.then((response)=>{ console.log( response.data );
							if(response.data =='ok'){
								this.mensajeBien = "Se actualizó correctamente";
								offPanel.hide();
								tostadaOk.show();
								this.verTours();
							}
						})
						.catch((error)=>{ console.log( error );});
				}
			},
			variasActividades(){
				if(this.tourActivo.actividades.length>0){
					var actividades = "";
					this.tourActivo.actividades.forEach(actividad =>{
						actividades += " "+this.actividades2.find(x=> x.id === actividad ).concepto+",";
					});
					return actividades.substring(0, actividades.length-1)
				}
			},
			variasCategorias(){
				if(this.tourActivo.categorias.length>0){
					var categorias = "";
					this.tourActivo.categorias.forEach(actividad =>{
						categorias += " "+this.categorias2.find(x=> x.id === actividad ).concepto+",";
					});
					return categorias.substring(0, categorias.length-1)
				}
			},
			formatoMoneda(valor){
				return parseFloat(valor).toFixed(2)
			},
			queDuraDia(duracion){
				//return this.duracion[duracion].valor;
				return this.duracion.find( x => x.clave === duracion ).valor;
			},
			queDuraNoche(duracion){ 
				//return this.duracionNoches[duracion].valor; 
				return this.duracionNoches.find( x => x.clave === duracion ).valor
			},
			horaLatam(hora){
				return( moment(hora, 'HH:mm').format('h:mm a') )
			},
			queAnticipa(valor){
				return this.anticipacion[valor].valor;
			},
			queDepa(valor){
				return this.departamentos[valor];
			},
			async hacerVisible(e){
				let response = await axios.post(this.servidor + 'hacerVisible.php', {id: this.idGlobal, visible: e.target.checked});
				
				let indexJuego = this.todosTours.map( tour => tour.id ).indexOf(this.idGlobal);
				//console.log( indexJuego );
				this.todosTours[indexJuego].visible=e.target.checked;
				this.todosTours[indexJuego].visible=e.target.checked;

			},
			abrirEdicion(){
				this.activarEditar=true;
				this.tour = this.tourActivo;
				$('#sltActividad2').selectpicker('val', this.tour.actividades);
				$('#sltCategoria2').selectpicker('val', this.tour.categorias);
				qDescripcion.setContents([]); qDescripcion.clipboard.dangerouslyPasteHTML(0, this.tour.descripcion);
				qPartida.setContents([]); qPartida.clipboard.dangerouslyPasteHTML(0, this.tour.partida);
				qItinerario.setContents([]); qItinerario.clipboard.dangerouslyPasteHTML(0, this.tour.itinerario);
				qNotas.setContents([]); qNotas.clipboard.dangerouslyPasteHTML(0, this.tour.notas);
				
				offPanel.hide();
				modalNuevo.show();
			},
			async buscarProducto(){
				//console.log( this.$refs.txtFiltro.value );
				var that = this;
				let respuesta = await axios.post(this.servidor+'buscarTour.php', {
					texto: this.$refs.txtFiltro.value,
					tipo: 2,
					departamento: this.idDepartamento
				})
				this.todosTours=[];
				this.variosTours=[];
				
				respuesta.data.forEach(dato=>{
					that.todosTours.push(dato)
					that.variosTours.push(JSON.parse(dato.contenido));
				});
			},
			async fotoPrincipal(queIndice){
				let copia = [...this.tourActivo.fotos];
				//console.log( 'copia' ); console.log( [...copia] );
				let principal = copia[queIndice];
				//console.log('que agrego'); console.log([principal])
				copia.splice(queIndice, 1)
				copia.unshift(principal);
				//console.log( 'nuevo' ); console.log( [...copia] );
				this.tourActivo.fotos = [...copia];
				this.actualizarTour();
				document.getElementById(`flexRadioDefault${queIndice}`).checked=false;
				document.getElementById(`flexRadioDefault0`).checked=true;
				this.queIndice=0;
				/* let datos = new FormData();
				datos.append('id', this.idGlobal)
				datos.append('fotos', JSON.stringify(copia));
				let respServ = await fetch(this.servidor+ 'actualizarFotos.php',{
					method:'POST', body: datos
				});
				console.log( await respServ.text() ); */
			},
			async borrarFoto(queIndice){
				if(confirm('¿Desea borrar la foto?')){
					let datos = new FormData();
					let copia = [...this.tourActivo.fotos];
					let nomArchivo = this.tourActivo.fotos[queIndice].nombreRuta;
					let borrar = copia[queIndice];
					this.tourActivo.fotos.splice(queIndice, 1)
	
					datos.append('foto', nomArchivo);
					let respServ = await fetch(this.servidor+'borrarFoto.php', {
						method:'POST', body:datos
					})
					if( await respServ.text()=='ok'){
						this.actualizarTour()
					}
				}
			},
			crearURL(){
				let url = this.tour.nombre.toLowerCase();
				url = url.replace(/\s+/g, ' ').trim() //Quita todos los espacios repetidos
				url = url.replace(/-/g, '');
				url = url.replace(/ /g, '-');
				url = url.replace(/á/g, 'a');
				url = url.replace(/é/g, 'e');
				url = url.replace(/í/g, 'i');
				url = url.replace(/ó/g, 'o');
				url = url.replace(/ú/g, 'u');
				url = url.replace(/ñ/g, 'n');
				url = url.replace(/:/g, '');
				url = url.replace(/\//g, '');
				url = url.replace(/\\/g, '');
				url = url.replace(/--/g, '-');

				this.tour.url = url;
			}
		}
	});
	
</script>
</body>
</html>