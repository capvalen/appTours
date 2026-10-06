<?php
/**
 * Plugin Name: Integración Tours
 * Description: Carga template-viajes.php en /tours/lo-que-sea y template-tienda.php en las rutas de tienda.
 * Version: 1.2.2
 * Author: Carlos Pariona
 *
 * Rutas gestionadas:
 *   - /tours/{texto}                        -> template-viajes.php
 *   - /viajes-de-promocion-escolar-en-peru  -> template-tienda.php  (idCategoria=38, idDia=-1)
 *   - /half-days-en-peru                    -> template-tienda.php  (idCategoria=-1, idDia=0)
 *   - /full-days-en-peru                    -> template-tienda.php  (idCategoria=-1, idDia=1)
 *   - /tours-en-peru                         -> template-tienda.php  (idCategoria=-1, idDia=-1)
 *   - /paquetes-turisticos-en-peru           -> template-tienda.php
 */

// 1. Le dice a WordPress que reconozca los parámetros "variable" y "vista"
add_filter('query_vars', function($vars) {
	$vars[] = 'variable';
	$vars[] = 'vista';
	return $vars;
});

// 2. Reglas de reescritura
add_action('init', function() {

	// /tours/lo-que-sea-texto -> index.php?variable=lo-que-sea-texto
	add_rewrite_rule(
		'^tours/([^/]+)/?$',
		'index.php?variable=$matches[1]',
		'top'
	);

	// Rutas de la tienda -> index.php?vista=...
	add_rewrite_rule(
		'^(viajes-de-promocion-escolar-en-peru|half-days-en-peru|full-days-en-peru|tours-en-peru|paquetes-turisticos-en-peru)/?$',
		'index.php?vista=$matches[1]',
		'top'
	);
});

// 3. Cuando llega ese parámetro, carga la plantilla en vez de la normal
add_filter('template_include', function($template) {

  // Rutas que usan template-tienda.php
	$vistas_tienda = [
		'viajes-de-promocion-escolar-en-peru',
		'half-days-en-peru',
		'full-days-en-peru',
		'tours-en-peru',
		'paquetes-turisticos-en-peru'
	];
	$vista = get_query_var('vista');

	//si la url contiene el parametro vista, carga el template-tienda.php
	if (in_array($vista, $vistas_tienda, true)) {
			return get_theme_file_path('template-tienda.php');
	}

	// Si no ubica el parámetro 'vista', carga el template-viajes.php
	if (get_query_var('variable')) {
			return get_theme_file_path('template-viajes.php');
	}

	return $template;
});