export default {
	data(){ return{
		departamentos: ['Amazonas', 'Ancash', 'Apurimac', 'Arequipa', 'Ayacucho', 'Cajamarca', 'Cusco', 'Callao', 'Huancavelica', 'Huánuco', 'Ica', 'Junín', 'La Libertad', 'Lambayeque', 'Lima', 'Loreto', 'Madre de Dios', 'Moquegua', 'Pasco', 'Piura', 'Puno', 'San Martín', 'Tacna', 'Tumbes', 'Ucayali'],
		hospedajes: ['', 'Albergue', 'Apartment', 'Bungalow', 'Hostal *', 'Hostal **', 'Hostal ***', 'Hotel *', 'Hotel **', 'Hotel ***', 'Hotel ****', 'Hotel *****', 'Lodge', 'Resort', 'Otro', 'Casa', 'Casa 2', 'Casa 3', 'Airbnb', 'Rural'],
		queTransportes: [
			{ id: 0, transporte: "ninguno", idTransporte: 3 },
			// Terrestre (1)
			{ id: 1, transporte: "tren", idTransporte: 1 },
			{ id: 2, transporte: "bus", idTransporte: 1 },
			// Aéreo (2)
			{ id: 3, transporte: "avión", idTransporte: 2 },
			{ id: 4, transporte: "avioneta", idTransporte: 2 },
			// Acuático (4)
			{ id: 5, transporte: "barco", idTransporte: 4 },
			{ id: 6, transporte: "lancha", idTransporte: 4 }
		],		
	}},
	props: ['duracion', 'dias', 'noches', 'tour'],
	methods:{
		queTransporte(tourActivo) {
			if ('idTransporte' in tourActivo)
				if (tourActivo.transporte == '3') return ''
				else return this.queTransportes.find(tra => tra.id == tourActivo.idTransporte)?.transporte
			else {
				let texto = ''
				switch (tourActivo.transporte) {
					case '1': texto = 'bus'; break;
					case '2': texto = 'avión'; break;
					case '3': texto = 'Ninguno'; break;
					case '4': texto = 'barco'; break;
				}
				return texto
			}
		},
		queDepa(valor) {
			return this.departamentos[valor];
		},
		queDura(duracion) {
			return this.duracion[duracion - 1].valor;
		},
		queDuraDia(duracion) {
			return this.dias.find(x => x.clave === duracion).valor;
		},
		queDuraNoche(duracion) {
			if (duracion >= 1) {
				//return this.noches[duracion].valor;
				return this.noches.find(x => x.clave === duracion).valor;
			}
		},
		formatoMoneda(valor) {
			return parseFloat(valor).toFixed(0)
		},
		retornarHospedaje(id) {
			let al = this.hospedajes.find(x => x.id == id)
			if (al) return al.alojamiento
		},
		
	},
	computed: {
		imagenDescuento() {
			return this.tour.descuento?.imagen || 'https://grupoeuroandino.com/app/render/images/discount.png';
		}
	},
	template: /*html*/`
	<div class="card h-100 border-0  ">
		<div v-if="tour.fotos.length>0" class="divImagen position-relative" style="height: 345px;">
			<div class="divOferta2 w-100 position-absolute bottom-0 end-0 d-flex justify-content-end mb-2 me-1">
				<span class="text-capitalize mx-1 px-1 rounded" v-if="tour.idTransporte!=undefined && tour.transporte!='3'" id="spanTransporte">{{queTransporte(tour)}}</span>
				<span v-if="tour.alojamiento" class="mx-1 px-1 rounded" id="spanOferta"> {{hospedajes[parseInt(tour.alojamiento)]}}</span>
				<span v-if="tour.alimentacion" class="mx-1 px-1 rounded" id="spanAlimentacion">Alimentación</span>
				<span class="mx-1 px-1 rounded" id="spanTour">Tour</span>
				<span v-if="tour.guia" class="mx-1 px-1 rounded" id="spanGuia">Guía</span>
				<span v-if="tour.tickets" class="mx-1 px-1 rounded" id="spanTickets">Tickets</span>
			</div>
			<a class="aImgs" :href="'https://grupoeuroandino.com/tours/' + tour.url" target="_parent"><img class="img-fluid rounded-top" :src="'https://grupoeuroandino.com/app/render/images/subidas/'+tour.fotos[0].nombreRuta" alt=""></a>
		</div>
		<div class="card-body">
			<div class="divProducto ">
				<div>
					<p class="mb-0 titulo ps-1 ">
						<a class="text-decoration-none text-dark fw-bold" :href="'https://grupoeuroandino.com/tours/' + tour.url" target="_parent">{{tour.nombre}}</a>
					</p>
					<!-- <div class="d-flex justify-content-between">
						aquí iba la bandera
					</div> -->
					<div class="row ">
						<div class="col-5">
							<span class="text-muted subText"><img class="bandera" src="https://grupoeuroandino.com/images/banderas/peru.jpeg"> {{tour.destino}},</span>
							<br>
							<img src="https://grupoeuroandino.com/images/punto.svg" alt="Ubicación" style="width: 16px; height: 16px; margin-top: -2px; display: inline-block;"> <span class="text-capitalize text-muted subText"> {{queDepa(tour.departamento)}}</span>
							<div class="estrellas">
								<template v-for="star in parseInt(tour.calificacion)"><i class="icofont-star"></i></template>
							</div>
							<span v-if="tour.tipo==1" class="text-muted subText">{{queDura(tour.duracion)}}</span>
							<span v-else class="text-muted subText">{{queDuraDia(tour.duracion.dias)}} / {{queDuraNoche(tour.duracion.noches)}}</span>
						</div>
						<div class="col-4 descuentos d-flex align-items-end">
							<div v-if="tour.descuento?.id">
							<img class="imagenDscto" :src="imagenDescuento" style="max-height: 60px; width: auto;" />
							</div>
						</div>
						<div class="col-3 d-flex flex-column align-items-end justify-content-end" id="pegar">
								<p class="mb-0" style="font-size: 12px;">Desde</p>
								<p class="mb-0"><span class="precio2"><span class="moneda-peque">S/.</span> {{formatoMoneda(tour.peruanos.adultos)}}</span></p>
								<p v-if="tour.oferta!='0' && tour.oferta!=''" class="precioAnt2 mb-0" style="font-size: 14px"><span class="moneda">S/.</span> <span>{{formatoMoneda(tour.oferta)}}</span></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>`
	
}