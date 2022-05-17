<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Carrito</title>
	<!-- CSS only -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" href="https://grupoeuroandino.com/app/render/icofont/icofont.min.css">
</head>
<body>
	<style>
		.gris { color: #adadad; }
		.form-control{border: 1px solid #ced4da!important;}
	</style>
	<div id="app">
		<div class="container" v-if="this.idProducto!=null">
			<div class="row ">
				<div class="col-12 col-md-8">
					<div class="card">
						<div class="card-body">
							<h3>Datos del comprador</h3>
							<div class="row row-cols-xs-1 row-cols-md-2">
								<div class="col">
									<div class="form-floating mb-3">
										<input type="text" class="form-control" id="" placeholder=" " v-model="nombres">
										<label for="floatingInput">Nombres</label>
									</div>
								</div>
								<div class="col">
									<div class="form-floating mb-3">
										<input type="text" class="form-control" id="" placeholder=" " v-model="apellidos">
										<label for="floatingInput">Apellidos</label>
									</div>
								</div>
								<div class="col">
									<div class="form-floating">
										<select class="form-select" id="floDni" aria-label=" ">
											<option value="1" selected>D.N.I.</option>
											<option value="2">Pasaporte</option>
											<option value="3">Carnet de extranjería</option>
										</select>
										<label for="floatingSelect">Documento</label>
									</div>
								</div>
								<div class="col">
									<div class="form-floating mb-3">
										<input type="text" class="form-control" id="" placeholder=" " v-model="documento">
										<label for="floatingInput">N° Documento</label>
									</div>
								</div>
							</div>
							<div class="row row-cols-xs-1 row-cols-md-2">
								<div class="col">
									<div class="form-floating mb-3">
										<input type="text" class="form-control" id="" placeholder=" " v-model="correo">
										<label for="floatingInput">Email</label>
									</div>
								</div>
								<div class="col">
									<div class="form-floating mb-3">
										<input type="text" class="form-control" id="" placeholder=" " v-model="celular">
										<label for="floatingInput">Celular</label>
									</div>
								</div>
								<div class="col">
								<div class="form-floating mb-3">
										<input type="text" class="form-control" id="" placeholder=" " v-model="ciudad">
										<label for="floatingInput">Ciudad</label>
									</div>
								</div>
								<div class="col">
									<div class="form-floating mb-3">
										<input type="text" class="form-control" id="" placeholder=" " v-model="direccion">
										<label for="floatingInput">Dirección</label>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col">
									<div class="form-check">
										<input class="form-check-input" type="checkbox" value="" id="chkPoliticas" v-model="politica">
										<label class="form-check-label" for="chkPoliticas">
										Acepto los <a class="text-decoration-none" href="https://grupoeuroandino.com/terminos-y-condiciones/" target="_blank">Términos y Condiciones Generales del Portal</a>
										</label>
									</div>
									<div class="form-check">
										<input class="form-check-input" type="checkbox" value="" id="chkPrivacidad" v-model="privacidad">
										<label class="form-check-label" for="chkPrivacidad">
										Acepto las <a class="text-decoration-none" href="https://grupoeuroandino.com/politicas-de-privacidad/" target="_blank">Políticas de privacidad</a>
										</label>
									</div>
								</div>
								<p class="mt-2">* Todos los campos son requeridos</p>
							</div>
						</div>
					</div>
					<p class="mt-2 text-muted"><i class="icofont-ui-close"> </i> Anular ésta compra</p>

				</div>
				<div class="col-12 col-md-4">
					<div class="card">
						<div class="card-body text-muted">
							<h3>Resumen del pedido</h3>
							<p class="fs-4 text-capitalize">{{nomTour.toLowerCase()}}</p>
							<p class="mb-0"><strong>Fecha de partida:</strong> <span>{{empieza}}</span></p>
							<p class="mb-0"><strong>Hora:</strong> <span>A las {{hora}}.</span></p>
							<p class="mb-0"><strong>Personas</strong> </p>
							<div class="row row-cols-2">
								<div class="col">
									<p class="mb-0">
										<span v-if="adultos==1">1 adulto</span>
										<span v-else>{{adultos}} adultos</span>
									</p>
									<p class="mb-0">
										<span v-if="kids==1">1 niño</span>
										<span v-else>{{kids}} niños</span>
										<span class="gris fs-6" >(max. 10 años)</span>
									</p>
									<p class="mb-0 fs-4"><strong>Total</strong></p>
								</div>
								<div class="col">
									<p class="mb-0"><span>S/</span> <span>{{parseFloat(precAdultos).toFixed(2)}}</span></p>
									<p class="mb-0"><span>S/</span> <span>{{parseFloat(precMenores).toFixed(2)}}</span></p>

									<p class="mb-0"><span class="gris">S/</span> <strong class="fs-4">{{parseFloat(total).toFixed(2)}}</strong></p>
								</div>
							</div>
						</div>
					</div>
					<div class="d-grid gap-1 mt-2">
						<button class="btn btn-primary btn-lg" @click="finalizarCompra">Finalizar compra</button>
					</div>
				</div>
			</div>
		</div>
		<div class="container" v-else>
			<p>Carrito vacío</p>
		</div>

		<div class="position-relative">
			<div class="toast-container position-absolute bottom-0 end-0 p-3">
				<div class="toast align-items-center text-white bg-danger border-0" id="toastMal" role="alert" aria-live="assertive" aria-atomic="true">
					<div class="d-flex">
						<div class="toast-body">
							{{mensajeError}}
						</div>
						<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
					</div>
				</div>

				<div class="toast align-items-center text-white bg-success border-0" id="toastBien" role="alert" aria-live="assertive" aria-atomic="true">
					<div class="d-flex">
						<div class="toast-body">
							Gracias por su pedido
						</div>
						<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
					</div>
				</div>
			</div>
		</div>
	</div>
<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script>
	var toastMal;
	const app = new Vue({
		el:'#app',
		data() {
			return {
				//servidor: 'http://localhost/euroAndinoApi/',
				servidor: 'https://grupoeuroandino.com/app/api/', 
				carrito:null,
				idProducto:null,adultos:0, kids:0,
				nacionalidad:-1, comienza:null,
				nombres: '', apellidos: '', documento: '', correo: '', celular: '', 
				ciudad: '', direccion: '', politica: '', privacidad: '', mensajeError:'', hora:'',
				precAdultos:'', precMenores:'', total:'', nomTour:'', adultoNormal:0,menorNormal:0
			}
		},
		mounted() {

			const queryString = window.location.search;
			const urlParams = new URLSearchParams(queryString);
			this.idProducto = urlParams.get('id');
			this.adultos = urlParams.get('adults');
			this.kids = urlParams.get('kids');
			this.nacionalidad = urlParams.get('nationality');
			this.empieza = urlParams.get('start');

			toastMal = new bootstrap.Toast(document.getElementById('toastMal'));
			toastBien = new bootstrap.Toast(document.getElementById('toastBien'));

			/* this.carrito = JSON.parse(localStorage.getItem('carrito'));
			if(this.carrito == null){ this.carrito=[] }else{} */
			if(this.idProducto!=null){
				this.verificarItemCarrito();
			}
			
 			/*this.carrito.push({dato:1, data2:2})
			localStorage.setItem('carrito', JSON.stringify(this.carrito)) 
			console.log(localStorage.getItem('carrito'));*/
		},
		methods:{
			async verificarItemCarrito(){
				var datos = new FormData();
				datos.append('id', this.idProducto)
				datos.append('adultos', this.adultos)
				datos.append('kids', this.kids)
				datos.append('nacionalidad', this.nacionalidad)
				
				//la consulta entrega precio, en base a la nacionalidad y la hora de inicio
				const resp = await fetch(this.servidor + "verificarItemCarrito.php", {
					method: 'POST', body: datos
				});
				let espera = await resp.json();
				this.nomTour = espera.nombre;
				this.hora = espera.hora;
				this.precAdultos = espera.adultos;
				this.precMenores = espera.menores;
				this.total = espera.total;
				this.adultoNormal = espera.adultoNormal;
				this.menorNormal = espera.menorNormal;
				
				//console.log( espera );

			},
			verificarCampos(){
				if(this.nombres==''){ this.mensajeError='Falta completar sus nombres';  toastMal.show(); return false; }
				else if(this.apellidos==''){ this.mensajeError='Falta completar sus apellidos';  toastMal.show(); return false; }
				else if(this.documento==''){ this.mensajeError='Falta completar su documento de identidad';  toastMal.show(); return false; }
				else if(this.correo==''){ this.mensajeError='Falta completar su e-mail';  toastMal.show(); return false; }
				else if(this.celular==''){ this.mensajeError='Falta completar su celular';  toastMal.show(); return false; }
				else if(this.ciudad==''){ this.mensajeError='Falta completar su ciudad';  toastMal.show(); return false; }
				else if(this.direccion==''){ this.mensajeError='Falta completar su dirección';  toastMal.show(); return false; }
				else if(!document.getElementById('chkPoliticas').checked){ this.mensajeError='Debe aceptar los Términos y condiciones';  toastMal.show(); return false; }
				else if(!document.getElementById('chkPrivacidad').checked){ this.mensajeError='Debe aceptar las Políticas de privacidad';  toastMal.show(); return false; }
				else{ return true;}
			},
			async finalizarCompra(){
				if(this.verificarCampos()){
					console.log( 'comenzar a guardar' );
					let datos = new FormData();
					datos.append('nombres', this.nombres)
					datos.append('apellidos', this.apellidos)
					datos.append('tipoDocumento', document.getElementById('floDni').value)
					datos.append('documento', this.documento)
					datos.append('correo', this.correo)
					datos.append('celular', this.celular)
					datos.append('ciudad', this.ciudad)
					datos.append('direccion', this.direccion)
					
					datos.append('id', this.idProducto)
					datos.append('adultos', this.adultos)
					datos.append('kids', this.kids)
					datos.append('nacionalidad', this.nacionalidad)
					datos.append('adultoNormal', this.adultoNormal)
					datos.append('menorNormal', this.menorNormal)
					datos.append('total', this.total)
					datos.append('moneda', 1)//falta habilitar izipay
					datos.append('titulo', this.nomTour)

					let respServer = fetch(this.servidor+'guardarPedido.php', {
						method:'POST', body:datos
					})
					.then(respo => { 
						return respo.text().then(texto=>{
							if( parseInt(texto)>0 ){
								toastBien.show();
							}
						})
					 })
					
					//console.log( await respServer.text() );
				}
			}
		}
	})
</script>
</body>
</html>