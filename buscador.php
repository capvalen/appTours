<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>buscador</title>

</head>
<body>
<style>
	.container{
		width: 50%;
	}
	#divBuscador{
		width: 100%;
		position: relative;
    
	}
	#txtBuscador{
		width: 100%;
		margin: 0;
		padding: 8px;
		height: 44px;
		background-color: #fff;
		border: 2px solid #1e1e1e;
		border-radius: 0 0 0 0;
		box-shadow: 0 0 0 0 #b5b5b5 inset;
		border-radius: 30px;
		padding:2rem;
	}
	#txtBuscador::placeholder{
    /* padding:2rem; */
	}
	#resultado{
		padding: 0.5rem;
		margin-top: 0.5rem;
		width: 95%;
		min-height: 150px;
		position:absolute; top:0; left:0;
		border-radius: 5px;
		border: 1px solid #ddd;
		box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
		z-index: 10;
		background-color: white;
	}
	.item{
		width: 100%;
		display: flex;
		background-color: white;
		border-bottom: 1px solid #ddd;
	}
	.item:hover{
		background: #f1f1f1; cursor:pointer;
	}
	.item:hover .titulo{
		color: #ff9715;
	}
	.imagen{
		width: 20%;
		padding: 0 0.5rem;
		display: flex;
    justify-content: center;
	}
	.imagen>img{width: 120px;}
	.contenido{
		width: 75%;
		display: flex;
    align-items: center;
	}
	.titulo{
		font-size: 1.1rem;
		font-weight: bold;
		margin-bottom: 0!important;
	}
	.precioPort{margin-bottom: 0!important; font-weight: bold;font-size: 1rem;color: #c7084e;}
	#verTodo{text-align: center;}
	#verTodo a{text-decoration: none; }
	.verMas{background-color: white;}
	.contVermas{
		min-height: 50px;
		display: flex;
    align-content: flex-start;
    justify-content: center;
		align-items: center;
	}
	@media (max-width: 600px) {
		.imagen{ width: 40%; }
		.container{width: 100%;}
	}
	@media (max-width: 120px) {
		.imagen{ width: 25%; }
		.container{width: 100%;}
	}
</style>
<div class="container" id="appBuscador">
	<input type="text" id="txtBuscador" v-model="texto" placeholder="Ciudad, lugar, actividad" @keyup="validar($event);">
	<div id="divBuscador">
		<div id="resultado" v-if="coincidencias.length>0">
			<div class="item" v-for="coincidencia in coincidencias" @click="irA(coincidencia.id)">
				<div class="imagen">
					<img :src="'https://grupoeuroandino.com/app/render/images/subidas/'+coincidencia.foto" alt="">
				</div>
				<div class="contenido">
					<div>
						<p class="titulo">{{coincidencia.nombre}}</p>
						<p class="precioPort">S/ {{coincidencia.precio}}</p>
					</div>
				</div>
			</div>
			<div class="verMas"  @click="irA('ultimo');">
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
		el:'#appBuscador',
		data:{
			texto: '', coincidencias:[]
		},
		methods:{
			async validar(e){
				console.log(e.keyCode);
				if(e.keyCode==27){
					this.coincidencias=[];
				}else{
					if( this.texto.length>=3 ){
						let datos = new FormData();
						datos.append('texto', this.texto);
						datos.append('departamento', -1);
						datos.append('tipo', -1);
						let resp = await fetch('https://grupoeuroandino.com/app/api/buscarTour_Portada.php',{
							method:'POST', body: datos
						})
						this.coincidencias = await resp.json();
					}else{
						this.coincidencias=[];
					}
				}
			},
			irA(id){
				if(id=='ultimo'){
						window.location.href="https://grupoeuroandino.com/destinos/?texto="+this.texto;
					}else{
						window.location.href="https://grupoeuroandino.com/tour/?id="+id;
				}
			}
		}
	})
</script>
</body>
</html>