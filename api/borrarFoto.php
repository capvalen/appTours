<?php 

if(unlink('../render/images/subidas/'.$_POST['foto'])){
	echo 'ok';
}else{
	echo 'error';
}
?>