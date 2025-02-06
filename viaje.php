<!DOCTYPE html>

<html lang="es">

<head>

	<meta charset="UTF-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/png" href="https://grupoeuroandino.com/wp-content/uploads/2023/07/cropped-Grupo-Euro-Andino-favicon.png">


	<?php

	ini_set('display_errors', 1);

	ini_set('display_startup_errors', 1);

	error_reporting(E_ALL);

	include('/home/perutra1/grupoeuroandino.com/app/api/conectkarl.php');

	$sqlBase = "SELECT id, JSON_UNQUOTE(JSON_EXTRACT(contenido, '$.nombre')) as titulo,

	JSON_UNQUOTE(JSON_EXTRACT(contenido, '$.descripcion')) as descripcion,

	IFNULL(JSON_UNQUOTE(JSON_EXTRACT(contenido, '$.fotos[0].nombreRuta')), 'defecto.jpg')as foto

	FROM `tours` where url = '{$_GET['variable']}' limit 1;";

	$sqlMeta = $db->query($sqlBase);

	//echo $sqlBase;

	if ($sqlMeta->execute()) {

		$rowMeta = $sqlMeta->fetch(PDO::FETCH_ASSOC);

	?>

		<meta property="og:title" content="<?= $rowMeta['titulo'] ?> - Grupo Euro Andino">

		<title><?= $rowMeta['titulo'] ?> - Grupo Euro Andino</title>

		<!-- <meta property="og:image" content="https://grupoeuroandino.com/images/marcapomacocha-2.png"> -->

		<meta property="og:image" content="https://grupoeuroandino.com/app/render/images/subidas/small-<?= $rowMeta['foto'] ?>">

		<meta property="og:description" content="<?= strip_tags($rowMeta['descripcion']) ?>">

	<?php

	}

	?>

<?php include("../app/render/headers.php");?>
</head>

