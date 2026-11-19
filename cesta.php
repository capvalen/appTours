
<!DOCTYPE html>

<html lang="es">

<head>

	<meta charset="UTF-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Cesta</title>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

	<link rel="stylesheet" href="https://grupoeuroandino.com/app/render/icofont/icofont.min.css">

</head>

<body>

	<style>

		p{margin-bottom: 0!important;}

		.table-responsive {
			border: 0;
			border-radius: 5px;
			overflow-x: auto;
		}

		.table-responsive .table {
			margin-bottom: 0;
			border-collapse: separate;
			border-spacing: 0;
		}

		/* Sin bordes en toda la tabla ni en las celdas */
		.table-responsive .table,
		.table-responsive .table > :not(caption) > * > * {
			border: 0;
			box-shadow: none;
		}

		/* Hover: solo sombra, sin fondo */
		.table-responsive .table-hover > tbody > tr:hover > * {
			--bs-table-bg-state: transparent;
			background-color: transparent;
		}

		.table-responsive .table tbody tr {
			transition: box-shadow .15s ease-in-out;
		}

		.table-responsive .table tbody tr:hover {
			box-shadow: 0 2px 10px rgba(0, 0, 0, .18);
		}

		/* Botón borrar moderno */
		.btn-borrar {
			display: inline-flex;
			align-items: center;
			gap: .35rem;
			padding: .35rem .7rem;
			border: 0;
			border-radius: 50rem;
			background-color: transparent;
			color: #adb5bd;
			font-size: .875rem;
			line-height: 1;
			cursor: pointer;
			transition: color .15s ease-in-out, background-color .15s ease-in-out;
		}

		.btn-borrar i {
			font-size: 1.05rem;
		}

		.btn-borrar:hover,
		.btn-borrar:focus-visible {
			color: #dc3545;
			background-color: rgba(220, 53, 69, .1);
			outline: none;
		}

	</style>

	<div id="app" class="p-2"> 

		<h2 class="fs-2">Carrito de compras</h2>

		<div v-if="carritos.length==0">

			<p>No tiene productos en su carrito</p>

		</div>

		<div v-else>

			<div class="table-responsive">
				<table class="table table-hover">
					<thead>
						<th>N°</th>
						<th>Tour o Paquete</th>
						<th>Precios</th>
						<th>Total</th>
						<th>Pasarela</th>
					</thead>
					<tbody>
						<tr v-for="(carrito, index) in resultados" :key="index">
							<td>{{index+1}}</td>
							<td>
								<img v-if="carrito.fotos && carrito.fotos.length" :src="'https://grupoeuroandino.com/app/render/images/subidas/'+carrito.fotos[0].nombreRuta" width="100px">
								<span>{{carrito.nombre}}</span>
							</td>
							<td>
								<p>{{carrito.cantAdultos}} Adultos: S/ {{monedaNacional(carrito.adultos)}}</p>
								<p>{{carrito.cantKids}} Niños: S/ {{monedaNacional(carrito.menores)}}</p>
							</td>
							<td>S/ {{monedaNacional(carrito.total)}}</td>
							<td><a :href="retornarLink(carrito.idProducto)" class="text-decoration-none"><i class="icofont-shopping-cart"></i> Ir a la pasarela</a></td>
							<td class="text-end">
								<button type="button" class="btn-borrar" @click="borrarItem(index)" title="Borrar del carrito" aria-label="Borrar del carrito">
									<i class="icofont-bin"></i>
									<span class="d-none d-sm-inline">Borrar</span>
								</button>
							</td>
						</tr>
					</tbody>
				</table>
			</div>

		</div>

	</div>

	

<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
<script src="https://grupoeuroandino.com/app/render/configuracion.js?v=1.0.2"></script>

<script>

	var toastMal;

	const app = new Vue({

		el:'#app',

		data() {

			return {

				//servidor: 'http://localhost/appTours/api/',

				servidor: window.lugarApi, 

				carritos:[], resultados:[]

			}

		},

		mounted() {

			this.carritos = JSON.parse(localStorage.getItem('carrito'));

			if(this.carritos == null){ 

				this.carritos=[];

				localStorage.setItem('carrito', JSON.stringify(this.carritos))

			}else{

				// Descarta registros incompletos (sin idProducto) guardados por error

				this.carritos = this.carritos.filter( item => item && item.idProducto != null && item.idProducto != 'null' );

			}

			this.rellenarCarrito();

			

		},

		methods:{

			async rellenarCarrito(){

				const resultados = await Promise.all(this.carritos.map(async item => {

					let datos = new FormData();

					datos.append('id', item.idProducto)

					datos.append('adultos', item.adultos)

					datos.append('kids', item.kids)

					datos.append('nacionalidad', item.nacionalidad)

					datos.append('horario', item.horario ?? -1)



					let respServ = await fetch(this.servidor+'verificarItemCarrito.php',{

						method:'POST',

						headers: { 'X-Requested-With': 'XMLHttpRequest' },

						body:datos

					});

					const texto = await respServ.text();

					let data;

					try {

						data = JSON.parse(texto);

					} catch(e) {

						const bloqueado = respServ.status === 403 || /Access Forbidden|wpcerber/i.test(texto);

						console.error('Respuesta inválida de verificarItemCarrito.php (HTTP '+respServ.status+'):', texto.slice(0, 300));

						data = {

							nombre: bloqueado ? '(bloqueado por el firewall del servidor)' : '(error al cargar)',

							adultos:0, menores:0, total:0,

							cantAdultos:item.adultos, cantKids:item.kids,

							fotos:[], idProducto:item.idProducto

						};

					}

					// Mezcla los datos guardados en el carrito (tipo, horario, empieza, nacionalidad...)

					return Object.assign({}, item, data);

				}));

				this.resultados = resultados;

			},

			retornarLink(idProducto){

				let miniIndex = this.carritos.findIndex( item => item.idProducto == idProducto);

				if(miniIndex < 0) return '#';

				const item = this.carritos[miniIndex];



				return "/carrito-compras/?id="+idProducto+"&type="+encodeURIComponent(item.tipo ?? '')+"&adults="+item.adultos+"&kids="+item.kids+"&nationality="+item.nacionalidad+"&start="+item.empieza+"&horario="+(item.horario ?? -1);

			},

			monedaNacional(valor){ return parseFloat(valor).toFixed(2)},
			borrarItem(index){
				const idProducto = this.resultados[index] ? this.resultados[index].idProducto : null;
				this.resultados.splice(index,1);
				if(idProducto != null){
					const idxCarrito = this.carritos.findIndex( item => item.idProducto == idProducto);
					if(idxCarrito >= 0) this.carritos.splice(idxCarrito,1);
				}
				localStorage.setItem('carrito', JSON.stringify(this.carritos))
			}
		},
		

	})

</script>

</body>

</html>