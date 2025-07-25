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
	<?php include "nav.php";?>

	<div class="container-fluix mx-2" id="app">
		<div class="row">
			<div class="col-8">
				<p class="fs-1">Reservas</p>
			</div>
		</div>
		<div class="row">
			<div class="col-12 col-md-6">
				<label for="" class="form-label"><i class="icofont-filter"></i> Filtrar</label>
				<div class="input-group mb-3">
					<input type="text" name="" id="txtFiltro" ref="txtFiltro" class="form-control" placeholder="Buscar" >
					<button class="btn btn-outline-secondary" type="button" @click="buscarPedidos()"><i class="icofont-search"></i> Buscar</button>
				</div>
			</div>
		</div>
		<p>Los 50 últimos pedidos realizados.</p>
		<table class="table table-hover">
			<thead>
				<tr>
					<th>N°</th>
					<th>Cliente</th>
					<th>Tour - Paquete</th>
					<th>Adultos</th>
					<th>Niños</th>
					<th>Total</th>
					<th>Tipo</th>
					<th>Estado</th>
					<th>@</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<tr v-if="pedidos.length == 0">
					<td colspan=5>No hay paquetes</td>
				</tr>
				<tr v-else v-for="(pedido, index) in pedidos" >
					<td>{{index+1}}</td>
					<td class="text-capitalize">{{pedido.nombre}} {{pedido.apellido}}</td>
					<td class="text-capitalize"><a class="text-decoration-none" :href="'https://grupoeuroandino.com/tours/'+pedido.url" target="_blank">{{pedido.titulo.toLowerCase()}} <i class="icofont-external-link"></i></a></td>
					<td>{{pedido.adultos}}</td>
					<td>{{pedido.menores}}</td>
					<td>S/ {{parseFloat(pedido.total).toFixed(2)}}</td>
					<td>
						<span v-if="pedido.moneda ==1">Pedido simple</span>
						<span v-else>Izi-Pay</span>
					</td>
					<td>{{pedido.estado}}</td>
					<td><button class="btn btn-outline-primary btn-sm" @click="abrirModal(index)" ><i class="icofont-eye-alt"></i> Detalles</button></td>
					<td><button class="btn btn-outline-danger border-0 btn-sm" @click="eliminarPedido(index)" ><i class="icofont-ui-delete"></i></button></td>
				</tr>
			</tbody>
		</table>

	<!-- Modal -->
	<div class="modal fade" id="modalDetalles" tabindex="-1" aria-labelledby="" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="">Detalles del pedido</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="indexPedido=null"></button>
				</div>
				<div class="modal-body" v-if="indexPedido!=null">
					<p class="mb-0"><strong><a class="text-decoration-none" :href="'https://grupoeuroandino.com/tours/'+pedidos[indexPedido].url" target="_blank">{{pedidos[indexPedido].titulo}} <i class="icofont-external-link"></i></a></strong> </p>
					<p class="mb-0"><strong>Fecha de pago</strong> {{fechaLatam(pedidos[indexPedido].fechaPago)}}</p>
					<p class="mb-0"><strong>Fecha de inicio</strong> {{fechaSimple(pedidos[indexPedido].separado)}}</p>
					<p class="mb-0"><strong>Total pagado</strong> S/ {{parseFloat(pedidos[indexPedido].total).toFixed(2)}}</p>
					<p class="mb-0"><strong>N° Adultos</strong> {{pedidos[indexPedido].adultos}}</p>
					<p class="mb-0"><strong>N° Niños</strong> {{pedidos[indexPedido].menores}}</p>
					<hr>

					<p class="mb-0"><strong>Cliente</strong> {{pedidos[indexPedido].nombre}}, {{pedidos[indexPedido].apellido}} </p>
					<p class="mb-0"><strong>D.N.I.</strong> {{pedidos[indexPedido].dni}}</p>
					<p class="mb-0"><strong>Celular</strong> {{pedidos[indexPedido].celular}}</p>
					<p class="mb-0"><strong>Correo</strong> {{pedidos[indexPedido].correo}}</p>
					<p class="mb-0"><strong>Dirección</strong> {{pedidos[indexPedido].direccion}}</p>
					<p class="mb-0"><strong>Nacionalidad</strong> 
						<span v-if="pedidos[indexPedido].nacionalidad == '159'">Peruana</span>
						<span v-else>Extranjera</span>
					</p>
				</div>
				<div class="modal-footer border-0">
					<button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="indexPedido=null">Cerrar</button>
				</div>
			</div>
		</div>
	</div>

	</div>

	<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
	
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
	
	<script src="js/axios.min.js"></script>
	<script src="js/moment.min.js"></script>
	<script>
	var modalDetalles,
	tostadaOk, tostadaMal;
	
	
	var app = new Vue({
		el: '#app',
		data: {
			//servidor: 'http://localhost/euroAndinoApi/',
			servidor: 'https://grupoeuroandino.com/app/api/',
			pedidos:[], indexPedido:null
			
		},
		mounted:function(){
			this.llamarPedidos()
			modalDetalles = new bootstrap.Modal(document.getElementById('modalDetalles'))
		},
		methods:{
			async llamarPedidos(){
				var datos = new FormData();
				datos.append('id', 'todos')
				let respServer =await fetch(this.servidor + 'verPedidos.php', {
					method:'POST', body:datos
				});
				this.pedidos = await respServer.json();
			},
			abrirModal(index){
				this.indexPedido = index;
				modalDetalles.show();
			},
			fechaLatam(hora){
				return( moment(hora).format('DD/MM/YYYY hh:mm a') )
			},
			fechaSimple(hora){
				return( moment(hora).format('DD/MM/YYYY') )
			},
			async eliminarPedido(index){
				if(confirm(`¿Desea eliminar el pedido de ${this.pedidos[index].nombre}?`)){
					const servidor =await axios.post(this.servidor + 'eliminarPedido.php', {
						id: this.pedidos[index].id
					})
					.then( respuesta =>{
						if(respuesta.data =='ok')
							this.llamarPedidos()
					})
				}
			}
		}
	});
	
</script>
</body>
</html>