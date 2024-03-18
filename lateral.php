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
</head>
<body>
	<style>
		.bg-success {background-color: #00b749!important;}
		.toast-container{z-index: 1046;}
		tr{cursor: pointer;}
		p{margin-bottom: 0;}
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
					<a class="nav-link " href="paquetes.php">Paquetes turísticos</a>
					<a class="nav-link" href="internacionales.php">Internacionales</a>
					<a class="nav-link " href="reservas.php">Reservas</a>
					<a class="nav-link active" href="lateral.php">Configuraciones</a>
				</div>
			</div>
		</div>
	</nav>

	<div class="container" id="app">

		<h2 class="mt-2">Configuraciones extras</h2>

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
				<button class="nav-link" id="sitemap-tab" data-bs-toggle="tab" data-bs-target="#sitemap" type="button" role="tab" aria-controls="sitemap" aria-selected="false">Sitemap Google</button>
			</li>
		</ul>
		<div class="tab-content" id="myTabContent">
			<div class="tab-pane fade show active" id="lateral" role="tabpanel" aria-labelledby="lateral-tab">
				<p class="my-2">Edite panel lateral</p>
				<div class="row">
					<div class="col-12 col-md-6 col-lg-5 mx-auto">
						<div class=" ">
							<button class="btn btn-outline-primary my-3" onclick="actualizarPanel()">Actualizar</button>
							<div id="editor"> </div>
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

			<div class="tab-pane fade" id="sitemap" role="tabpanel" aria-labelledby="sitemap-tab">
				<p>Para actualizar el sitemap de productos personalizados, haga click en el botón de abajo:</p>
				<button class="btn btn-outline-primary" @click="enviarSitemap()">Enviar Sitemap XML</button>
			</div>
		</div>


		
	</div>

	<script src="https://unpkg.com/vue@3"></script>

	
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
	<script src="./js/quill.min.js"></script>
	
	<script src="js/axios.min.js"></script>
	<script src="js/moment.min.js"></script>
	<script>
		var quill;
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
		async function cargarPanel(){
			let respServ = await fetch("https://grupoeuroandino.com/app/api/cargarPanel.php");
			let html = await respServ.text();
			quill.setContents([]);
			quill.clipboard.dangerouslyPasteHTML(0, html);
		}

		
	const { createApp } = Vue

	createApp({
		data() {
			return {
				servidor: 'https://grupoeuroandino.com/app/api/', actividades:[], categorias:[],
				nTexto:''
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
			cargarPanel();
			this.pedirComplementos();
		},
		methods:{
			async pedirComplementos(){
				let respServ =await fetch(this.servidor +'pedirComplementos.php');
				let temporal = await respServ.json();
				this.actividades = temporal[0];
				this.categorias = temporal[1];
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
			}


		}
	}).mount('#app')
	
	
</script>
</body>
</html>