//Component Tarjeta Tour
export default{
	name: 'TarjetaTour',
	template: /*html*/`
	<div class="card h-100 border-0  position-relative">
		<div class="divOferta2 w-100 position-absolute end-0 d-flex justify-content-end">
			<span v-if="tour.transporte==1" class="mx-1 px-1 rounded" id="spanTransporte">Bus</span>
			<span v-if="tour.transporte==2" class="mx-1 px-1 rounded" id="spanTransporte">Avión</span>
			<span v-if="tour.alojamiento" class="mx-1 px-1 rounded" id="spanOferta"> {{hospedajes[tour.alojamiento]}}</span>
			<span v-if="tour.alimentacion" class="mx-1 px-1 rounded" id="spanAlimentacion">Alimentación</span>
			<span class="mx-1 px-1 rounded" id="spanTour">Tour</span>
			<span v-if="tour.guia" class="mx-1 px-1 rounded" id="spanGuia">Guía</span>
			<span v-if="tour.tickets" class="mx-1 px-1 rounded" id="spanTickets">Tickets</span>
		</div>

		<div v-if="tour.fotos.length>0" class="divImagen card-img-top">
			<a class="aImgs" v-if="tour.tipo==1" :href="'https://grupoeuroandino.com/tours/' + tours[index].url" target="framename"><img class="img-fluid rounded-top" :src="'https://grupoeuroandino.com/app/render/images/subidas/'+tour.fotos[0].nombreRuta" alt=""></a>
			<a class="aImgs" v-if="tour.tipo==2" :href="'https://grupoeuroandino.com/tours/' + tours[index].url" target="framename"><img class="img-fluid rounded-top" :src="'https://grupoeuroandino.com/app/render/images/subidas/'+tour.fotos[0].nombreRuta" alt=""></a>
		</div>
		<div class="card-body">
			<div class="divProducto ">
				
				
				<div>
					<p class="mb-0 titulo ps-1 text-capitalize">
						<a class="text-decoration-none text-dark" v-if="tour.tipo==1" :href="'https://grupoeuroandino.com/tours/' + tours[index].url" target="framename">{{tour.nombre}}</a>
						<a class="text-decoration-none text-dark" v-if="tour.tipo==2" :href="'https://grupoeuroandino.com/tours/' + tours[index].url" target="framename">{{tour.nombre}}</a>
						
					</p>
					<div class="estrellas">
						<i class="icofont-star"></i><i class="icofont-star"></i><i class="icofont-star"></i><i class="icofont-star"></i><i class="icofont-star"></i>
					</div>
					
					<div class="row row-cols-2">
						<div><i class="icofont-google-map"></i> <span class="text-capitalize"><strong>{{tour.destino}}, {{queDepa(tour.departamento)}}</strong></span> <br>
							<span v-if="tour.tipo==1" class="text-muted subText">{{queDura(tour.duracion)}}</span>
							<span v-else class="text-muted subText">{{queDuraDia(tour.duracion.dias)}} / {{queDuraNoche(tour.duracion.noches-1)}}</span>
						</div>
						<div class="text-end ">
							<span class="precio2">S/ {{formatoMoneda(tour.peruanos.adultos)}}</span>
							<p class="mb-0 text-end"><small>Precio normal</small></p>
							<p v-if="tour.oferta!='0' && tour.oferta!=''" class="precioAnt2 mb-0">S/ {{formatoMoneda(tour.oferta)}}</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	`,
	props:['tour'],
	methods: {
		
	},
}