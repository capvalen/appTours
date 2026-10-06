<?php
//el archivo debe vivir en la carpeta del tema

// Ruta por la que se accedió (valor de la query var "vista")
$tic_vista = get_query_var('vista') ?: 'desconocida';

// Primero en -1 todas las variables, para que no se filtre nada por defecto
$tic_tour = -1;
$tic_dia = -1;
$tic_categoria = -1;

// Día por defecto según la vista (0 = Half Day, 1 = Full Day, -1 = Todos)
if ($tic_vista === 'tours-en-peru') $tic_tour = 1;
elseif ($tic_vista === 'paquetes-turisticos-en-peru') $tic_tour = 2;
elseif ($tic_vista === 'half-days-en-peru') $tic_dia = 0;
elseif ($tic_vista === 'full-days-en-peru') $tic_dia = 1;
elseif ($tic_vista === 'viajes-de-promocion-escolar-en-peru') $tic_categoria = 38;

// URL personalizada que apunta a la tienda, pasando vista, idCategoria e idDia
$tic_url_tienda = add_query_arg(
    [
        'vista'       => $tic_vista,
        'idCategoria' => $tic_categoria,
        'idDia'       => $tic_dia,
        'idTour'       => $tic_tour,
    ],
    'https://grupoeuroandino.com/app/render/tienda.php'
);

get_header(); ?>
<script>
    console.log(<?php echo wp_json_encode('Estás accediendo por la URL-2: ' . $tic_vista . ' | idCategoria: ' . $tic_categoria . ' | idDia: ' . $tic_dia); ?>);
</script>
<style>
    #iframeTienda { width:100%; border:0; display:block; height:100vh; padding-top:20px }
</style>
<iframe id="iframeTienda"
        src="<?php echo esc_url($tic_url_tienda); ?>"
        title="Tienda"></iframe>
<?php get_footer(); ?>