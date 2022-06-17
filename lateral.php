<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Panel de paguetes - Grupo Euro-Andino</title>
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
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="container">
			<a class="navbar-brand" href="#">Grupo Euro Andino</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
				<div class="navbar-nav">
					<a class="nav-link " aria-current="page" href="tours.php">Tours</a>
					<a class="nav-link " href="paquetes.php">Paquetes turísticos</a>
					<a class="nav-link " href="pedidos.php">Pedidos</a>
					<a class="nav-link active" href="lateral.php">Lateral</a>
				</div>
			</div>
		</div>
	</nav>

	<div class="container" id="app">

		<p class="my-2">Edite panel lateral</p>

		<div class="row">
			<div class="col-12 col-md-6 col-lg-5 mx-auto">
				<div class=" ">
					<button class="btn btn-outline-primary my-3" onclick="actualizarPanel()">Actualizar</button>
					<div id="editor"> </div>
				</div>
			</div>
		</div>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
	
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
	<script src="./js/quill.min.js"></script>
	
	<script src="js/axios.min.js"></script>
	<script src="js/moment.min.js"></script>
	<script>
		var toolBarOptions = [
			[{ 'header': [false, 2, 3, 4, 5] }],
				//[{ 'size': ['small', false, 'large'] }],
				[{ 'align': [] }],
				['bold', 'italic','underline', 'strike'],
				['link', 'image'],
				[{ list: 'ordered' }, { list: 'bullet' }],
			];
		var quill = new Quill('#editor', {
		  modules: { 
				toolbar: {
					container : toolBarOptions,
					handlers:{
						image: imageHandler
					}
				}
			},
		  theme: 'snow'
		});
		cargarPanel();

		function imageHandler() {
      var range = this.quill.getSelection();
      var value = prompt('¿Cuál es la URL de la imágen?');
      if(value){
          this.quill.insertEmbed(range.index, 'image', value, Quill.sources.USER);
      }
 		}
		async function actualizarPanel(){
			let datos = new FormData();
			datos.append('panel',  quill.root.innerHTML.trim() )
			let respServ = await fetch("https://grupoeuroandino.com/app/api/actualizarPanel.php",{
				method:'POST', body: datos
			});
			if( await respServ.text() =='ok' ){
				alert('Guardado exitoso')
			}else{
				alert('Hubo un error')
			}

		}
		async function cargarPanel(){
			let respServ = await fetch("https://grupoeuroandino.com/app/api/cargarPanel.php");
			let html = await respServ.text();
			quill.setContents([]);
			quill.clipboard.dangerouslyPasteHTML(0, html);
		}
	
</script>
</body>
</html>