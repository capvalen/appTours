
<?php
include '../api/'
?>
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
	
	<!-- Javascript library. Should be loaded in head section -->
	<!-- <script type="text/javascript" src="https://static.micuentaweb.pe/static/js/krypton-client/V4.0/stable/kr-payment-form.min.js"  kr-public-key="99809654:publickey_tXwOD7MbbajQWgNUXaUU1UaIrlEqLFpESM2tz7weDTqNI"> </script> -->
	<script type="text/javascript" src="https://static.micuentaweb.pe/static/js/krypton-client/V4.0/stable/kr-payment-form.min.js"  kr-public-key="99809654:publickey_tXwOD7MbbajQWgNUXaUU1UaIrlEqLFpESM2tz7weDTqNI"> </script>

    <!-- theme and plugins. should be loaded in the HEAD section -->
    <link rel="stylesheet" href="https://static.micuentaweb.pe/static/js/krypton-client/V4.0/ext/classic-reset.css">
    <script type="text/javascript" src="https://static.micuentaweb.pe/static/js/krypton-client/V4.0/ext/classic.js"></script>
</head>
<body>
	<style>
		.gris { color: #adadad; }
		.form-control{border: 1px solid #ced4da!important;}
	</style>
	<div id="app" class="p-4">
		<div class="container" v-if="this.idProducto!=null">
			<div class="row ">
				<div class="col-12 col-md-8">
					<div class="card">
						<div class="card-body">
							<h3>Datos del comprador (v. 1.01)</h3>
							<div class="row row-cols-1 row-cols-md-2">
							<div class="col">
									<div class="form-floating mb-3">
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
										<input type="text" class="form-control" id="" placeholder=" " v-model="documento" @keyup="buscarReniec()">
										<label for="floatingInput">N° Documento</label>
									</div>
								</div>
								<div class="col">
									<div class="form-floating mb-3">
										<input type="text" class="form-control text-capitalize" id="" placeholder=" " v-model="nombres">
										<label for="floatingInput">Nombres</label>
									</div>
								</div>
								<div class="col">
									<div class="form-floating mb-3">
										<input type="text" class="form-control text-capitalize" id="" placeholder=" " v-model="apellidos">
										<label for="floatingInput">Apellidos</label>
									</div>
								</div>
							</div>
							<div class="row row-cols-1 row-cols-md-2">
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
										<input type="text" class="form-control text-capitalize" id="" placeholder=" " v-model="ciudad">
										<label for="floatingInput">Ciudad</label>
									</div>
								</div>
								<div class="col">
									<div class="form-floating mb-3">
										<input type="text" class="form-control text-capitalize" id="" placeholder=" " v-model="direccion">
										<label for="floatingInput">Dirección</label>
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col">
									<p><strong>Condiciones: </strong></p>
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
								<p class="mt-2"><small>* Todos los campos son requeridos</small></p>
							</div>
							<div class="row">
								<div class="col">
									<p class="mt-2"><strong>Restricciones: </strong></p>
									<template v-for="(regla, index) in reglas">
											<div class="row row row-cols-auto g-3 my-1">
											<div class="col">
												<p class="me-1"><i class="icofont-circled-right"></i> {{regla.regla}}. <a href="#!" class="text-decoration-none" data-bs-toggle="modal" @click="indexRegla=index" data-bs-target="#modalDetalleReglas"><i class="icofont-plus"></i> Detalles</a></p>
											</div>
											<div class="col">
												<div class="btn-group" :role="'rules-group'+regla.id" >
													<input type="radio" class="btn-check" :name="'rules-group'+regla.id" :id="'btnradio'+regla.id+'1'" autocomplete="off">
													<label class="btn btn-outline-primary btn-sm" :for="'btnradio'+regla.id+'1'" @click="regla.respuesta='si'">Sí</label>
													<input type="radio" class="btn-check" :name="'rules-group'+regla.id" :id="'btnradio'+regla.id+'2'" autocomplete="off">
													<label class="btn btn-outline-primary btn-sm" :for="'btnradio'+regla.id+'2'" @click="regla.respuesta='no'">No</label>
												</div>
											</div>
										</div>
									</template>
									
								</div>
							</div>
						</div>
					</div>
					<div class="card p-2 mt-3">
						<div class="card-body">
							<p class="mb-0">Su Boleta de Venta Electrónica se generará con los datos ingresados previamente</p>
							<div class="form-check">
								<input class="form-check-input" type="checkbox" value="" id="chkFactura" @click="cambiarEntreFactura()">
								<label class="form-check-label" for="chkFactura"> Yo deseo una factura </label>
							</div>
						</div>
						<div v-if="actiFactura==1">
							<div class="row">
								<div class="col-12 col-md-6">
									<div class="form-floating mb-3">
										<input type="text" class="form-control text-capitalize" id="txtNRuc" placeholder=" " v-model="nRuc">
										<label for="floatingInput">R.U.C.</label>
									</div>
								</div>
								<div class="col-12 col-md-6">
									<div class="form-floating mb-3">
										<input type="text" class="form-control text-capitalize" id="txtNRazon" placeholder=" " v-model="nRazon">
										<label for="floatingInput">Razón social</label>
									</div>
								</div>
								<div class="col-12 col-md-12">
									<div class="form-floating mb-3">
										<input type="text" class="form-control text-capitalize" id="txtNDireccion" placeholder=" " v-model="nDireccion">
										<label for="floatingInput">Dirección fiscal:</label>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- <p class="mt-2 text-muted"><i class="icofont-ui-close"> </i> Anular ésta compra</p> -->

				</div>
				<div class="col-12 col-md-4">
					<div class="card mb-3 d-none">
						<div class="card-body">
							<p class="fs-4 text-capitalize">Cambio de moneda</p>
							<p>Seleccione su moneda de preferencia</p>
							<div class="form-check">
								<input class="form-check-input" type="radio" name="rMoneda" id="rMoneda1" checked  @click="cambioMoneda('soles')">
								<label class="form-check-label" for="rMoneda1" @click="cambioMoneda('soles')">
									Soles (S/)
								</label>
							</div>
							<div class="form-check">
								<input class="form-check-input" type="radio" name="rMoneda" id="rMoneda2" @click="cambioMoneda('dolares')">
								<label class="form-check-label" for="rMoneda2" @click="cambioMoneda('dolares')">
									USD Dolar ($)
								</label>
							</div>
						</div>
					</div>
					<div class="card">
						<div class="card-body text-muted">
							<h3>Resumen del pedido</h3>
							<p class="fs-4 text-capitalize"><a :href="'https://grupoeuroandino.com/tours/'+url" class="text-decoration-none">{{nomTour.toLowerCase()}}</a></p>
							<p class="mb-0"><strong>Fecha de inicio:</strong> <span>{{empieza}}</span></p>
							<p class="mb-0"><strong>Hora:</strong> <span>A las {{hora}}.</span></p>
							<p class="mb-0"><strong>Nacionalidad:</strong> 
								<span v-if="nacionalidad == 140">Peruana</span>
								<span v-else>Extranjera</span>
							</p>
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
										<p class="gris fs-6" >(max. 10 años)</p>
									</p>
									<p class="mb-0 fs-4"><strong>Total</strong></p>
								</div>
								<div class="col" >
									<p class="mb-0" v-if="moneda == 'soles'"><span>S/</span> <span>{{parseFloat(precAdultos).toFixed(2)}}</span></p>
									<p class="mb-0" v-if="moneda == 'dolares'"><span>$</span> <span>{{parseFloat(adulDolar).toFixed(2)}}</span></p>
									<p class="mb-0" v-if="moneda == 'soles'"><span>S/</span> <span>{{parseFloat(precMenores).toFixed(2)}}</span></p>
									<p class="mb-0" v-if="moneda == 'dolares'"><span>$</span> <span>{{parseFloat(ninDolar).toFixed(2)}}</span></p>
									<br>

									<p class="mb-0" v-if="moneda == 'soles'"><span class="gris">S/</span> <strong class="fs-4">{{parseFloat(total).toFixed(2)}}</strong></p>
									<p class="mb-0" v-if="moneda == 'dolares'"><span class="gris">$</span> <strong class="fs-4">{{parseFloat(totalDolar).toFixed(2)}}</strong></p>
								</div>
							</div>
						</div>
					</div>
					<div class="d-grid gap-1 my-2">
						<button class="btn btn-outline-danger btn-lg" @click="finalizarCompra"><i class="icofont-check-circled"></i> Finalizar compra</button>
					</div>
					<div>
						<img src="https://grupoeuroandino.com/wp-content/uploads/2022/06/83589178_2587722714818486_2444153424434954240_n.png" alt="" class="img-fluid">
					</div>
				</div>
			</div>
		</div>
		<div class="container" v-else>
			<p>Carrito vacío</p>
		</div>

		<div class="position-relative">
			<div class="toast-container position-absolute bottom-0 start-50 translate-middle-x p-3">
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

		<div class="modal fade" tabindex="-1" id="modalPagar" data-bs-backdrop="static" data-bs-keyboard="false" >
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					
					<div class="modal-body">
						<div class="d-flex justify-content-between">
							<h5 class="modal-title">Pagar con tarjeta</h5>
						</div>
						<p>Complete su pago</p>

						<!--Hidden payment form -->
						<div id="paymentForm" class="kr-embedded" style="display:none">

							<!-- payment form fields -->
							<div class="kr-pan"></div>
							<div class="kr-expiry"></div>
							<div class="kr-security-code"></div>

							<!-- payment form submit button -->
							<button class="kr-payment-button"></button>

							<!-- error zone -->
							<div class="kr-form-error"></div>
						</div>



						<div class="d-flex justify-content-between">
						<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar pedido</button>
						
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal para las reglas-->
		<div class="modal fade" id="modalDetalleReglas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<h1 class="modal-title fs-5" id="exampleModalLabel">Descripción</h1>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<p v-if="indexRegla>=0">{{reglas[indexRegla].instrucciones}}</p>
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- Desarrollo -->
<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
<!-- Produccion -->
<!-- <script src="https://cdn.jsdelivr.net/npm/vue@2"></script> -->

<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://grupoeuroandino.com/app/render/js/moment.min.js"></script>



<script>
	var toastMal, modalPagar;
	const app = new Vue({
		el:'#app',
		data() {
			return {
				//servidor: 'http://localhost/appTours/api/',
				servidor: 'https://grupoeuroandino.com/app/api/', 
				carrito:null,
				idProducto:null,adultos:0, kids:0,
				nacionalidad:-1, comienza:null,
				/* nombres: 'carlos', apellidos: 'pariona', documento: '44475064', correo: 'infocat.servicios@gmail.com', celular: '977692108', 
				ciudad: 'huancayo', direccion: 'av huancavelica 435',  */
				nombres: '', apellidos: '', documento: '', correo: '', celular: '', 
				ciudad: '', direccion: '',
				politica: '', privacidad: '', mensajeError:'', hora:'',
				precAdultos:'', precMenores:'', total:'', nomTour:'', adultoNormal:0,menorNormal:0, idOrden:-1, actiFactura:3, //3boleta, 1 factura
				nRuc:'', nRazon:'', nDireccion:'', dolar:0, comision:0, totalDolar: 0, moneda:'soles', adulDolar:0, ninDolar:0, url:'', indexRegla:-1,
				reglas:[
					{id:1, regla: 'Restricciones Alimentarias', instrucciones:'Son limitaciones en la dieta de una persona, ya sea por motivos de salud, creencias religiosas, preferencias personales o alergias/intolerancias. Estas restricciones pueden implicar evitar ciertos alimentos o grupos de alimentos por completo, o simplemente reducir su consumo.', respuesta:'' },
					{id:2,regla:'Condición Médica', instrucciones:'Se refiere a cualquier estado de salud que se aparta de lo normal, ya sea una enfermedad, un trastorno o una lesión. Estas condiciones pueden ser agudas (de corta duración y severas) o crónicas (de larga duración), y afectar tanto la salud física como mental.', respuesta:'' },
					{id:3,regla:'Requerimientos Especiales', instrucciones:'Se refieren a las necesidades específicas y particulares que un cliente o usuario tiene al solicitar un servicio, más allá de los requisitos básicos. Estos requerimientos pueden abarcar aspectos como plazos de entrega, niveles de calidad, recursos específicos, o consideraciones técnicas, entre otros. En esencia, son las condiciones adicionales que se deben cumplir para que un servicio sea satisfactorio y cumpla con las expectativas del cliente.', respuesta:'' },
					{id:4,regla:'Autorización de Uso de Imagen Fotográfica, audio y/o video', instrucciones:'Es un documento legal que otorga permiso a una persona o entidad para utilizar la imagen, voz y/o grabaciones audiovisuales de otra persona. Este permiso suele ser necesario cuando se pretende utilizar la imagen de alguien con fines comerciales, publicitarios, o en cualquier contexto donde su imagen pueda ser difundida públicamente.', respuesta:'' },
				]
			}
		},
		async mounted() {

			const queryString = window.location.search;
			const urlParams = new URLSearchParams(queryString);
			this.idProducto = urlParams.get('id');
			this.adultos = urlParams.get('adults');
			this.kids = urlParams.get('kids');
			this.nacionalidad = urlParams.get('nationality');
			this.empieza = urlParams.get('start');
			this.horario = urlParams.get('horario');

			toastMal = new bootstrap.Toast(document.getElementById('toastMal'));
			toastBien = new bootstrap.Toast(document.getElementById('toastBien'));
			modalPagar = new bootstrap.Modal(document.getElementById('modalPagar'));

			const serv = await fetch(this.servidor + "verDolar.php")
			let espera = await serv.json()
			this.dolar = parseFloat(espera[0].contenido)
			this.comision = parseFloat(espera[1].contenido)

			if(this.idProducto!=null){
				this.verificarItemCarrito();
			}
			this.carrito = JSON.parse(localStorage.getItem('carrito'));
			if(this.carrito == null){ 
				this.carrito=[];
			 }else{
				let resol = this.carrito.findIndex( item => item.idProducto == this.idProducto)
				if(resol>=0){
					this.carrito.splice(resol,1)
				}
			}

			this.carrito.push({
				idProducto: this.idProducto,
				adultos: this.adultos,
				kids: this.kids,
				nacionalidad: this.nacionalidad,
				empieza: this.empieza,
				horario: this.horario
			});
			localStorage.setItem('carrito', JSON.stringify(this.carrito))
			
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
				datos.append('horario', this.horario)
				
				//la consulta entrega precio, en base a la nacionalidad y la hora de inicio
				const resp = await fetch(this.servidor + "verificarItemCarrito.php", {
					method: 'POST', body: datos
				});
				let espera = await resp.json();
				this.nomTour = espera.nombre;
				this.url = espera.url
				this.hora = espera.hora;
				this.precAdultos = espera.adultos;
				this.precMenores = espera.menores;
				this.total = espera.total;
				this.adultoNormal = espera.adultoNormal;
				this.menorNormal = espera.menorNormal;

				const queryString = window.location.search;
				const urlParams = new URLSearchParams(queryString);
				if(urlParams.get('nationality') == 140) this.cambioMoneda('soles')
				else this.cambioMoneda('dolares')
				
				//console.log( espera );

			},
			verificarCampos(){
				if(this.nombres==''){ this.mensajeError='Falta completar sus nombres';  toastMal.show(); return false; }
				if(this.apellidos==''){ this.mensajeError='Falta completar sus apellidos';  toastMal.show(); return false; }
				if(this.documento==''){ this.mensajeError='Falta completar su documento de identidad';  toastMal.show(); return false; }
				if(this.correo==''){ this.mensajeError='Falta completar su e-mail';  toastMal.show(); return false; }
				if(this.celular==''){ this.mensajeError='Falta completar su celular';  toastMal.show(); return false; }
				if(this.ciudad==''){ this.mensajeError='Falta completar su ciudad';  toastMal.show(); return false; }
				if(this.direccion==''){ this.mensajeError='Falta completar su dirección';  toastMal.show(); return false; }
				if(!document.getElementById('chkPoliticas').checked){ this.mensajeError='Debe aceptar los Términos y condiciones';  toastMal.show(); return false; }
				if(!document.getElementById('chkPrivacidad').checked){ this.mensajeError='Debe aceptar las Políticas de privacidad';  toastMal.show(); return false; }
				if(document.getElementById('chkFactura').checked){ 
					if( this.nRuc =='' || this.nRuc.length!=11 ){ this.mensajeError='Falta completar su RUC o está erróneo';  toastMal.show(); return false;  }
					else if( this.nRazon =='' ){ this.mensajeError='Falta completar su razón social';  toastMal.show(); return false;  }
					else if( this.nDireccion =='' ){ this.mensajeError='Falta completar su dirección fiscal';  toastMal.show(); return false;  }
					else{ return true;}
				 }

				 let validacionReglas = true;

				 this.reglas.forEach(regla => {
					if(regla.respuesta == ''){
						this.mensajeError='Debe rellenar todos las restricciones';  toastMal.show();
						validacionReglas = false
						return false;
					}
				 });

				return validacionReglas;
			},
			finalizarCompra(){
				//this.crearToken();}
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
					datos.append('empieza', moment(this.empieza, 'DD/MM/YYYY').format('YYYY-MM-DD'))
					
					//datos de factura o boleta
					datos.append('tipoComprobante', this.actiFactura)
					datos.append('nRuc', this.nRuc)
					datos.append('nRazon', this.nRazon)
					datos.append('nDireccion', this.nDireccion)

					let respServer = fetch(this.servidor+'guardarPedido.php', {
						method:'POST', body:datos
					})
					.then(respo => { 
						return respo.text().then(texto=>{
							if( parseInt(texto)>0 ){
								this.idOrden=parseInt(texto);
								toastBien.show();
								this.crearToken();
								//goToThanks();
							}
						})
					 })
					//console.log( await respServer.text() );
				}
			},
			async crearToken(){
				let datos = new FormData()
				if( this.moneda == 'soles')
					datos.append('monto', this.total*100)
				else{
					let mDolar = Math.round(this.total*(1+this.comision/100),1)*100 //La entrega es en decimales grandes
					datos.append('monto', mDolar)
					console.log('quemMonto',mDolar)
				}
				
				datos.append('correo', 'ejemplo1@hotmail.com')
				datos.append('id', this.idOrden);

				let respIzi = await fetch('https://grupoeuroandino.com/app/render/token.php',{
					method:'POST', body: datos
				})
				.then(respuesta =>{
					respuesta.text().then(letra  =>{
						console.log(letra)
						//document.getElementsByClassName('kr-embedded')[0].setAttribute('kr-form-token', letra)
						displayPaymentForm(letra)
					})
				})
				//onCheckout()
				modalPagar.show();
			},
			cambiarEntreFactura(){
				if(!document.getElementById('chkFactura').checked){ //boleta
					this.actiFactura = 3;
				}
				if(document.getElementById('chkFactura').checked){ //factura
					this.actiFactura = 1;
				}
			},
			async buscarReniec(){
				if( document.getElementById('floDni').value == '1' && this.documento.length==8)
					if(event.keyCode==13){
						let datos = new FormData()
						datos.append('ruc', this.documento)
						const serv = await fetch('https://grupoeuroandino.com/app/facturador/php/dataSunat.php',{
							method:'POST', body:datos
						})
						const resp = await serv.json()
						this.nombres = resp.nombres
						this.apellidos = resp.paterno +' '+resp.materno
					}
			},
			async cambioMoneda(moneda){
				this.moneda = moneda
				this.adulDolar = (this.precAdultos/this.dolar)*(1+this.comision/100)
				this.ninDolar = (this.precMenores/this.dolar)*(1+this.comision/100)
				this.totalDolar = (this.total/this.dolar)*(1+this.comision/100)

			}
		}
	});
	
	function displayPaymentForm(formToken){
		// Show the payment form
		document.getElementById('paymentForm').style.display = 'block';

		// recupera datos desde el tocken generado con anterioridad
		KR.setFormToken(formToken);

		// Agrega un Listener (evento de escucha) cuando algún pago se haya realizado, sea bueno o mano para evaluarlo luego
		KR.onSubmit(onPaid);
		
	}
	
	function onPaid(event) {
		if (event.clientAnswer.orderStatus === "PAID") {
			
			goToThanks();
			// Remove the payment form
			KR.removeForms();

			// Show success message
			document.getElementById("paymentSuccessful").style.display = "block";
		
		} else {
			// Show error message to the user
			alert("Payment failed !");
		}
	}
	
	function goToThanks(){
		let resol = app.carrito.findIndex( item => item.idProducto == app.idProducto)
		if(resol>=0){
			app.carrito.splice(resol,1)
		}
		localStorage.setItem('carrito', JSON.stringify(app.carrito))

		//console.log('empeiza a redirigir')
		var url = 'https://grupoeuroandino.com/gracias';
		var form = $('<form action="' + url + '" method="post">' +
			'<input type="text" name="id" value="' + app.idOrden + '" />' +
			'</form>');
		$('body').append(form);
		form.submit();
	}
	
	
</script>
</body>
</html>