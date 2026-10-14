<?php
/**
 * Plugin Name: Integración Tours
 * Description: Carga template-viajes.php en /tours/lo-que-sea, template-tour-ciudades.php en /tours-y-paquetes/lo-que-sea, template-paquetes.php en /paquetes-y-tours/lo-que-sea y template-tienda.php en las rutas de tienda.
 * Version: 1.2.4
 * Author: Carlos Pariona
 *
 * Rutas gestionadas:
 *   - /tours/{texto}                        -> template-viajes.php
 *   - /tours-y-paquetes/{texto}             -> template-tour-ciudades.php
 *   - /paquetes-y-tours/{texto}             -> template-paquetes.php
 *   - /viajes-de-promocion-escolar-en-peru  -> template-tienda.php  (idCategoria=38, idDia=-1)
 *   - /half-days-en-peru                    -> template-tienda.php  (idCategoria=-1, idDia=0)
 *   - /full-days-en-peru                    -> template-tienda.php  (idCategoria=-1, idDia=1)
 *   - /tours-en-peru                         -> template-tienda.php  (idCategoria=-1, idDia=-1)
 *   - /paquetes-turisticos-en-peru           -> template-tienda.php
 *   - /registro-panel                        -> template-panel.php (registro de cuenta)
 *   - /login-panel                           -> template-login-panel.php (inicio de sesión)
 */

// 1. Le dice a WordPress que reconozca los parámetros "variable", "vista", "tour_ciudades" y "paquetes_tours"
add_filter('query_vars', function($vars) {
	$vars[] = 'variable';
	$vars[] = 'vista';
	$vars[] = 'tour_ciudades';
	$vars[] = 'paquetes_tours';
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

	// /tours-y-paquetes/lo-que-sea -> index.php?tour_ciudades=lo-que-sea
	add_rewrite_rule(
		'^tours-y-paquetes/([^/]+)/?$',
		'index.php?tour_ciudades=$matches[1]',
		'top'
	);

	// /paquetes-y-tours/lo-que-sea -> index.php?paquetes_tours=lo-que-sea
	add_rewrite_rule(
		'^paquetes-y-tours/([^/]+)/?$',
		'index.php?paquetes_tours=$matches[1]',
		'top'
	);

	// Rutas de la tienda -> index.php?vista=...
	add_rewrite_rule(
		'^(viajes-de-promocion-escolar-en-peru|half-days-en-peru|full-days-en-peru|tours-en-peru|paquetes-turisticos-en-peru|registro-panel|login-panel)/?$',
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
		'paquetes-turisticos-en-peru',
	];
	$vista = get_query_var('vista');

	// La ruta /registro-panel carga el registro del panel de usuario (template-panel.php)
	if ($vista === 'registro-panel') {
			return get_theme_file_path('template-panel.php');
	}

	// La ruta /login-panel carga el login del panel de usuario (template-login-panel.php)
	if ($vista === 'login-panel') {
			return get_theme_file_path('template-login-panel.php');
	}

	//si la url contiene el parametro vista, carga el template-tienda.php
	if (in_array($vista, $vistas_tienda, true)) {
			return get_theme_file_path('template-tienda.php');
	}

	if (get_query_var('variable')) {
			return get_theme_file_path('template-viajes.php');
	}

	// La ruta /tours-y-paquetes/{texto} carga el filtrado de ciudades (template-tour-ciudades.php)
	if (get_query_var('tour_ciudades')) {
			return get_theme_file_path('template-tour-ciudades.php');
	}

	// La ruta /paquetes-y-tours/{texto} carga el filtrado de departamentos (template-paquetes.php)
	if (get_query_var('paquetes_tours')) {
			return get_theme_file_path('template-paquetes.php');
	}

	return $template;
});