<body>
	<style>
		#divIncluye ul{ list-style-type: "✅ "; }
		#divNoIncluye ul{ list-style-type: "❌ "; }
		.divOferta2{width: 70px; height: 25px; /* rgb(192, 0, 67);  */ margin-top: 1rem; margin-right: 0rem; color:white; font-size: 0.8rem;  }
		/* .estrellas{color: rgb(58, 91, 255);} */
		.estrellas{color: #ffd400;}
		.divImagen img{
			width:100%!important;
			height: 320px!important;
    	object-fit: cover!important;
		}
	</style>


	<!-- Inicio de Encabezado -->
	<?php include ("../app/render/menu.php");?>

    <!-- Fin de Encabezado -->



	<div class="container" id="app">

		<div class="row">

			<div class="col-12 col-md-8">

				<div class="fotorama" data-nav="thumbs" data-width="100%" @contextmenu="handler($event)">

					<img v-for="foto in tourActivo.fotos" :src="'https://grupoeuroandino.com/app/render/images/subidas/'+foto.nombreRuta">



				</div>



				<!-- Empieza el bloque de descripción -->

				<div class="my-3 p-4 border rounded" id="divIzquierda">

					<h2 class="text-danger">{{tourActivo.nombre}}</h2>

					<div class="row">
						<div v-if="tourActivo.transporte !=3" class="col-4 col-md text-center fs-6">
							<span v-if="tourActivo.transporte==='2'"><span class="fs-2"><span style="display: inline-block;-webkit-transform:rotate(45deg)"><i class="icofont-airplane"></i></span></span> Avión</span>
							<span v-else><span class="fs-2"><i class="icofont-bus"></i></span> Bus</span>
						</div>
						<div v-if="tourActivo.alojamiento" class="col-4 col-md text-center fs-6"><span class="fs-2"><i class="icofont-bed"></i></span> {{retornarHospedaje(tourActivo.alojamiento)}}</div>
						<div v-if="tourActivo.alimentacion" class="col-4 col-md text-center fs-6"> <span class="fs-2"><i class="icofont-fork-and-knife"></i></span> Alimentación </div>
						<div class="col-4 col-md text-center fs-6"><span class="fs-2"><i class="icofont-google-map"></i></span> <span>Tour</span></div>
						<div v-if="tourActivo.guia" class="col-4 col-md text-center fs-6"><span class="fs-2"><i class="icofont-tracking"></i></span> Guía</div>
						<div v-if="tourActivo.tickets" class="col-4 col-md text-center fs-6"><span class="fs-2"><i class="icofont-ticket"></i></span> Tickets</div>
					</div>

					<!-- <div class="row row-cols-2 row-cols-md-3" v-if="tourActivo.tipo===2" id="divTransportes">

						<div class="col" v-if="tourActivo.transporte!='3'">

							<div class="d-flex justify-content-between">

								<div class="m-auto ps-2">
									

									<img v-if="tourActivo.transporte==='2'" src="https://grupoeuroandino.com/app/render/images/vuelo.png" alt="">

									<img v-else src="https://grupoeuroandino.com/app/render/images/carro2.png" style="width:38px">

								</div>

								<div class="text-start">

									<h6 class="mb-1 ">Transporte</h6>

									<span>{{transportes[parseInt(tourActivo.transporte)-1]}}</span>

								</div>

							</div>

						</div>

						<div class="col ps-0">

							<div class="d-flex justify-content-between">

								<div class="m-auto px-2">

									<img src="https://grupoeuroandino.com/app/render/images/hostal.png" style="width:50px">

								</div>

								<div class="text-start">

									<h6 class="mb-1

									">Alojamiento</h6>

									<span>{{hospedajes[parseInt(tourActivo.alojamiento)-1]}}</span>

								</div>

							</div>

						</div>

					</div> -->

					<h4 class="mt-4 text-danger">Descripción</h4>

					<div v-html="tourActivo.descripcion"></div>

					<h4 class="mt-4 text-danger">Punto de Partida</h4>

					<div class="w-100 text-break" v-html="tourActivo.partida"></div>

					<h4 class="mt-4 text-danger">Itinerario</h4>
					
					<div class="w-100 text-break p-2" v-html="tourActivo.itinerario"></div>
					<h4 class="mt-4 text-danger">Incluye</h4>
					<div class="w-100 text-break p-2" id="divIncluye" v-html="tourActivo.incluye"></div>
					<h4 class="mt-4 text-danger">No incluye</h4>
					<div class="w-100 text-break p-2" id="divNoIncluye" v-html="tourActivo.noIncluye"></div>



					<!-- <h5 class="mt-3 text-danger">Incluye</h5>

					<div>

						<p class="ms-2 mb-0" v-for="cadena in incluidos"><i class="icofont-check-alt"></i> {{cadena}}</p>

					</div> 



					<h5 class="mt-3 text-danger">No Incluye</h5>

					<div>

						<p class="ms-2 mb-0" v-for="cadena in noIncluidos"><i class="icofont-close-line"></i> {{cadena}}</p>

					</div>-->



					<h5 class="mt-3 text-danger">Notas</h5>
					<div v-html="tourActivo.notas"></div>

					<div class="w-100 text-break p-2" id="divNotas" v-html="entregarCorto(inferior, !verMas)"></div>

					<p @click="verMas = !verMas">

						<a class="text-decoration-none" href="#!">

							<span v-if="!verMas">Ver más</span>

							<span v-else>Ver menos</span>

						</a>

					</p>







				</div>

			</div>

			<div class="col-12 col-md-4">

				<div class="row">

					<div class="col text-center bg-secondary bg-opacity-25 ">

						<span class="fs-1"><strong class="text-danger"><small class="fs-3">S/</small> {{precioPorPersona}}</strong> <small class="fs-5">por persona</small></span>

					</div>

				</div>

				<div class="row">

					<div class="col px-0">

						<div id="dtpFecha" data-date-format="dd/mm/yyyy"></div>

					</div>

				</div>

				<p class="fs-3 text-center text-muted mt-2">

					<span v-if="tourActivo.cupos==1">Último cupo disponible</span>

					<span v-else>{{tourActivo.cupos}} cupos disponibles</span>

				</p>

				<div class="row container" id="divAdultos">

					<div class="col-5 ">

						<p v-if="tourActivo.tipo=='1'" class="text-muted text-end mb-0">Adultos</p>

						<p v-else class="text-muted mb-0">en hab. matrimonial, doble ó triple</p>

					</div>

					<div class="col-6 ms-3">

						<div class="input-group mx-auto">

							<button class="btn btn-outline-secondary border-0" type="button" @click='restarAdulto()'><i class="icofont-minus"></i></button>

							<input type="text" class="form-control w-25 border-0 text-center text-muted" placeholder=" " @focusout="contarMinimoPersonas()" v-model="cantAdultos">

							<button class="btn btn-outline-secondary border-0" type="button" @click="sumarAdulto()"><i class="icofont-plus"></i></button>

						</div>

					</div>

				</div>

				<div class="row container mt-2" id="divKids">

					<div class="col-5 ">

						<p v-if="tourActivo.tipo==1" class="text-muted text-end mb-0">Niños <br><small>(hasta 10 años)</small></p>

						<p v-else class="text-muted mb-0">en hab. simple <small class="text fst-italic">(1 persona por habitación)</small></p>

					</div>

					<div class="col-6 ms-3">

						<div class="input-group mx-auto">

							<button class="btn btn-outline-secondary border-0" type="button" @click="restarKid()"><i class="icofont-minus"></i></button>

							<input type="text" class="form-control w-25 border-0 text-center text-muted" placeholder=" " @focusout="contarMinimoPersonas()" v-model="cantKids">

							<button class="btn btn-outline-secondary border-0" type="button" @click="sumarKid()"><i class="icofont-plus"></i></button>

						</div>

					</div>

				</div>

				<div class="row col mx-auto my-3 " v-if="!faltaMinimo">
					<div class="alert alert-warning " role="alert">
						La <strong>cantidad mínima</strong> de viajeros debe ser <strong>{{tourActivo.minimo}}</strong>
					</div>
				</div>
				<div class="row col mx-auto my-3 " v-if="!faltaAdulto">
					<div class="alert alert-warning " role="alert">
						Mínimo debe haber un <strong>adulto</strong>
					</div>
				</div>



				<div class="row col-7 mx-auto my-3">

					<select class="form-select" id="sltPais" @change="comprobarNacionalidad()" v-model="nacionalidad">

						<option value="-1">País o Nacionalidad</option>

						<option value="140">PERU</option>
						<option value="1">Afganistán</option>
						<option value="2">Albania</option>
						<option value="3">Algeria</option>
						<option value="4">American Samoa</option>
						<option value="5">Andorra</option>
						<option value="6">Angola</option>
						<option value="7">Anguilla</option>
						<option value="8">Antigua and Barbuda</option>
						<option value="9">Argentina</option>
						<option value="10">Armenia</option>
						<option value="11">Aruba</option>
						<option value="12">Australia</option>
						<option value="13">Austria</option>
						<option value="14">Azerbaijan</option>
						<option value="15">Bahamas</option>
						<option value="16">Bahrain</option>
						<option value="17">Bangladesh</option>
						<option value="18">Barbados</option>
						<option value="19">Belarus</option>
						<option value="20">Belgium</option>
						<option value="21">Belize</option>
						<option value="22">Benin</option>
						<option value="23">Bermuda</option>
						<option value="24">Bhutan</option>
						<option value="25">Bolivia</option>
						<option value="26">Bosnia and Herzegovina</option>
						<option value="27">Botswana</option>
						<option value="28">Brazil</option>
						<option value="29">Brunei Darussalam</option>
						<option value="30">Bulgaria</option>
						<option value="31">Burkina Faso</option>
						<option value="32">Burundi</option>
						<option value="33">Cambodia</option>
						<option value="34">Cameroon</option>
						<option value="35">Canada</option>
						<option value="36">Cape Verde</option>
						<option value="37">Cayman Islands</option>
						<option value="38">Central African Republic</option>
						<option value="39">Chad</option>
						<option value="40">Chile</option>
						<option value="41">China</option>
						<option value="42">Colombia</option>
						<option value="43">Comoros</option>
						<option value="44">Congo</option>
						<option value="45">Congo, the Democratic Republic of the</option>
						<option value="46">Cook Islands</option>
						<option value="47">Costa Rica</option>
						<option value="48">Cote D'Ivoire</option>
						<option value="49">Croatia</option>
						<option value="51">Cyprus</option>
						<option value="52">Czech Republic</option>
						<option value="53">Denmark</option>
						<option value="54">Djibouti</option>
						<option value="55">Dominica</option>
						<option value="56">Dominican Republic</option>
						<option value="57">Ecuador</option>
						<option value="58">Egypt</option>
						<option value="59">El Salvador</option>
						<option value="60">Equatorial Guinea</option>
						<option value="61">Eritrea</option>
						<option value="62">Estonia</option>
						<option value="63">Ethiopia</option>
						<option value="64">Falkland Islands (Malvinas)</option>
						<option value="65">Faroe Islands</option>
						<option value="66">Fiji</option>
						<option value="67">Finland</option>
						<option value="68">France</option>
						<option value="69">French Guiana</option>
						<option value="70">French Polynesia</option>
						<option value="71">Gabon</option>
						<option value="72">Gambia</option>
						<option value="73">Georgia</option>
						<option value="74">Germany</option>
						<option value="75">Ghana</option>
						<option value="76">Gibraltar</option>
						<option value="77">Greece</option>
						<option value="78">Greenland</option>
						<option value="79">Grenada</option>
						<option value="80">Guadeloupe</option>
						<option value="81">Guam</option>
						<option value="82">Guatemala</option>
						<option value="83">Guinea</option>
						<option value="84">Guinea-Bissau</option>
						<option value="85">Guyana</option>
						<option value="86">Haiti</option>
						<option value="87">Holy See (Vatican City State)</option>
						<option value="88">Honduras</option>
						<option value="89">Hong Kong</option>
						<option value="90">Hungary</option>
						<option value="91">Iceland</option>
						<option value="92">India</option>
						<option value="93">Indonesia</option>
						<option value="95">Iraq</option>
						<option value="96">Ireland</option>
						<option value="97">Israel</option>
						<option value="98">Italy</option>
						<option value="99">Jamaica</option>
						<option value="100">Japan</option>
						<option value="101">Jordan</option>
						<option value="102">Kazakhstan</option>
						<option value="103">Kenya</option>
						<option value="104">Kiribati</option>
						<option value="106">Korea, Republic of</option>
						<option value="107">Kuwait</option>
						<option value="108">Kyrgyzstan</option>
						<option value="109">Lao People's Democratic Republic</option>
						<option value="110">Latvia</option>
						<option value="111">Lebanon</option>
						<option value="112">Lesotho</option>
						<option value="113">Liberia</option>
						<option value="114">Libyan Arab Jamahiriya</option>
						<option value="115">Liechtenstein</option>
						<option value="116">Lithuania</option>
						<option value="117">Luxembourg</option>
						<option value="118">Macao</option>
						<option value="119">Macedonia, the Former Yugoslav Republic of</option>
						<option value="120">Madagascar</option>
						<option value="121">Malawi</option>
						<option value="122">Malaysia</option>
						<option value="123">Maldives</option>
						<option value="124">Mali</option>
						<option value="125">Malta</option>
						<option value="126">Marshall Islands</option>
						<option value="127">Martinique</option>
						<option value="128">Mauritania</option>
						<option value="129">Mauritius</option>
						<option value="130">Mexico</option>
						<option value="131">Micronesia, Federated States of</option>
						<option value="132">Moldova, Republic of</option>
						<option value="133">Monaco</option>
						<option value="134">Mongolia</option>
						<option value="135">Montserrat</option>
						<option value="136">Morocco</option>
						<option value="137">Mozambique</option>
						<option value="139">Namibia</option>
						<option value="159">Nauru</option>
						<option value="141">Nepal</option>
						<option value="142">Netherlands</option>
						<option value="143">Netherlands Antilles</option>
						<option value="144">New Caledonia</option>
						<option value="145">New Zealand</option>
						<option value="146">Nicaragua</option>
						<option value="147">Niger</option>
						<option value="148">Nigeria</option>
						<option value="149">Niue</option>
						<option value="150">Norfolk Island</option>
						<option value="151">Northern Mariana Islands</option>
						<option value="152">Norway</option>
						<option value="153">Oman</option>
						<option value="154">Pakistan</option>
						<option value="155">Palau</option>
						<option value="156">Panama</option>
						<option value="157">Papua New Guinea</option>
						<option value="158">Paraguay</option>
						<option value="160">Philippines</option>
						<option value="161">Pitcairn</option>
						<option value="162">Poland</option>
						<option value="163">Portugal</option>
						<option value="164">Puerto Rico</option>
						<option value="165">Qatar</option>
						<option value="166">Reunion</option>
						<option value="167">Romania</option>
						<option value="168">Russian Federation</option>
						<option value="169">Rwanda</option>
						<option value="170">Saint Helena</option>
						<option value="171">Saint Kitts and Nevis</option>
						<option value="172">Saint Lucia</option>
						<option value="173">Saint Pierre and Miquelon</option>
						<option value="174">Saint Vincent and the Grenadines</option>
						<option value="175">Samoa</option>
						<option value="176">San Marino</option>
						<option value="177">Sao Tome and Principe</option>
						<option value="178">Saudi Arabia</option>
						<option value="179">Senegal</option>
						<option value="180">Seychelles</option>
						<option value="181">Sierra Leone</option>
						<option value="182">Singapore</option>
						<option value="183">Slovakia</option>
						<option value="184">Slovenia</option>
						<option value="185">Solomon Islands</option>
						<option value="186">Somalia</option>
						<option value="187">South Africa</option>
						<option value="188">Spain</option>
						<option value="189">Sri Lanka</option>
						<option value="190">Sudan</option>
						<option value="191">Suriname</option>
						<option value="192">Svalbard and Jan Mayen</option>
						<option value="193">Swaziland</option>
						<option value="194">Sweden</option>
						<option value="195">Switzerland</option>
						<option value="197">Taiwan, Province of China</option>
						<option value="198">Tajikistan</option>
						<option value="199">Tanzania, United Republic of</option>
						<option value="200">Thailand</option>
						<option value="201">Togo</option>
						<option value="202">Tokelau</option>
						<option value="203">Tonga</option>
						<option value="204">Trinidad and Tobago</option>
						<option value="205">Tunisia</option>
						<option value="206">Turkey</option>
						<option value="207">Turkmenistan</option>
						<option value="208">Turks and Caicos Islands</option>
						<option value="209">Tuvalu</option>
						<option value="210">Uganda</option>
						<option value="211">Ukraine</option>
						<option value="212">United Arab Emirates</option>
						<option value="213">United Kingdom</option>
						<option value="214">United States</option>
						<option value="215">Uruguay</option>
						<option value="216">Uzbekistan</option>
						<option value="217">Vanuatu</option>
						<option value="218">Venezuela</option>
						<option value="219">Viet Nam</option>
						<option value="220">Virgin Islands, British</option>
						<option value="221">Virgin Islands, U.s.</option>
						<option value="222">Wallis and Futuna</option>
						<option value="223">Western Sahara</option>
						<option value="224">Yemen</option>
						<option value="225">Zambia</option>
						<option value="226">Zimbabwe</option>

					</select>

				</div>

				<div class="row col-7 mx-auto my-3">
					<label for="">Horarios:</label>

					<select name="" id="sltHorario" class="form-select" v-model="horarioSelect">
						<option value="-1">{{horaLatam(tourActivo.hora).replace('pm', 'p.m.').replace('am', 'a.m.')}}</option>
						<option v-if="tourActivo.hora2" value="1">{{horaLatam(tourActivo.hora2).replace('pm', 'p.m.').replace('am', 'a.m.')}}</option>
					</select>

				</div>

				<div class=" ms-5 ps-3" id="divDuracion">

					<span><strong>Anticipación:</strong> {{queAnticipa(tourActivo.anticipacion)}}</span><br>
					<span><strong>Duración:</strong> {{queDuraComp}}</span><br>


					<span><strong>Mínimo de viajeros:</strong>

						<span v-if="tourActivo.minimo==1">1 viajero</span>

						<span v-else>{{tourActivo.minimo}} viajeros</span>

					</span>

					<br><br>

					<span><strong>Ciudad:</strong> {{tourActivo.destino}} - {{queDepa(tourActivo.departamento)}}</span><br>

					<span><strong>Actividades:</strong> {{tourActivo.actividad}} {{variasActividades(tourActivo.actividades)}}</span><br>

					<span><strong>Categorías:</strong> {{variasCategorias(tourActivo.categorias)}}</span><br>

				</div>

				<div class="row col mx-auto mt-3 mb-0 " v-if="faltaPais">

					<div class="alert alert-warning " role="alert">

						{{msjError}}

					</div>

				</div>



				<div class="row">

					<div class="col text-center">

						<span class='fs-2 text-muted'>Total: <strong style="color:#60696d" class="">S/ {{formatoMoneda(precioTotal)}}</strong></span>
						<p class="mb-2"><span>Total en dólares: <strong> USD {{precioDolares.toFixed(2)}}</strong></span></p>
						
					</div>

				</div>

				<div class="row">

					<div class="col-10 mx-auto d-grid">

						<button class="btn btn-danger rounded-pill" @click="reservar"><strong>RESERVAR AHORA</strong></button>

					</div>

				</div>

				<div class="row col mt-3">
					<img src="https://grupoeuroandino.com/app/render/images/tarjetas.png" alt="" class="img-fluid">

				</div>



				<div class="row my-3 ">

					<div class="col m-4 p-3 border rounded" id="divQuill" v-html="lateral"></div>

				</div>

			</div>

		</div>



		<div class="row">

			<div class="col-12">

				<div class="my-3 p-4 border rounded">

					<div id="divRecomendaciones">

						<div class="titulo p-2 mb-3">

							<h3 class="my-1">Tours y paquetes turísticos similares:</h3>

						</div>

					<!-- 	<div class="row row-cols-12 row-cols-lg-3">
							
						</div> -->

						<div class="carousel-wrapper">

							<div class=" my-2 owl-carousel owl-theme">
								<div class="col-12 my-3" v-for="(tour, index) in contenidos">
									<div class="card border-0 h-100">
									



										<div v-if="tour.fotos.length>0" class="divImagen card-img-top position-relative">
											<div class="divOferta2 w-100 position-absolute bottom-0 end-0 d-flex justify-content-end mb-2 me-1">
												<span v-if="tour.transporte==1" class="mx-1 px-1 rounded" id="spanTransporte">Bus</span>
												<span v-if="tour.transporte==2" class="mx-1 px-1 rounded" id="spanTransporte">Avión</span>
												<span v-if="tour.alojamiento" class="mx-1 px-1 rounded" id="spanOferta"> {{hospedajes[tour.alojamiento]}}</span>
												<span v-if="tour.alimentacion" class="mx-1 px-1 rounded" id="spanAlimentacion">Alimentación</span>
												<span class="mx-1 px-1 rounded" id="spanTour">Tour</span>
												<span v-if="tour.guia" class="mx-1 px-1 rounded" id="spanGuia">Guía</span>
												<span v-if="tour.tickets" class="mx-1 px-1 rounded" id="spanTickets">Tickets</span>
											</div>
											<a class="aImgs" v-if="tour.tipo==1" :href="'https://grupoeuroandino.com/tours/' + tours[index].url" target="_parent"><img class="img-fluid rounded-top" :src="'https://grupoeuroandino.com/app/render/images/subidas/'+tour.fotos[0].nombreRuta" alt=""></a>
											<a class="aImgs" v-if="tour.tipo==2" :href="'https://grupoeuroandino.com/tours/' + tours[index].url" target="_parent"><img class="img-fluid rounded-top" :src="'https://grupoeuroandino.com/app/render/images/subidas/'+tour.fotos[0].nombreRuta" alt=""></a>
										</div>
										
										<div class="card-body">
											<div class="divProducto ">
								
								
												<div>
													<p class="mb-0 titulo text-capitalize text-start"><strong>
														<a class="text-decoration-none text-dark" v-if="tour.tipo==1" :href="'https://grupoeuroandino.com/tours/' + tours[index].url" target="_parent">{{tour.nombre}}</a>
														<a class="text-decoration-none text-dark" v-if="tour.tipo==2" :href="'https://grupoeuroandino.com/tours/' + tours[index].url" target="_parent">{{tour.nombre}}</a>
														</strong>
													</p>
													
												</div>
								
												<div class="row row-cols-2">
													<div class="text-start">
														<span class="text-capitalize"><img class="bandera" src="https://grupoeuroandino.com/images/banderas/peru.jpeg" style="width:20px; height:13.59px; display:inline;"></span> <span ><strong>{{tour.destino}},</strong></span><br>
														<i class="icofont-google-map"></i> <span class="text-capitalize"><strong>{{queDepa(tour.departamento)}}</strong></span>
														<div class="estrellas">
															<i v-for="star in cuantasEstrellas(index)" class="icofont-star"></i>
														</div>
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

								<!-- <div class=" item" v-for="recomendado in recomendados" :key="recomendado.id">

									<a :href="'https://grupoeuroandino.com/tour/'+recomendado.url"><img :src="'https://grupoeuroandino.com/app/render/images/subidas/'+recomendado.foto" alt="" class="img-fluid"></a>

									<h5 class="mb-0 text-start">{{recomendado.titulo}}</h5>

									<p class="card-text mb-0 text-start"><i class="icofont-google-map"></i> <span class="text-capitalize"><strong>{{recomendado.destino}}, {{departamentos[recomendado.depa]}}</strong></span></p>

									<div class="text-start estrellas"><i class="icofont-star"></i><i class="icofont-star"></i><i class="icofont-star"></i><i class="icofont-star"></i><i class="icofont-star"></i></div>

									<div class="row row-cols-2">

										<div class="text-start">

											<span>{{queDuraRecomendado(recomendado.tipo, recomendado.duracion, recomendado.duracion2)}}</span>

										</div>

										<div class="text-end "><span class="precio2"><span class="monedita fs-6">S/</span> {{formatoMoneda(recomendado.precio)}}</span>
											<p class="precioAnt2 mb-0">S/ {{formatoMoneda(recomendado.oferta)}}</p>
										</div>

									</div>

								</div> -->

							</div>

						</div>

					</div>

				</div>

			</div>

		</div>
		<div class="row">
			<div class="col-12 col-md-8">
				<div class="my-3 p-4 border rounded">
					<div class="titulo p-2 mb-3">
						<h3 class="my-1">Que opinan los viajeros que compraron este tour</h3>
						<ul class="list-group list-group-flush">
							<li class="list-group-item" v-for="(comentario, index) in comentarios">
								<div class="d-flex w-100 justify-content-between">
									<h5 class="mb-1 text-capitalize">{{index+1}}. {{comentario.nombre}}</h5>
									<small>Viajó el {{fechaFrom(comentario.fecha)}}</small>
								</div>
								<div>
									<span>Nos calificó con</span> <span v-for="estrella in parseInt(comentario.calificacion)"><img src="http://grupoeuroandino.com/images/star.png" alt="estrella"></span>
									<p class="text-capitalize">Comentario: {{comentario.comentario || 'Me gustó'}}</p>
								</div>
							</li>
						</ul>
					</div>
				</div>
				<p>Comentaron {{parseInt(variosTours.votantes) - comentarios.length }} viajeros más...</p>
			</div>
		</div>



	</div>

	</div>



	</div>

	</div>

	<!-- Modal -->

	<div class="modal fade" id="modalAgenda" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

		<div class="modal-dialog modal-dialog-centered">

			<div class="modal-content">

				<div class="modal-body">

					<div class="d-flex justify-content-between">

						<h1 class="modal-title fs-5" id="exampleModalLabel">Horario de atención</h1>

						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

					</div>

					<p class=" mt-2 lead">Lunes a Domingo</p>

					<p>De 9:00 am - 1:00 pm</p>

					<p>De 3:00 am - 7:00 pm</p>



				</div>

			</div>

		</div>

	</div>



	<footer class="container-fluid pt-5 pb-5" id="pie">



		<div class="container">

			<div class=" row" style="margin-top: 8rem!important;">

				<div class="col-12 col-md-4">

					<a href=""><img src="https://grupoeuroandino.com/wp-content/uploads/2022/11/yape.png" alt=""></a>

				</div>

				<div class="col-12 col-md-4">

					<a href=""><img src="https://grupoeuroandino.com/images/pie2.png?v=2" alt=""></a>

				</div>

				<div class="col-12 col-md-4">

					<a href=""><img src="https://grupoeuroandino.com/images/form.png?v=1" alt="" style="margin-bottom: 1em;"></a>

					<form id="formulario">

						<input type="text" id="txtNombres1" placeholder="Nombres y Apellidos">

						<input type="email" id="txtCorreo1" placeholder="Ingresa tu Email">

						<button id="btnFormulario"><img src="https://grupoeuroandino.com/images/address-book-solid.svg" id="enviarMnj"> SUSCRIBIRME</button>

					</form>

					<p class="text-white pb-2" style="font-size: 18px;"><strong>REDES SOCIALES</strong></p>

					<div class="d-flex" style="margin-bottom: 1em;">

						<a href="https://www.facebook.com/grupoeuroandino/"><img src="https://grupoeuroandino.com/images/facebook.png" width="50" height="50"></a>

						<a href="https://twitter.com/grupoeuroandino/"><img src="https://grupoeuroandino.com/images/twitter.png" width="50" height="50" style="margin:0 5px;"></a>

						<a href="https://twitter.com/grupoeuroandino/"><img src="https://grupoeuroandino.com/images/instagram.png" width="50" height="50" style="margin:0 5px;"></a>

						<a href="https://www.youtube.com/channel/UCG31MOsbyOuHr6-LpH4Mkbw"><img src="https://grupoeuroandino.com/images/youtube.png" width="50" height="50" style="margin:0 5px;"></a>

						<a href="https://www.linkedin.com/in/grupo-euro-andino-426b81123/"><img src="https://grupoeuroandino.com/images/in.png" width="50" height="50" style="margin:0 5px;"></a>

						<a href="https://www.flickr.com/photos/193956460@N06/"><img src="https://grupoeuroandino.com/images/cua.png" width="50" height="50" style="margin:0 5px;"></a>

					</div>

					<div>

						<a href="https://grupoeuroandino.com/libro-de-reclamaciones/"><img src="https://grupoeuroandino.com/wp-content/uploads/elementor/thumbs/Libro-de-Reclamaciones-pqjdp1qustruv9u46xq03mwub2nazjop222m18a8h4.jpg" width="160" height="auto" style="margin-right:10px;"></a>

						<a href="http://consultasenlinea.mincetur.gob.pe/directoriodeserviciosturisticos/DirPrestadores/DirBusquedaPrincipal/AgenciaViajes?IdGrupo=2"><img src="https://grupoeuroandino.com/wp-content/uploads/elementor/thumbs/Agencia-de-viajes-y-Turismo-Registrada-pqjfqac5b415hhgbj3eivnkskvnvqjfs4jzl6doxns.jpg" width="160" height="auto"></a>

					</div>

				</div>

			</div>

		</div>



	</footer>







	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>



	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<!-- Desarrollo -->
<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
<!-- Produccion -->
<!-- <script src="https://cdn.jsdelivr.net/npm/vue@2"></script> -->


	<script src="https://grupoeuroandino.com/app/render/js/axios.min.js"></script>

	<script src="https://grupoeuroandino.com/app/render/js/moment.min.js"></script>
	
	<link href="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css" rel="stylesheet">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js"></script>
	<script src="https://grupoeuroandino.com/app/render/js/bootstrap-datepicker.min.js"></script>
	<script src="https://grupoeuroandino.com/app/render/js/bootstrap-datepicker.es.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.js" integrity="sha512-gY25nC63ddE0LcLPhxUJGFxa2GoIyA5FLym4UJqHDEMHjp8RET6Zn/SHo1sltt3WuVtqfyxECP38/daUc/WVEA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>



	<script>
		var datepicker = $.fn.datepicker.noConflict();

		$.fn.bootstrapDP = datepicker;

		/* $('#dtpFecha').datepicker({

	    language: "es",

	    keyboardNavigation: false,

	    todayHighlight: false,

	    datesDisabled: ['07/02/2022','06/02/2022', '05/02/2022', '04/02/2022', '03/02/2022', '02/02/2022', '01/02/2022','31/01/2022' ]

		});

		$(".prev").each(function(i) {$(".prev")[i].innerHTML = `<i class="icofont-rounded-left"></i>`})

		$(".next").each(function(i) {$(".next")[i].innerHTML = `<i class="icofont-rounded-right"></i>`}) */

		var app = new Vue({

			el: '#app',

			data() {

				return {

					idProducto: -1, horarioSelect:-1,

					//servidor: 'http://localhost/euroAndinoApi/',
					servidor: 'https://grupoeuroandino.com/app/api/',
					lateral:'', dolar:0, precioDolares:0, inferior:'',
					variosTours: [],
					tourActivo: [{
						incluye: '',
						noIncluye: '',
						peruanos: {
							adultos: 0,
							kids: 0
						},
						extranjeros: {
							adultos: 0,
							kids: 0
						},
						duracion: 0,
						notas: ''

					}],

					precioPorPersona: 0,
					cantAdultos: 0,
					cantKids: 0,

					duracion: [{
						clave: 1,
						valor: 'Half Day (Medio día)'
					}, {
						clave: 2,
						valor: 'Full Day (1 día)'
					}],

					duracionDias: [{
						clave: 1,
						valor: 'Half Day (Medio día)'
					}, {
						clave: 2,
						valor: 'Full Day (1 día)'
					}],

					duracionNoches: [{
						clave: 1,
						valor: '0 noches'
					}, {
						clave: 2,
						valor: '1 noche'
					}],

					anticipacion: [{
						clave: 1,
						valor: '12 horas'
					}, {
						clave: 2,
						valor: '1 día'
					}],

					departamentos: ['Amazonas', 'Ancash', 'Apurimac', 'Arequipa', 'Ayacucho', 'Cajamarca', 'Cusco', 'El Callao', 'Huancavelica', 'Huánuco', 'Ica', 'Junín', 'La Libertad', 'Lambayeque', 'Lima', 'Loreto', 'Madre de Dios', 'Moquegua', 'Pasco', 'Piura', 'Puno', 'San Martín', 'Tacna', 'Tumbes', 'Ucayali'],

					diasMuertos: [],
					precioTotal: 0,
					nacionalidad: -1,
					faltaPais: false,
					msjError: '',
					verMas: false,

					incluidos: [],
					noIncluidos: [],
					faltaMinimo: true, faltaAdulto:true,
					recomendados: [],
					categorias2: [],
					actividades2: [], contenidos:[], comentarios:[],
					transportes: ['Terrestre', 'Aéreo', 'Ninguno'],
					hospedajes: []

				}

			},

			mounted() {

				//sacando el ID

				const queryString = window.location.search;

				const urlParams = new URLSearchParams(queryString);

				this.idProducto = '<?= $rowMeta['id']; ?>'

				//console.log( 'el id es ' + this.idProducto );

				this.cargarComplementos();

				this.pedirDatos();

			},

		methods: {

			async cargarComplementos() {

				let servComplementos = await fetch(this.servidor + 'pedirComplementos.php', {

					method: 'POST'

				})
				axios.post(this.servidor + 'Alojamientos.php',{
					pedir: 'listar'
				})
				.then(serv=> this.hospedajes = serv.data )

				let resServidor = await servComplementos

				resServidor.json().then((queVino) => {
					this.actividades2 = queVino[0];
					this.categorias2 = queVino[1];
					//Obtener el valor de lo seleccionado
					//$('#sltActividad2').selectpicker('val');
					//asignar valor
					//$('#sltActividad2').selectpicker('val', ['51', '53']);
				})
				let servConfig = await fetch(this.servidor+ 'cargarPanel.php',{ method:'POST' })
				let resConfig = await servConfig.json();
				this.lateral = resConfig.lateral;
				this.inferior = resConfig.inferior;
				this.dolar = resConfig.dolar

			},
			async cargarTours(){
				let datos = new FormData()
				datos.append('departamento', this.tourActivo.departamento+1)
				const respuesta = await fetch(this.servidor+'mostrarTours_scriptDepartamentos.php',{
					method:'POST', body:datos
				})
				let temp = await respuesta.json()
				//console.log('temp',temp);
				this.tours = temp;
				this.contenidos=[];
				this.tours.forEach(dato=>{
					this.contenidos.push( JSON.parse(dato.contenido));
				});
				console.log( this.contenidos);
			},
			queDura(duracion){
				return this.duracion[duracion-1].valor;
			},
			queDuraDia(duracion){
				//return this.duracion[duracion].valor;
				return this.duracionDias.find( x => x.clave === duracion ).valor;
			},
			queDuraNoche(duracion){ 
				if(duracion>=1){
					return this.duracionNoches[duracion].valor;
				}
			 },
			queDepa(valor){
				return this.departamentos[valor];
			},

			async pedirDatos() {

				var hoy = moment();

				const respuesta = await axios.post(this.servidor + 'verTourPorId_v2.php', {
					id: this.idProducto
				});

				this.variosTours = respuesta.data['tour'];
				this.comentarios = respuesta.data['comentarios'];

				this.tourActivo = JSON.parse(this.variosTours.contenido);

				this.precioPorPersona = this.tourActivo.peruanos.adultos;

				//this.cantAdultos = this.tourActivo.minimo;

				$('.fotorama').fotorama();

				for (let dia = 2; dia <= 31; dia++) {

					this.duracion.push({
						clave: dia + 1,
						valor: dia + ' días / 0 noches'
					});

					this.duracionDias.push({
						clave: dia + 1,
						valor: dia + ' días'
					});

					this.duracionNoches.push({
						clave: dia + 1,
						valor: dia + ' noches'
					});

				}

				for (let dia = 2; dia <= 15; dia++) {

					this.anticipacion.push({
						clave: dia + 1,
						valor: dia + ' días'
					});

				}
				for (let dia = 30; dia <= 180; dia+=15) {
							this.anticipacion.push({ clave: dia+1, valor: dia + ' días' });
						}

				//$('#dtpFecha').bootstrapDP('setDate', moment().format('DD/MM/YYYY'))
				/* $('#dtpFecha').bootstrapDP({
					language: 'es',
					setDate: moment().format('DD/MM/YYYY')
				}) */

				switch (this.tourActivo.anticipacion) {
					case "1":
						this.bloquearFechaDesde(hoy.diff(1, 'days'));break;
					case "2":
						this.bloquearFechaDesde(hoy.add(1, 'days'));break;
					default:
						this.bloquearFechaDesde(hoy.add(parseInt(this.tourActivo.anticipacion) - 1, 'days'));break;
				}

				this.incluidos = this.tourActivo.incluye.split('\n');

				this.noIncluidos = this.tourActivo.noIncluye.split('\n');

				const myTimeout = setTimeout(function() {

					$('.fotorama').fotorama();

				}, 500);

				this.cargarTours()




				let datos = new FormData();

				datos.append('tipo', this.tourActivo.tipo);

				datos.append('departamento', this.tourActivo.departamento);

				let respRecomendados = await fetch(this.servidor + 'pedirRecomendadosRandom.php', {

						method: 'POST',
						body: datos

					})

					.then(response => response.json())

					.then(data => {

						this.recomendados = data;

					}).then(() => {

						$(".owl-carousel").owlCarousel({

							autoplay: true,

							loop: true,
							margin: 20,
							dots: true,

							nav: true,

							navText: ["<div class='nav-button owl-prev'>‹</div>", "<div class='nav-button owl-next'>›</div>"],

							responsive: {

								0: {

									items: 1

								},

								600: {

									items: 3

								}

							}

						});

					});

				/* this.recomendados = await respRecomendados.json()

				.then(()=>{

				}); */



			},

			contarMinimoPersonas() {

				if (this.nacionalidad == 159 || this.nacionalidad == -1) {
					this.precioTotal = parseFloat(this.cantAdultos * this.tourActivo.peruanos.adultos) + parseFloat(this.cantKids * this.tourActivo.peruanos.kids);
				} else {
					this.precioTotal = parseFloat(this.cantAdultos * this.tourActivo.extranjeros.adultos) + parseFloat(this.cantKids * this.tourActivo.extranjeros.kids);

				}
				this.precioDolares = this.precioTotal / this.dolar


				if(this.cantKids>0 && this.cantAdultos==0 ){
					this.msjError = "Se debe reservar como mínimo un adulto";
					return this.faltaAdulto = false;
				}
				else
					this.faltaAdulto=true;
					if ((this.cantAdultos + this.cantKids) < parseInt(this.tourActivo.minimo)) {
						this.faltaPais = true;
						this.msjError = "Debe rellenar el campo de su nacionalidad antes de reservar";
						return this.faltaMinimo = false;
					} else {
						this.faltaPais = false;
						return this.faltaMinimo = true;
					}
			},

			restarAdulto() {

				if (this.cantAdultos > 0) {

					this.cantAdultos--;
					this.contarMinimoPersonas();

				}

			},

			sumarAdulto() {

				this.cantAdultos++;
				this.contarMinimoPersonas();

			},

			restarKid() {

				if (this.cantKids > 0) {

					this.cantKids--;
					this.contarMinimoPersonas();

				}

			},

			sumarKid() {

				this.cantKids++;
				this.contarMinimoPersonas();

			},

			queAnticipa(valor) {

				if (valor != null) {
					if(valor==1){
						if( this.tourActivo.antes)
						    if(this.tourActivo.antes == "0") return "Sin restricciones"
							else return `${this.tourActivo.antes} hora${this.tourActivo.antes == 1 ? '':'s'} antes`
						else{
							return 'Sin restricciones';
						}
					}else if(valor>1){
						return this.anticipacion[parseInt(valor) - 1].valor + " antes del viaje";
					}
				}
			},

			variasActividades(queActividad) {

				//console.log('es la acti', queActividad);

				var actividades = "";

				if (queActividad != undefined) {

					queActividad.forEach(actividad => {

						actividades += " " + this.actividades2.find(x => x.id === actividad).concepto + ",";

					});

					return actividades.substring(0, actividades.length - 1)

				} else {

					return '-';

				}

			},

			variasCategorias(queCategoria) {

				if (queCategoria != undefined) {

					var categorias = "";

					queCategoria.forEach(actividad => {

						categorias += " " + this.categorias2.find(x => x.id === actividad).concepto + ",";

					});

					return categorias.substring(0, categorias.length - 1)

				} else {

					return '-';

				}

			},

			bloquearFechaDesde(fechaInicial) {

				//console.log( fechaInicial.format('DD/MM/YYYY') );

				if(this.tourActivo.fechas){
					for(let index = 0; index< this.tourActivo.fechas.length; index++){
						this.diasMuertos.push(moment(this.tourActivo.fechas[index].fecha).format('DD/MM/YYYY'))
					}
				}
				
				for (let index = 1; index <= 90; index++) {

					this.diasMuertos.push(moment(fechaInicial, 'DD/MM/YYYY').subtract(index, 'days').format('DD/MM/YYYY'));

				}
				//console.log(this.diasMuertos);

				//$('#dtpFecha').datepicker('destroy');

				$('#dtpFecha').bootstrapDP({
					language: 'es',
					setDate: moment().format('DD/MM/YYYY'),
					language: "es",
					keyboardNavigation: false,
					todayHighlight: true,
					datesDisabled: this.diasMuertos
				});



				$(".prev").each(function(i) {
					$(".prev")[i].innerHTML = `<i class="icofont-rounded-left"></i>`
				})

				$(".next").each(function(i) {
					$(".next")[i].innerHTML = `<i class="icofont-rounded-right"></i>`
				})

			},

			horaLatam(hora) {

				return (moment(hora, 'HH:mm').format('h:mm a'))

			},

				reservar() {
					if ($('#dtpFecha').bootstrapDP('getFormattedDate') == null || $('#dtpFecha').bootstrapDP('getFormattedDate') == '') {

						this.faltaPais = true;
						this.msjError = "Debe seleccionar una fecha inicial";
						return false;
					}else if( $('#dtpFecha').bootstrapDP('getFormattedDate') == moment().format('DD/MM/YYYY')){ //Es hoy
						if(this.tourActivo.anticipacion == 1 ){
							const horaActual = moment()
							var horaElegida = null
							const horasAntes = parseInt(this.tourActivo.antes) ?? 0
							if( this.horarioSelect=='-1') horaElegida = moment(this.tourActivo.hora, 'HH:mm')
							else horaElegida = moment(this.tourActivo.hora2, 'HH:mm')
							const diferenciaHoras = horaElegida.diff(horaActual, 'hours') - horasAntes;
							if (diferenciaHoras >= 0) { //Se puede comprar esta en el rango
								this.faltaPais = false;
								this.msjError=''
								console.log("La horaComparar en el rango.", diferenciaHoras );
								this.prepararCompra();

							} else { //Esta muy atrás
								console.log("La horaComparar no está en el rango.", diferenciaHoras );
								this.faltaPais = true;
								this.msjError = `Se debe reservar ${Math.abs(horasAntes)} hora${Math.abs(horasAntes) == 1 ? '':'s'} antes a la hora elegida`;
								return false;
							}
						}
					}
					else{
						this.prepararCompra();
					}
				},
				prepararCompra(){
					if (this.comprobarNacionalidad() && this.contarMinimoPersonas()) {
						window.location.href = "/carrito-compras/?id=" + this.idProducto + "&adults=" + this.cantAdultos + "&kids=" + this.cantKids + "&nationality=" + this.nacionalidad + "&start=" + $('#dtpFecha').bootstrapDP('getFormattedDate')+'&horario='+this.horarioSelect;
					}
				},

				comprobarNacionalidad() {

					if (this.nacionalidad == -1) {

						this.faltaPais = true;
						this.msjError = "Debe rellenar el campo de su nacionalidad antes de reservar";
						return false;

					} else {

						this.faltaPais = false;

						return true;

					}

				},

				formatoMoneda(valor) {

					return parseFloat(valor).toFixed(2)

				},

				/* 	

				comprobarRequisitos(){

					if(this.nacionalidad==-1){

						this.faltaPais=true; this.msjError = "Debe rellenar el campo de su nacionalidad antes de reservar"; return false;

					}else if(!this.contarMinimoPersonas()){

						this.faltaPais=true; this.msjError = "Se debe completar un mínimo de personas"; return false;

					}else{

						this.faltaPais=false;

						return true;

					}

				} */

				queDuraRecomendado(tipo, queDuracion, queDuracion2) {

					try {

						if (tipo == '2') {

							queDuracion3 = JSON.parse(queDuracion2);

							//return 'caso 2';

							return this.duracionDias.find(x => x.clave === queDuracion).valor + " / " + this.duracionNoches[queDuracion2].valor;;

							//return this.duracionDias[parseInt(this.tourActivo.duracion.dias)].valor + ", " + this.duracionNoches[parseInt(this.tourActivo.duracion.noches)].valor;

						}

						if (tipo == '1') {

							return this.duracion[parseInt(queDuracion) - 1].valor

							//return this.duracion.find( x => x.clave === duracion ).valor;

						}

					} catch (error) {



					}

				},
				fechaFrom(fecha){
					return moment(fecha).format('DD/MM/YYYY');
				},
				cuantasEstrellas(index){
					return parseInt(this.tours[index].calificacion)
				},
				expandirMas() {

					this.verMas = true;

					let divNotas = document.getElementById('divNotas');

					divNotas.style.height = "100%";

					divNotas.style.overflow = auto;

				},

				entregarCorto(texto, corto) {



					if (corto && texto != undefined) {

						return texto.substring(0, 1600) + '...';

					} else {

						return texto;

					}

				},
				handler: function(e) {
					//do stuff
					e.preventDefault();
				},
				retornarHospedaje(id){
					let al = this.hospedajes.find(x=> x.id == id)
					if (al) return al.alojamiento
				}

			},

			computed: {

				queDuraComp() {

					try {

						if (this.tourActivo.tipo == '2') {

							return this.duracionDias.find(x => x.clave === this.tourActivo.duracion.dias).valor + " / " + this.duracionNoches.find(x => x.clave === this.tourActivo.duracion.noches).valor;

							//return this.duracionDias[parseInt(this.tourActivo.duracion.dias)].valor + ", " + this.duracionNoches[parseInt(this.tourActivo.duracion.noches)].valor;

						} else {

							return this.duracion.find(x => x.clave === this.tourActivo.duracion).valor;

						}

					} catch (error) {



					}

				},

			},

		})



		$(document).ready(function() {

			const signupForm = document.querySelector("#btnFormulario");



			signupForm.addEventListener("click", async function(event) {

				event.preventDefault();

				var dato = new FormData();

				dato.append('txtNombres', document.getElementById('txtNombres1').value)

				dato.append('txtCorreo', document.getElementById('txtCorreo1').value)



				let respuesta = await fetch('https://grupoeuroandino.com/app/api/correo_suscribir.php', {

					method: 'POST',
					body: dato

				});

				console.log(await respuesta.text())



			});







		});
	</script>

</body>

</html>