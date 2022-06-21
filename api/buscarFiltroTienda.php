<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include ("conectkarl.php");

$departamentos=['Amazonas', 'Ancash', 'Apurimac', 'Arequipa', 'Ayacucho', 'Cajamarca', 'Cusco', 'El Callao', 'Huancavelica','Huánuco', 'Ica', 'Junín', 'Chanchamayo', 'Chupaca', 'Concepción', 'Huancayo', 'Jauja', 'Junín', 'Satipo', 'Tarma', 'Yauli', 'La Libertad', 'Lambayeque', 'Lima', 'Loreto', 'Madre de Dios', 'Moquegua', 'Pasco', 'Piura', 'Puno','San Martín', 'Tacna', 'Tumbes', 'Ucayali' ];

$precios=['Hasta S/ 150.00', 'De S/ 151.00 a S/ 300.00', 'De S/ 301.00 a S/ 500.00', 'De S/ 501.00 a S/ 1000.00', 'De S/ 1001.00 a S/ 1500.00', 'De S/ 1501.00 a S/ 2000.00', 'Más de S/ 2000.00'];

//var_dump($_POST); die();
$idTour=-1;
$idActividad=-1;
$idDepartamento=-1;
$idCategoria=-1;
$idDia=-1;
$idPrecio=-1;
$idTransporte=-1;

$fPrecio ="1";

$filas = [];

if($_POST['idTour']>-1){ $fTour = "tipo = {$_POST['idTour']}"; } else{ $fTour="tipo in (1,2)";}
if($_POST['idActividad']>-1){ $fActividad ="JSON_EXTRACT(contenido, '$.actividades') like '%{$_POST['idActividad']}%'";}else{ $fActividad='1';}
if($_POST['idDepartamento']>-1){ $fDepartamento ="contenido like  '%\"departamento\":{$_POST['idDepartamento']},%'";}else{ $fDepartamento='1';}
if($_POST['idCategoria']>-1){ $fCategoria ="JSON_EXTRACT(contenido, '$.categorias') like '%{$_POST['idCategoria']}%'";}else{ $fCategoria='1';}
if($_POST['idTransporte']>-1){ $fTransporte ="JSON_EXTRACT(contenido, '$.transporte') like '%{$_POST['idTransporte']}%'";}else{ $fTransporte='1';}
if($_POST['idDia']>-1){ $fDuracion ="contenido like  '%\"duracion\":{$_POST['idDia']}%'";}else{ $fDuracion='1';}
if($_POST['idPrecio']>-1){
	switch ($_POST['idPrecio']) {
		case '-1': //0-150
			$fPrecio ="1"; break;
		case '0': //0-150
			$fPrecio ="CAST(JSON_EXTRACT(contenido, '$.peruanos.adultos') as DECIMAL) between 0 and 150"; break;
		case '1': //150-300
			$fPrecio ="CAST(JSON_EXTRACT(contenido, '$.peruanos.adultos') as DECIMAL) between 150 and 300"; break;
		case '2': //300-500
			$fPrecio ="CAST(JSON_EXTRACT(contenido, '$.peruanos.adultos') as DECIMAL) between 300 and 500"; break;
		case '3': //500-1000
			$fPrecio ="CAST(JSON_EXTRACT(contenido, '$.peruanos.adultos') as DECIMAL) between 500 and 1000"; break;
		case '4': //100-1500
			$fPrecio ="CAST(JSON_EXTRACT(contenido, '$.peruanos.adultos') as DECIMAL) between 1000 and 1500"; break;
		case '5': //1500-2000
			$fPrecio ="CAST(JSON_EXTRACT(contenido, '$.peruanos.adultos') as DECIMAL) between 1500 and 2000"; break;
		case '6': //>2000
			$fPrecio ="CAST(JSON_EXTRACT(contenido, '$.peruanos.adultos') as DECIMAL) >= 2000"; break;
			break;
	}
}

$sql = $db->query("SELECT * FROM `tours` where activo=1 and {$fTour} and {$fActividad} and {$fDepartamento} and {$fCategoria} and {$fDuracion} and {$fPrecio} and {$fTransporte};");
if($sql->execute()){
	//echo $sql->debugDumpParams();
	while($row = $sql->fetch(PDO::FETCH_ASSOC)){
		$filas[] = $row;
	}
}

echo json_encode($filas);