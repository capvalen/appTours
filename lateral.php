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

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
	<link rel="stylesheet" href="icofont/icofont.min.css">
	<link rel="stylesheet" href="css/bootstrap-datepicker.min.css">
	<link rel="stylesheet" href="css/quill.bubble.css">
	<link rel="stylesheet" href="css/quill.snow.css">
</head>
<body>
	<style>
		.bg-success {background-color: #00b749!important;}
		.toast-container{z-index: 1046;}
		tr{cursor: pointer;}
		p{margin-bottom: 0;}
	</style>
	<?php include "nav.php";?>

	<div class="container" id="app">

		<h2 class="mt-2">Configuraciones</h2>

		<ul class="nav nav-tabs" id="myTab" role="tablist">
			<li class="nav-item" role="presentation">
				<button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#lateral" type="button" role="tab" aria-controls="lateral" aria-selected="true">Panel lateral</button>
			</li>
			<li class="nav-item" role="presentation">
				<button class="nav-link" id="actividades-tab" data-bs-toggle="tab" data-bs-target="#actividades" type="button" role="tab" aria-controls="actividades" aria-selected="false">Actividades</button>
			</li>
			<li class="nav-item" role="presentation">
				<button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#categorias" type="button" role="tab" aria-controls="categorias" aria-selected="false">Categorías</button>
			</li>
			<li class="nav-item" role="presentation">
				<button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#hospedajes" type="button" role="tab" aria-controls="hospedajes" aria-selected="false">Alojamientos</button>
			</li>
			<li class="nav-item" role="presentation">
				<button class="nav-link" id="sitemap-tab" data-bs-toggle="tab" data-bs-target="#sitemap" type="button" role="tab" aria-controls="sitemap" aria-selected="false">Sitemap Google</button>
			</li>			
			<li class="nav-item" role="presentation">
				<button class="nav-link" id="promos-tab" data-bs-toggle="tab" data-bs-target="#promos" type="button" role="tab" aria-controls="promos" aria-selected="false">Promociones</button>
			</li>			
		</ul>
		<div class="tab-content" id="myTabContent">
			<div class="tab-pane fade show active p-3" id="lateral" role="tabpanel" aria-labelledby="lateral-tab">
				<div class="row ">
					<div class="col-6">
						<div class="card">
							<div class="card-body">
								<h5>Valores de comisiones</h5>
									<label for="">Precio actual del dolar (S/)</label>
									<input type="number" value="4.5" class="form-control" id="txtDolar">
									<label for="">Porcentaje de comisión (%)</label>
									<input type="number" value="4.5" class="form-control" id="txtComision">
									<button class="btn btn-outline-primary mt-2" onclick="actualizarComisiones()"><i class="icofont-refresh"></i> Actualizar campos</button>
							</div>
						</div>

						<div class="card my-3">
							<div class="card-body">
								<h5>Sección inferior de cada tour/paquete</h5>
								<button class="btn btn-outline-primary my-3" onclick="actualizarBajo()"><i class="icofont-refresh"></i> Actualizar sección inferior</button>
								<div id="editorBajo"></div>
							</div>
						</div>
					</div>
					<div class="col-6">
						<div class="card">
							<div class="card-body">
								<h5>Panel lateral de la web</h5>
								<button class="btn btn-outline-primary my-3" onclick="actualizarPanel()"><i class="icofont-refresh"></i> Actualizar lateral</button>
								<div id="editor"> </div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="tab-pane fade" id="actividades" role="tabpanel" aria-labelledby="actividades-tab">
				<div class="container">
					<button class="btn btn-outline-primary mt-2" @click="crearActividad"><i class="icofont-diamond"></i> Nueva actividad</button>
					<table class="table table-hover">
						<thead>
							<tr>
								<th>N°</th>
								<th>Actividad</th>
								<th>@</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(actividad, indice) in actividades" :key="actividad.id">
								<td>{{indice+1}}</td>
								<td>{{actividad.concepto}}</td>
								<td><button type="button" class="btn btn-sm btn-outline-success mx-1" @click="editarActividad(indice)"><i class="icofont-edit"></i></button>
								<button type="button" class="btn btn-sm btn-outline-danger mx-1" @click="eliminarActividad(indice)"><i class="icofont-ui-delete"></i></button></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>

			<div class="tab-pane fade" id="categorias" role="tabpanel" aria-labelledby="categorias-tab">
			<div class="container">
				<button class="btn btn-outline-primary mt-2" @click="crearCategoria"><i class="icofont-diamond"></i> Nueva categoría</button>
					<table class="table table-hover">
						<thead>
							<tr>
								<th>N°</th>
								<th>Categoría</th>
								<th>@</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(categoria, indice) in categorias" :key="categoria.id">
								<td>{{indice+1}}</td>
								<td>{{categoria.concepto}}</td>
								<td><button type="button" class="btn btn-sm btn-outline-success mx-1" @click="editarCategoria(indice)"><i class="icofont-edit"></i></button>
								<button type="button" class="btn btn-sm btn-outline-danger mx-1" @click="eliminarCategoria(indice)"><i class="icofont-ui-delete"></i></button></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>

			<div class="tab-pane" id="hospedajes" role="tabpanel" aria-labelledby="hospedajes-tab">
				<button class="btn btn-outline-primary mt-2" @click="crearHospedaje"><i class="icofont-diamond"></i> Nuevo alojamiento</button>
				<table class="table table-hover">
						<thead>
							<tr>
								<th>N°</th>
								<th>Hospedaje</th>
								<th>@</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(hospedaje, indice) in hospedajes" :key="hospedaje.id">
								<td>{{indice+1}}</td>
								<td>{{hospedaje.alojamiento}}</td>
								<td>
								<button type="button" class="btn btn-sm btn-outline-danger mx-1" @click="eliminarHospedaje(indice)"><i class="icofont-ui-delete"></i></button></td>
							</tr>
						</tbody>
					</table>
			</div>

			<div class="tab-pane fade" id="sitemap" role="tabpanel" aria-labelledby="sitemap-tab">
				<p>Para actualizar el sitemap de productos personalizados, haga click en el botón de abajo:</p>
				<button class="btn btn-outline-primary" @click="enviarSitemap()">Enviar Sitemap XML</button>
			</div>
			<div class="tab-pane fade" id="promos" role="tabpanel" aria-labelledby="promos-tab">
				<div class="container-fluid py-4 px-4">
				<div class="row g-4">
					<!-- Columna 1: Formulario -->
					<div class="col-lg-4 col-md-5">
						<div class="card h-100">
							<div class="card-header"><i class="bi bi-plus-circle me-2"></i>Nuevo Descuento</div>
							<div class="card-body p-4">
								<form id="descuentoForm" onsubmit="return agregarDescuento(event)" novalidate>
									<!-- Nombre del descuento -->
									<div class="mb-3">
										<label for="nombreDescuento" class="form-label">
											<i class="bi bi-tag me-1"></i>Nombre del Descuento
										</label>
										<input type="text" class="form-control" id="nombreDescuento" placeholder="Ej: Descuento de Verano" required>
										<div class="invalid-feedback">Por favor ingresa un nombre válido.</div>
									</div>

									<!-- Tipo de descuento -->
									<div class="mb-3">
										<label for="tipoDescuento" class="form-label">
											<i class="bi bi-list-check me-1"></i>Tipo de Descuento
										</label>
										<select class="form-select" id="tipoDescuento" required>
											<option value="" selected disabled>Selecciona el tipo...</option>
											<option value="combo">Combo</option>
											<option value="porcentaje">Porcentaje (%)</option>
											<option value="monto">Monto Fijo (S/)</option>
										</select>
										<div class="invalid-feedback">Por favor selecciona un tipo.</div>
									</div>

									<!-- Valor del descuento -->
									<div class="mb-3">
										<label for="valorDescuento" class="form-label">
											<i class="bi bi-cash-coin me-1"></i>Valor del Descuento
										</label>
										<div class="input-group">
												<input type="number" class="form-control valor-input" id="valorDescuento" placeholder="0.00" min="0" step="1" required>
												<span class="input-group-text" id="simboloTipo">%</span>
										</div>
										<div class="invalid-feedback">Por favor ingresa un valor válido mayor a 0.</div>
									</div>

									<!-- Fecha de inicio -->
									<div class="mb-3">
										<label for="fechaInicio" class="form-label">
											<i class="bi bi-calendar-event me-1"></i>Fecha de Inicio
										</label>
										<input type="date" class="form-control" id="fechaInicio" required>
										<div class="invalid-feedback">Por favor selecciona una fecha de inicio.</div>
									</div>

									<!-- Fecha de fin -->
									<div class="mb-3">
										<label for="fechaFin" class="form-label">
											<i class="bi bi-calendar-check me-1"></i>Fecha de Fin
										</label>
										<input type="date" class="form-control" id="fechaFin" required>
										<div class="invalid-feedback">La fecha de fin debe ser posterior a la de inicio.</div>
									</div>

									<!-- Botón submit -->
									<div class="d-grid">
										<button type="submit" class="btn btn-primary">
											<i class="bi bi-plus-lg me-2"></i>Agregar Descuento
										</button>
									</div>
								</form>
							</div>
						</div>
					</div>

					<!-- Columna 2: Tabla -->
					<div class="col-lg-8 col-md-7">
						<div class="table-container h-100">
							<div class="card-header d-flex justify-content-between align-items-center">
								<span><i class="bi bi-table me-2"></i>Descuentos Registrados</span>
								<span class="badge bg-white text-primary" id="contadorDescuentos">0 registros</span>
							</div>
							<div class="table-responsive">
								<table class="table table-hover mb-0" id="tablaDescuentos">
									<thead>
										<tr>
											<th>Imagen</th>
											<th>Nombre</th>
											<th>Tipo</th>
											<th>Valor</th>
											<th>Inicio</th>
											<th>Fin</th>
											<th class="text-center">Acciones</th>
										</tr>
									</thead>
									<tbody id="tbodyDescuentos">
										<tr id="emptyRow">
											<td colspan="7" class="empty-state">
												<i class="bi bi-inbox"></i>
												<p class="mb-0">No hay descuentos registrados</p>
												<small>Agrega uno desde el formulario</small>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


		
	</div>

	<script src="https://unpkg.com/vue@3"></script>

	
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
	<script src="./js/quill.min.js"></script>
	
	<script src="js/axios.min.js"></script>
	<script src="js/moment.min.js"></script>
	<script src="./configuracion.js?v=1.0"></script>
	<script>
		var quill, quillBajo, comision, dolar;
		var toolBarOptions = [
			[{ 'header': [false, 2, 3, 4, 5] }],
				//[{ 'size': ['small', false, 'large'] }],
				[{ 'align': [] }],
				['bold', 'italic','underline', 'strike'],
				['link', 'image'],
				[{ list: 'ordered' }, { list: 'bullet' }],
			];
		

		function imageHandler() {
			var range = this.quill.getSelection();
			var value = prompt('¿Cuál es la URL de la imágen?');
			if(value){
					this.quill.insertEmbed(range.index, 'image', value, Quill.sources.USER);
			}
 		}
		async function actualizarPanel(){
			let datos = new FormData();
			datos.append('panel',  quill.root.innerHTML.trim() )
			let respServ = await fetch("https://grupoeuroandino.com/app/api/actualizarPanel.php",{
				method:'POST', body: datos
			});
			if( await respServ.text() =='ok' ){
				alert('Guardado exitoso')
			}else{
				alert('Hubo un error')
			}
		}
		async function actualizarBajo(){
			let datos = new FormData();
			datos.append('contenido',  quillBajo.root.innerHTML.trim() )
			let respServ = await fetch("https://grupoeuroandino.com/app/api/actualizarInferior.php",{
				method:'POST', body: datos
			});
			if( await respServ.text() =='ok' ){
				alert('Guardado exitoso')
			}else{
				alert('Hubo un error')
			}
		}
		async function cargarPanel(){
			let respServ = await fetch("https://grupoeuroandino.com/app/api/cargarPanel.php");
			let serv = await respServ.json();
			document.getElementById('txtDolar').value = serv.dolar
			document.getElementById('txtComision').value = serv.comision
			quill.setContents([]);
			quill.clipboard.dangerouslyPasteHTML(0, serv.lateral);
			quillBajo.clipboard.dangerouslyPasteHTML(0, serv.inferior);
		}
		async function agregarDescuento(e){
		e.preventDefault();
		let form = document.getElementById('descuentoForm');
		if(!form.checkValidity()){ form.classList.add('was-validated'); return false; }

		let tipo = document.getElementById('tipoDescuento').value;
		let valor = document.getElementById('valorDescuento').value;
		if(tipo == 'combo' && !/^\d+x\d+$/i.test(valor)){
			alert('El valor del descuento combo debe tener el formato: (2x1, 3x2)');
			return false;
		}else{
			valor = parseFloat(valor).toFixed(2)
		}

		let descuento = {
			promocion: document.getElementById('nombreDescuento').value,
			tipo: document.getElementById('tipoDescuento').value,
			valor: document.getElementById('valorDescuento').value,
			inicio: document.getElementById('fechaInicio').value,
			fin: document.getElementById('fechaFin').value
		};
		try {
			let resp = await axios.post(window.lugarApi + 'Descuentos.php', {
				pedir: 'crearPromocion',
				descuento: descuento
			});
			if(resp.data == 'ok'){
				alert('Descuento agregado correctamente');
				form.reset();
				form.classList.remove('was-validated');
				listarDescuentos();
			}else{
				alert('Hubo un error al guardar');
			}
		} catch (error) {
			alert('Error de conexión');
		}
		return false;
	}
	async function listarDescuentos(){
		try {
			let resp = await axios.post(window.lugarApi + 'Descuentos.php', {
				pedir: 'listarPromociones'
			});
			let tbody = document.getElementById('tbodyDescuentos');
			let contador = document.getElementById('contadorDescuentos');
			if(resp.data.length > 0){
				tbody.innerHTML = resp.data.map(p => /*html*/
					`<tr>
						<td><img src="${p.imagen || './images/discount.png'}" width="35" height="auto" class="rounded"></td>
						<td>${p.promocion}</td>
						<td>${p.tipo == 'combo' ? '©' : p.tipo == 'porcentaje' ? '%' : 'S/'}</td>
						<td>${p.valor}${p.tipo == 'porcentaje' ? '%' : ''}</td>
						<td>${fechaLatam(p.inicio)}</td>
						<td>${fechaLatam(p.fin)}</td>
						<td class="text-center">
							<button class="btn btn-sm btn-outline-success" title="Adjuntar imágen" onclick="adjuntarFoto(${p.id})" ><i class="icofont-cloud-upload"></i></button>
							<button class="btn btn-sm btn-outline-danger" title="Eliminar descuento" onclick="borrarDescuento(${p.id})"><i class="icofont-ui-delete"></i></button>
						</td>
					</tr>`
				).join('');
				contador.textContent = resp.data.length + ' registros';
			}else{
				tbody.innerHTML = '<tr id="emptyRow"><td colspan="7" class="empty-state"><i class="bi bi-inbox"></i><p class="mb-0">No hay descuentos registrados</p><small>Agrega uno desde el formulario</small></td></tr>';
				contador.textContent = '0 registros';
			}
		} catch (error) {
			console.error(error);
		}
	}
	async function adjuntarFoto(id){
		let url = prompt('¿Cuál es la URL de la imagen?');
		if(url){
			try {
				let resp = await axios.post(window.lugarApi + 'Descuentos.php', {
					pedir: 'adjuntarFoto', id: id, url: url
				});
				if(resp.data == 'ok') listarDescuentos();
			} catch (error) {
				alert('Error de conexión');
			}
		}
	}
	async function adjuntarFoto(id){
		let url = prompt('¿Cuál es la URL de la imagen?');
		if(url){
			try {
				let resp = await axios.post(window.lugarApi + 'Descuentos.php', {
					pedir: 'adjuntarFoto', id: id, url: url
				});
				if(resp.data == 'ok') listarDescuentos();
			} catch (error) {
				alert('Error de conexión');
			}
		}
	}
	async function borrarDescuento(id){
		if(confirm('¿Desea borrar este descuento?')){
			try {
				let resp = await axios.post(window.lugarApi + 'Descuentos.php', {
					pedir: 'borrarPromocion', id: id
				});
				if(resp.data == 'ok') listarDescuentos();
			} catch (error) {
				alert('Error de conexión');
			}
		}
	}
	
	document.addEventListener('DOMContentLoaded', function(){
		document.getElementById('tipoDescuento').addEventListener('change', function(){
			let valorInput = document.getElementById('valorDescuento');
			let simbolo = document.getElementById('simboloTipo');
			if(this.value == 'combo'){
				valorInput.type = 'text';
				valorInput.placeholder = 'Ejm: 2x1';
				valorInput.removeAttribute('min');
				valorInput.removeAttribute('step');
				simbolo.style.display = 'none';
			} else {
				valorInput.type = 'number';
				valorInput.placeholder = '0.00';
				valorInput.min = 0;
				valorInput.step = '0.01';
				simbolo.style.display = '';
				simbolo.textContent = this.value == 'porcentaje' ? '%' : 'S/';
			}
		});
		listarDescuentos();
	});
	function fechaLatam(fecha){
		return( moment(fecha, 'YYYY-MM-DD').format('DD/MM/YYYY') )
	}
	async function actualizarComisiones(){
			console.log('camp')
			let datos = new FormData();
			datos.append('dolar', document.getElementById('txtDolar').value )
			datos.append('comision', document.getElementById('txtComision').value )
			let serv = await fetch('https://grupoeuroandino.com/app/api/actualizarComisiones.php',{
				method:'POST', body: datos
			})
			if( await serv.text() == 'ok'){
				alert('Guardado exitoso')
			}else{
				alert('Hubo un error')
			}
		}

		
	const { createApp } = Vue

	const app = createApp({
		data() {
			return {
				servidor: window.lugarApi, actividades:[], categorias:[],
				nTexto:'', hospedajes:[], idGeneral:-1
			}
		},
		mounted(){
			quill = new Quill('#editor', {
				modules: { 
					toolbar: {
						container : toolBarOptions,
						handlers:{
							image: imageHandler
						}
					}
				},
				theme: 'snow'
			});
			quillBajo = new Quill('#editorBajo', {
				modules: { 
					toolbar: {
						container : toolBarOptions,
						handlers:{
							image: imageHandler
						}
					}
				},
				theme: 'snow'
			});
			cargarPanel();
			this.pedirComplementos();
		},
		methods:{
			async pedirComplementos(){
				let respServ =await fetch(this.servidor +'pedirComplementos.php');
				let temporal = await respServ.json();
				this.actividades = temporal[0];
				this.categorias = temporal[1];
				axios.post(this.servidor + 'Alojamientos.php',{
					pedir: 'listar'
				})
				.then(serv=> this.hospedajes = serv.data )
			},
			async editarActividad(queId){
				if(this.nTexto = prompt('¿Cuál es el nuevo nombre?', this.actividades[queId].concepto )){
					let datos = new FormData();
					datos.append('id', this.actividades[queId].id)
					datos.append('nombre', this.nTexto)
					datos.append('comando', 'update')
					let respServ =await fetch(this.servidor +'editarActividad.php',{
						method:'POST', body: datos
					});
					if( await respServ.text() == 'ok'){
						this.actividades[queId].concepto = this.nTexto;
					}
				}
			},
			async eliminarActividad(queId){
				if(confirm('¿Desea borrar la actividad ' + this.actividades[queId].concepto +'?' )){
					let datos = new FormData();
					datos.append('id', this.actividades[queId].id)
					datos.append('comando', 'delete')
					let respServ =await fetch(this.servidor +'editarActividad.php',{
						method:'POST', body: datos
					});
					if( await respServ.text() == 'ok'){
						this.actividades.splice(queId, 1)
					}
				}
			},
			async eliminarHospedaje(queId){
				if(confirm('¿Desea borrar el hospedaje ' + this.hospedajes[queId].alojamiento +'?' )){
					axios.post(this.servidor +'Alojamientos.php', {
						pedir: 'borrar',
						id: this.hospedajes[queId].id
					})
					.then(respServ=>{
						if(respServ.data=='ok')
							this.hospedajes.splice(queId, 1)
					})
				}
			},
			async editarCategoria(queId){
				if(this.nTexto = prompt('¿Cuál es el nuevo nombre?', this.categorias[queId].concepto )){
					let datos = new FormData();
					datos.append('id', this.categorias[queId].id)
					datos.append('nombre', this.nTexto)
					datos.append('comando', 'update')
					let respServ =await fetch(this.servidor +'editarCategoria.php',{
						method:'POST', body: datos
					});
					if( await respServ.text() == 'ok'){
						this.categorias[queId].concepto = this.nTexto;
					}
				}
			},
			async eliminarCategoria(queId){
				if(confirm('¿Desea borrar la categoría ' + this.categorias[queId].concepto +'?' )){
					let datos = new FormData();
					datos.append('id', this.categorias[queId].id)
					datos.append('comando', 'delete')
					let respServ =await fetch(this.servidor +'editarCategoria.php',{
						method:'POST', body: datos
					});
					if( await respServ.text() == 'ok'){
						this.categorias.splice(queId, 1)
					}
				}
			},
			async crearActividad(){
				if(this.nTexto = prompt('Ingrese el nombre de la nueva actividad' )){
					if(this.nTexto!='' && this.nTexto!=null){
						let datos = new FormData();
						datos.append('nombre', this.nTexto)
						datos.append('comando', 'add')
						let respServ =await fetch(this.servidor +'editarActividad.php',{
							method:'POST', body: datos
						});
						//console.log(await respServ.text())
						let valorN = await respServ.text()
						if( parseInt(valorN) >0){
							this.actividades.push({id: valorN, concepto: this.nTexto, activo: 1});
						}
					}
				}
			},
			async crearCategoria(){
				if(this.nTexto = prompt('Ingrese el nombre de la nueva categoria' )){
					if(this.nTexto!='' && this.nTexto!=null){
						let datos = new FormData();
						datos.append('nombre', this.nTexto)
						datos.append('comando', 'add')
						let respServ =await fetch(this.servidor +'editarCategoria.php',{
							method:'POST', body: datos
						});
						//console.log(await respServ.text())
						let valorN = await respServ.text()
						if( parseInt(valorN) >0){
							this.categorias.push({id: valorN, concepto: this.nTexto, activo: 1});
						}
					}
				}
			},
			async enviarSitemap(){
				fetch(this.servidor+'enviarSitemap.php')
				.then(serv => serv.text())
				.then(resp => alert(resp) )
			},
			crearHospedaje(){
				if(alo=prompt('Ingrese un nombre para el nuevo alojamiento')){
					axios.post(this.servidor+'Alojamientos.php',{
						pedir: 'crear', alojamiento: alo
					}).then(resp=> this.pedirComplementos())
				}
			},
			
		}
	}).mount('#app')
	window.vueApp = app;
	
	
</script>
</body>
</html>