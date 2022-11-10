<!DOCTYPE html>

<html lang="es">

<head>

	<meta charset="UTF-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Cesta</title>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

	<link rel="stylesheet" href="https://grupoeuroandino.com/app/render/icofont/icofont.min.css">

</head>

<body>

	<style>

		p{margin-bottom: 0!important;}

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
						<th>Nacionalidad</th>
						<th>Total</th>
						<th>Pasarela</th>
					</thead>
					<tbody>
						<tr v-for="(carrito, index) in resultados" >
							<td>{{index+1}}</td>
							<td>
								<img :src="'https://grupoeuroandino.com/app/render/images/subidas/'+carrito.fotos[0].nombreRuta" width="128px">
								<span>{{carrito.nombre}}</span>
							</td>
							<td>
								<p>{{carrito.cantAdultos}} Adultos: S/ {{monedaNacional(carrito.adultos)}}</p>
								<p>{{carrito.cantKids}} Niños: S/ {{monedaNacional(carrito.menores)}}</p>
							</td>
							<td>
								<span v-if="carritos[index].nacionalidad==159">Peruana</span>
								<span v-else>Extranjero</span>
							</td>
							<td>S/ {{monedaNacional(carrito.total)}}</td>
							<td><a :href="retornarLink(carrito.idProducto)">Ir a la pasarela</a></td>
							<td @click="borrarItem(index)" style="cursor:pointer"><img src="https://grupoeuroandino.com/app/render/images/x.svg" width="25" height="25"> Borrar</td>
						</tr>
					</tbody>
				</table>
			</div>

		</div>

	</div>

	

<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>

<script>

	var toastMal;

	const app = new Vue({

		el:'#app',

		data() {

			return {

				//servidor: 'http://localhost/euroAndinoApi/',

				servidor: 'https://grupoeuroandino.com/app/api/', 

				carritos:[], resultados:[]

			}

		},

		mounted() {

			this.carritos = JSON.parse(localStorage.getItem('carrito'));

			if(this.carritos == null){ 

				this.carritos=[];

				localStorage.setItem('carrito', JSON.stringify(this.carritos))

			}

			this.rellenarCarrito();

			

		},

		methods:{

			rellenarCarrito(){

				this.carritos.forEach(async item=>{

					let datos = new FormData();

					datos.append('id', item.idProducto)

					datos.append('adultos', item.adultos)

					datos.append('kids', item.kids)

					datos.append('nacionalidad', item.nacionalidad)



					let respServ = await fetch(this.servidor+'verificarItemCarrito.php',{

						method:'POST', body:datos

					});

					respServ.text().then( que=>{

						//console.log(que)

						this.resultados.push( JSON.parse(que) );

					});

					console.log (await this.resultados)

				})

			},

			retornarLink(idProducto){

				let miniIndex = this.carritos.findIndex( item => item.idProducto == idProducto);



				return "/carrito-compras/?id="+idProducto+"&adults="+this.carritos[miniIndex].adultos+"&kids="+this.carritos[miniIndex].kids+"&nationality="+this.carritos[miniIndex].nacionalidad+"&start="+this.carritos[miniIndex].empieza;

			},

			monedaNacional(valor){ return parseFloat(valor).toFixed(2)},
			borrarItem(index){
				this.resultados.splice(index,1);
				localStorage.setItem('carrito', JSON.stringify(this.resultados))
			}
		},
		

	})

</script>

</body>

</html>