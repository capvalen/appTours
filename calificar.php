<!DOCTYPE html>
				<html lang="es">
				<head>
					<meta charset="UTF-8">
					<meta http-equiv="X-UA-Compatible" content="IE=edge">
					<meta name="viewport" content="width=device-width, initial-scale=1.0">
					<title>Gracias</title>
					<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
					<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
				</head>
				<body>

<div id="app" class="card w-75 mx-auto" style="width: 18rem;">
	<div class="card-body" v-if="calificado==0">
		<p class="lead">Tour a calificar</p>
		<input type="text" class="form-control mb-3" v-model="tour" readonly disabled>
		<p class="lead">Dinos tu nombre que se publicará</p>
		<input type="text" class="form-control mb-3" v-model="nombre">
		<p class="lead">¿Con cuántas estrellas calificarías tu experiencia?</p>
		<div class="mb-2">
			<span class="puntero mx-1 text-warning" @click="cambiarNumero(1)">
				<i class="bi bi-star-fill"></i>
			</span>
			<span class="puntero mx-1 text-warning" @click="cambiarNumero(2)">
				<span v-if="calificacion>=2"><i class="bi bi-star-fill"></i></span>
				<span v-else><i class="bi bi-star"></i></span>
			</span>
			<span class="puntero mx-1 text-warning" @click="cambiarNumero(3)">
				<span v-if="calificacion>=3"><i class="bi bi-star-fill"></i></span>
				<span v-else><i class="bi bi-star"></i></span>
			</span>
			<span class="puntero mx-1 text-warning" @click="cambiarNumero(4)">
				<span v-if="calificacion>=4"><i class="bi bi-star-fill"></i></span>
				<span v-else><i class="bi bi-star"></i></span>
			</span>
			<span class="puntero mx-1 text-warning" @click="cambiarNumero(5)">
				<span v-if="calificacion>=5"><i class="bi bi-star-fill"></i></span>
				<span v-else><i class="bi bi-star"></i></span>
			</span>
		</div>
		
		<p class="lead">Adjunta un comentario público</p>
		<input type="text" class="form-control mb-3" v-model="comentario">
		<div class="text-end"><button class="btn btn-primary" id="btnEnviar" @click="enviar()">Enviar encuesta</button></div>
	</div>
	<div v-else class="p-5">
		<h2>Pedido ya calificado</h2>
		<p>Gracias por calificar el servicio que le brindamos</p>
	</div>
</div>

<script type="module">
	import { createApp } from 'https://unpkg.com/vue@3/dist/vue.esm-browser.js'

	createApp({
		data() {
			return {
				calificacion:5, idPedido:-1, tour: '', nombre: '', idTour: -1, comentario:'', calificado: 1, fecha: null
			}
		},
		mounted(){
			// Get the GET parameters
			const getParams = new URLSearchParams(window.location.search);
			/* const color = getParams.get("color");
			console.log(color); */
			this.idPedido = getParams.get('id')
			this.pedirData()
			

		},
		methods:{
			async pedirData(){
				let datos = new FormData()
				datos.append('id', this.idPedido)
				let serv = await fetch('https://peru-travel.pe/app/api/verPedidoPorId.php', {
					method:'POST', body:datos
				})
				const respuesta = await serv.json()
				this.calificado = respuesta[0].calificado
				this.tour = respuesta[0].titulo
				this.nombre = respuesta[0].nombre
				this.idTour = respuesta[0].idTour
				this.fecha = respuesta[0].fecha
			},
			async enviar(){
				const btnEnviar = document.getElementById('btnEnviar')
				btnEnviar.remove();
				let datos = new FormData()
				datos.append('idPedido', this.idPedido)
				datos.append('nombre', this.nombre)
				datos.append('idTour', this.idTour)
				datos.append('calificacion', this.calificacion)
				datos.append('comentario', this.comentario)
				datos.append('fecha', this.fecha)
				let serv = await fetch('https://peru-travel.pe/app/api/enviarEncuesta.php',{
					method:'POST', body:datos
				})
				const respuesta = await serv.text() 
				if(respuesta == 'ok')
					location.reload()
			},
			cambiarNumero(num){
				this.calificacion= num
			}
		}
	}).mount('#app')
</script>
<style>
	.puntero{cursor:pointer}
	.puntero:hover{color:#B07713!important}
</style>
</body>
</html>