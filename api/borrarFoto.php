<?php 

if(unlink('../render/images/subidas/'.$_POST['foto'])){
	unlink('../render/images/subidas/small-'.$_POST['foto']);
	echo 'ok';
}else{
	echo 'error';
}
?>