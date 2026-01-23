<!DOCTYPE html>

<html lang="es">

<head>

	<meta charset="UTF-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Buscador - Perú Travel</title>



</head>

<body>

	<style>
		.container {

			width: 50%;

		}

		#divBuscador {

			width: 100%;

			position: relative;



		}

		#txtBuscador {
			width: 75%;
			background-color: #fff;
			border: none;
			height: 50px;
			font-size: 1.2rem;
			border-radius: 20px;

			/* margin: 0;
			height: 44px;
			
			border: 2px solid #1e1e1e;
			box-shadow: 0 0 0 0 #b5b5b5 inset;
			padding: 1.5rem;
			display: inline; */
		}
		#txtBuscador:focus{
			outline: none;
		}
		#btnBuscador {
			width: 25%;
			margin: 0;
			height: auto;
			background-color: #fff;
			border: none;
			box-shadow: 0 0 0 0 #b5b5b5 inset;
			border-radius: 50px;
			padding: 0rem;
			display: inline;
			color: white;
    	background-color: #ffa300;
			font-size:1.3em;
			font-weight: bold;
		}
		/* #btnBuscador:hover{color: #1e1e1e} */

		#cajaBuscador{
			width: 80%;
			margin: 0 auto;
			height: auto;
			background-color: #fff;
			border: transparent;
			border-radius: 50px;
			padding: 0.5rem;
			/*sombra */
			-webkit-box-shadow: 5px 5px 46px 16px rgba(0,0,0,0.6);
			box-shadow: 5px 5px 46px 16px rgba(0,0,0,0.6);
			display: flex;
			justify-content: flex-start;
		}

		@media (max-width: 480px) {
			#cajaBuscador{width: 100%; }
			#txtBuscador{height: 35px; }
			#btnBuscador{font-size:0.8em;
				font-weight: 400;	
			}

		}

		#resultado {

			padding: 0.5rem;

			margin-top: 0.5rem;

			width: 95%;

			min-height: 150px;

			position: absolute;
			top: 0;
			left: 0;

			border-radius: 5px;

			border: 1px solid #ddd;

			box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;

			z-index: 10;

			background-color: white;

		}

		.item {

			width: 100%;

			display: flex;

			background-color: white;

			border-bottom: 1px solid #ddd;

		}

		.item:hover {

			background: #f1f1f1;
			cursor: pointer;

		}

		.item:hover .titulo {

			color: #ff9715;

		}

		.imagen {

			width: 15%;

			padding: 0 0.5rem;

			display: flex;

			justify-content: center;

		}

		.imagen>img {
			width: 120px;
		}

		.contenido {

			width: 75%;

			display: flex;

			align-items: center;

		}

		.titulo {

			font-size: 1.05rem;

			font-weight: bold;

			margin-bottom: 0 !important;

		}

		.precioPort {
			margin-bottom: 0 !important;
			font-weight: bold;
			font-size: 1rem;
			color: #c7084e;
		}

		#verTodo {
			text-align: center;
		}

		#verTodo a {
			text-decoration: none;
		}

		.verMas {
			background-color: white;
		}

		.contVermas {

			min-height: 50px;

			display: flex;

			align-content: flex-start;

			justify-content: center;

			align-items: center;

		}

		#divLupa {
			right: 100px;
			top: 10px;
		}

		@media (max-width: 600px) {

			.imagen {
				width: 40%;
			}

			.container {
				width: 100%;
			}

			#divLupa {
				right: 51px
			}
			.titulo {font-size: 1rem!important; }

		}

		@media (max-width: 120px) {

			.imagen {
				width: 25%;
			}

			.container {
				width: 100%;
			}

			#divLupa {
				right: 45px
			}
			.titulo {font-size: 1rem!important; }

		}
	</style>

	<div class="container text-center" id="appBuscador">
		

		<div class="position-relative d-none">
			<input type="text" id="txtBuscador2" v-model="texto" placeholder="Ciudad, lugar, actividad" @keyup="validar($event);" @keyup.enter="irA('ultimo')" >
			<span id="divLupa" class="position-absolute"><img src="https://peru-travel.pe/images/search_icon.svg" alt="" style="width: 25px;"></span>
		</div>
		<div class="" id="cajaBuscador">
			<input type="text" id="txtBuscador" v-model="texto" placeholder="Ciudad, lugar, actividad" @keyup="validar($event);" @keyup.enter="irA('ultimo')" autocomplete="off">
			<button class="btn" id="btnBuscador" @click="irA('ultimo')">BUSCAR</button>
		</div>
			<!-- <div class="form-inline">
				<input type="text" id="txtBuscador" v-model="texto" placeholder="Ciudad, lugar, actividad" @keyup="validar($event);">
				<button class="btn btn-outline-secondary rounded-pill" id="btnBuscador">
					<span class="w-100 h-100 d-flex "><span class="ms-2 align-self-center">Buscar</span></span>
				</button>
			</div> -->

		<div id="divBuscador">

			<div id="resultado" v-if="coincidencias.length>0">

				<div class="item" v-for="(coincidencia, index) in coincidencias" @click="irA(coincidencia.id,index)">

					<div class="imagen">

						<img :src="'https://peru-travel.pe/app/render/images/subidas/'+coincidencia.foto" alt="">

					</div>

					<div class="contenido">

						<div>

							<p class="titulo">{{coincidencia.nombre}}</p>

							<p class="precioPort">S/ {{coincidencia.precio}}</p>

						</div>

					</div>

				</div>

				<div class="verMas" @click="irA('ultimo');">

					<div class="contVermas">

						<span id="verTodo"><a href="#!">Ver todos los resultados</a></span>

					</div>

				</div>

			</div>

		</div>

	</div>

	<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>

	<script>
		var appBuscador = new Vue({

			el: '#appBuscador',

			data: {

				texto: '',
				coincidencias: []

			},

			methods: {

				async validar(e) {

					console.log(e.keyCode);

					if (e.keyCode == 27) { //tecla esc

						this.coincidencias = [];

					} else {

						if (this.texto.length >= 3) {

							let datos = new FormData();

							datos.append('texto', this.texto);

							datos.append('departamento', -1);

							datos.append('tipo', -1);

							let resp = await fetch('https://peru-travel.pe/app/api/buscarTour_Portada.php', {

								method: 'POST',
								body: datos

							})

							this.coincidencias = await resp.json();

						} else {

							this.coincidencias = [];

						}

					}

				},

				irA(id, index = -1) {

					if (id == 'ultimo') {

						window.location.href = "https://peru-travel.pe/destinos/?texto=" + this.texto;

					} else {

						window.location.href = "https://peru-travel.pe/tours/" + this.coincidencias[index].url;

					}

				}

			}

		})
	</script>

</body>

