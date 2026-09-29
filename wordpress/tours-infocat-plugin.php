<?php
/**
 * Plugin Name: Integración Tours
 * Description: Enruta /tours/lo-que-sea hacia template-viajes.php
 * Version: 1.0.1
 * Author: Carlos Pariona
 */

// 1. Le dice a WordPress que reconozca el parámetro "variable"
add_filter('query_vars', function($vars) {
    $vars[] = 'variable';
    return $vars;
});

// 2. Convierte /tours/lo-que-sea-texto en index.php?variable=lo-que-sea-texto
add_action('init', function() {
    add_rewrite_rule(
        '^tours/([^/]+)/?$',
        'index.php?variable=$matches[1]',
        'top'
    );
});

// 3. Cuando llega ese parámetro, carga tu plantilla en vez de la normal
add_filter('template_include', function($template) {
    if (get_query_var('variable')) {
        return get_theme_file_path('template-viajes.php');
    }
    return $template;
});