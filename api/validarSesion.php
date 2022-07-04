<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'conectkarl.php';

$clavePrivada= 'Es sencillo hacer que las cosas sean complicadas, pero difícil hacer que sean sencillas. Friedrich Nietzsche';

$sql = $db->query( "SELECT * from usuario u  where usuNick = '".$_POST['user']."' and usuPass=md5('{$_POST['pws']}');");
if($sql->execute()){
	$row = $sql->fetch(PDO::FETCH_ASSOC);
	if($sql->rowCount()>0){

		if( $row['usuActivo']=='1' ){
			$local='/';
			$expira=time()+60*60*3; //cookie para 3 horas

			setcookie('ckAtiende', $row['usuNombres'], $expira, $local);
			setcookie('cknomCompleto', $row['usuNombres'].', '.$row['usuApellido'], $expira, $local);
			setcookie('ckPower', $row['usuPoder'], $expira, $local);
			setcookie('ckidUsuario', $row['idUsuario'], $expira, $local);
			setcookie('ckUsuario', $row['usuNick'], $expira, $local);
			
			echo 'concedido';
		}else{
			echo 'inhabilitado';
		}

	}else{
		echo 'nada';
	}
	
}else{
	echo 'error';
}

?>