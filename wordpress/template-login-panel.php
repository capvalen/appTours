<?php
//el archivo debe vivir en la carpeta del tema

// URL del inicio de sesión del panel de usuario (vive en /public_html/app/usuario-panel)
// Se accede como https://grupoeuroandino.com/app/usuario-panel/login.php
$tic_url_login = 'https://grupoeuroandino.com/app/usuario-panel/login.php';

get_header(); ?>
<style>
    #iframeLogin { width:100%; border:0; display:block; height:100vh; }
</style>
<iframe id="iframeLogin"
        src="<?php echo esc_url($tic_url_login); ?>"
        title="Iniciar sesión"></iframe>
<?php get_footer(); ?>
