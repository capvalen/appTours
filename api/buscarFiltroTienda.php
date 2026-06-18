<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include ("conectkarl.php");

$departamentos=['AMAZONAS', 'ANCASH', 'APURIMAC', 'AREQUIPA', 'AYACUCHO', 'CAJAMARCA', 'CALLAO', 'CUSCO', 'HUANCAVELICA', 'HUÁNUCO', 'ICA', 'JUNÍN', 'LA LIBERTAD', 'LAMBAYEQUE', 'LIMA', 'LORETO', 'MADRE DE DIOS', 'MOQUEGUA', 'PASCO', 'PIURA', 'PUNO', 'SAN MARTÍN', 'TACNA', 'TUMBES', 'UCAYALI'];

$precios=['Hasta S/ 150.00', 'De S/ 151.00 a S/ 300.00', 'De S/ 301.00 a S/ 500.00', 'De S/ 501.00 a S/ 1000.00', 'De S/ 1001.00 a S/ 1500.00', 'De S/ 1501.00 a S/ 2000.00', 'Más de S/ 2000.00'];

if(!isset($_POST['idCiudad'])){ $_POST['idCiudad'] =''; }
if(!isset($_POST['idPais'])){ $_POST['idPais'] = 140; }

//var_dump($_POST); die();
$idTour=-1;
$idActividad=-1;
$idDepartamento=-1;
$idCategoria=-1;
$idDia=-1;
$idPrecio=-1;
$idPais=-1;
$idHospedaje=-1;
$fTransporte=-1;
$fPais=-1;
$fDepartamento=-1;


$fPrecio ="1";

$bloque = isset($_POST['bloque']) ? (int)$_POST['bloque'] : 500;
$pagina = isset($_POST['pagina']) ? (int)$_POST['pagina'] : 1;

$filas = [];

if($_POST['idTour']>-1){ $fTour = "tipo = {$_POST['idTour']}"; } else{ $fTour="tipo in (1,2)";}
if($_POST['idActividad']>-1){ $fActividad =
	"JSON_CONTAINS(JSON_EXTRACT(contenido, '$.actividades'), '\"{$_POST['idActividad']}\"')";
	//"JSON_EXTRACT(contenido, '$.actividades') like '%{$_POST['idActividad']}%'";
}else{ $fActividad='1';}
if(isset($_POST['idPais'])){
	$fPais = " pais = {$_POST['idPais']} ";
	$fDepartamento = '1';
}
if($_POST['idPais']==140 ){
	$fPais='1';
	if($_POST['idDepartamento']>-1){ 
		//$fDepartamento ="contenido like  '%\"departamento\":{$_POST['idDepartamento']},%'";}
		$fDepartamento = "JSON_UNQUOTE(JSON_EXTRACT(contenido, '$.departamento')) = {$_POST['idDepartamento']}";
	}else $fDepartamento='1';
}
$fTexto = '1';
if($_POST['texto']!=''){
	$textoLimpio = mb_strtolower(str_replace(['á','é','í','ó','ú','ñ'], ['a','e','i','o','u','n'], trim($_POST['texto'])));
	$extraDept = '';
	foreach($departamentos as $idx => $dept){
		$deptLimpio = mb_strtolower(str_replace(['Á','É','Í','Ó','Ú','Ñ'], ['A','E','I','O','U','N'], $dept));
		if( $deptLimpio === $textoLimpio || strpos($deptLimpio, $textoLimpio) !== false ){
			$extraDept = " OR JSON_UNQUOTE(JSON_EXTRACT(contenido, '$.departamento')) = $idx";
			break;
		}
	}
	$fTexto = "(lower(JSON_UNQUOTE(JSON_EXTRACT(contenido, '$.nombre'))) COLLATE utf8mb4_unicode_ci like '%{$_POST['texto']}%' OR lower(JSON_UNQUOTE(JSON_EXTRACT(contenido, '$.destino'))) COLLATE utf8mb4_unicode_ci like '%{$_POST['texto']}%' $extraDept) ";
	}
if($_POST['idCiudad']!='' && $_POST['idCiudad']!=-1){ $fCiudades = "JSON_EXTRACT(contenido, '$.destino') = '{$_POST['idCiudad']}' "; }else{ $fCiudades = '1';}
if($_POST['idCategoria']>-1){ $fCategoria ="JSON_EXTRACT(contenido, '$.categorias') like '%{$_POST['idCategoria']}%'";}else{ $fCategoria='1';}
if($_POST['idTransporte']>-1){ $fTransporte ="JSON_EXTRACT(contenido, '$.transporte') like '%{$_POST['idTransporte']}%'";}else{ $fTransporte='1';}
if($_POST['idDia']>0)
	$fDuracion ="(JSON_EXTRACT(contenido, '$.duracion') = {$_POST['idDia']} OR JSON_EXTRACT(JSON_EXTRACT(contenido, '$.duracion'), '$.dias') = {$_POST['idDia']} )";
	//if($_POST['idDia'] == 0 ) $fDuracion ="contenido like  '%\"dias\":1%' ";
	//else $fDuracion ="contenido like  '%\"duracion\":{$_POST['idDia']}%'";
else $fDuracion='1';
if($_POST['idHospedaje']>-1){ $fHospedaje ="JSON_EXTRACT(contenido, '$.alojamiento') = '{$_POST['idHospedaje']}' "; }else{ $fHospedaje = '1';}
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

$where = "activo=1 and visible = 1 and {$fTexto} and {$fPais} and {$fTour} and {$fActividad} and {$fDepartamento} and {$fCategoria} and {$fDuracion} and {$fPrecio} and {$fCiudades} and {$fHospedaje} and {$fTransporte}";

$sqlCount = "SELECT COUNT(*) as total FROM `tours` t inner join paises p on p.id = t.pais where $where;";
$total = $db->query($sqlCount)->fetch(PDO::FETCH_ASSOC)['total'];

$totalPaginas = $bloque ? max(1, (int)ceil($total / $bloque)) : 1;
$offset = $bloque ? ($pagina - 1) * $bloque : 0;
$limit = $bloque ? "LIMIT $bloque OFFSET $offset" : '';

$sentencia = "SELECT t.*, p.nombre as nombrePais, p.name as namePais, p.bandera FROM `tours` t inner join paises p on p.id = t.pais where $where order by rand() $limit;";
//echo $sentencia; die();

$sql = $db->query($sentencia);
if($sql->execute()){
	while($row = $sql->fetch(PDO::FETCH_ASSOC)){
		$filas[] = $row;
	}
}

echo json_encode([
	'data' => $filas,
	'total' => (int)$total,
	'pagina' => $pagina,
	'totalPaginas' => $totalPaginas,
	'bloque' => $bloque ?? (int)$total
]);