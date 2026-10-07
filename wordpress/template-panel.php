<?php
//el archivo debe vivir en la carpeta del tema

// URL de la aplicación del panel de usuario (vive en /public_html/app/usuario-panel)
// Se accede como https://grupoeuroandino.com/app/usuario-panel
// Se deja la barra final para que los enlaces relativos del panel
// (login.php, dashboard.php, assets/...) se resuelvan dentro de la carpeta.
$tic_url_panel = 'https://grupoeuroandino.com/app/usuario-panel/';

get_header(); ?>
<style>
    #iframePanel { width:100%; border:0; display:block; height:100vh;  }
</style>
<iframe id="iframePanel"
        src="<?php echo esc_url($tic_url_panel); ?>"
        title="Panel de usuario"></iframe>
<?php get_footer(); ?>
